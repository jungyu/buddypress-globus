<?php
/**
 * Enables BP multilingual components on frontend using various filters.
 */
class BPGL_Filters
{
    public function __construct() {
        // Filter BP AJAX URL (add query args 'lang' and '_bpgl_ac')
        add_filter( 'bp_core_ajax_url', array($this, 'core_ajax_url_filter') );
        // WPGL Convert URL
        add_filter( 'bp_core_get_root_domain', array($this, 'core_get_root_domain_filter'), 0 );
        add_filter( 'bp_uri', array($this, 'uri_filter'), 0 );
    }
    
    public function core_ajax_url_filter( $url ){
        $optionLanguages = wpgl_get_option_language();
        $url = add_query_arg( array(
            'lang' => wpgl_get_current_language($optionLanguages),
            'bpgl_filter' => 'true',
            ), $url );
        echo $url;
        return $url;
    }

    /**
     * Filters BuddyPress root domain.
     */
    public function core_get_root_domain_filter( $url ) {
        return rtrim( $url , '/' );
    }
    
    /**
     * Filters bp_uri.
     *
     * This URI is important for BuddyPress.
     * By that it determines some components and actions.
     * We remove language component so BP can determine things right.
     * 
     * @todo Review regex.
     */
    public function uri_filter( $url ) {
        $optionLanguages = wpgl_get_option_language();
        $language = wpgl_get_current_language($optionLanguages);
        return preg_replace('/(\/|^)' . $language . '\//', '$1', $url, 1);
    }

}

new BPGL_Filters();