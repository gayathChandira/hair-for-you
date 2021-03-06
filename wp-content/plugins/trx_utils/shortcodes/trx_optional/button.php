<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('charity_is_hope_sc_button_theme_setup')) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_sc_button_theme_setup' );
	function charity_is_hope_sc_button_theme_setup() {
		add_action('charity_is_hope_action_shortcodes_list', 		'charity_is_hope_sc_button_reg_shortcodes');
		if (function_exists('charity_is_hope_exists_visual_composer') && charity_is_hope_exists_visual_composer())
			add_action('charity_is_hope_action_shortcodes_list_vc','charity_is_hope_sc_button_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_button id="unique_id" type="square|round" fullsize="0|1" style="global|light|dark" size="mini|medium|big|huge|banner" icon="icon-name" link='#' target='']Button caption[/trx_button]
*/

if (!function_exists('charity_is_hope_sc_button')) {	
	function charity_is_hope_sc_button($atts, $content=null){	
		if (charity_is_hope_in_shortcode_blogger()) return '';
		extract(charity_is_hope_html_decode(shortcode_atts(array(
			// Individual params
			"type" => "square",
			"style" => "filled",
			"size" => "small",
			"icon" => "",
			"color" => "",
			"bg_color" => "",
			"link" => "",
			"target" => "",
			"align" => "",
			"rel" => "",
			"popup" => "no",
			// Common params
			"id" => "",
			"class" => "",
			"css" => "",
			"animation" => "",
			"width" => "",
			"height" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
		$class .= ($class ? ' ' : '') . charity_is_hope_get_css_position_as_classes($top, $right, $bottom, $left);
		$css .= charity_is_hope_get_css_dimensions_from_values($width, $height)
			. ($color !== '' ? 'color:' . esc_attr($color) .';' : '')
			. ($bg_color !== '' ? 'background-color:' . esc_attr($bg_color) . '; border-color:'. esc_attr($bg_color) .';' : '');
		if (charity_is_hope_param_is_on($popup)) charity_is_hope_enqueue_popup('magnific');
		$output = '<a href="' . (empty($link) ? '#' : $link) . '"'
			. (!empty($target) ? ' target="'.esc_attr($target).'"' : '')
			. (!empty($rel) ? ' rel="'.esc_attr($rel).'"' : '')
			. (!charity_is_hope_param_is_off($animation) ? ' data-animation="'.esc_attr(charity_is_hope_get_animation_classes($animation)).'"' : '')
			. ' class="sc_button sc_button_' . esc_attr($type) 
					. ' sc_button_style_' . esc_attr($style) 
					. ' sc_button_size_' . esc_attr($size)
					. ($align && $align!='none' ? ' align'.esc_attr($align) : '') 
					. (!empty($class) ? ' '.esc_attr($class) : '')
					. ($icon!='' ? '  sc_button_iconed '. esc_attr($icon) : '') 
					. (charity_is_hope_param_is_on($popup) ? ' sc_popup_link' : '') 
					. '"'
			. ($id ? ' id="'.esc_attr($id).'"' : '') 
			. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
			. '>'
			. do_shortcode($content)
			. '</a>';
		return apply_filters('charity_is_hope_shortcode_output', $output, 'trx_button', $atts, $content);
	}
	charity_is_hope_require_shortcode('trx_button', 'charity_is_hope_sc_button');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'charity_is_hope_sc_button_reg_shortcodes' ) ) {
	//add_action('charity_is_hope_action_shortcodes_list', 'charity_is_hope_sc_button_reg_shortcodes');
	function charity_is_hope_sc_button_reg_shortcodes() {
	
		charity_is_hope_sc_map("trx_button", array(
			"title" => esc_html__("Button", 'charity-is-hope'),
			"desc" => wp_kses_data( __("Button with link", 'charity-is-hope') ),
			"decorate" => false,
			"container" => true,
			"params" => array(
				"_content_" => array(
					"title" => esc_html__("Caption", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Button caption", 'charity-is-hope') ),
					"value" => "",
					"type" => "text"
				),
				"style" => array(
					"title" => esc_html__("Button's style", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Select button's style", 'charity-is-hope') ),
					"value" => "default",
					"dir" => "horizontal",
					"options" => array(
						'filled' => esc_html__('Filled', 'charity-is-hope'),
						'filled2' => esc_html__('Filled 2', 'charity-is-hope'),
						'filled3' => esc_html__('Filled 3', 'charity-is-hope')
					),
					"type" => "checklist"
				), 
				"size" => array(
					"title" => esc_html__("Button's size", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Select button's size", 'charity-is-hope') ),
					"value" => "small",
					"dir" => "horizontal",
					"options" => array(
						'small' => esc_html__('Small', 'charity-is-hope'),
						'large' => esc_html__('Large', 'charity-is-hope')
					),
					"type" => "checklist"
				), 
				"icon" => array(
					"title" => esc_html__("Button's icon",  'charity-is-hope'),
					"desc" => wp_kses_data( __('Select icon for the title from Fontello icons set',  'charity-is-hope') ),
					"value" => "",
					"type" => "icons",
					"options" => charity_is_hope_get_sc_param('icons')
				),
				"color" => array(
					"title" => esc_html__("Button's text color", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Any color for button's caption", 'charity-is-hope') ),
					"std" => "",
					"value" => "",
					"type" => "color"
				),
				"bg_color" => array(
					"title" => esc_html__("Button's backcolor", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Any color for button's background", 'charity-is-hope') ),
					"value" => "",
					"type" => "color"
				),
				"align" => array(
					"title" => esc_html__("Button's alignment", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Align button to left, center or right", 'charity-is-hope') ),
					"value" => "none",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => charity_is_hope_get_sc_param('align')
				), 
				"link" => array(
					"title" => esc_html__("Link URL", 'charity-is-hope'),
					"desc" => wp_kses_data( __("URL for link on button click", 'charity-is-hope') ),
					"divider" => true,
					"value" => "",
					"type" => "text"
				),
				"target" => array(
					"title" => esc_html__("Link target", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Target for link on button click", 'charity-is-hope') ),
					"dependency" => array(
						'link' => array('not_empty')
					),
					"value" => "",
					"type" => "text"
				),
				"popup" => array(
					"title" => esc_html__("Open link in popup", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Open link target in popup window", 'charity-is-hope') ),
					"dependency" => array(
						'link' => array('not_empty')
					),
					"value" => "no",
					"type" => "switch",
					"options" => charity_is_hope_get_sc_param('yes_no')
				), 
				"rel" => array(
					"title" => esc_html__("Rel attribute", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Rel attribute for button's link (if need)", 'charity-is-hope') ),
					"dependency" => array(
						'link' => array('not_empty')
					),
					"value" => "",
					"type" => "text"
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
if ( !function_exists( 'charity_is_hope_sc_button_reg_shortcodes_vc' ) ) {
	//add_action('charity_is_hope_action_shortcodes_list_vc', 'charity_is_hope_sc_button_reg_shortcodes_vc');
	function charity_is_hope_sc_button_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_button",
			"name" => esc_html__("Button", 'charity-is-hope'),
			"description" => wp_kses_data( __("Button with link", 'charity-is-hope') ),
			"category" => esc_html__('Content', 'charity-is-hope'),
			'icon' => 'icon_trx_button',
			"class" => "trx_sc_single trx_sc_button",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "content",
					"heading" => esc_html__("Caption", 'charity-is-hope'),
					"description" => wp_kses_data( __("Button caption", 'charity-is-hope') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "style",
					"heading" => esc_html__("Button's style", 'charity-is-hope'),
					"description" => wp_kses_data( __("Select button's style", 'charity-is-hope') ),
					"class" => "",
					"value" => array(
						esc_html__('Filled', 'charity-is-hope') => 'filled',
						esc_html__('Filled 2', 'charity-is-hope') => 'filled2',
						esc_html__('Filled 3', 'charity-is-hope') => 'filled3'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "size",
					"heading" => esc_html__("Button's size", 'charity-is-hope'),
					"description" => wp_kses_data( __("Select button's size", 'charity-is-hope') ),
					"admin_label" => true,
					"class" => "",
					"value" => array(
						esc_html__('Small', 'charity-is-hope') => 'small',
						esc_html__('Large', 'charity-is-hope') => 'large'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "icon",
					"heading" => esc_html__("Button's icon", 'charity-is-hope'),
					"description" => wp_kses_data( __("Select icon for the title from Fontello icons set", 'charity-is-hope') ),
					"class" => "",
					"value" => charity_is_hope_get_sc_param('icons'),
					"type" => "dropdown"
				),
				array(
					"param_name" => "color",
					"heading" => esc_html__("Button's text color", 'charity-is-hope'),
					"description" => wp_kses_data( __("Any color for button's caption", 'charity-is-hope') ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "bg_color",
					"heading" => esc_html__("Button's backcolor", 'charity-is-hope'),
					"description" => wp_kses_data( __("Any color for button's background", 'charity-is-hope') ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Button's alignment", 'charity-is-hope'),
					"description" => wp_kses_data( __("Align button to left, center or right", 'charity-is-hope') ),
					"class" => "",
					"value" => array_flip(charity_is_hope_get_sc_param('align')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "link",
					"heading" => esc_html__("Link URL", 'charity-is-hope'),
					"description" => wp_kses_data( __("URL for the link on button click", 'charity-is-hope') ),
					"class" => "",
					"group" => esc_html__('Link', 'charity-is-hope'),
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "target",
					"heading" => esc_html__("Link target", 'charity-is-hope'),
					"description" => wp_kses_data( __("Target for the link on button click", 'charity-is-hope') ),
					"class" => "",
					"group" => esc_html__('Link', 'charity-is-hope'),
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "popup",
					"heading" => esc_html__("Open link in popup", 'charity-is-hope'),
					"description" => wp_kses_data( __("Open link target in popup window", 'charity-is-hope') ),
					"class" => "",
					"group" => esc_html__('Link', 'charity-is-hope'),
					"value" => array(esc_html__('Open in popup', 'charity-is-hope') => 'yes'),
					"type" => "checkbox"
				),
				array(
					"param_name" => "rel",
					"heading" => esc_html__("Rel attribute", 'charity-is-hope'),
					"description" => wp_kses_data( __("Rel attribute for the button's link (if need", 'charity-is-hope') ),
					"class" => "",
					"group" => esc_html__('Link', 'charity-is-hope'),
					"value" => "",
					"type" => "textfield"
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
			'js_view' => 'VcTrxTextView'
		) );
		
		class WPBakeryShortCode_Trx_Button extends CHARITY_IS_HOPE_VC_ShortCodeSingle {}
	}
}
?>