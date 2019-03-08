<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('charity_is_hope_sc_icon_theme_setup')) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_sc_icon_theme_setup' );
	function charity_is_hope_sc_icon_theme_setup() {
		add_action('charity_is_hope_action_shortcodes_list', 		'charity_is_hope_sc_icon_reg_shortcodes');
		if (function_exists('charity_is_hope_exists_visual_composer') && charity_is_hope_exists_visual_composer())
			add_action('charity_is_hope_action_shortcodes_list_vc','charity_is_hope_sc_icon_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_icon id="unique_id" style='round|square' icon='' color="" bg_color="" size="" weight=""]
*/

if (!function_exists('charity_is_hope_sc_icon')) {	
	function charity_is_hope_sc_icon($atts, $content=null){	
		if (charity_is_hope_in_shortcode_blogger()) return '';
		extract(charity_is_hope_html_decode(shortcode_atts(array(
			// Individual params
			"icon" => "",
			"color" => "",
			"bg_color" => "",
			"bg_shape" => "",
			"font_size" => "",
			"font_weight" => "",
			"align" => "",
			"link" => "",
			// Common params
			"id" => "",
			"class" => "",
			"css" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
		$class .= ($class ? ' ' : '') . charity_is_hope_get_css_position_as_classes($top, $right, $bottom, $left);
		$css2 = ($font_weight != '' && !charity_is_hope_is_inherit_option($font_weight) ? 'font-weight:'. esc_attr($font_weight).';' : '')
			. ($font_size != '' ? 'font-size:' . esc_attr(charity_is_hope_prepare_css_value($font_size)) . '; line-height: ' . (!$bg_shape || charity_is_hope_param_is_inherit($bg_shape) ? '1' : '1.2') . 'em;' : '')
			. ($color != '' ? 'color:'.esc_attr($color).';' : '')
			. ($bg_color != '' ? 'background-color:'.esc_attr($bg_color).';border-color:'.esc_attr($bg_color).';' : '')
		;
		$output = $icon!='' 
			? ($link ? '<a href="'.esc_url($link).'"' : '<span') . ($id ? ' id="'.esc_attr($id).'"' : '')
				. ' class="sc_icon '.esc_attr($icon)
					. ($bg_shape && !charity_is_hope_param_is_inherit($bg_shape) ? ' sc_icon_shape_'.esc_attr($bg_shape) : '')
					. ($align && $align!='none' ? ' align'.esc_attr($align) : '') 
					. (!empty($class) ? ' '.esc_attr($class) : '')
				.'"'
				.($css || $css2 ? ' style="'.($class ? 'display:block;' : '') . ($css) . ($css2) . '"' : '')
				.'>'
				.($link ? '</a>' : '</span>')
			: '';
		return apply_filters('charity_is_hope_shortcode_output', $output, 'trx_icon', $atts, $content);
	}
	charity_is_hope_require_shortcode('trx_icon', 'charity_is_hope_sc_icon');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'charity_is_hope_sc_icon_reg_shortcodes' ) ) {
	//add_action('charity_is_hope_action_shortcodes_list', 'charity_is_hope_sc_icon_reg_shortcodes');
	function charity_is_hope_sc_icon_reg_shortcodes() {
	
		charity_is_hope_sc_map("trx_icon", array(
			"title" => esc_html__("Icon", 'charity-is-hope'),
			"desc" => wp_kses_data( __("Insert icon", 'charity-is-hope') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"icon" => array(
					"title" => esc_html__('Icon',  'charity-is-hope'),
					"desc" => wp_kses_data( __('Select font icon from the Fontello icons set',  'charity-is-hope') ),
					"value" => "",
					"type" => "icons",
					"options" => charity_is_hope_get_sc_param('icons')
				),
				"color" => array(
					"title" => esc_html__("Icon's color", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Icon's color", 'charity-is-hope') ),
					"dependency" => array(
						'icon' => array('not_empty')
					),
					"value" => "",
					"type" => "color"
				),
				"bg_shape" => array(
					"title" => esc_html__("Background shape", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Shape of the icon background", 'charity-is-hope') ),
					"dependency" => array(
						'icon' => array('not_empty')
					),
					"value" => "none",
					"type" => "radio",
					"options" => array(
						'none' => esc_html__('None', 'charity-is-hope'),
						'round' => esc_html__('Round', 'charity-is-hope'),
						'square' => esc_html__('Square', 'charity-is-hope')
					)
				),
				"bg_color" => array(
					"title" => esc_html__("Icon's background color", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Icon's background color", 'charity-is-hope') ),
					"dependency" => array(
						'icon' => array('not_empty'),
						'background' => array('round','square')
					),
					"value" => "",
					"type" => "color"
				),
				"font_size" => array(
					"title" => esc_html__("Font size", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Icon's font size", 'charity-is-hope') ),
					"dependency" => array(
						'icon' => array('not_empty')
					),
					"value" => "",
					"type" => "spinner",
					"min" => 8,
					"max" => 240
				),
				"font_weight" => array(
					"title" => esc_html__("Font weight", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Icon font weight", 'charity-is-hope') ),
					"dependency" => array(
						'icon' => array('not_empty')
					),
					"value" => "",
					"type" => "select",
					"size" => "medium",
					"options" => array(
						'100' => esc_html__('Thin (100)', 'charity-is-hope'),
						'300' => esc_html__('Light (300)', 'charity-is-hope'),
						'400' => esc_html__('Normal (400)', 'charity-is-hope'),
						'700' => esc_html__('Bold (700)', 'charity-is-hope')
					)
				),
				"align" => array(
					"title" => esc_html__("Alignment", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Icon text alignment", 'charity-is-hope') ),
					"dependency" => array(
						'icon' => array('not_empty')
					),
					"value" => "",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => charity_is_hope_get_sc_param('align')
				), 
				"link" => array(
					"title" => esc_html__("Link URL", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Link URL from this icon (if not empty)", 'charity-is-hope') ),
					"value" => "",
					"type" => "text"
				),
				"top" => charity_is_hope_get_sc_param('top'),
				"bottom" => charity_is_hope_get_sc_param('bottom'),
				"left" => charity_is_hope_get_sc_param('left'),
				"right" => charity_is_hope_get_sc_param('right'),
				"id" => charity_is_hope_get_sc_param('id'),
				"class" => charity_is_hope_get_sc_param('class'),
				"css" => charity_is_hope_get_sc_param('css')
			)
		));
	}
}


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'charity_is_hope_sc_icon_reg_shortcodes_vc' ) ) {
	//add_action('charity_is_hope_action_shortcodes_list_vc', 'charity_is_hope_sc_icon_reg_shortcodes_vc');
	function charity_is_hope_sc_icon_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_icon",
			"name" => esc_html__("Icon", 'charity-is-hope'),
			"description" => wp_kses_data( __("Insert the icon", 'charity-is-hope') ),
			"category" => esc_html__('Content', 'charity-is-hope'),
			'icon' => 'icon_trx_icon',
			"class" => "trx_sc_single trx_sc_icon",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "icon",
					"heading" => esc_html__("Icon", 'charity-is-hope'),
					"description" => wp_kses_data( __("Select icon class from Fontello icons set", 'charity-is-hope') ),
					"admin_label" => true,
					"class" => "",
					"value" => charity_is_hope_get_sc_param('icons'),
					"type" => "dropdown"
				),
				array(
					"param_name" => "color",
					"heading" => esc_html__("Text color", 'charity-is-hope'),
					"description" => wp_kses_data( __("Icon's color", 'charity-is-hope') ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "bg_color",
					"heading" => esc_html__("Background color", 'charity-is-hope'),
					"description" => wp_kses_data( __("Background color for the icon", 'charity-is-hope') ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "bg_shape",
					"heading" => esc_html__("Background shape", 'charity-is-hope'),
					"description" => wp_kses_data( __("Shape of the icon background", 'charity-is-hope') ),
					"admin_label" => true,
					"class" => "",
					"value" => array(
						esc_html__('None', 'charity-is-hope') => 'none',
						esc_html__('Round', 'charity-is-hope') => 'round',
						esc_html__('Square', 'charity-is-hope') => 'square'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "font_size",
					"heading" => esc_html__("Font size", 'charity-is-hope'),
					"description" => wp_kses_data( __("Icon's font size", 'charity-is-hope') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "font_weight",
					"heading" => esc_html__("Font weight", 'charity-is-hope'),
					"description" => wp_kses_data( __("Icon's font weight", 'charity-is-hope') ),
					"class" => "",
					"value" => array(
						esc_html__('Default', 'charity-is-hope') => 'inherit',
						esc_html__('Thin (100)', 'charity-is-hope') => '100',
						esc_html__('Light (300)', 'charity-is-hope') => '300',
						esc_html__('Normal (400)', 'charity-is-hope') => '400',
						esc_html__('Bold (700)', 'charity-is-hope') => '700'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Icon's alignment", 'charity-is-hope'),
					"description" => wp_kses_data( __("Align icon to left, center or right", 'charity-is-hope') ),
					"admin_label" => true,
					"class" => "",
					"value" => array_flip(charity_is_hope_get_sc_param('align')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "link",
					"heading" => esc_html__("Link URL", 'charity-is-hope'),
					"description" => wp_kses_data( __("Link URL from this icon (if not empty)", 'charity-is-hope') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				charity_is_hope_get_vc_param('id'),
				charity_is_hope_get_vc_param('class'),
				charity_is_hope_get_vc_param('css'),
				charity_is_hope_get_vc_param('margin_top'),
				charity_is_hope_get_vc_param('margin_bottom'),
				charity_is_hope_get_vc_param('margin_left'),
				charity_is_hope_get_vc_param('margin_right')
			),
		) );
		
		class WPBakeryShortCode_Trx_Icon extends CHARITY_IS_HOPE_VC_ShortCodeSingle {}
	}
}
?>