<?php
/* Tribe Events (TE) support functions
------------------------------------------------------------------------------- */


if (!defined('CHARITY_IS_HOPE_GIVE_TAXONOMY_CATEGORY')) 	{ define('CHARITY_IS_HOPE_GIVE_TAXONOMY_CATEGORY', 'give_forms_category'); }
if (!defined('CHARITY_IS_HOPE_GIVE_TAXONOMY_TAG')) 	{ define('CHARITY_IS_HOPE_GIVE_TAXONOMY_TAG', 'give_forms_tag'); }


if (!defined('CHARITY_IS_HOPE_GIVE_POST_TYPE_FORMS'))	{ define('CHARITY_IS_HOPE_GIVE_POST_TYPE_FORMS', 'give_forms'); }
if (!defined('CHARITY_IS_HOPE_GIVE_POST_TYPE_LIST')) 	{ define('CHARITY_IS_HOPE_GIVE_POST_TYPE_PAYMENTS', 'give_payment'); }
if (!defined('CHARITY_IS_HOPE_GIVE_FORMS_SLUG')) 		{ define('CHARITY_IS_HOPE_GIVE_FORMS_SLUG', (defined( 'GIVE_FORMS_SLUG' ) ? GIVE_FORMS_SLUG : 'donations')); }

// Theme init
if (!function_exists('charity_is_hope_give_theme_setup')) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_give_theme_setup', 1 );
	function charity_is_hope_give_theme_setup() {
		if (charity_is_hope_exists_give()) {

			// Hide goal process in the form content
			remove_action( 'give_pre_form',								'give_show_goal_progress', 10 );
			add_action( 'give_pre_form', 'charity_is_hope_give_pre_form', 55, 3 );

			add_action('charity_is_hope_action_add_styles',					'charity_is_hope_give_frontend_scripts' );
			add_action('give_donation_form_bottom',							'charity_is_hope_give_donation_form_bottom' );

			// Detect current page type, taxonomy and title (for custom post_types use priority < 10 to fire it handles early, than for standard post types)
			add_filter('charity_is_hope_filter_get_blog_type',			'charity_is_hope_give_get_blog_type', 9, 2);
			add_filter('charity_is_hope_filter_get_blog_title',			'charity_is_hope_give_get_blog_title', 9, 2);
			add_filter('charity_is_hope_filter_get_current_taxonomy',	'charity_is_hope_give_get_current_taxonomy', 9, 2);
			add_filter('charity_is_hope_filter_is_taxonomy',			'charity_is_hope_give_is_taxonomy', 9, 2);
			add_filter('charity_is_hope_filter_get_stream_page_title',	'charity_is_hope_give_get_stream_page_title', 9, 2);
//			add_filter('charity_is_hope_filter_get_stream_page_link',	'charity_is_hope_give_get_stream_page_link', 9, 2);
//			add_filter('charity_is_hope_filter_get_stream_page_id',		'charity_is_hope_give_get_stream_page_id', 9, 2);
//			add_filter('charity_is_hope_filter_query_add_filters',		'charity_is_hope_give_query_add_filters', 9, 2);
			add_filter('charity_is_hope_filter_list_post_types',		'charity_is_hope_give_list_post_types');
			// Register shortcodes in the list
			add_action('charity_is_hope_action_shortcodes_list',		'charity_is_hope_give_reg_shortcodes');
			if (function_exists('charity_is_hope_exists_visual_composer') && charity_is_hope_exists_visual_composer()) {
				add_action('charity_is_hope_action_shortcodes_list_vc','charity_is_hope_give_reg_shortcodes_vc');
			}

//			add_filter( 'give_currency_symbol', 							'charity_is_hope_give_currency_symbol', 10, 2 );
		}
		if (is_admin()) {
			add_filter( 'charity_is_hope_filter_required_plugins',			'charity_is_hope_give_required_plugins' );
		}
	}
}

// Check if Tribe Events installed and activated
if (!function_exists('charity_is_hope_exists_give')) {
	function charity_is_hope_exists_give() {
		return class_exists( 'Give' );
	}
}

if ( !function_exists( 'charity_is_hope_give_settings_theme_setup2' ) ) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_give_settings_theme_setup2', 3 );
	function charity_is_hope_give_settings_theme_setup2() {
		// Add Donations post type and taxonomy into theme inheritance list
		if (charity_is_hope_exists_trx_donations()) {
			charity_is_hope_add_theme_inheritance( array(CHARITY_IS_HOPE_GIVE_FORMS_SLUG => array(
					'stream_template' => '',
					'single_template' => '',
					'taxonomy' => array(CHARITY_IS_HOPE_GIVE_TAXONOMY_CATEGORY),
					'taxonomy_tags' => array(CHARITY_IS_HOPE_GIVE_TAXONOMY_TAG),
					'post_type' => array(CHARITY_IS_HOPE_GIVE_POST_TYPE_FORMS, CHARITY_IS_HOPE_GIVE_POST_TYPE_PAYMENTS),
					'override' => 'custom'
				) )
			);
		}
	}
}


