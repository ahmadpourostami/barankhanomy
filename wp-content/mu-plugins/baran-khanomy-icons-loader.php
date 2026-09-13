<?php
/**
 * Baran Khanomy — icon stylesheet loader.
 * Loads the dedicated SVG icon CSS after the theme styles so it is actually active.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_enqueue_scripts', function() {
    $theme_uri = get_template_directory_uri();
    $theme_dir = get_template_directory();
    $file = $theme_dir . '/assets/css/icons.css';

    if ( file_exists( $file ) ) {
        wp_enqueue_style(
            'bk-icons',
            $theme_uri . '/assets/css/icons.css',
            array( 'bk-main', 'bk-home', 'bk-footer' ),
            (string) filemtime( $file )
        );
    }
}, 99 );
