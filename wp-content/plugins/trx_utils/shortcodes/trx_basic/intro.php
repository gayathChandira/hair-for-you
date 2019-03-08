<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('charity_is_hope_sc_intro_theme_setup')) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_sc_intro_theme_setup' );
	function charity_is_hope_sc_intro_theme_setup() {
		add_action('charity_is_hope_action_shortcodes_list', 		'charity_is_hope_sc_intro_reg_shortcodes');
		if (function_exists('charity_is_hope_exists_visual_composer') && charity_is_hope_exists_visual_composer())
			add_action('charity_is_hope_action_shortcodes_list_vc','charity_is_hope_sc_intro_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

if (!function_exists('charity_is_hope_sc_intro')) {	
	function charity_is_hope_sc_intro($atts, $content=null){	
		if (charity_is_hope_in_shortcode_blogger()) return '';
		extract(charity_is_hope_html_decode(shortcode_atts(array(
			// Individual params
			"style" => 1,
			"align" => "none",
			"image" => "",
			"bg_color" => "",
			"icon" => "",
			"scheme" => "",
			"title" => "",
			"subtitle" => "",
			"description" => "",
			"link" => '',
			"link_caption" => esc_html__('Read more', 'charity-is-hope'),
			"link2" => '',
			"link2_caption" => '',
			"url" => "",
			"content_position" => "",
			"content_width" => "",
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => "",
			"width" => "",
			"height" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
	
		if ($image > 0) {
			$attach = wp_get_attachment_image_src($image, 'full');
			if (isset($attach[0]) && $attach[0]!='')
				$image = $attach[0];
		}
		
		$width  = charity_is_hope_prepare_css_value($width);
		$height = charity_is_hope_prepare_css_value($height);
		
		$class .= ($class ? ' ' : '') . charity_is_hope_get_css_position_as_classes($top, $right, $bottom, $left);

		$css .= charity_is_hope_get_css_dimensions_from_values($width,$height);
		$css .= ($image ? 'background: url('.$image.');' : '');
		$css .= ($bg_color ? 'background-color: '.$bg_color.';' : '');
		
		$buttons = (!empty($link) || !empty($link2) 
						? '<div class="sc_intro_buttons sc_item_buttons">'
							. (!empty($link) 
								? '<div class="sc_intro_button sc_item_button">'.do_shortcode('[trx_button link="'.esc_url($link).'" size="medium"]'.esc_html($link_caption).'[/trx_button]').'</div>' 
								: '')
							. (!empty($link2) && $style==2 
								? '<div class="sc_intro_button sc_item_button">'.do_shortcode('[trx_button link="'.esc_url($link2).'" size="medium"]'.esc_html($link2_caption).'[/trx_button]').'</div>' 
								: '')
							. '</div>'
						: '');
						
		$output = '<div '.(!empty($url) ? 'data-href="'.esc_url($url).'"' : '') 
					. ($id ? ' id="'.esc_attr($id).'"' : '') 
					. ' class="sc_intro' 
						. ($class ? ' ' . esc_attr($class) : '') 
						. ($content_position && $style==1 ? ' sc_intro_position_' . esc_attr($content_position) : '') 
						. ($style==5 ? ' small_padding' : '') 
						. ($scheme && !charity_is_hope_param_is_off($scheme) && !charity_is_hope_param_is_inherit($scheme) ? ' scheme_'.esc_attr($scheme) : '') 
						. ($align && $align!='none' ? ' align'.esc_attr($align) : '') 
						. '"'
					. (!charity_is_hope_param_is_off($animation) ? ' data-animation="'.esc_attr(charity_is_hope_get_animation_classes($animation)).'"' : '')
					. ($css ? ' style="'.esc_attr($css).'"' : '')
					.'>' 
					. '<div class="sc_intro_inner '.($style ? ' sc_intro_style_' . esc_attr($style) : '').'"'.(!empty($content_width) ? ' style="width:'.esc_attr($content_width).';"' : '').'>'
						. (!empty($icon) && $style==5 ? '<div class="sc_intro_icon '.esc_attr($icon).'"></div>' : '')
						. '<div class="sc_intro_content">'
							. (!empty($subtitle) && $style!=4 && $style!=5 ? '<h6 class="sc_intro_subtitle">' . trim(charity_is_hope_strmacros($subtitle)) . '</h6>' : '')
							. (!empty($title) ? '<h2 class="sc_intro_title">' . trim(charity_is_hope_strmacros($title)) . '</h2>' : '')
							. (!empty($description) && $style!=1 ? '<div class="sc_intro_descr">' . trim(charity_is_hope_strmacros($description)) . '</div>' : '')
							. ($style==2 || $style==3 ? $buttons : '')
						. '</div>'
					. '</div>'
				.'</div>';
	
	
	
		return apply_filters('charity_is_hope_shortcode_output', $output, 'trx_intro', $atts, $content);
	}
	charity_is_hope_require_shortcode('trx_intro', 'charity_is_hope_sc_intro');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'charity_is_hope_sc_intro_reg_shortcodes' ) ) {
	//add_action('charity_is_hope_action_shortcodes_list', 'charity_is_hope_sc_intro_reg_shortcodes');
	function charity_is_hope_sc_intro_reg_shortcodes() {
	
		charity_is_hope_sc_map("trx_intro", array(
			"title" => esc_html__("Intro", 'charity-is-hope'),
			"desc" => wp_kses_data( __("Insert Intro block in your page (post)", 'charity-is-hope') ),
			"decorate" => true,
			"container" => false,
			"params" => array(
				"style" => array(
					"title" => esc_html__("Style", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Select style to display block", 'charity-is-hope') ),
					"value" => "1",
					"type" => "checklist",
					"options" => charity_is_hope_get_list_styles(1, 5)
				),
				"align" => array(
					"title" => esc_html__("Alignment of the intro block", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Align whole intro block to left or right side of the page or parent container", 'charity-is-hope') ),
					"value" => "",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => charity_is_hope_get_sc_param('float')
				), 
				"image" => array(
					"title" => esc_html__("Image URL", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Select the intro image from the library for this section", 'charity-is-hope') ),
					"readonly" => false,
					"value" => "",
					"type" => "media"
				),
				"bg_color" => array(
					"title" => esc_html__("Background color", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Select background color for the intro", 'charity-is-hope') ),
					"value" => "",
					"type" => "color"
				),
				"icon" => array(
					"title" => esc_html__('Icon',  'charity-is-hope'),
					"desc" => wp_kses_data( __("Select icon from Fontello icons set",  'charity-is-hope') ),
					"dependency" => array(
						'style' => array(5)
					),
					"value" => "",
					"type" => "icons",
					"options" => charity_is_hope_get_sc_param('icons')
				),
				"content_position" => array(
					"title" => esc_html__('Content position', 'charity-is-hope'),
					"desc" => wp_kses_data( __("Select content position", 'charity-is-hope') ),
					"dependency" => array(
						'style' => array(1)
					),
					"value" => "top_left",
					"type" => "checklist",
					"options" => array(
						'top_left' => esc_html__('Top Left', 'charity-is-hope'),
						'top_right' => esc_html__('Top Right', 'charity-is-hope'),
						'bottom_right' => esc_html__('Bottom Right', 'charity-is-hope'),
						'bottom_left' => esc_html__('Bottom Left', 'charity-is-hope')
					)
				),
				"content_width" => array(
					"title" => esc_html__('Content width', 'charity-is-hope'),
					"desc" => wp_kses_data( __("Select content width", 'charity-is-hope') ),
					"dependency" => array(
						'style' => array(1)
					),
					"value" => "100%",
					"type" => "checklist",
					"options" => array(
						'100%' => esc_html__('100%', 'charity-is-hope'),
						'90%' => esc_html__('90%', 'charity-is-hope'),
						'80%' => esc_html__('80%', 'charity-is-hope'),
						'70%' => esc_html__('70%', 'charity-is-hope'),
						'60%' => esc_html__('60%', 'charity-is-hope'),
						'50%' => esc_html__('50%', 'charity-is-hope'),
						'40%' => esc_html__('40%', 'charity-is-hope'),
						'30%' => esc_html__('30%', 'charity-is-hope')
					)
				),
				"subtitle" => array(
					"title" => esc_html__("Subtitle", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Subtitle for the block", 'charity-is-hope') ),
					"divider" => true,
					"dependency" => array(
						'style' => array(1,2,3)
					),
					"value" => "",
					"type" => "text"
				),
				"title" => array(
					"title" => esc_html__("Title", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Title for the block", 'charity-is-hope') ),
					"value" => "",
					"type" => "textarea"
				),
				"description" => array(
					"title" => esc_html__("Description", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Short description for the block", 'charity-is-hope') ),
					"dependency" => array(
						'style' => array(2,3,4,5),
					),
					"value" => "",
					"type" => "textarea"
				),
				"link" => array(
					"title" => esc_html__("Button URL", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Link URL for the button at the bottom of the block", 'charity-is-hope') ),
					"dependency" => array(
						'style' => array(2,3),
					),
					"divider" => true,
					"value" => "",
					"type" => "text"
				),
				"link_caption" => array(
					"title" => esc_html__("Button caption", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Caption for the button at the bottom of the block", 'charity-is-hope') ),
					"dependency" => array(
						'style' => array(2,3),
					),
					"value" => "",
					"type" => "text"
				),
				"link2" => array(
					"title" => esc_html__("Button 2 URL", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Link URL for the second button at the bottom of the block", 'charity-is-hope') ),
					"dependency" => array(
						'style' => array(2)
					),
					"divider" => true,
					"value" => "",
					"type" => "text"
				),
				"link2_caption" => array(
					"title" => esc_html__("Button 2 caption", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Caption for the second button at the bottom of the block", 'charity-is-hope') ),
					"dependency" => array(
						'style' => array(2)
					),
					"value" => "",
					"type" => "text"
				),
				"url" => array(
					"title" => esc_html__("Link", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Link of the intro block", 'charity-is-hope') ),
					"value" => "",
					"type" => "text"
				),
				"scheme" => array(
					"title" => esc_html__("Color scheme", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Select color scheme for the section with text", 'charity-is-hope') ),
					"value" => "",
					"type" => "checklist",
					"options" => charity_is_hope_get_sc_param('schemes')
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
if ( !function_exists( 'charity_is_hope_sc_intro_reg_shortcodes_vc' ) ) {
	//add_action('charity_is_hope_action_shortcodes_list_vc', 'charity_is_hope_sc_intro_reg_shortcodes_vc');
	function charity_is_hope_sc_intro_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_intro",
			"name" => esc_html__("Intro", 'charity-is-hope'),
			"description" => wp_kses_data( __("Insert Intro block", 'charity-is-hope') ),
			"category" => esc_html__('Content', 'charity-is-hope'),
			'icon' => 'icon_trx_intro',
			"class" => "trx_sc_single trx_sc_intro",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "style",
					"heading" => esc_html__("Style of the block", 'charity-is-hope'),
					"description" => wp_kses_data( __("Select style to display this block", 'charity-is-hope') ),
					"class" => "",
					"admin_label" => true,
					"value" => array_flip(charity_is_hope_get_list_styles(1, 5)),
					"type" => "dropdown"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Alignment of the block", 'charity-is-hope'),
					"description" => wp_kses_data( __("Align whole intro block to left or right side of the page or parent container", 'charity-is-hope') ),
					"class" => "",
					"std" => 'none',
					"value" => array_flip(charity_is_hope_get_sc_param('float')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "image",
					"heading" => esc_html__("Image URL", 'charity-is-hope'),
					"description" => wp_kses_data( __("Select the intro image from the library for this section", 'charity-is-hope') ),
					"class" => "",
					"value" => "",
					"type" => "attach_image"
				),
				array(
					"param_name" => "bg_color",
					"heading" => esc_html__("Background color", 'charity-is-hope'),
					"description" => wp_kses_data( __("Select background color for the intro", 'charity-is-hope') ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "icon",
					"heading" => esc_html__("Icon", 'charity-is-hope'),
					"description" => wp_kses_data( __("Select icon from Fontello icons set", 'charity-is-hope') ),
					"class" => "",
					'dependency' => array(
						'element' => 'style',
						'value' => array('5')
					),
					"value" => charity_is_hope_get_sc_param('icons'),
					"type" => "dropdown"
				),
				array(
					"param_name" => "content_position",
					"heading" => esc_html__("Content position", 'charity-is-hope'),
					"description" => wp_kses_data( __("Select content position", 'charity-is-hope') ),
					"class" => "",
					"admin_label" => true,
					"value" => array(
						esc_html__('Top Left', 'charity-is-hope') => 'top_left',
						esc_html__('Top Right', 'charity-is-hope') => 'top_right',
						esc_html__('Bottom Right', 'charity-is-hope') => 'bottom_right',
						esc_html__('Bottom Left', 'charity-is-hope') => 'bottom_left'
					),
					'dependency' => array(
						'element' => 'style',
						'value' => array('1')
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "content_width",
					"heading" => esc_html__("Content width", 'charity-is-hope'),
					"description" => wp_kses_data( __("Select content width", 'charity-is-hope') ),
					"class" => "",
					"admin_label" => true,
					"value" => array(
						esc_html__('100%', 'charity-is-hope') => '100%',
						esc_html__('90%', 'charity-is-hope') => '90%',
						esc_html__('80%', 'charity-is-hope') => '80%',
						esc_html__('70%', 'charity-is-hope') => '70%',
						esc_html__('60%', 'charity-is-hope') => '60%',
						esc_html__('50%', 'charity-is-hope') => '50%',
						esc_html__('40%', 'charity-is-hope') => '40%',
						esc_html__('30%', 'charity-is-hope') => '30%'
					),
					'dependency' => array(
						'element' => 'style',
						'value' => array('1')
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "subtitle",
					"heading" => esc_html__("Subtitle", 'charity-is-hope'),
					"description" => wp_kses_data( __("Subtitle for the block", 'charity-is-hope') ),
					'dependency' => array(
						'element' => 'style',
						'value' => array('1','2','3')
					),
					"group" => esc_html__('Captions', 'charity-is-hope'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "title",
					"heading" => esc_html__("Title", 'charity-is-hope'),
					"description" => wp_kses_data( __("Title for the block", 'charity-is-hope') ),
					"group" => esc_html__('Captions', 'charity-is-hope'),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textarea"
				),
				array(
					"param_name" => "description",
					"heading" => esc_html__("Description", 'charity-is-hope'),
					"description" => wp_kses_data( __("Description for the block", 'charity-is-hope') ),
					"group" => esc_html__('Captions', 'charity-is-hope'),
					'dependency' => array(
						'element' => 'style',
						'value' => array('2','3','4','5')
					),
					"class" => "",
					"value" => "",
					"type" => "textarea"
				),
				array(
					"param_name" => "link",
					"heading" => esc_html__("Button URL", 'charity-is-hope'),
					"description" => wp_kses_data( __("Link URL for the button at the bottom of the block", 'charity-is-hope') ),
					"group" => esc_html__('Captions', 'charity-is-hope'),
					'dependency' => array(
						'element' => 'style',
						'value' => array('2','3')
					),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "link_caption",
					"heading" => esc_html__("Button caption", 'charity-is-hope'),
					"description" => wp_kses_data( __("Caption for the button at the bottom of the block", 'charity-is-hope') ),
					"group" => esc_html__('Captions', 'charity-is-hope'),
					'dependency' => array(
						'element' => 'style',
						'value' => array('2','3')
					),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "link2",
					"heading" => esc_html__("Button 2 URL", 'charity-is-hope'),
					"description" => wp_kses_data( __("Link URL for the second button at the bottom of the block", 'charity-is-hope') ),
					"group" => esc_html__('Captions', 'charity-is-hope'),
					'dependency' => array(
						'element' => 'style',
						'value' => array('2')
					),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "link2_caption",
					"heading" => esc_html__("Button 2 caption", 'charity-is-hope'),
					"description" => wp_kses_data( __("Caption for the second button at the bottom of the block", 'charity-is-hope') ),
					"group" => esc_html__('Captions', 'charity-is-hope'),
					'dependency' => array(
						'element' => 'style',
						'value' => array('2')
					),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "url",
					"heading" => esc_html__("Link", 'charity-is-hope'),
					"description" => wp_kses_data( __("Link of the intro block", 'charity-is-hope') ),
					"value" => '',
					"type" => "textfield"
				),
				array(
					"param_name" => "scheme",
					"heading" => esc_html__("Color scheme", 'charity-is-hope'),
					"description" => wp_kses_data( __("Select color scheme for the section with text", 'charity-is-hope') ),
					"class" => "",
					"value" => array_flip(charity_is_hope_get_sc_param('schemes')),
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
			)
		) );
		
		class WPBakeryShortCode_Trx_Intro extends CHARITY_IS_HOPE_VC_ShortCodeSingle {}
	}
}
?>