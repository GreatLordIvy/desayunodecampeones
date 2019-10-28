<?php
/* Tribe Events Calendar support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 1 - register filters, that add/remove lists items for the Theme Options
if (!function_exists('studeon_tribe_events_theme_setup1')) {
	add_action( 'after_setup_theme', 'studeon_tribe_events_theme_setup1', 1 );
	function studeon_tribe_events_theme_setup1() {
		add_filter( 'studeon_filter_list_sidebars', 'studeon_tribe_events_list_sidebars' );
	}
}

// Theme init priorities:
// 3 - add/remove Theme Options elements
if (!function_exists('studeon_tribe_events_theme_setup3')) {
	add_action( 'after_setup_theme', 'studeon_tribe_events_theme_setup3', 3 );
	function studeon_tribe_events_theme_setup3() {
		if (studeon_exists_tribe_events()) {
		
			studeon_storage_merge_array('options', '', array(
				// Section 'Tribe Events' - settings for show pages
				'events' => array(
					"title" => esc_html__('Events', 'studeon'),
					"desc" => wp_kses_data( __('Select parameters to display the events pages', 'studeon') ),
					"type" => "section"
					),
				'expand_content_events' => array(
					"title" => esc_html__('Expand content', 'studeon'),
					"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'studeon') ),
					"refresh" => false,
					"std" => 1,
					"type" => "checkbox"
					),
				'header_style_events' => array(
					"title" => esc_html__('Header style', 'studeon'),
					"desc" => wp_kses_data( __('Select style to display the site header on the events pages', 'studeon') ),
					"std" => 'inherit',
					"options" => array(),
					"type" => "select"
					),
				'header_position_events' => array(
					"title" => esc_html__('Header position', 'studeon'),
					"desc" => wp_kses_data( __('Select position to display the site header on the events pages', 'studeon') ),
					"std" => 'inherit',
					"options" => array(),
					"type" => "select"
					),
				'header_widgets_events' => array(
					"title" => esc_html__('Header widgets', 'studeon'),
					"desc" => wp_kses_data( __('Select set of widgets to show in the header on the events pages', 'studeon') ),
					"std" => 'hide',
					"options" => array(),
					"type" => "select"
					),
				'sidebar_widgets_events' => array(
					"title" => esc_html__('Sidebar widgets', 'studeon'),
					"desc" => wp_kses_data( __('Select sidebar to show on the events pages', 'studeon') ),
					"std" => 'tribe_events_widgets',
					"options" => array(),
					"type" => "select"
					),
				'sidebar_position_events' => array(
					"title" => esc_html__('Sidebar position', 'studeon'),
					"desc" => wp_kses_data( __('Select position to show sidebar on the events pages', 'studeon') ),
					"refresh" => false,
					"std" => 'left',
					"options" => array(),
					"type" => "select"
					),
				'hide_sidebar_on_single_events' => array(
					"title" => esc_html__('Hide sidebar on the single event', 'studeon'),
					"desc" => wp_kses_data( __("Hide sidebar on the single event's page", 'studeon') ),
					"std" => 0,
					"type" => "checkbox"
					),
				'widgets_above_page_events' => array(
					"title" => esc_html__('Widgets above the page', 'studeon'),
					"desc" => wp_kses_data( __('Select widgets to show above page (content and sidebar)', 'studeon') ),
					"std" => 'hide',
					"options" => array(),
					"type" => "select"
					),
				'widgets_above_content_events' => array(
					"title" => esc_html__('Widgets above the content', 'studeon'),
					"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'studeon') ),
					"std" => 'hide',
					"options" => array(),
					"type" => "select"
					),
				'widgets_below_content_events' => array(
					"title" => esc_html__('Widgets below the content', 'studeon'),
					"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'studeon') ),
					"std" => 'hide',
					"options" => array(),
					"type" => "select"
					),
				'widgets_below_page_events' => array(
					"title" => esc_html__('Widgets below the page', 'studeon'),
					"desc" => wp_kses_data( __('Select widgets to show below the page (content and sidebar)', 'studeon') ),
					"std" => 'hide',
					"options" => array(),
					"type" => "select"
					),
				'footer_scheme_events' => array(
					"title" => esc_html__('Footer Color Scheme', 'studeon'),
					"desc" => wp_kses_data( __('Select color scheme to decorate footer area', 'studeon') ),
					"std" => 'dark',
					"options" => array(),
					"type" => "select"
					),
				'footer_widgets_events' => array(
					"title" => esc_html__('Footer widgets', 'studeon'),
					"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'studeon') ),
					"std" => 'footer_widgets',
					"options" => array(),
					"type" => "select"
					),
				'footer_columns_events' => array(
					"title" => esc_html__('Footer columns', 'studeon'),
					"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'studeon') ),
					"dependency" => array(
						'footer_widgets_events' => array('^hide')
					),
					"std" => 0,
					"options" => studeon_get_list_range(0,6),
					"type" => "select"
					),
				'footer_wide_events' => array(
					"title" => esc_html__('Footer fullwide', 'studeon'),
					"desc" => wp_kses_data( __('Do you want to stretch the footer to the entire window width?', 'studeon') ),
					"std" => 0,
					"type" => "checkbox"
					)
				)
			);
		}
	}
}

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('studeon_tribe_events_theme_setup9')) {
	add_action( 'after_setup_theme', 'studeon_tribe_events_theme_setup9', 9 );
	function studeon_tribe_events_theme_setup9() {
		
		if (studeon_exists_tribe_events()) {
			add_action( 'wp_enqueue_scripts', 								'studeon_tribe_events_frontend_scripts', 1100 );
			add_filter( 'studeon_filter_merge_styles',						'studeon_tribe_events_merge_styles' );
			add_filter( 'studeon_filter_get_css',							'studeon_tribe_events_get_css', 10, 4 );
			add_filter( 'studeon_filter_post_type_taxonomy',				'studeon_tribe_events_post_type_taxonomy', 10, 2 );
			if (!is_admin()) {
				add_filter( 'studeon_filter_detect_blog_mode',				'studeon_tribe_events_detect_blog_mode' );
				add_filter( 'studeon_filter_get_post_categories', 			'studeon_tribe_events_get_post_categories');
				add_filter( 'studeon_filter_get_post_date',		 			'studeon_tribe_events_get_post_date');
			}
		}
		if (is_admin()) {
			add_filter( 'studeon_filter_tgmpa_required_plugins',			'studeon_tribe_events_tgmpa_required_plugins' );
		}

	}
}



// Check if Tribe Events is installed and activated
if ( !function_exists( 'studeon_exists_tribe_events' ) ) {
	function studeon_exists_tribe_events() {
		return class_exists( 'Tribe__Events__Main' );
	}
}

// Return true, if current page is any tribe_events page
if ( !function_exists( 'studeon_is_tribe_events_page' ) ) {
	function studeon_is_tribe_events_page() {
		$rez = false;
		if (studeon_exists_tribe_events())
			if (!is_search()) $rez = tribe_is_event() || tribe_is_event_query() || tribe_is_event_category() || tribe_is_event_venue() || tribe_is_event_organizer();
		return $rez;
	}
}

// Detect current blog mode
if ( !function_exists( 'studeon_tribe_events_detect_blog_mode' ) ) {
	//Handler of the add_filter( 'studeon_filter_detect_blog_mode', 'studeon_tribe_events_detect_blog_mode' );
	function studeon_tribe_events_detect_blog_mode($mode='') {
		if (studeon_is_tribe_events_page())
			$mode = 'events';
		return $mode;
	}
}

// Return taxonomy for current post type
if ( !function_exists( 'studeon_tribe_events_post_type_taxonomy' ) ) {
	//Handler of the add_filter( 'studeon_filter_post_type_taxonomy',	'studeon_tribe_events_post_type_taxonomy', 10, 2 );
	function studeon_tribe_events_post_type_taxonomy($tax='', $post_type='') {
		if (studeon_exists_tribe_events() && $post_type == Tribe__Events__Main::POSTTYPE)
			$tax = Tribe__Events__Main::TAXONOMY;
		return $tax;
	}
}

// Show categories of the current event
if ( !function_exists( 'studeon_tribe_events_get_post_categories' ) ) {
	//Handler of the add_filter( 'studeon_filter_get_post_categories', 		'studeon_tribe_events_get_post_categories');
	function studeon_tribe_events_get_post_categories($cats='') {
		global $wp_query;
		$id = $wp_query->current_post>=0 ? get_the_ID() : $wp_query->post->ID;
		$post_type = $wp_query->current_post>=0 ? get_post_type() : $wp_query->post->post_type;
		if ($post_type==Tribe__Events__Main::POSTTYPE) {
			$cats = studeon_get_post_terms(', ', $id, Tribe__Events__Main::TAXONOMY);
		}
		return $cats;
	}
}

// Return date of the current event
if ( !function_exists( 'studeon_tribe_events_get_post_date' ) ) {
	function studeon_tribe_events_get_post_date($dt='') {
		if (get_post_type() == Tribe__Events__Main::POSTTYPE) {
			$dt = tribe_get_start_date(null, true, 'Y-m-d');
			$dt = sprintf($dt < date('Y-m-d') 
								? esc_html__('Started on %s', 'studeon')
								: esc_html__('Starting %s', 'studeon'),
								date(get_option('date_format'), strtotime($dt)));
		}
		return $dt;
	}
}

// Enqueue Tribe Events custom scripts and styles
if ( !function_exists( 'studeon_tribe_events_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'studeon_tribe_events_frontend_scripts', 1100 );
	function studeon_tribe_events_frontend_scripts() {
		if (studeon_is_tribe_events_page()) {
			wp_deregister_style('tribe-events-custom-jquery-styles');
			if (studeon_is_on(studeon_get_theme_option('debug_mode')) && studeon_get_file_dir('plugins/the-events-calendar/the-events-calendar.css')!='')
				wp_enqueue_style( 'studeon-the-events-calendar',  studeon_get_file_url('plugins/the-events-calendar/the-events-calendar.css'), array(), null );
				wp_enqueue_style( 'studeon-the-events-calendar-images',  studeon_get_file_url('css/the-events-calendar.css'), array(), null );
		}
	}
}

// Merge custom styles
if ( !function_exists( 'studeon_tribe_events_merge_styles' ) ) {
	//Handler of the add_filter('studeon_filter_merge_styles', 'studeon_tribe_events_merge_styles');
	function studeon_tribe_events_merge_styles($list) {
		$list[] = 'plugins/the-events-calendar/the-events-calendar.css';
		$list[] = 'css/the-events-calendar.css';
		return $list;
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'studeon_tribe_events_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('studeon_filter_tgmpa_required_plugins',	'studeon_tribe_events_tgmpa_required_plugins');
	function studeon_tribe_events_tgmpa_required_plugins($list=array()) {
		if (in_array('the-events-calendar', studeon_storage_get('required_plugins')))
			$list[] = array(
					'name' 		=> esc_html__('Tribe Events Calendar', 'studeon'),
					'slug' 		=> 'the-events-calendar',
					'required' 	=> false
				);
		return $list;
	}
}



// Add Tribe Events specific items into lists
//------------------------------------------------------------------------

// Add sidebar
if ( !function_exists( 'studeon_tribe_events_list_sidebars' ) ) {
	//Handler of the add_filter( 'studeon_filter_list_sidebars', 'studeon_tribe_events_list_sidebars' );
	function studeon_tribe_events_list_sidebars($list=array()) {
		$list['tribe_events_widgets'] = array(
											'name' => esc_html__('Tribe Events Widgets', 'studeon'),
											'description' => esc_html__('Widgets to be shown on the Tribe Events pages', 'studeon')
											);
		return $list;
	}
}



// Add Tribe Events specific styles into color scheme
//------------------------------------------------------------------------

// Add styles into CSS
if ( !function_exists( 'studeon_tribe_events_get_css' ) ) {
	//Handler of the add_filter( 'studeon_filter_get_css', 'studeon_tribe_events_get_css', 10, 4 );
	function studeon_tribe_events_get_css($css, $colors, $fonts, $scheme='') {
		if (isset($css['fonts']) && $fonts) {
			$css['fonts'] .= <<<CSS
			
.tribe-events-list .tribe-events-list-event-title {
	{$fonts['h3_font-family']}
}

#tribe-events .tribe-events-button,
.tribe-events-button,
.tribe-events-cal-links a,
.tribe-events-sub-nav li a {
	{$fonts['button_font-family']}
	{$fonts['button_font-size']}
	{$fonts['button_font-weight']}
	{$fonts['button_font-style']}
	{$fonts['button_line-height']}
	{$fonts['button_text-decoration']}
	{$fonts['button_text-transform']}
	{$fonts['button_letter-spacing']}
}
#tribe-bar-form button, #tribe-bar-form a,
.tribe-events-read-more {
	{$fonts['button_font-family']}
	{$fonts['button_letter-spacing']}
}
.tribe-events-list .tribe-events-list-separator-month,
.tribe-events-calendar thead th,
#tribe-bar-form label,
.tribe-events-schedule, .tribe-events-schedule h2 {
	{$fonts['h5_font-family']}
}
#tribe-bar-form input, #tribe-events-content.tribe-events-month,
#tribe-events-content .tribe-events-calendar div[id*="tribe-events-event-"] h3.tribe-events-month-event-title,
#tribe-mobile-container .type-tribe_events,
.tribe-events-list-widget ol li .tribe-event-title {
	{$fonts['p_font-family']}
}
.tribe-events-loop .tribe-event-schedule-details,
.single-tribe_events #tribe-events-content .tribe-events-event-meta dt,
#tribe-mobile-container .type-tribe_events .tribe-event-date-start {
	{$fonts['info_font-family']};
}

CSS;

			
			$rad = studeon_get_border_radius();
			$css['fonts'] .= <<<CSS

#tribe-events .tribe-events-button,
.tribe-events-button,
.tribe-events-cal-links a,
#tribe-bar-views li.tribe-bar-views-option a,
#tribe-bar-views .tribe-bar-views-list .tribe-bar-views-option.tribe-bar-active a,
#tribe-bar-form .tribe-bar-submit input[type="submit"],
 #tribe-bar-form.tribe-bar-mini .tribe-bar-submit input[type="submit"],
#tribe-bar-form input[type=text],
.tribe-events-sub-nav li a {
	-webkit-border-radius: {$rad};
	    -ms-border-radius: {$rad};
			border-radius: {$rad};
}
.tribe-events-calendar thead th:first-child {
	-webkit-border-top-left-radius: {$rad};
	    -ms-border-top-left-radius: {$rad};
			border-top-left-radius: {$rad};
}
.tribe-events-calendar thead th:last-child {
	-webkit-border-top-right-radius: {$rad};
	    -ms-border-top-right-radius: {$rad};
			border-top-right-radius: {$rad};
}
CSS;
		}


		if (isset($css['colors']) && $colors) {
			$css['colors'] .= <<<CSS

/* Buttons */
#tribe-bar-form .tribe-bar-submit input[type="submit"],
#tribe-bar-form.tribe-bar-mini .tribe-bar-submit input[type="submit"]  {
	color: {$colors['inverse_link']};
	background-color: {$colors['accent2']};
}
#tribe-bar-form .tribe-bar-submit input[type="submit"]:hover,
#tribe-bar-form .tribe-bar-submit input[type="submit"]:focus,
#tribe-bar-form.tribe-bar-mini .tribe-bar-submit input[type="submit"]:focus,
#tribe-bar-form.tribe-bar-mini .tribe-bar-submit input[type="submit"]:focus {
	color: {$colors['inverse_link']};
	background-color: {$colors['accent2_blend']};
}
#tribe-events .tribe-events-button,
.tribe-events-button,
.tribe-events-cal-links a,
.tribe-events-sub-nav li a {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_link']};
}
#tribe-events .tribe-events-button:hover,
.tribe-events-button:hover,
.tribe-events-cal-links a:hover,
.tribe-events-sub-nav li a:hover {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_link_blend']};
}