// Filter to detect current page slug
if ( !function_exists( 'charity_is_hope_give_get_blog_type' ) ) {
	//add_filter('charity_is_hope_filter_get_blog_type',	'charity_is_hope_give_get_blog_type', 9, 2);
	function charity_is_hope_give_get_blog_type($page, $query=null) {
		if (!empty($page)) return $page;
		if ($query && $query->is_tax(CHARITY_IS_HOPE_GIVE_TAXONOMY_CATEGORY) || is_tax(CHARITY_IS_HOPE_GIVE_TAXONOMY_CATEGORY))
			$page = CHARITY_IS_HOPE_GIVE_TAXONOMY_CATEGORY;
		else if ($query && $query->is_tax(CHARITY_IS_HOPE_GIVE_TAXONOMY_TAG) || is_tax(CHARITY_IS_HOPE_GIVE_TAXONOMY_TAG))
			$page = CHARITY_IS_HOPE_GIVE_TAXONOMY_TAG;
		else if ($query && $query->get('post_type') == CHARITY_IS_HOPE_GIVE_POST_TYPE_FORMS
			|| get_query_var('post_type' == CHARITY_IS_HOPE_GIVE_POST_TYPE_FORMS))
			$page = $query && $query->is_single() || is_single() ? CHARITY_IS_HOPE_GIVE_POST_TYPE_FORMS . '_item' : CHARITY_IS_HOPE_GIVE_POST_TYPE_FORMS;
		else if ($query && $query->get('post_type') == CHARITY_IS_HOPE_GIVE_POST_TYPE_PAYMENTS
			|| get_query_var('post_type' == CHARITY_IS_HOPE_GIVE_POST_TYPE_PAYMENTS))
			$page = $query && $query->is_single() || is_single() ? CHARITY_IS_HOPE_GIVE_POST_TYPE_PAYMENTS . '_item' : CHARITY_IS_HOPE_GIVE_POST_TYPE_PAYMENTS;
		return $page;
	}
}

// Filter to detect current page title
if ( !function_exists( 'charity_is_hope_give_get_blog_title' ) ) {
	//add_filter('charity_is_hope_filter_get_blog_title',	'charity_is_hope_give_get_blog_title', 9, 2);
	function charity_is_hope_give_get_blog_title($title, $page) {
		if (!empty($title)) return $title;

		if ( charity_is_hope_strpos($page, CHARITY_IS_HOPE_GIVE_TAXONOMY_CATEGORY) !== false ) {
			$term = get_term_by( 'slug', get_query_var( CHARITY_IS_HOPE_GIVE_TAXONOMY_CATEGORY ), CHARITY_IS_HOPE_GIVE_TAXONOMY_CATEGORY, OBJECT);
			$title = $term->name;
		}
		if ( charity_is_hope_strpos($page, CHARITY_IS_HOPE_GIVE_TAXONOMY_TAG) !== false ) {
			$term = get_term_by( 'slug', get_query_var( CHARITY_IS_HOPE_GIVE_TAXONOMY_TAG ), CHARITY_IS_HOPE_GIVE_TAXONOMY_TAG, OBJECT);
			$title = $term->name;
		}
		if ( charity_is_hope_strpos($page, CHARITY_IS_HOPE_GIVE_POST_TYPE_FORMS . '_item')  !== false
			|| charity_is_hope_strpos($page, CHARITY_IS_HOPE_GIVE_POST_TYPE_PAYMENTS . '_item') !== false) {
			$title = charity_is_hope_get_post_title();
		}
		if ( charity_is_hope_strpos($page, CHARITY_IS_HOPE_GIVE_POST_TYPE_FORMS) !== false ) {
			$title = esc_html__('All donations', 'charity-is-hope');
		}
		if ( charity_is_hope_strpos($page, CHARITY_IS_HOPE_GIVE_POST_TYPE_PAYMENTS) !== false ) {
			$title = esc_html__('All paymants', 'charity-is-hope');
		}

		return $title;
	}
}

