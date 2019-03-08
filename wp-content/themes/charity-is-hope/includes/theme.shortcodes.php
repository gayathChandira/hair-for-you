<?php
if (!function_exists('charity_is_hope_theme_shortcodes_setup')) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_theme_shortcodes_setup', 1 );
	function charity_is_hope_theme_shortcodes_setup() {
		add_filter('charity_is_hope_filter_googlemap_styles', 'charity_is_hope_theme_shortcodes_googlemap_styles');
	}
}


// Add theme-specific Google map styles
if ( !function_exists( 'charity_is_hope_theme_shortcodes_googlemap_styles' ) ) {
	function charity_is_hope_theme_shortcodes_googlemap_styles($list) {
		$list['simple']		= esc_html__('Simple', 'charity-is-hope');
		$list['greyscale']	= esc_html__('Greyscale', 'charity-is-hope');
		$list['inverse']	= esc_html__('Inverse', 'charity-is-hope');
		$list['apple']		= esc_html__('Apple', 'charity-is-hope');
		return $list;
	}
}
?>