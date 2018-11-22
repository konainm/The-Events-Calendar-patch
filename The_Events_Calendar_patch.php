<?php
/**
 * Plugin Name: The Events Calendar patch
 * Plugin URI: https://github.com/KonainM/The-Events-Calendar-patch.git
 * Description: This plugin makes The Events Calendar compatible with Genesis Framework (Genesis 2.2.6+ required). This plugin also makes The Events Calendar plugin WCAG 2.0 AA compliant.
 * Version: 0.1
 * Author: Konain Mukadam
 * Author URI: https://github.com/KonainM/
*/

/*
* Bypass Genesis genesis_do_post_content in Event Views
* Override the Genesis Content Archive settings for Event Views
* Event Template set to: Admin > Events > Settings > Display Tab > Events template > Default Page Template
*/
function tribe_genesis_bypass_genesis_do_post_content() {

	if ( class_exists( 'Tribe__Events__Main' ) && class_exists( 'Tribe__Events__Pro__Main' ) ) {
		if ( tribe_is_month() || tribe_is_upcoming() || tribe_is_past() || tribe_is_day() || tribe_is_map() || tribe_is_photo() || tribe_is_week() || ( tribe_is_recurring_event() && ! is_singular( 'tribe_events' ) ) ) {
			remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
			remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
			add_action( 'genesis_entry_content', 'the_content', 15 );
		}
	} elseif ( class_exists( 'Tribe__Events__Main' ) && ! class_exists( 'Tribe__Events__Pro__Main' ) ) {
		if ( tribe_is_month() || tribe_is_upcoming() || tribe_is_past() || tribe_is_day() ) {
			remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
			remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
			add_action( 'genesis_entry_content', 'the_content', 15 );
		}
	}
}

/* The above functions will only be implemented if both of the following conditions are met
 * 1) Genesis Framework is activated
 * 2) The Events Calendar is activated
*/

if(in_array('the-events-calendar/the-events-calendar.php', apply_filters('active_plugins', get_option('active_plugins')))){
	$theme_name = wp_get_theme();
	if($theme_name->get('Template') === "genesis"){
		add_action( 'get_header', 'tribe_genesis_bypass_genesis_do_post_content' );
		wp_register_style( 'tec_css', plugins_url( '/CSS/tec_css.css' , __FILE__ ) );
		wp_enqueue_style( 'tec_css' );
	}
}
