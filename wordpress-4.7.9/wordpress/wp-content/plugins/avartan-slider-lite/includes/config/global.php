<?php
if( !defined( 'ABSPATH') ) exit();

class avsLiteGlobals {
    const AVS_VERSION = '1.3';
    const AVS_SLIDER = 'avartan_sliders';
    const AVS_SLIDES = 'avartan_slides';
    public static $avs_slider_tbl;
    public static $avs_slides_tbl;

    public function __construct() {
        global $wpdb;
        static::$avs_slider_tbl = $wpdb->prefix.self::AVS_SLIDER;
        static::$avs_slides_tbl = $wpdb->prefix.self::AVS_SLIDES;
    }
}
new avsLiteGlobals();