// Filter to detect stream page title
if ( !function_exists( 'charity_is_hope_give_get_stream_page_title' ) ) {
	//add_filter('charity_is_hope_filter_get_stream_page_title',	'charity_is_hope_give_get_stream_page_title', 9, 2);
	function charity_is_hope_give_get_stream_page_title($title, $page) {
		if (!empty($title)) return $title;

		if ( charity_is_hope_strpos($page, CHARITY_IS_HOPE_GIVE_POST_TYPE_FORMS . '_item') !== false ) {
			$title = charity_is_hope_get_post_title();
		}
		if ( charity_is_hope_strpos($page, CHARITY_IS_HOPE_GIVE_POST_TYPE_FORMS) !== false ) {
			$title = esc_html__('All donations', 'charity-is-hope');
		}

		return $title;
	}
}

// Add title to a donation form
if (!function_exists('charity_is_hope_give_pre_form')) {
	function charity_is_hope_give_pre_form($form_id, $args, $form) {
		echo '<h4 class="give-form-title">';
		esc_html_e('Donation form', 'charity-is-hope');
		echo '</h4>';
	}
}

// Add title to a donation form
if (!function_exists('charity_is_hope_give_currency_symbol')) {
	function charity_is_hope_give_currency_symbol($symbol, $currency) {
		return ' ' . $currency;
	}
}



// Enqueue Tribe Events custom styles
if ( !function_exists( 'charity_is_hope_give_frontend_scripts' ) ) {
	//add_action( 'charity_is_hope_action_add_styles', 'charity_is_hope_give_frontend_scripts' );
	function charity_is_hope_give_frontend_scripts() {
		if (file_exists(charity_is_hope_get_file_dir('css/plugin.give.css')))
			wp_enqueue_style( 'charity_is_hope-plugin.give-style',  charity_is_hope_get_file_url('css/plugin.give.css'), array(), null );
	}
}


// Filter to add in the required plugins list
if ( !function_exists( 'charity_is_hope_give_required_plugins' ) ) {
	//add_filter('charity_is_hope_filter_required_plugins',	'charity_is_hope_give_required_plugins');
	function charity_is_hope_give_required_plugins($list=array()) {
		if (in_array('give', (array)charity_is_hope_storage_get('required_plugins')))
			$list[] = array(
					'name' 		=> esc_html__('Give WP', 'charity-is-hope'),
					'slug' 		=> 'give',
					'required' 	=> false
				);

		return $list;
	}
}

// Add share buttons
if ( !function_exists( 'charity_is_hope_give_donation_form_bottom' ) ) {
	function charity_is_hope_give_donation_form_bottom() {
		$show_share = charity_is_hope_get_custom_option("show_share");
		if (!charity_is_hope_param_is_off($show_share)) {
			$rez = charity_is_hope_show_share_links(array(
				'post_id'    => get_the_ID(),
				'post_link'  => get_post_permalink(),
				'post_title' => get_the_title(),
				'post_descr' => strip_tags(get_the_excerpt()),
				'post_thumb' => get_the_post_thumbnail_url(),
				'type'		 => 'block',
				'echo'		 => false
			));
			if ($rez) {
				?>
				<div class="post_info post_info_bottom post_info_share post_info_share_<?php echo esc_attr($show_share); ?>"><?php charity_is_hope_show_layout($rez); ?></div>
				<?php
			}
		}
	}
}





// Widgets
//------------------------------------------------------------------------

// Load widget
if (!function_exists('charity_is_hope_widget_give_goal_load')) {
	add_action( 'widgets_init', 'charity_is_hope_widget_give_goal_load' );
	function charity_is_hope_widget_give_goal_load() {
		if (!charity_is_hope_exists_give()) { return; }

		register_widget( 'charity_is_hope_widget_give_goal' );
		register_widget( 'charity_is_hope_widget_give_donation_history' );
	}
}

// Widget Class

/**
 * Widget Give goal
 * Class charity_is_hope_widget_give_goal
 */