/* Filters bar */
#tribe-bar-form {
	color: {$colors['text_dark']};
}
#tribe-bar-form input[type="text"] {
	background-color: {$colors['input_bg_color']};
	border-color: {$colors['input_bd_color']};
	color: {$colors['text_dark']};
}
#tribe-bar-form input[type="text"]:focus,
#tribe-bar-form input[type="text"]:hover {
	background-color: {$colors['input_bg_hover']};
	border-color: {$colors['input_bd_hover']};
	color: {$colors['text_dark']};
}

#tribe-bar-views li.tribe-bar-views-option a,
#tribe-bar-views .tribe-bar-views-list .tribe-bar-views-option.tribe-bar-active a {
	color: {$colors['inverse_link']};
	background: {$colors['accent2']};
}
#tribe-bar-views li.tribe-bar-views-option a:hover,
#tribe-bar-views .tribe-bar-views-list .tribe-bar-views-option.tribe-bar-active a:hover {
	color: {$colors['inverse_link']};
	background: {$colors['accent2_blend']};
}
.datepicker thead tr:first-child th:hover, .datepicker tfoot tr th:hover {
	color: {$colors['text_link']};
	background: {$colors['text_dark']};
}

/* Content */
.tribe-events-calendar thead th {
	color: {$colors['text_dark']};
	background-color: {$colors['alter_bg_color']} !important;
	border-color: {$colors['alter_bg_color']} !important;
}
.tribe-events-calendar thead th + th:before {
	background: {$colors['bg_color']};
}
#tribe-events-content .tribe-events-calendar td {
	border-color: {$colors['bd_color']} !important;
}
.tribe-events-calendar td.tribe-events-present:after,
.tribe-events-calendar td div[id*="tribe-events-daynum-"],
.tribe-events-calendar td div[id*="tribe-events-daynum-"] > a {
	background-color: {$colors['text_dark']};
	color: {$colors['inverse_link']};
}
.tribe-events-calendar td.tribe-events-othermonth {
	color: {$colors['alter_light']};
	background: {$colors['alter_bg_color']} !important;
}
.tribe-events-calendar td.tribe-events-othermonth div[id*="tribe-events-daynum-"],
.tribe-events-calendar td.tribe-events-othermonth div[id*="tribe-events-daynum-"] > a {
	color: {$colors['alter_light']};
}
.tribe-events-calendar td.tribe-events-past div[id*="tribe-events-daynum-"], .tribe-events-calendar td.tribe-events-past div[id*="tribe-events-daynum-"] > a {
	color: {$colors['text_light']};
}
.tribe-events-calendar td.tribe-events-present div[id*="tribe-events-daynum-"],
.tribe-events-calendar td.tribe-events-present div[id*="tribe-events-daynum-"] > a {
	color: {$colors['text_link']};
}
.tribe-events-calendar td.tribe-events-present:before {
	border-color: {$colors['text_link']};
}
.tribe-events-calendar .tribe-events-has-events:after {
	background-color: {$colors['text']};
}
.tribe-events-calendar .mobile-active.tribe-events-has-events:after {
	background-color: {$colors['bg_color']};
}
#tribe-events-content .tribe-events-calendar td,
#tribe-events-content .tribe-events-calendar div[id*="tribe-events-event-"] h3.tribe-events-month-event-title a {
	color: {$colors['text_dark']};
}
#tribe-events-content .tribe-events-calendar div[id*="tribe-events-event-"] h3.tribe-events-month-event-title a:hover {
	color: {$colors['text_link']};
}
#tribe-events-content .tribe-events-calendar td.mobile-active,
#tribe-events-content .tribe-events-calendar td.mobile-active:hover {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_link']};
}
#tribe-events-content .tribe-events-calendar td.mobile-active div[id*="tribe-events-daynum-"] {
	color: {$colors['bg_color']};
	background-color: {$colors['text_dark']};
}
#tribe-events-content .tribe-events-calendar td.tribe-events-othermonth.mobile-active div[id*="tribe-events-daynum-"] a,
.tribe-events-calendar .mobile-active div[id*="tribe-events-daynum-"] a {
	background-color: transparent;
	color: {$colors['bg_color']};
}

