<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'charity_is_hope_template_header_7_theme_setup' ) ) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_template_header_7_theme_setup', 1 );
	function charity_is_hope_template_header_7_theme_setup() {
		charity_is_hope_add_template(array(
			'layout' => 'header_7',
			'mode'   => 'header',
			'title'  => esc_html__('Header 7', 'charity-is-hope'),
			'icon'   => charity_is_hope_get_file_url('templates/headers/images/7.jpg'),
			'thumb_title'  => esc_html__('Original image', 'charity-is-hope'),
			'w'		 => null,
			'h_crop' => null,
			'h'      => null
			));
	}
}

// Template output
if ( !function_exists( 'charity_is_hope_template_header_7_output' ) ) {
	function charity_is_hope_template_header_7_output($post_options, $post_data) {

		// Get custom image (for blog) or featured image (for single)
		$header_css = '';
		if (is_singular()) {
			$post_id = get_the_ID();
			$post_format = get_post_format();

			$header_image = wp_get_attachment_url(get_post_thumbnail_id($post_id));
		}
		if (empty($header_image))
			$header_image = charity_is_hope_get_custom_option('top_panel_image');
		if (empty($header_image))
			$header_image = get_header_image();
		if (!empty($header_image)) {
			// Uncomment next rows if you want crop image
			//$thumb_sizes = charity_is_hope_get_thumb_sizes(array( 'layout' => $post_options['layout'] ));
			//$header_image = charity_is_hope_get_resized_image_url($header_image, $thumb_sizes['w'], $thumb_sizes['h'], null, false, false, true);
			$header_css = ' style="background-image: url('.esc_url($header_image).')"';
		}
		?>

		<div class="top_panel_fixed_wrap"></div>

		<header class="top_panel_wrap top_panel_style_7 scheme_<?php echo esc_attr($post_options['scheme']); ?>">
			<div class="top_panel_wrap_inner top_panel_inner_style_7 top_panel_position_<?php echo esc_attr(charity_is_hope_get_custom_option('top_panel_position')); ?>">

				<?php if (charity_is_hope_get_custom_option('show_top_panel_top') == 'yes') { ?>
					<div class="top_panel_top">
						<div class="content_wrap clearfix">
							<?php
							charity_is_hope_template_set_args('top-panel-top', array(
								'top_panel_top_components' => array('login', 'currency', 'bookmarks', 'language', 'cart')
							));
							require CHARITY_IS_HOPE_THEME_PATH .'templates/headers/_parts/top-panel-top.php';
							?>
						</div>
					</div>
				<?php } ?>
				<div class="top_panel_middle">
					<div class="content_wrap">
						<div class="contact_logo">
							<?php charity_is_hope_show_logo(); ?>
						</div>
						<?php
						// info link
						$first_button = charity_is_hope_get_custom_option('first_button');
						$first_button_link = charity_is_hope_get_custom_option('first_button_link');
						$second_button = charity_is_hope_get_custom_option('second_button');
						$second_button_link = charity_is_hope_get_custom_option('second_button_link');
						if ((!empty($first_button) && !empty($first_button_link)) || (!empty($second_button) && !empty($second_button_link))) {
							?>
							<div class="contact_button">
								<?php
								if (!empty($first_button) && !empty($first_button_link)) {
									echo '<a class="first_button" href="' . esc_url($first_button_link) . '">' . esc_html($first_button) . '</a>';
								}
								if (!empty($second_button) && !empty($second_button_link)) {
									echo '<a class="second_button" href="' . esc_url($second_button_link) . '">' . esc_html($second_button) . '</a>';
								}
								?>
							</div>
						<?php
						}
						?>
						<div class="contact_socials">
							<?php if(function_exists('charity_is_hope_sc_socials')) charity_is_hope_show_layout(charity_is_hope_sc_socials(array('size' => 'tiny', 'shape' => 'round'))); ?>
						</div>
					</div>
				</div>

				<div class="top_panel_bottom">
					<div class="content_wrap clearfix">
						<nav
							class="menu_main_nav_area menu_hover_<?php echo esc_attr(charity_is_hope_get_theme_option('menu_hover')); ?>">
							<?php
							$menu_main = charity_is_hope_get_nav_menu('menu_main');
							if (empty($menu_main)) $menu_main = charity_is_hope_get_nav_menu();
							charity_is_hope_show_layout($menu_main);
							?>
						</nav>
						<?php if (charity_is_hope_get_custom_option('show_search') == 'yes') charity_is_hope_show_layout(charity_is_hope_sc_search(array("style" => charity_is_hope_get_theme_option('search_style')))); ?>
					</div>
				</div>

			</div>
		</header>
		<?php
		charity_is_hope_storage_set('header_mobile', array(
				'open_hours' => false,
				'login' => true,
				'socials' => true,
				'bookmarks' => false,
				'contact_address' => false,
				'contact_phone_email' => false,
				'woo_cart' => false,
				'search' => true
			)
		);
		if ($header_css) { ?>
		<section class="top_panel_image" <?php charity_is_hope_show_layout($header_css); ?>>
			<div class="top_panel_image_header"></div>
		</section>
		<?php
		}
	}
}
?>