class charity_is_hope_widget_give_goal extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_give_goal', 'description' => esc_html__('Give goal', 'charity-is-hope'));
		parent::__construct('charity_is_hope_widget_give_goal', esc_html__('Charity Is Hope - Give goal', 'charity-is-hope'), $widget_ops);
	}

	// Show widget
	function widget($args, $instance) {

		extract($args);

		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '');
		$goal_description = isset($instance['goal_description']) ? $instance['goal_description'] : '';

		// Before widget (defined by themes)
		charity_is_hope_show_layout($before_widget);

		// Display the widget title if one was input (before and after defined by themes)
		if ($title) charity_is_hope_show_layout($title, $before_title, $after_title);

		if ($goal_description) echo '<p>' . esc_attr($goal_description) . '</p>';

		if (function_exists('give_show_goal_progress')) give_show_goal_progress(get_the_ID(), array());

		// After widget (defined by themes)
		charity_is_hope_show_layout($after_widget);
	}

	// Update the widget settings.
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['goal_description'] = strip_tags($new_instance['goal_description']);
		return $instance;
	}

	// Displays the widget settings controls on the widget panel.
	function form($instance) {

		// Set up some default widget settings
		$instance = wp_parse_args((array)$instance, array(
				'title' => '',
				'goal_description' => ''
			)
		);
		$title = $instance['title'];
		$goal_description = $instance['goal_description'];
		?>
		<p>
			<label
				for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'charity-is-hope'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id('title')); ?>"
				   name="<?php echo esc_attr($this->get_field_name('title')); ?>"
				   value="<?php echo esc_attr($title); ?>" class="widgets_param_fullwidth"/>
		</p>

		<p>
			<label
				for="<?php echo esc_attr($this->get_field_id('goal_description')); ?>"><?php esc_html_e('Goal description:', 'charity-is-hope'); ?></label>
			<textarea id="<?php echo esc_attr($this->get_field_id('goal_description')); ?>"
					  name="<?php echo esc_attr($this->get_field_name('goal_description')); ?>" rows="5"
					  class="widgets_param_fullwidth"><?php echo esc_attr($goal_description); ?></textarea>
		</p>
		<?php
	}
}


/**
 * Widget Give donation history
 * Class charity_is_hope_widget_give_donation_history
 */
class charity_is_hope_widget_give_donation_history extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_give_donation_history', 'description' => esc_html__('Give donation history', 'charity-is-hope'));
		parent::__construct('charity_is_hope_widget_give_donation_history', esc_html__('Charity Is Hope - Give donation history', 'charity-is-hope'), $widget_ops);
	}

	// Show widget
	function widget($args, $instance) {

		extract($args);

		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '');
		$goal_description = isset($instance['goal_description']) ? $instance['goal_description'] : '';

		// Before widget (defined by themes)
		charity_is_hope_show_layout($before_widget);

		// Display the widget title if one was input (before and after defined by themes)
		if ($title) charity_is_hope_show_layout($title, $before_title, $after_title);

		if ($goal_description) echo '<p>' . esc_attr($goal_description) . '</p>';

		if (shortcode_exists('donation_history')) echo do_shortcode('[donation_history]');

		// After widget (defined by themes)
		charity_is_hope_show_layout($after_widget);
	}

	// Update the widget settings.
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['goal_description'] = strip_tags($new_instance['goal_description']);
		return $instance;
	}

	// Displays the widget settings controls on the widget panel.
	function form($instance) {

		// Set up some default widget settings
		$instance = wp_parse_args((array)$instance, array(
				'title' => '',
				'goal_description' => ''
			)
		);
		$title = $instance['title'];
		$goal_description = $instance['goal_description'];
		?>
		<p>
			<label
					for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'charity-is-hope'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id('title')); ?>"
				   name="<?php echo esc_attr($this->get_field_name('title')); ?>"
				   value="<?php echo esc_attr($title); ?>" class="widgets_param_fullwidth"/>
		</p>

		<p>
			<label
					for="<?php echo esc_attr($this->get_field_id('goal_description')); ?>"><?php esc_html_e('Goal description:', 'charity-is-hope'); ?></label>
			<textarea id="<?php echo esc_attr($this->get_field_id('goal_description')); ?>"
					  name="<?php echo esc_attr($this->get_field_name('goal_description')); ?>" rows="5"
					  class="widgets_param_fullwidth"><?php echo esc_attr($goal_description); ?></textarea>
		</p>
		<?php
	}
}



// Shortcodes
//------------------------------------------------------------------------

