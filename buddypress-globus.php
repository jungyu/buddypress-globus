<?php
/*
Plugin Name: Buddypress Globus
Plugin URI:  http://www.grid.com.tw
Description: BuddyPress Globus allows BuddyPress sites to run fully multilingual using the WPGlobus plugin.
Version:     1.0
Author:      Aaron Yu
Author URI:  http://www.grid.com.tw
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

define( 'BPGL_VERSION', '1.0.0' );
define( 'BPGL_RELPATH', plugins_url( '', __FILE__ ) );
add_action( 'plugins_loaded', 'bpg_init', 11 );

function bpg_init() {
	require_once dirname( __FILE__ ) . '/includes/functions.php';
	if ( defined( 'BP_VERSION' ) && defined( 'WPGLOBUS_VERSION' ) ) {
		$apply_filters = false; //TOFIX
		
		// Always on frontend
        if ( !is_admin() || $apply_filters ) {
            include_once dirname( __FILE__ ) . '/includes/class.filters.php';
            $optionLanguages = wpgl_get_option_language();
            $defaultLanguage = wpgl_get_default_language($optionLanguages);
            $currentLanguage = wpgl_get_current_language($optionLanguages);
            
            // Verbose page rewrite rules
            if ( !defined( 'BPGL_USE_VERBOSE_PAGE_RULES' ) || BPGL_USE_VERBOSE_PAGE_RULES ) {
                add_action( 'init', 'bpgl_use_verbose_rules' );
                add_filter( 'page_rewrite_rules', 'bpgl_page_rewrite_rules_filter' );
                add_filter( 'rewrite_rules_array', 'bpgl_rewrite_rules_array_filter' );
            }
        }

        // XProfile
        include_once dirname( __FILE__ ) . '/includes/class.xprofile.php';
		
	} else if ( is_admin() ) {
        add_action( 'admin_notices', 'bpgl_admin_notice_required_plugins' );
    }
}


?>