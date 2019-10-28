<?php
/* Custom Feeds for Instagram support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('studeon_instagram_feed_theme_setup9')) {
	add_action( 'after_setup_theme', 'studeon_instagram_feed_theme_setup9', 9 );
	function studeon_instagram_feed_theme_setup9() {
		if (is_admin()) {
			add_filter( 'studeon_filter_tgmpa_required_plugins',		'studeon_instagram_feed_tgmpa_required_plugins' );
		}
	}
}

// Check if Custom Feeds for Instagram installed and activated
if ( !function_exists( 'studeon_exists_instagram_feed' ) ) {
	function studeon_exists_instagram_feed() {
		return defined('SBIVER');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'studeon_instagram_feed_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('studeon_filter_tgmpa_required_plugins',	'studeon_instagram_feed_tgmpa_required_plugins');
	function studeon_instagram_feed_tgmpa_required_plugins($list=array()) {
		if (in_array('instagram-feed', studeon_storage_get('required_plugins')))
			$list[] = array(
					'name' 		=> esc_html__('Custom Feeds for Instagram', 'studeon'),
					'slug' 		=> 'instagram-feed',
					'required' 	=> false
				);
		return $list;
	}
}
?>