/*
[trx_give_list ]
*/
if ( !function_exists( 'charity_is_hope_sc_give_list' ) ) {
	function charity_is_hope_sc_give_list($atts, $content=null){
		if (charity_is_hope_in_shortcode_blogger()) return '';
		extract(charity_is_hope_html_decode(shortcode_atts(array(
			// Individual params
			"style" => "excerpt",
			"columns" => 3,
			"cat" => "",
			"ids" => "",
			"count" => 3,
			"offset" => "",
			"orderby" => "date",
			"order" => "asc",
			"title" => "",
			"subtitle" => "",
			"description" => "",
			"link_caption" => esc_html__('More donations', 'charity-is-hope'),
			"link" => '',
			// Common params
			"id" => "",
			"class" => "",
			"css" => "",
			"top" => "",
			"bottom" => ""
		), $atts)));

		$post_type = CHARITY_IS_HOPE_GIVE_POST_TYPE_FORMS;
		$tax = CHARITY_IS_HOPE_GIVE_TAXONOMY_CATEGORY;
		$output = '';
		$in_shortcode = true;
		if (file_exists($tpl = charity_is_hope_get_file_dir( 'templates/trx_give_list/content-'.$style.'.php' ))) {

			if (empty($id)) $id = "sc_donations_".str_replace('.', '', mt_rand());

			$css .= !empty($top) ? 'margin-top:' . $top : '';
			$css .= !empty($bottom) ? 'margin-bottom:' . $bottom : '';

			$count = max(1, (int) $count);
			$columns = max(1, min(12, (int) $columns));
			if ($count < $columns) $columns = $count;

			$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '')
				. ' class="sc_donations'
				. ' sc_donations_style_'.esc_attr($style)
				. (!empty($class) ? ' '.esc_attr($class) : '')
				. '"'
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
				. '>'
				. (!empty($subtitle) ? '<h6 class="sc_donations_subtitle sc_item_subtitle">' . trim($subtitle) . '</h6>' : '')
				. (!empty($title) ? '<h2 class="sc_donations_title sc_item_title">' . trim($title) . '</h2>' : '')
				. (!empty($description) ? '<div class="sc_donations_descr sc_item_descr">' . trim($description) . '</div>' : '')
				. ($columns > 1
					? '<div class="columns_wrap sc_columns sc_columns_count_' . $columns . '">'
					: '');

			if (!empty($ids)) {
				$posts = explode(',', $ids);
				$count = count($posts);
				if ($count < $columns) $columns = $count;
			}

			$args = array(
				'post_type' => $post_type,
				'post_status' => 'publish',
				'posts_per_page' => $count,
				'ignore_sticky_posts' => true,
				'order' => $order=='desc' ? 'desc' : 'asc'
			);

			if ($offset > 0 && empty($ids)) {
				$args['offset'] = $offset;
			}

			$args = charity_is_hope_query_add_sort_order($args, $orderby, $order);
			$args = charity_is_hope_query_add_posts_and_cats($args, $ids, $post_type, $cat, $tax);

			$query = new WP_Query( $args );

			while ( $query->have_posts() ) {
				$query->the_post();
				ob_start();
				require $tpl;
				$output .= ob_get_contents();
				ob_end_clean();
			}
			wp_reset_postdata();

			if ($columns > 1) {
				$output .= '</div>';
			}

			$output .=  (!empty($link) ? '<div class="sc_donations_button sc_item_button"><a href="'.esc_url($link).'">'.esc_html($link_caption).'</a></div>' : '')
				. '</div><!-- /.sc_donations -->';
		}
	
		return apply_filters('charity_is_hope_shortcode_output', $output, 'trx_give_list', $atts, $content);
	}
	charity_is_hope_require_shortcode('trx_give_list', 'charity_is_hope_sc_give_list');
}


// Add sorting parameter in query arguments
if (!function_exists('charity_is_hope_query_add_sort_order')) {
	function charity_is_hope_query_add_sort_order($args, $orderby='date', $order='asc') {
		$q = array();
		$q['order'] = $order;
		if ($orderby == 'comments') {
			$q['orderby'] = 'comment_count';
		} else if ($orderby == 'title' || $orderby == 'alpha') {
			$q['orderby'] = 'title';
		} else if ($orderby == 'rand' || $orderby == 'random')  {
			$q['orderby'] = 'rand';
		} else {
			$q['orderby'] = 'post_date';
		}
		foreach ($q as $mk=>$mv) {
			if (is_array($args))
				$args[$mk] = $mv;
			else
				$args->set($mk, $mv);
		}
		return $args;
	}
}


