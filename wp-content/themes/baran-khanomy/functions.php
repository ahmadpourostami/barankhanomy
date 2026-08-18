<?php
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'BK_THEME_VERSION', '0.1.0' );

define( 'BK_THEME_DIR', get_template_directory() );
define( 'BK_THEME_URI', get_template_directory_uri() );

add_action( 'after_setup_theme', function() {
    load_theme_textdomain( 'baran-khanomy', BK_THEME_DIR . '/languages' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
    add_theme_support( 'custom-logo', array( 'height' => 80, 'width' => 180, 'flex-height' => true, 'flex-width' => true ) );
    register_nav_menus( array( 'primary' => 'منوی اصلی' ) );
});

add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style( 'bk-font', 'https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700;800&display=swap', array(), null );
    wp_enqueue_style( 'bk-main', BK_THEME_URI . '/assets/css/main.css', array(), BK_THEME_VERSION );
    wp_enqueue_script( 'bk-main', BK_THEME_URI . '/assets/js/main.js', array(), BK_THEME_VERSION, true );
});

function bk_setting( $key, $fallback = '' ) {
    if ( function_exists( 'bk_core_get' ) ) {
        $value = bk_core_get( $key );
        return $value !== '' ? $value : $fallback;
    }
    return $fallback;
}

function bk_icon( $name ) {
    $icons = array(
        'grid' => '▦', 'bag' => '♧', 'gift' => '◇', 'award' => '✦', 'calendar' => '□', 'play' => '▷', 'headset' => '♧', 'heart' => '♡', 'arrow' => '←', 'menu' => '☰', 'search' => '⌕',
    );
    return isset( $icons[ $name ] ) ? $icons[ $name ] : '•';
}
