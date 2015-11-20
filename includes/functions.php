<?php

/**
 * Turns on verbose rewrite rules.
 * 
 * @see http://wordpress.stackexchange.com/questions/22438/how-to-make-pages-slug-have-priority-over-any-other-taxonomies-like-custom-post
 * @see http://wordpress.stackexchange.com/questions/16902/permalink-rewrite-404-conflict-wordpress-taxonomies-cpt/16929#16929
 * @see http://wordpress.stackexchange.com/questions/17569/using-postname-for-a-custom-post-type
 * @see http://wordpress.stackexchange.com/a/16929/9244
 */
function bpgl_use_verbose_rules(){
	global $wp_rewrite;
    $wp_rewrite->use_verbose_page_rules = true;
}

/**
 * Modifies and collects rewrite rules for pages.
 * 
 * @see bpgl_rewrite_rules_array_filter
 * @see http://codex.wordpress.org/Plugin_API/Filter_Reference/page_rewrite_rules
 */
function bpgl_page_rewrite_rules_filter( $page_rewrite_rules ){
    $GLOBALS['bpgl_page_rewrite_rules'] = $page_rewrite_rules;
    return array();
}

/**
 * Re-orders rewrite rules by pre-pending collected rules.
 * 
 * @see bpgl_page_rewrite_rules_filter
 * @see http://codex.wordpress.org/Plugin_API/Filter_Reference/rewrite_rules_array
 */
function bpgl_rewrite_rules_array_filter( $rewrite_rules ){
    return $GLOBALS['bpgl_page_rewrite_rules'] + $rewrite_rules;
}

function bpgl_sanitize_string_name( $string, $max_length = 30 ) {
    $string = sanitize_text_field( $string );
    if ( strlen( $string ) > $max_length ) {
        $string = substr( $string, 0, strrpos( substr( $string, 0, $max_length ), ' ' ) );
    }
    return sanitize_title( $string );
}


function bpgl_admin_notice_required_plugins() {
    echo '<div class="message updated"><p>'
    . __( 'For BuddyPress Globus to work you must enable WPGlobus and BuddyPress.', 'bpg' )
    . '</p></div>';
}

function wpgl_get_option_language() {
    return maybe_unserialize(get_option( 'wpglobus_option_language_names' ));
}

function wpgl_get_current_language($optionLanguages) {
    $result = 'en';
    $wpCurrentLocale = get_locale();
    foreach ( $optionLanguages as $code => &$language) {
        if(wpgl_map_locale_code($code, $wpCurrentLocale)){
             $result = $code;
        }
    } 
    return $result;
}

function wpgl_get_default_language($optionLanguages) {
    $result = 'en';
    $defaultLanguage = str_replace('-', '_', get_bloginfo('language'));
    foreach ( $optionLanguages as $code => &$language) {
        if(wpgl_map_locale_code($code, $defaultLanguage)){
             $result = $code;
        }
    } 
    return $result;
}

/*
    refer: http://wpcentral.io/internationalization/
*/
function wpgl_map_locale_code($code, $wpCode) {
    $result = false;
    $mapLocaleCodes = array(
        'en' => 'en_US',
        'ru' => 'ru_RU',
        'de' => 'de_DE',
        'zh' => 'zh_CN',
        'fi' => 'fi',
        'fr' => 'fr_FR',
        'nl' => 'nl_NL',
        'sv' => 'sv_SE',
        'it' => 'it_IT',
        'ro' => 'ro_RO',
        'hu' => 'hu_HU',
        'ja' => 'ja',
        'es' => 'es_ES',
        'vi' => 'vi',
        'ar' => 'ar',
        'pt' => 'pt_PT',
        'br' => 'bre',
        'pl' => 'pl_PL',
        'gl' => 'gl_ES',
        'tw' => 'zh_TW'
    );
    if($mapLocaleCodes[$code] == $wpCode) $result = true;
    return $result;
}

?>