// Add post type and posts list or categories list in query arguments
if (!function_exists('charity_is_hope_query_add_posts_and_cats')) {
	function charity_is_hope_query_add_posts_and_cats($args, $ids='', $post_type='', $cat='', $taxonomy='') {
		if (!empty($ids)) {
			$args['post_type'] = empty($args['post_type'])
				? (empty($post_type) ? array('post', 'page') : $post_type)
				: $args['post_type'];
			$args['post__in'] = explode(',', str_replace(' ', '', $ids));
		} else {
			$args['post_type'] = empty($args['post_type'])
				? (empty($post_type) ? 'post' : $post_type)
				: $args['post_type'];
			$post_type = is_array($args['post_type']) ? $args['post_type'][0] : $args['post_type'];
			if (!empty($cat)) {
				$cats = !is_array($cat) ? explode(',', $cat) : $cat;
				if (empty($taxonomy))
					$taxonomy = 'category';
				if ($taxonomy == 'category') {				// Add standard categories
					if (is_array($cats) && count($cats) > 1) {
						$cats_ids = array();
						foreach($cats as $c) {
							$c = trim(chop($c));
							if (empty($c)) continue;
							if ((int) $c == 0) {
								$cat_term = get_term_by( 'slug', $c, $taxonomy, OBJECT);
								if ($cat_term) $c = $cat_term->term_id;
							}
							if ($c==0) continue;
							$cats_ids[] = (int) $c;
							$children = get_categories( array(
								'type'                     => $post_type,
								'child_of'                 => $c,
								'hide_empty'               => 0,
								'hierarchical'             => 0,
								'taxonomy'                 => $taxonomy,
								'pad_counts'               => false
							));
							if (is_array($children) && count($children) > 0) {
								foreach($children as $c) {
									if (!in_array((int) $c->term_id, $cats_ids)) $cats_ids[] = (int) $c->term_id;
								}
							}
						}
						if (count($cats_ids) > 0) {
							$args['category__in'] = $cats_ids;
						}
					} else {
						if ((int) $cat > 0)
							$args['cat'] = (int) $cat;
						else
							$args['category_name'] = $cat;
					}
				} else {									// Add custom taxonomies
					if (!isset($args['tax_query']))
						$args['tax_query'] = array();
					$args['tax_query']['relation'] = 'AND';
					$args['tax_query'][] = array(
						'taxonomy' => $taxonomy,
						'include_children' => true,
						'field'    => (int) $cats[0] > 0 ? 'id' : 'slug',
						'terms'    => $cats
					);
				}
			}
		}
		return $args;
	}
}

// ---------------------------------- [/trx_give_list] ---------------------------------------


// Add [trx_give_list] in the VC shortcodes list

//// Add custom post type and/or taxonomies arguments to the query
//if ( !function_exists( 'charity_is_hope_give_query_add_filters' ) ) {
//	//add_filter('charity_is_hope_filter_query_add_filters',	'charity_is_hope_give_query_add_filters', 9, 2);
//	function charity_is_hope_give_query_add_filters($args, $filter) {
//		if ($filter == 'donations') {
//			$args['post_type'] = CHARITY_IS_HOPE_GIVE_POST_TYPE_LIST;
//		}
//		return $args;
//	}
//}

// Add custom post type to the list
if ( !function_exists( 'charity_is_hope_give_list_post_types' ) ) {
	//add_filter('charity_is_hope_filter_list_post_types',		'charity_is_hope_give_list_post_types');
	function charity_is_hope_give_list_post_types($list) {
		$list[CHARITY_IS_HOPE_GIVE_POST_TYPE_FORMS] = esc_html__('Give Donation forms', 'charity-is-hope');
		return $list;
	}
}


