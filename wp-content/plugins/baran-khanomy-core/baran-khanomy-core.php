<?php
/**
 * Plugin Name: Baran Khanomy Core
 * Description: مدیریت محتوای قالب باران خانومی و رابط ورود/ثبت‌نام موبایلی.
 * Version: 0.4.2
 * Author: Baran Khanomy
 * Text Domain: baran-khanomy-core
 */
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'BK_CORE_VERSION', '0.4.2' );
define( 'BK_CORE_FILE', __FILE__ );
define( 'BK_CORE_DIR', plugin_dir_path( __FILE__ ) );
require_once BK_CORE_DIR . 'includes/settings.php';
require_once BK_CORE_DIR . 'includes/content-types.php';
require_once BK_CORE_DIR . 'includes/shortcodes.php';

add_action( 'after_setup_theme', function() {
    add_theme_support( 'widgets-block-editor' );
}, 11 );

add_action( 'init', 'bk_register_gutenberg_blocks', 30 );
function bk_register_gutenberg_blocks() {
    $blocks = array( 'tutor-course-grid', 'social-links' );
    foreach ( $blocks as $block ) {
        $block_dir = BK_CORE_DIR . 'blocks/' . $block;
        if ( file_exists( $block_dir . '/block.json' ) ) register_block_type( $block_dir );
    }
}

register_activation_hook( __FILE__, 'bk_core_activate' );
function bk_core_activate() {
    $defaults = bk_core_defaults();
    if ( false === get_option( 'bk_core_settings', false ) ) add_option( 'bk_core_settings', $defaults );
    if ( function_exists( 'bk_register_content_types' ) ) bk_register_content_types();
    if ( function_exists( 'bk_seed_demo_content' ) ) bk_seed_demo_content();
    bk_core_migrate_homepage_content();
    update_option( 'bk_core_schema_version', BK_CORE_VERSION );
    flush_rewrite_rules();
}

add_action( 'init', 'bk_core_maybe_upgrade', 20 );
function bk_core_maybe_upgrade() {
    $version = get_option( 'bk_core_schema_version', '0' );
    if ( version_compare( $version, BK_CORE_VERSION, '>=' ) ) return;
    if ( function_exists( 'bk_register_content_types' ) ) bk_register_content_types();
    if ( function_exists( 'bk_seed_demo_content' ) ) bk_seed_demo_content();
    bk_core_migrate_homepage_content();
    update_option( 'bk_core_schema_version', BK_CORE_VERSION );
    flush_rewrite_rules();
}

function bk_core_migrate_homepage_content() {
    $settings = get_option( 'bk_core_settings', array() );
    if ( ! is_array( $settings ) ) $settings = array();
    if ( ! empty( $settings['hero_image'] ) && empty( $settings['about_image'] ) ) $settings['about_image'] = esc_url_raw( $settings['hero_image'] );
    if ( ! empty( $settings['hero_badge'] ) && empty( $settings['about_badge'] ) ) $settings['about_badge'] = sanitize_text_field( $settings['hero_badge'] );
    if ( ! empty( $settings['hero_title'] ) && empty( $settings['about_title'] ) ) $settings['about_title'] = sanitize_text_field( wp_strip_all_tags( $settings['hero_title'] ) );
    if ( ! empty( $settings['hero_text'] ) && empty( $settings['about_text'] ) ) $settings['about_text'] = sanitize_textarea_field( $settings['hero_text'] );
    if ( ! empty( $settings['hero_primary'] ) && empty( $settings['about_primary'] ) ) $settings['about_primary'] = sanitize_text_field( $settings['hero_primary'] );
    if ( ! empty( $settings['hero_secondary'] ) && empty( $settings['about_secondary'] ) ) $settings['about_secondary'] = sanitize_text_field( $settings['hero_secondary'] );
    if ( empty( $settings['about_image_migrated'] ) ) { $settings['hero_image'] = ''; $settings['about_image_migrated'] = 1; update_option( 'bk_core_settings', $settings ); }
}

add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style( 'bk-core-auth', plugins_url( 'assets/auth.css', __FILE__ ), array(), BK_CORE_VERSION );
    wp_enqueue_script( 'bk-core-auth', plugins_url( 'assets/auth.js', __FILE__ ), array(), BK_CORE_VERSION, true );
});

add_action( 'wp_footer', function() {
    if ( is_admin() ) return;
    ?>
    <div class="bk-auth-modal" id="bk-auth-modal" aria-hidden="true"><div class="bk-auth-backdrop" data-bk-close></div><div class="bk-auth-dialog" role="dialog" aria-modal="true" aria-labelledby="bk-auth-title"><button class="bk-auth-close" type="button" data-bk-close aria-label="بستن">×</button><div class="bk-auth-icon">ب</div><h2 id="bk-auth-title">ورود یا ثبت‌نام</h2><p>شماره موبایل خود را وارد کنید تا کد تأیید برای شما ارسال شود.</p><form class="bk-auth-form" action="#" method="post"><label for="bk-mobile">شماره موبایل</label><input id="bk-mobile" name="mobile" type="tel" inputmode="numeric" autocomplete="tel" placeholder="۰۹۱۲۱۲۳۴۵۶۷" required><button type="submit">دریافت کد تأیید <span>←</span></button></form><small>اتصال به پنل پیامکی بعداً از بخش تنظیمات افزونه انجام می‌شود.</small></div></div>
    <?php
});
