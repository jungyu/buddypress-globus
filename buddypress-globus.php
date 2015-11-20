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
            $optionLanguages = wpgl_get_option_language();
            $defaultLanguage = wpgl_get_default_language($optionLanguages);
            $currentLanguage = wpgl_get_current_language($optionLanguages);
            if($currentLanguage != $defaultLanguage){
                apply_filters( 'bp_get_groups_directory_permalink', trailingslashit( bp_get_groups_directory_permalink() . $currentLanguage . '/' ));
                apply_filters( 'bp_get_activity_directory_permalink', trailingslashit( bp_get_activity_directory_permalink() . $currentLanguage . '/' ));
                apply_filters( 'bp_get_blogs_directory_permalink', trailingslashit( bp_get_blogs_directory_permalink() . $currentLanguage . '/' ));
                apply_filters( 'bp_get_forum_directory_permalink', trailingslashit( bp_get_forum_directory_permalink() . $currentLanguage . '/' ));
                apply_filters( 'bp_get_members_directory_permalink', trailingslashit( bp_get_members_directory_permalink() . $currentLanguage . '/' ));
            }
        }
		
	} else if ( is_admin() ) {
        add_action( 'admin_notices', 'bpgl_admin_notice_required_plugins' );
    }
}


?>