// Register shortcode in the shortcodes list
if (!function_exists('charity_is_hope_give_reg_shortcodes')) {
	//add_filter('charity_is_hope_action_shortcodes_list',	'charity_is_hope_give_reg_shortcodes');
	function charity_is_hope_give_reg_shortcodes() {
		if (charity_is_hope_storage_isset('shortcodes')) {

			$donations_groups = charity_is_hope_get_list_terms(false, CHARITY_IS_HOPE_GIVE_TAXONOMY_CATEGORY);

			charity_is_hope_sc_map_before('trx_dropcaps', array(

				// Donations list
				"trx_give_list" => array(
					"title" => esc_html__("Give donations list", 'charity-is-hope'),
					"desc" => esc_html__("Insert Donations list", 'charity-is-hope'),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"title" => array(
							"title" => esc_html__("Title", 'charity-is-hope'),
							"desc" => esc_html__("Title for the donations list", 'charity-is-hope'),
							"value" => "",
							"type" => "text"
						),
						"subtitle" => array(
							"title" => esc_html__("Subtitle", 'charity-is-hope'),
							"desc" => esc_html__("Subtitle for the donations list", 'charity-is-hope'),
							"value" => "",
							"type" => "text"
						),
						"description" => array(
							"title" => esc_html__("Description", 'charity-is-hope'),
							"desc" => esc_html__("Short description for the donations list", 'charity-is-hope'),
							"value" => "",
							"type" => "textarea"
						),
						"link" => array(
							"title" => esc_html__("Button URL", 'charity-is-hope'),
							"desc" => esc_html__("Link URL for the button at the bottom of the block", 'charity-is-hope'),
							"divider" => true,
							"value" => "",
							"type" => "text"
						),
						"link_caption" => array(
							"title" => esc_html__("Button caption", 'charity-is-hope'),
							"desc" => esc_html__("Caption for the button at the bottom of the block", 'charity-is-hope'),
							"value" => "",
							"type" => "text"
						),
						"style" => array(
							"title" => esc_html__("List style", 'charity-is-hope'),
							"desc" => esc_html__("Select style to display donations", 'charity-is-hope'),
							"value" => "excerpt",
							"type" => "select",
							"options" => array(
								'excerpt' => esc_html__('Excerpt', 'charity-is-hope'),
								'extra' => esc_html__('Extra', 'charity-is-hope')
							)
						),
						"readmore" => array(
							"title" => esc_html__("Read more text", 'charity-is-hope'),
							"desc" => esc_html__("Text of the 'Read more' link", 'charity-is-hope'),
							"value" => esc_html__('Read more', 'charity-is-hope'),
							"type" => "hidden"
						),
						"cat" => array(
							"title" => esc_html__("Categories", 'charity-is-hope'),
							"desc" => esc_html__("Select categories (groups) to show donations. If empty - select donations from any category (group) or from IDs list", 'charity-is-hope'),
							"divider" => true,
							"value" => "",
							"type" => "select",
							"style" => "list",
							"multiple" => true,
							"options" => charity_is_hope_array_merge(array(0 => esc_html__('- Select category -', 'charity-is-hope')), $donations_groups)
						),
						"count" => array(
							"title" => esc_html__("Number of donations", 'charity-is-hope'),
							"desc" => esc_html__("How many donations will be displayed? If used IDs - this parameter ignored.", 'charity-is-hope'),
							"value" => 3,
							"min" => 1,
							"max" => 100,
							"type" => "spinner"
						),
						"columns" => array(
							"title" => esc_html__("Columns", 'charity-is-hope'),
							"desc" => esc_html__("How many columns use to show donations list", 'charity-is-hope'),
							"value" => 3,
							"min" => 2,
							"max" => 6,
							"step" => 1,
							"type" => "spinner"
						),
						"offset" => array(
							"title" => esc_html__("Offset before select posts", 'charity-is-hope'),
							"desc" => esc_html__("Skip posts before select next part.", 'charity-is-hope'),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => 0,
							"min" => 0,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => esc_html__("Donadions order by", 'charity-is-hope'),
							"desc" => esc_html__("Select desired sorting method", 'charity-is-hope'),
							"value" => "date",
							"type" => "select",
							"options" => charity_is_hope_get_sc_param('sorting')
						),
						"order" => array(
							"title" => esc_html__("Donations order", 'charity-is-hope'),
							"desc" => esc_html__("Select donations order", 'charity-is-hope'),
							"value" => "asc",
							"type" => "switch",
							"size" => "big",
							"options" => charity_is_hope_get_sc_param('ordering')
						),
						"ids" => array(
							"title" => esc_html__("Donations IDs list", 'charity-is-hope'),
							"desc" => esc_html__("Comma separated list of donations ID. If set - parameters above are ignored!", 'charity-is-hope'),
							"value" => "",
							"type" => "text"
						),
						//"top" => charity_is_hope_get_sc_param('top'),
						//"bottom" => charity_is_hope_get_sc_param('bottom'),
						"id" => charity_is_hope_get_sc_param('id'),
						"class" => charity_is_hope_get_sc_param('class'),
						"css" => charity_is_hope_get_sc_param('css')
					)
				)

			));
		}
	}
}


