<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('charity_is_hope_sc_audio_theme_setup')) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_sc_audio_theme_setup' );
	function charity_is_hope_sc_audio_theme_setup() {
		add_action('charity_is_hope_action_shortcodes_list', 		'charity_is_hope_sc_audio_reg_shortcodes');
		if (function_exists('charity_is_hope_exists_visual_composer') && charity_is_hope_exists_visual_composer())
			add_action('charity_is_hope_action_shortcodes_list_vc','charity_is_hope_sc_audio_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_audio url="http://trex2.themerex.dnw/wp-content/uploads/2014/12/Dream-Music-Relax.mp3" image="http://trex2.themerex.dnw/wp-content/uploads/2014/10/post_audio.jpg" title="Insert Audio Title Here" author="Lily Hunter" controls="show" autoplay="off"]
*/

if (!function_exists('charity_is_hope_sc_audio')) {	
	function charity_is_hope_sc_audio($atts, $content = null) {
		if (charity_is_hope_in_shortcode_blogger()) return '';
		extract(charity_is_hope_html_decode(shortcode_atts(array(
			// Individual params
			"title" => "",
			"author" => "",
			"image" => "",
			"mp3" => '',
			"wav" => '',
			"src" => '',
			"url" => '',
			"align" => '',
			"controls" => "",
			"autoplay" => "",
			"frame" => "on",
			// Common params
			"id" => "",
			"class" => "",
			"css" => "",
			"animation" => "",
			"width" => '',
			"height" => '',
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
		if ($src=='' && $url=='' && isset($atts[0])) {
			$src = $atts[0];
		}
		if ($src=='') {
			if ($url) $src = $url;
			else if ($mp3) $src = $mp3;
			else if ($wav) $src = $wav;
		}
		if ($image > 0) {
			$attach = wp_get_attachment_image_src( $image, 'full' );
			if (isset($attach[0]) && $attach[0]!='')
				$image = $attach[0];
		}
		$class .= ($class ? ' ' : '') . charity_is_hope_get_css_position_as_classes($top, $right, $bottom, $left);
		$data = ($title != ''  ? ' data-title="'.esc_attr($title).'"'   : '')
				. ($author != '' ? ' data-author="'.esc_attr($author).'"' : '')
				. ($image != ''  ? ' data-image="'.esc_url($image).'"'   : '')
				. ($align && $align!='none' ? ' data-align="'.esc_attr($align).'"' : '')
				. (!charity_is_hope_param_is_off($animation) ? ' data-animation="'.esc_attr(charity_is_hope_get_animation_classes($animation)).'"' : '');
		$audio = '<audio'
			. ($id ? ' id="'.esc_attr($id).'"' : '')
			. ' class="sc_audio' . (!empty($class) ? ' '.esc_attr($class) : '') . '"'
			. ' src="'.esc_url($src).'"'
			. (charity_is_hope_param_is_on($controls) ? ' controls="controls"' : '')
			. (charity_is_hope_param_is_on($autoplay) && is_single() ? ' autoplay="autoplay"' : '')
			. ' width="'.esc_attr($width).'" height="'.esc_attr($height).'"'
			. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
			. ($data)
			. '></audio>';
		if ( charity_is_hope_get_custom_option('substitute_audio')=='no') {
			if (charity_is_hope_param_is_on($frame)) {
				$audio = charity_is_hope_get_audio_frame($audio, $image, $s);
			}
		} else {
			if ((isset($_GET['vc_editable']) && $_GET['vc_editable']=='true') && (isset($_POST['action']) && $_POST['action']=='vc_load_shortcode')) {
				$audio = charity_is_hope_substitute_audio($audio, false);
			}
		}
		if (charity_is_hope_get_theme_option('use_mediaelement')=='yes')
			wp_enqueue_script('wp-mediaelement');
		return apply_filters('charity_is_hope_shortcode_output', $audio, 'trx_audio', $atts, $content);
	}
	charity_is_hope_require_shortcode("trx_audio", "charity_is_hope_sc_audio");
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'charity_is_hope_sc_audio_reg_shortcodes' ) ) {
	//add_action('charity_is_hope_action_shortcodes_list', 'charity_is_hope_sc_audio_reg_shortcodes');
	function charity_is_hope_sc_audio_reg_shortcodes() {
	
		charity_is_hope_sc_map("trx_audio", array(
			"title" => esc_html__("Audio", 'charity-is-hope'),
			"desc" => wp_kses_data( __("Insert audio player", 'charity-is-hope') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"url" => array(
					"title" => esc_html__("URL for audio file", 'charity-is-hope'),
					"desc" => wp_kses_data( __("URL for audio file", 'charity-is-hope') ),
					"readonly" => false,
					"value" => "",
					"type" => "media",
					"before" => array(
						'title' => esc_html__('Choose audio', 'charity-is-hope'),
						'action' => 'media_upload',
						'type' => 'audio',
						'multiple' => false,
						'linked_field' => '',
						'captions' => array( 	
							'choose' => esc_html__('Choose audio file', 'charity-is-hope'),
							'update' => esc_html__('Select audio file', 'charity-is-hope')
						)
					),
					"after" => array(
						'icon' => 'icon-cancel',
						'action' => 'media_reset'
					)
				),
				"image" => array(
					"title" => esc_html__("Cover image", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Select or upload image or write URL from other site for audio cover", 'charity-is-hope') ),
					"readonly" => false,
					"value" => "",
					"type" => "media"
				),
				"title" => array(
					"title" => esc_html__("Title", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Title of the audio file", 'charity-is-hope') ),
					"divider" => true,
					"value" => "",
					"type" => "text"
				),
				"author" => array(
					"title" => esc_html__("Author", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Author of the audio file", 'charity-is-hope') ),
					"value" => "",
					"type" => "text"
				),
				"controls" => array(
					"title" => esc_html__("Show controls", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Show controls in audio player", 'charity-is-hope') ),
					"divider" => true,
					"size" => "medium",
					"value" => "show",
					"type" => "switch",
					"options" => charity_is_hope_get_sc_param('show_hide')
				),
				"autoplay" => array(
					"title" => esc_html__("Autoplay audio", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Autoplay audio on page load", 'charity-is-hope') ),
					"value" => "off",
					"type" => "switch",
					"options" => charity_is_hope_get_sc_param('on_off')
				),
				"align" => array(
					"title" => esc_html__("Align", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Select block alignment", 'charity-is-hope') ),
					"value" => "none",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => charity_is_hope_get_sc_param('align')
				),
				"width" => charity_is_hope_shortcodes_width(),
				"height" => charity_is_hope_shortcodes_height(),
				"top" => charity_is_hope_get_sc_param('top'),
				"bottom" => charity_is_hope_get_sc_param('bottom'),
				"left" => charity_is_hope_get_sc_param('left'),
				"right" => charity_is_hope_get_sc_param('right'),
				"id" => charity_is_hope_get_sc_param('id'),
				"class" => charity_is_hope_get_sc_param('class'),
				"animation" => charity_is_hope_get_sc_param('animation'),
				"css" => charity_is_hope_get_sc_param('css')
			)
		));
	}
}


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'charity_is_hope_sc_audio_reg_shortcodes_vc' ) ) {
	//add_action('charity_is_hope_action_shortcodes_list_vc', 'charity_is_hope_sc_audio_reg_shortcodes_vc');
	function charity_is_hope_sc_audio_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_audio",
			"name" => esc_html__("Audio", 'charity-is-hope'),
			"description" => wp_kses_data( __("Insert audio player", 'charity-is-hope') ),
			"category" => esc_html__('Content', 'charity-is-hope'),
			'icon' => 'icon_trx_audio',
			"class" => "trx_sc_single trx_sc_audio",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "url",
					"heading" => esc_html__("URL for audio file", 'charity-is-hope'),
					"description" => wp_kses_data( __("Put here URL for audio file", 'charity-is-hope') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "image",
					"heading" => esc_html__("Cover image", 'charity-is-hope'),
					"description" => wp_kses_data( __("Select or upload image or write URL from other site for audio cover", 'charity-is-hope') ),
					"class" => "",
					"value" => "",
					"type" => "attach_image"
				),
				array(
					"param_name" => "title",
					"heading" => esc_html__("Title", 'charity-is-hope'),
					"description" => wp_kses_data( __("Title of the audio file", 'charity-is-hope') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "author",
					"heading" => esc_html__("Author", 'charity-is-hope'),
					"description" => wp_kses_data( __("Author of the audio file", 'charity-is-hope') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "controls",
					"heading" => esc_html__("Controls", 'charity-is-hope'),
					"description" => wp_kses_data( __("Show/hide controls", 'charity-is-hope') ),
					"class" => "",
					"value" => array("Hide controls" => "hide" ),
					"type" => "checkbox"
				),
				array(
					"param_name" => "autoplay",
					"heading" => esc_html__("Autoplay", 'charity-is-hope'),
					"description" => wp_kses_data( __("Autoplay audio on page load", 'charity-is-hope') ),
					"class" => "",
					"value" => array("Autoplay" => "on" ),
					"type" => "checkbox"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Alignment", 'charity-is-hope'),
					"description" => wp_kses_data( __("Select block alignment", 'charity-is-hope') ),
					"class" => "",
					"value" => array_flip(charity_is_hope_get_sc_param('align')),
					"type" => "dropdown"
				),
				charity_is_hope_get_vc_param('id'),
				charity_is_hope_get_vc_param('class'),
				charity_is_hope_get_vc_param('animation'),
				charity_is_hope_get_vc_param('css'),
				charity_is_hope_vc_width(),
				charity_is_hope_vc_height(),
				charity_is_hope_get_vc_param('margin_top'),
				charity_is_hope_get_vc_param('margin_bottom'),
				charity_is_hope_get_vc_param('margin_left'),
				charity_is_hope_get_vc_param('margin_right')
			),
		) );
		
		class WPBakeryShortCode_Trx_Audio extends CHARITY_IS_HOPE_VC_ShortCodeSingle {}
	}
}
?>