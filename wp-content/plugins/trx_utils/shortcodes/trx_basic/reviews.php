<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('charity_is_hope_sc_reviews_theme_setup')) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_sc_reviews_theme_setup' );
	function charity_is_hope_sc_reviews_theme_setup() {
		add_action('charity_is_hope_action_shortcodes_list', 		'charity_is_hope_sc_reviews_reg_shortcodes');
		if (function_exists('charity_is_hope_exists_visual_composer') && charity_is_hope_exists_visual_composer())
			add_action('charity_is_hope_action_shortcodes_list_vc','charity_is_hope_sc_reviews_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_reviews]
*/

if (!function_exists('charity_is_hope_sc_reviews')) {	
	function charity_is_hope_sc_reviews($atts, $content = null) {
		if (charity_is_hope_in_shortcode_blogger()) return '';
		extract(charity_is_hope_html_decode(shortcode_atts(array(
			// Individual params
			"align" => "right",
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
		$class .= ($class ? ' ' : '') . charity_is_hope_get_css_position_as_classes($top, $right, $bottom, $left);
		$output = charity_is_hope_param_is_off(charity_is_hope_get_custom_option('show_sidebar_main'))
			? '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
						. ' class="sc_reviews'
							. ($align && $align!='none' ? ' align'.esc_attr($align) : '')
							. ($class ? ' '.esc_attr($class) : '')
							. '"'
						. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
						. (!charity_is_hope_param_is_off($animation) ? ' data-animation="'.esc_attr(charity_is_hope_get_animation_classes($animation)).'"' : '')
						. '>'
					. trim(charity_is_hope_get_reviews_placeholder())
					. '</div>'
			: '';
		return apply_filters('charity_is_hope_shortcode_output', $output, 'trx_reviews', $atts, $content);
	}
	charity_is_hope_require_shortcode("trx_reviews", "charity_is_hope_sc_reviews");
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'charity_is_hope_sc_reviews_reg_shortcodes' ) ) {
	//add_action('charity_is_hope_action_shortcodes_list', 'charity_is_hope_sc_reviews_reg_shortcodes');
	function charity_is_hope_sc_reviews_reg_shortcodes() {
	
		charity_is_hope_sc_map("trx_reviews", array(
			"title" => esc_html__("Reviews", 'charity-is-hope'),
			"desc" => wp_kses_data( __("Insert reviews block in the single post", 'charity-is-hope') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"align" => array(
					"title" => esc_html__("Alignment", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Align counter to left, center or right", 'charity-is-hope') ),
					"divider" => true,
					"value" => "none",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => charity_is_hope_get_sc_param('align')
				), 
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
if ( !function_exists( 'charity_is_hope_sc_reviews_reg_shortcodes_vc' ) ) {
	//add_action('charity_is_hope_action_shortcodes_list_vc', 'charity_is_hope_sc_reviews_reg_shortcodes_vc');
	function charity_is_hope_sc_reviews_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_reviews",
			"name" => esc_html__("Reviews", 'charity-is-hope'),
			"description" => wp_kses_data( __("Insert reviews block in the single post", 'charity-is-hope') ),
			"category" => esc_html__('Content', 'charity-is-hope'),
			'icon' => 'icon_trx_reviews',
			"class" => "trx_sc_single trx_sc_reviews",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "align",
					"heading" => esc_html__("Alignment", 'charity-is-hope'),
					"description" => wp_kses_data( __("Align counter to left, center or right", 'charity-is-hope') ),
					"class" => "",
					"value" => array_flip(charity_is_hope_get_sc_param('align')),
					"type" => "dropdown"
				),
				charity_is_hope_get_vc_param('id'),
				charity_is_hope_get_vc_param('class'),
				charity_is_hope_get_vc_param('animation'),
				charity_is_hope_get_vc_param('css'),
				charity_is_hope_get_vc_param('margin_top'),
				charity_is_hope_get_vc_param('margin_bottom'),
				charity_is_hope_get_vc_param('margin_left'),
				charity_is_hope_get_vc_param('margin_right')
			)
		) );
		
		class WPBakeryShortCode_Trx_Reviews extends CHARITY_IS_HOPE_VC_ShortCodeSingle {}
	}
}
?>