/* Tooltip */
.recurring-info-tooltip,
.tribe-events-calendar .tribe-events-tooltip,
.tribe-events-week .tribe-events-tooltip,
.tribe-events-tooltip .tribe-events-arrow {
	color: {$colors['alter_text']};
	background: {$colors['alter_bg_color']};
}
#tribe-events-content .tribe-events-tooltip h4 { 
	color: {$colors['text_link']};
	background: {$colors['text_dark']};
}
.tribe-events-tooltip .tribe-event-duration {
	color: {$colors['text_light']};
}

/* Events list */
.tribe-events-list-separator-month {
	color: {$colors['text_dark']};
}
.tribe-events-list-separator-month:after {
	border-color: {$colors['bd_color']};
}
.tribe-events-list .type-tribe_events + .type-tribe_events {
	border-color: {$colors['bd_color']};
}
.tribe-events-list .tribe-events-event-cost span {
	color: {$colors['accent2']};
	border-color: transparent;
	background: transparent;
}
.tribe-mobile .tribe-events-loop .tribe-events-event-meta {
	color: {$colors['alter_text']};
	border-color: {$colors['alter_bg_color']};
	background-color: {$colors['alter_bg_color']};
}
.tribe-mobile .tribe-events-loop .tribe-events-event-meta a {
	color: {$colors['alter_link']};
}
.tribe-mobile .tribe-events-loop .tribe-events-event-meta a:hover {
	color: {$colors['alter_hover']};
}
.tribe-mobile .tribe-events-list .tribe-events-venue-details {
	border-color: {$colors['alter_bd_color']};
}

/* Events day */
.tribe-events-day .tribe-events-day-time-slot h5 {
	color: {$colors['bg_color']};
	background: {$colors['text_dark']};
}

/* Single Event */
.single-tribe_events .tribe-events-venue-map {
	color: {$colors['alter_text']};
	border-color: {$colors['alter_bd_hover']};
	background: {$colors['alter_bg_hover']};
}
.single-tribe_events .tribe-events-schedule .tribe-events-cost {
	color: {$colors['text_dark']};
}
.single-tribe_events .type-tribe_events {
	border-color: {$colors['bd_color']};
}


CSS;
		}
		
		return $css;
	}
}
?>