// Register shortcode in the VC shortcodes list
if (!function_exists('charity_is_hope_give_reg_shortcodes_vc')) {
	//add_filter('charity_is_hope_action_shortcodes_list_vc',	'charity_is_hope_give_reg_shortcodes_vc');
	function charity_is_hope_give_reg_shortcodes_vc() {

		$donations_groups = charity_is_hope_get_list_terms(false, CHARITY_IS_HOPE_GIVE_TAXONOMY_CATEGORY);

		// Donations list
		vc_map( array(
			"base" => "trx_give_list",
			"name" => esc_html__("Give Donations list", 'charity-is-hope'),
			"description" => esc_html__("Insert Donations list", 'charity-is-hope'),
			"category" => esc_html__('Content', 'charity-is-hope'),
			'icon' => 'icon_trx_donations_list',
			"class" => "trx_sc_single trx_sc_donations_list",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "style",
					"heading" => esc_html__("List style", 'charity-is-hope'),
					"description" => esc_html__("Select style to display donations", 'charity-is-hope'),
					"class" => "",
					"value" => array(
						esc_html__('Excerpt', 'charity-is-hope') => 'excerpt',
						esc_html__('Extra', 'charity-is-hope') => 'extra'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "title",
					"heading" => esc_html__("Title", 'charity-is-hope'),
					"description" => esc_html__("Title for the donations form", 'charity-is-hope'),
					"group" => esc_html__('Captions', 'charity-is-hope'),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "subtitle",
					"heading" => esc_html__("Subtitle", 'charity-is-hope'),
					"description" => esc_html__("Subtitle for the donations form", 'charity-is-hope'),
					"group" => esc_html__('Captions', 'charity-is-hope'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "description",
					"heading" => esc_html__("Description", 'charity-is-hope'),
					"description" => esc_html__("Description for the donations form", 'charity-is-hope'),
					"group" => esc_html__('Captions', 'charity-is-hope'),
					"class" => "",
					"value" => "",
					"type" => "textarea"
				),
				array(
					"param_name" => "link",
					"heading" => esc_html__("Button URL", 'charity-is-hope'),
					"description" => esc_html__("Link URL for the button at the bottom of the block", 'charity-is-hope'),
					"group" => esc_html__('Captions', 'charity-is-hope'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "link_caption",
					"heading" => esc_html__("Button caption", 'charity-is-hope'),
					"description" => esc_html__("Caption for the button at the bottom of the block", 'charity-is-hope'),
					"group" => esc_html__('Captions', 'charity-is-hope'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "readmore",
					"heading" => esc_html__("Read more text", 'charity-is-hope'),
					"description" => esc_html__("Text of the 'Read more' link", 'charity-is-hope'),
					"group" => esc_html__('Captions', 'charity-is-hope'),
					"class" => "",
					"value" => esc_html__('Read more', 'charity-is-hope'),
					"type" => "hidden"
				),
				array(
					"param_name" => "cat",
					"heading" => esc_html__("Categories", 'charity-is-hope'),
					"description" => esc_html__("Select category to show donations. If empty - select donations from any category (group) or from IDs list", 'charity-is-hope'),
					"group" => esc_html__('Query', 'charity-is-hope'),
					"class" => "",
					"value" => array_flip(charity_is_hope_array_merge(array(0 => esc_html__('- Select category -', 'charity-is-hope')), $donations_groups)),
					"type" => "dropdown"
				),
				array(
					"param_name" => "columns",
					"heading" => esc_html__("Columns", 'charity-is-hope'),
					"description" => esc_html__("How many columns use to show donations", 'charity-is-hope'),
					"group" => esc_html__('Query', 'charity-is-hope'),
					"admin_label" => true,
					"class" => "",
					"value" => "3",
					"type" => "textfield"
				),
				array(
					"param_name" => "count",
					"heading" => esc_html__("Number of posts", 'charity-is-hope'),
					"description" => esc_html__("How many posts will be displayed? If used IDs - this parameter ignored.", 'charity-is-hope'),
					"group" => esc_html__('Query', 'charity-is-hope'),
					"class" => "",
					"value" => "3",
					"type" => "textfield"
				),
				array(
					"param_name" => "offset",
					"heading" => esc_html__("Offset before select posts", 'charity-is-hope'),
					"description" => esc_html__("Skip posts before select next part.", 'charity-is-hope'),
					"group" => esc_html__('Query', 'charity-is-hope'),
					"class" => "",
					"value" => "0",
					"type" => "textfield"
				),
				array(
					"param_name" => "orderby",
					"heading" => esc_html__("Post sorting", 'charity-is-hope'),
					"description" => esc_html__("Select desired posts sorting method", 'charity-is-hope'),
					"group" => esc_html__('Query', 'charity-is-hope'),
					"class" => "",
					"value" => array_flip((array)charity_is_hope_get_sc_param('sorting')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "order",
					"heading" => esc_html__("Post order", 'charity-is-hope'),
					"description" => esc_html__("Select desired posts order", 'charity-is-hope'),
					"group" => esc_html__('Query', 'charity-is-hope'),
					"class" => "",
					"value" => array_flip((array)charity_is_hope_get_sc_param('ordering')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "ids",
					"heading" => esc_html__("client's IDs list", 'charity-is-hope'),
					"description" => esc_html__("Comma separated list of donation's ID. If set - parameters above (category, count, order, etc.)  are ignored!", 'charity-is-hope'),
					"group" => esc_html__('Query', 'charity-is-hope'),
					'dependency' => array(
						'element' => 'cats',
						'is_empty' => true
					),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),

				charity_is_hope_get_vc_param('id'),
				charity_is_hope_get_vc_param('class'),
				charity_is_hope_get_vc_param('css'),
				//charity_is_hope_get_vc_param('margin_top'),
				//charity_is_hope_get_vc_param('margin_bottom')
			)
		) );

		class WPBakeryShortCode_Trx_Donations_List extends CHARITY_IS_HOPE_VC_ShortCodeSingle {}

	}
}
?>