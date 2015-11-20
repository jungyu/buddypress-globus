<?php


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