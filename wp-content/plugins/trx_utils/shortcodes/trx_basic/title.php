<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('charity_is_hope_sc_title_theme_setup')) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_sc_title_theme_setup' );
	function charity_is_hope_sc_title_theme_setup() {
		add_action('charity_is_hope_action_shortcodes_list', 		'charity_is_hope_sc_title_reg_shortcodes');
		if (function_exists('charity_is_hope_exists_visual_composer') && charity_is_hope_exists_visual_composer())
			add_action('charity_is_hope_action_shortcodes_list_vc','charity_is_hope_sc_title_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_title id="unique_id" style='regular|iconed' icon='' image='' background="on|off" type="1-6"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/trx_title]
*/

if (!function_exists('charity_is_hope_sc_title')) {	
	function charity_is_hope_sc_title($atts, $content=null){	
		if (charity_is_hope_in_shortcode_blogger()) return '';
		extract(charity_is_hope_html_decode(shortcode_atts(array(
			// Individual params
			"type" => "1",
			"style" => "regular",
			"align" => "",
			"font_weight" => "",
			"font_size" => "",
			"color" => "",
			"icon" => "",
			"image" => "",
			"picture" => "",
			"image_size" => "small",
			"position" => "left",
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => "",
			"width" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
		$class .= ($class ? ' ' : '') . charity_is_hope_get_css_position_as_classes($top, $right, $bottom, $left);
		$css .= charity_is_hope_get_css_dimensions_from_values($width)
			.($align && $align!='none' && !charity_is_hope_param_is_inherit($align) ? 'text-align:' . esc_attr($align) .';' : '')
			.($color ? 'color:' . esc_attr($color) .';' : '')
			.($font_weight && !charity_is_hope_param_is_inherit($font_weight) ? 'font-weight:' . esc_attr($font_weight) .';' : '')
			.($font_size   ? 'font-size:' . esc_attr($font_size) .';' : '')
			;
		$type = min(6, max(1, $type));
		if ($picture > 0) {
			$attach = wp_get_attachment_image_src( $picture, 'full' );
			if (isset($attach[0]) && $attach[0]!='')
				$picture = $attach[0];
		}
		$pic = $style!='iconed' 
			? '' 
			: '<span class="sc_title_icon sc_title_icon_'.esc_attr($position).'  sc_title_icon_'.esc_attr($image_size).($icon!='' && $icon!='none' ? ' '.esc_attr($icon) : '').'"'.'>'
				.($picture ? '<img src="'.esc_url($picture).'" alt="" />' : '')
				.(empty($picture) && $image && $image!='none' ? '<img src="'.esc_url(charity_is_hope_strpos($image, 'http')===0 ? $image : charity_is_hope_get_file_url('images/icons/'.($image).'.png')).'" alt="" />' : '')
				.'</span>';
		$output = '<h' . esc_attr($type) . ($id ? ' id="'.esc_attr($id).'"' : '')
				. ' class="sc_title sc_title_'.esc_attr($style)
					.($align && $align!='none' && !charity_is_hope_param_is_inherit($align) ? ' sc_align_' . esc_attr($align) : '')
					.(!empty($class) ? ' '.esc_attr($class) : '')
					.'"'
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
				. (!charity_is_hope_param_is_off($animation) ? ' data-animation="'.esc_attr(charity_is_hope_get_animation_classes($animation)).'"' : '')
				. '>'
					. ($pic)
					. ($style=='divider' ? '<span class="sc_title_divider_before"'.($color ? ' style="background-color: '.esc_attr($color).'"' : '').'></span>' : '')
					. do_shortcode($content) 
					. ($style=='divider' ? '<span class="sc_title_divider_after"'.($color ? ' style="background-color: '.esc_attr($color).'"' : '').'></span>' : '')
				. '</h' . esc_attr($type) . '>';
		return apply_filters('charity_is_hope_shortcode_output', $output, 'trx_title', $atts, $content);
	}
	charity_is_hope_require_shortcode('trx_title', 'charity_is_hope_sc_title');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'charity_is_hope_sc_title_reg_shortcodes' ) ) {
	//add_action('charity_is_hope_action_shortcodes_list', 'charity_is_hope_sc_title_reg_shortcodes');
	function charity_is_hope_sc_title_reg_shortcodes() {
	
		charity_is_hope_sc_map("trx_title", array(
			"title" => esc_html__("Title", 'charity-is-hope'),
			"desc" => wp_kses_data( __("Create header tag (1-6 level) with many styles", 'charity-is-hope') ),
			"decorate" => false,
			"container" => true,
			"params" => array(
				"_content_" => array(
					"title" => esc_html__("Title content", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Title content", 'charity-is-hope') ),
					"rows" => 4,
					"value" => "",
					"type" => "textarea"
				),
				"type" => array(
					"title" => esc_html__("Title type", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Title type (header level)", 'charity-is-hope') ),
					"divider" => true,
					"value" => "1",
					"type" => "select",
					"options" => array(
						'1' => esc_html__('Header 1', 'charity-is-hope'),
						'2' => esc_html__('Header 2', 'charity-is-hope'),
						'3' => esc_html__('Header 3', 'charity-is-hope'),
						'4' => esc_html__('Header 4', 'charity-is-hope'),
						'5' => esc_html__('Header 5', 'charity-is-hope'),
						'6' => esc_html__('Header 6', 'charity-is-hope'),
					)
				),
				"style" => array(
					"title" => esc_html__("Title style", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Title style", 'charity-is-hope') ),
					"value" => "regular",
					"type" => "select",
					"options" => array(
						'regular' => esc_html__('Regular', 'charity-is-hope'),
						'underline' => esc_html__('Underline', 'charity-is-hope'),
						'divider' => esc_html__('Divider', 'charity-is-hope'),
						'iconed' => esc_html__('With icon (image)', 'charity-is-hope')
					)
				),
				"align" => array(
					"title" => esc_html__("Alignment", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Title text alignment", 'charity-is-hope') ),
					"value" => "",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => charity_is_hope_get_sc_param('align')
				), 
				"font_size" => array(
					"title" => esc_html__("Font_size", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Custom font size. If empty - use theme default", 'charity-is-hope') ),
					"value" => "",
					"type" => "text"
				),
				"font_weight" => array(
					"title" => esc_html__("Font weight", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Custom font weight. If empty or inherit - use theme default", 'charity-is-hope') ),
					"value" => "",
					"type" => "select",
					"size" => "medium",
					"options" => array(
						'inherit' => esc_html__('Default', 'charity-is-hope'),
						'100' => esc_html__('Thin (100)', 'charity-is-hope'),
						'300' => esc_html__('Light (300)', 'charity-is-hope'),
						'400' => esc_html__('Normal (400)', 'charity-is-hope'),
						'600' => esc_html__('Semibold (600)', 'charity-is-hope'),
						'700' => esc_html__('Bold (700)', 'charity-is-hope'),
						'900' => esc_html__('Black (900)', 'charity-is-hope')
					)
				),
				"color" => array(
					"title" => esc_html__("Title color", 'charity-is-hope'),
					"desc" => wp_kses_data( __("Select color for the title", 'charity-is-hope') ),
					"value" => "",
					"type" => "color"
				),
				"icon" => array(
					"title" => esc_html__('Title font icon',  'charity-is-hope'),
					"desc" => wp_kses_data( __("Select font icon for the title from Fontello icons set (if style=iconed)",  'charity-is-hope') ),
					"dependency" => array(
						'style' => array('iconed')
					),
					"value" => "",
					"type" => "icons",
					"options" => charity_is_hope_get_sc_param('icons')
				),
				"image" => array(
					"title" => esc_html__('or image icon',  'charity-is-hope'),
					"desc" => wp_kses_data( __("Select image icon for the title instead icon above (if style=iconed)",  'charity-is-hope') ),
					"dependency" => array(
						'style' => array('iconed')
					),
					"value" => "",
					"type" => "images",
					"size" => "small",
					"options" => charity_is_hope_get_sc_param('images')
				),
				"picture" => array(
					"title" => esc_html__('or URL for image file', 'charity-is-hope'),
					"desc" => wp_kses_data( __("Select or upload image or write URL from other site (if style=iconed)", 'charity-is-hope') ),
					"dependency" => array(
						'style' => array('iconed')
					),
					"readonly" => false,
					"value" => "",
					"type" => "media"
				),
				"image_size" => array(
					"title" => esc_html__('Image (picture) size', 'charity-is-hope'),
					"desc" => wp_kses_data( __("Select image (picture) size (if style='iconed')", 'charity-is-hope') ),
					"dependency" => array(
						'style' => array('iconed')
					),
					"value" => "small",
					"type" => "checklist",
					"options" => array(
						'small' => esc_html__('Small', 'charity-is-hope'),
						'medium' => esc_html__('Medium', 'charity-is-hope'),
						'large' => esc_html__('Large', 'charity-is-hope')
					)
				),
				"position" => array(
					"title" => esc_html__('Icon (image) position', 'charity-is-hope'),
					"desc" => wp_kses_data( __("Select icon (image) position (if style=iconed)", 'charity-is-hope') ),
					"dependency" => array(
						'style' => array('iconed')
					),
					"value" => "left",
					"type" => "checklist",
					"options" => array(
						'top' => esc_html__('Top', 'charity-is-hope'),
						'left' => esc_html__('Left', 'charity-is-hope')
					)
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
if ( !function_exists( 'charity_is_hope_sc_title_reg_shortcodes_vc' ) ) {
	//add_action('charity_is_hope_action_shortcodes_list_vc', 'charity_is_hope_sc_title_reg_shortcodes_vc');
	function charity_is_hope_sc_title_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_title",
			"name" => esc_html__("Title", 'charity-is-hope'),
			"description" => wp_kses_data( __("Create header tag (1-6 level) with many styles", 'charity-is-hope') ),
			"category" => esc_html__('Content', 'charity-is-hope'),
			'icon' => 'icon_trx_title',
			"class" => "trx_sc_single trx_sc_title",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "content",
					"heading" => esc_html__("Title content", 'charity-is-hope'),
					"description" => wp_kses_data( __("Title content", 'charity-is-hope') ),
					"class" => "",
					"value" => "",
					"type" => "textarea_html"
				),
				array(
					"param_name" => "type",
					"heading" => esc_html__("Title type", 'charity-is-hope'),
					"description" => wp_kses_data( __("Title type (header level)", 'charity-is-hope') ),
					"admin_label" => true,
					"class" => "",
					"value" => array(
						esc_html__('Header 1', 'charity-is-hope') => '1',
						esc_html__('Header 2', 'charity-is-hope') => '2',
						esc_html__('Header 3', 'charity-is-hope') => '3',
						esc_html__('Header 4', 'charity-is-hope') => '4',
						esc_html__('Header 5', 'charity-is-hope') => '5',
						esc_html__('Header 6', 'charity-is-hope') => '6'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "style",
					"heading" => esc_html__("Title style", 'charity-is-hope'),
					"description" => wp_kses_data( __("Title style: only text (regular) or with icon/image (iconed)", 'charity-is-hope') ),
					"admin_label" => true,
					"class" => "",
					"value" => array(
						esc_html__('Regular', 'charity-is-hope') => 'regular',
						esc_html__('Underline', 'charity-is-hope') => 'underline',
						esc_html__('Divider', 'charity-is-hope') => 'divider',
						esc_html__('With icon (image)', 'charity-is-hope') => 'iconed'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Alignment", 'charity-is-hope'),
					"description" => wp_kses_data( __("Title text alignment", 'charity-is-hope') ),
					"admin_label" => true,
					"class" => "",
					"value" => array_flip(charity_is_hope_get_sc_param('align')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "font_size",
					"heading" => esc_html__("Font size", 'charity-is-hope'),
					"description" => wp_kses_data( __("Custom font size. If empty - use theme default", 'charity-is-hope') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "font_weight",
					"heading" => esc_html__("Font weight", 'charity-is-hope'),
					"description" => wp_kses_data( __("Custom font weight. If empty or inherit - use theme default", 'charity-is-hope') ),
					"class" => "",
					"value" => array(
						esc_html__('Default', 'charity-is-hope') => 'inherit',
						esc_html__('Thin (100)', 'charity-is-hope') => '100',
						esc_html__('Light (300)', 'charity-is-hope') => '300',
						esc_html__('Normal (400)', 'charity-is-hope') => '400',
						esc_html__('Semibold (600)', 'charity-is-hope') => '600',
						esc_html__('Bold (700)', 'charity-is-hope') => '700',
						esc_html__('Black (900)', 'charity-is-hope') => '900'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "color",
					"heading" => esc_html__("Title color", 'charity-is-hope'),
					"description" => wp_kses_data( __("Select color for the title", 'charity-is-hope') ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "icon",
					"heading" => esc_html__("Title font icon", 'charity-is-hope'),
					"description" => wp_kses_data( __("Select font icon for the title from Fontello icons set (if style=iconed)", 'charity-is-hope') ),
					"class" => "",
					"group" => esc_html__('Icon &amp; Image', 'charity-is-hope'),
					'dependency' => array(
						'element' => 'style',
						'value' => array('iconed')
					),
					"value" => charity_is_hope_get_sc_param('icons'),
					"type" => "dropdown"
				),
				array(
					"param_name" => "image",
					"heading" => esc_html__("or image icon", 'charity-is-hope'),
					"description" => wp_kses_data( __("Select image icon for the title instead icon above (if style=iconed)", 'charity-is-hope') ),
					"class" => "",
					"group" => esc_html__('Icon &amp; Image', 'charity-is-hope'),
					'dependency' => array(
						'element' => 'style',
						'value' => array('iconed')
					),
					"value" => charity_is_hope_get_sc_param('images'),
					"type" => "dropdown"
				),
				array(
					"param_name" => "picture",
					"heading" => esc_html__("or select uploaded image", 'charity-is-hope'),
					"description" => wp_kses_data( __("Select or upload image or write URL from other site (if style=iconed)", 'charity-is-hope') ),
					"group" => esc_html__('Icon &amp; Image', 'charity-is-hope'),
					"class" => "",
					"value" => "",
					"type" => "attach_image"
				),
				array(
					"param_name" => "image_size",
					"heading" => esc_html__("Image (picture) size", 'charity-is-hope'),
					"description" => wp_kses_data( __("Select image (picture) size (if style=iconed)", 'charity-is-hope') ),
					"group" => esc_html__('Icon &amp; Image', 'charity-is-hope'),
					"class" => "",
					"value" => array(
						esc_html__('Small', 'charity-is-hope') => 'small',
						esc_html__('Medium', 'charity-is-hope') => 'medium',
						esc_html__('Large', 'charity-is-hope') => 'large'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "position",
					"heading" => esc_html__("Icon (image) position", 'charity-is-hope'),
					"description" => wp_kses_data( __("Select icon (image) position (if style=iconed)", 'charity-is-hope') ),
					"group" => esc_html__('Icon &amp; Image', 'charity-is-hope'),
					"class" => "",
					"std" => "left",
					"value" => array(
						esc_html__('Top', 'charity-is-hope') => 'top',
						esc_html__('Left', 'charity-is-hope') => 'left'
					),
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
			'js_view' => 'VcTrxTextView'
		) );
		
		class WPBakeryShortCode_Trx_Title extends CHARITY_IS_HOPE_VC_ShortCodeSingle {}
	}
}
?>