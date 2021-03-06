<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('charity_is_hope_sc_accordion_theme_setup')) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_sc_accordion_theme_setup' );
	function charity_is_hope_sc_accordion_theme_setup() {
		add_action('charity_is_hope_action_shortcodes_list', 		'charity_is_hope_sc_accordion_reg_shortcodes');
		if (function_exists('charity_is_hope_exists_visual_composer') && charity_is_hope_exists_visual_composer())
			add_action('charity_is_hope_action_shortcodes_list_vc','charity_is_hope_sc_accordion_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_accordion counter="off" initial="1"]
	[trx_accordion_item title="Accordion Title 1"]Lorem ipsum dolor sit amet, consectetur adipisicing elit[/trx_accordion_item]
	[trx_accordion_item title="Accordion Title 2"]Proin dignissim commodo magna at luctus. Nam molestie justo augue, nec eleifend urna laoreet non.[/trx_accordion_item]
	[trx_accordion_item title="Accordion Title 3 with custom icons" icon_closed="icon-check" icon_opened="icon-delete"]Curabitur tristique tempus arcu a placerat.[/trx_accordion_item]
[/trx_accordion]
*/
if (!function_exists('charity_is_hope_sc_accordion')) {	
	function charity_is_hope_sc_accordion($atts, $content=null){	
		if (charity_is_hope_in_shortcode_blogger()) return '';
		extract(charity_is_hope_html_decode(shortcode_atts(array(
			// Individual params
			"initial" => "1",
			"counter" => "off",
			"icon_closed" => "icon-plus",
			"icon_opened" => "icon-minus",
			// Common params
			"id" => "",
			"class" => "",
			"css" => "",
			"animation" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
		$class .= ($class ? ' ' : '') . charity_is_hope_get_css_position_as_classes($top, $right, $bottom, $left);
		$initial = max(0, (int) $initial);
		charity_is_hope_storage_set('sc_accordion_data', array(
			'counter' => 0,
            'show_counter' => charity_is_hope_param_is_on($counter),
            'icon_closed' => empty($icon_closed) || charity_is_hope_param_is_inherit($icon_closed) ? "icon-plus" : $icon_closed,
            'icon_opened' => empty($icon_opened) || charity_is_hope_param_is_inherit($icon_opened) ? "icon-minus" : $icon_opened
            )
        );
		wp_enqueue_script('jquery-ui-accordion', false, array('jquery','jquery-ui-core'), null, true);
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_accordion'
					. (!empty($class) ? ' '.esc_attr($class) : '')
					. (charity_is_hope_param_is_on($counter) ? ' sc_show_counter' : '') 
				. '"'
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
				. ' data-active="' . ($initial-1) . '"'
				. (!charity_is_hope_param_is_off($animation) ? ' data-animation="'.esc_attr(charity_is_hope_get_animation_classes($animation)).'"' : '')
				. '>'
				. do_shortcode($content)
				. '</div>';
		return apply_filters('charity_is_hope_shortcode_output', $output, 'trx_accordion', $atts, $content);
	}
	charity_is_hope_require_shortcode('trx_accordion', 'charity_is_hope_sc_accordion');
}


if (!function_exists('charity_is_hope_sc_accordion_item')) {	
	function charity_is_hope_sc_accordion_item($atts, $content=null) {
		if (charity_is_hope_in_shortcode_blogger()) return '';
		extract(charity_is_hope_html_decode(shortcode_atts( array(
			// Individual params
			"icon_closed" => "",
			"icon_opened" => "",
			"title" => "",
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
		), $atts)));
		charity_is_hope_storage_inc_array('sc_accordion_data', 'counter');
		if (empty($icon_closed) || charity_is_hope_param_is_inherit($icon_closed)) $icon_closed = charity_is_hope_storage_get_array('sc_accordion_data', 'icon_closed', '', "icon-plus");
		if (empty($icon_opened) || charity_is_hope_param_is_inherit($icon_opened)) $icon_opened = charity_is_hope_storage_get_array('sc_accordion_data', 'icon_opened', '', "icon-minus");
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_accordion_item' 
				. (!empty($class) ? ' '.esc_attr($class) : '')
				. (charity_is_hope_storage_get_array('sc_accordion_data', 'counter') % 2 == 1 ? ' odd' : ' even') 
				. (charity_is_hope_storage_get_array('sc_accordion_data', 'counter') == 1 ? ' first' : '') 
				. '">'
				. '<h5 class="sc_accordion_title">'
				. (!charity_is_hope_param_is_off($icon_closed) ? '<span class="sc_accordion_icon sc_accordion_icon_closed '.esc_attr($icon_closed).'"></span>' : '')
				. (!charity_is_hope_param_is_off($icon_opened) ? '<span class="sc_accordion_icon sc_accordion_icon_opened '.esc_attr($icon_opened).'"></span>' : '')
				. (charity_is_hope_storage_get_array('sc_accordion_data', 'show_counter') ? '<span class="sc_items_counter">'.(charity_is_hope_storage_get_array('sc_accordion_data', 'counter')).'</span>' : '')
				. ($title)
				. '</h5>'
				. '<div class="sc_accordion_content"'
					. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
					. '>'
					. do_shortcode($content) 
				. '</div>'
				. '</div>';
		return apply_filters('charity_is_hope_shortcode_output', $output, 'trx_accordion_item', $atts, $content);
	}
	charity_is_hope_require_shortcode('trx_accordion_item', 'charity_is_hope_sc_accordion_item');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'charity_is_hope_sc_accordion_reg_shortcodes' ) ) {
	//add_action('charity_is_hope_action_shortcodes_list', 'charity_is_hope_sc_accordion_reg_shortcodes');
	function charity_is_hope_sc_accordion_reg_shortcodes() {
	
		charity_is_hope_sc_map("trx_accordion", array(
			"title" => esc_html__("Accordion", 'charity-is-hope'),
			"desc" => wp_kses_data( __("Accordion items", 'charity-is-hope') ),
			"decorate" => true,
			"container" => false,
			"params" => array(
				"counter" => array(
					"title" => esc_html__("Counter", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Display counter before each accordion title", 'charity-is-hope') ),
					"value" => "off",
					"type" => "switch",
					"options" => charity_is_hope_get_sc_param('on_off')
				),
				"initial" => array(
					"title" => esc_html__("Initially opened item", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Number of initially opened item", 'charity-is-hope') ),
					"value" => 1,
					"min" => 0,
					"type" => "spinner"
				),
				"icon_closed" => array(
					"title" => esc_html__("Icon while closed",  'charity-is-hope'),
					"desc" => wp_kses_data( __('Select icon for the closed accordion item from Fontello icons set',  'charity-is-hope') ),
					"value" => "",
					"type" => "icons",
					"options" => charity_is_hope_get_sc_param('icons')
				),
				"icon_opened" => array(
					"title" => esc_html__("Icon while opened",  'charity-is-hope'),
					"desc" => wp_kses_data( __('Select icon for the opened accordion item from Fontello icons set',  'charity-is-hope') ),
					"value" => "",
					"type" => "icons",
					"options" => charity_is_hope_get_sc_param('icons')
				),
				"top" => charity_is_hope_get_sc_param('top'),
				"bottom" => charity_is_hope_get_sc_param('bottom'),
				"left" => charity_is_hope_get_sc_param('left'),
				"right" => charity_is_hope_get_sc_param('right'),
				"id" => charity_is_hope_get_sc_param('id'),
				"class" => charity_is_hope_get_sc_param('class'),
				"animation" => charity_is_hope_get_sc_param('animation'),
				"css" => charity_is_hope_get_sc_param('css')
			),
			"children" => array(
				"name" => "trx_accordion_item",
				"title" => esc_html__("Item", 'charity-is-hope'),
				"desc" => wp_kses_data( __("Accordion item", 'charity-is-hope') ),
				"container" => true,
				"params" => array(
					"title" => array(
						"title" => esc_html__("Accordion item title", 'charity-is-hope'),
						"desc" => wp_kses_data( __("Title for current accordion item", 'charity-is-hope') ),
						"value" => "",
						"type" => "text"
					),
					"icon_closed" => array(
						"title" => esc_html__("Icon while closed",  'charity-is-hope'),
						"desc" => wp_kses_data( __('Select icon for the closed accordion item from Fontello icons set',  'charity-is-hope') ),
						"value" => "",
						"type" => "icons",
						"options" => charity_is_hope_get_sc_param('icons')
					),
					"icon_opened" => array(
						"title" => esc_html__("Icon while opened",  'charity-is-hope'),
						"desc" => wp_kses_data( __('Select icon for the opened accordion item from Fontello icons set',  'charity-is-hope') ),
						"value" => "",
						"type" => "icons",
						"options" => charity_is_hope_get_sc_param('icons')
					),
					"_content_" => array(
						"title" => esc_html__("Accordion item content", 'charity-is-hope'),
						"desc" => wp_kses_data( __("Current accordion item content", 'charity-is-hope') ),
						"rows" => 4,
						"value" => "",
						"type" => "textarea"
					),
					"id" => charity_is_hope_get_sc_param('id'),
					"class" => charity_is_hope_get_sc_param('class'),
					"css" => charity_is_hope_get_sc_param('css')
				)
			)
		));
	}
}


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'charity_is_hope_sc_accordion_reg_shortcodes_vc' ) ) {
	//add_action('charity_is_hope_action_shortcodes_list_vc', 'charity_is_hope_sc_accordion_reg_shortcodes_vc');
	function charity_is_hope_sc_accordion_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_accordion",
			"name" => esc_html__("Accordion", 'charity-is-hope'),
			"description" => wp_kses_data( __("Accordion items", 'charity-is-hope') ),
			"category" => esc_html__('Content', 'charity-is-hope'),
			'icon' => 'icon_trx_accordion',
			"class" => "trx_sc_collection trx_sc_accordion",
			"content_element" => true,
			"is_container" => true,
			"show_settings_on_create" => false,
			"as_parent" => array('only' => 'trx_accordion_item'),	// Use only|except attributes to limit child shortcodes (separate multiple values with comma)
			"params" => array(
				array(
					"param_name" => "counter",
					"heading" => esc_html__("Counter", 'charity-is-hope'),
					"description" => wp_kses_data( __("Display counter before each accordion title", 'charity-is-hope') ),
					"class" => "",
					"value" => array("Add item numbers before each element" => "on" ),
					"type" => "checkbox"
				),
				array(
					"param_name" => "initial",
					"heading" => esc_html__("Initially opened item", 'charity-is-hope'),
					"description" => wp_kses_data( __("Number of initially opened item", 'charity-is-hope') ),
					"class" => "",
					"value" => 1,
					"type" => "textfield"
				),
				array(
					"param_name" => "icon_closed",
					"heading" => esc_html__("Icon while closed", 'charity-is-hope'),
					"description" => wp_kses_data( __("Select icon for the closed accordion item from Fontello icons set", 'charity-is-hope') ),
					"class" => "",
					"value" => charity_is_hope_get_sc_param('icons'),
					"type" => "dropdown"
				),
				array(
					"param_name" => "icon_opened",
					"heading" => esc_html__("Icon while opened", 'charity-is-hope'),
					"description" => wp_kses_data( __("Select icon for the opened accordion item from Fontello icons set", 'charity-is-hope') ),
					"class" => "",
					"value" => charity_is_hope_get_sc_param('icons'),
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
			),
			'default_content' => '
				[trx_accordion_item title="' . esc_html__( 'Item 1 title', 'charity-is-hope' ) . '"][/trx_accordion_item]
				[trx_accordion_item title="' . esc_html__( 'Item 2 title', 'charity-is-hope' ) . '"][/trx_accordion_item]
			',
			"custom_markup" => '
				<div class="wpb_accordion_holder wpb_holder clearfix vc_container_for_children">
					%content%
				</div>
				<div class="tab_controls">
					<button class="add_tab" title="'.esc_attr__("Add item", 'charity-is-hope').'">'.esc_html__("Add item", 'charity-is-hope').'</button>
				</div>
			',
			'js_view' => 'VcTrxAccordionView'
		) );
		
		
		vc_map( array(
			"base" => "trx_accordion_item",
			"name" => esc_html__("Accordion item", 'charity-is-hope'),
			"description" => wp_kses_data( __("Inner accordion item", 'charity-is-hope') ),
			"show_settings_on_create" => true,
			"content_element" => true,
			"is_container" => true,
			'icon' => 'icon_trx_accordion_item',
			"as_child" => array('only' => 'trx_accordion'), 	// Use only|except attributes to limit parent (separate multiple values with comma)
			"as_parent" => array('except' => 'trx_accordion'),
			"params" => array(
				array(
					"param_name" => "title",
					"heading" => esc_html__("Title", 'charity-is-hope'),
					"description" => wp_kses_data( __("Title for current accordion item", 'charity-is-hope') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "icon_closed",
					"heading" => esc_html__("Icon while closed", 'charity-is-hope'),
					"description" => wp_kses_data( __("Select icon for the closed accordion item from Fontello icons set", 'charity-is-hope') ),
					"class" => "",
					"value" => charity_is_hope_get_sc_param('icons'),
					"type" => "dropdown"
				),
				array(
					"param_name" => "icon_opened",
					"heading" => esc_html__("Icon while opened", 'charity-is-hope'),
					"description" => wp_kses_data( __("Select icon for the opened accordion item from Fontello icons set", 'charity-is-hope') ),
					"class" => "",
					"value" => charity_is_hope_get_sc_param('icons'),
					"type" => "dropdown"
				),
				charity_is_hope_get_vc_param('id'),
				charity_is_hope_get_vc_param('class'),
				charity_is_hope_get_vc_param('css')
			),
		  'js_view' => 'VcTrxAccordionTabView'
		) );

		class WPBakeryShortCode_Trx_Accordion extends CHARITY_IS_HOPE_VC_ShortCodeAccordion {}
		class WPBakeryShortCode_Trx_Accordion_Item extends CHARITY_IS_HOPE_VC_ShortCodeAccordionItem {}
	}
}
?>