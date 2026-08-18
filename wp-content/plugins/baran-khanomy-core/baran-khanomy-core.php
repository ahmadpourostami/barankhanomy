<?php
/**
 * Plugin Name: Baran Khanomy Core
 * Description: مدیریت محتوای قالب باران خانومی و رابط ورود/ثبت‌نام موبایلی.
 * Version: 0.1.0
 * Author: Baran Khanomy
 * Text Domain: baran-khanomy-core
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'BK_CORE_VERSION', '0.1.0' );
define( 'BK_CORE_FILE', __FILE__ );
define( 'BK_CORE_DIR', plugin_dir_path( __FILE__ ) );

require_once BK_CORE_DIR . 'includes/settings.php';
require_once BK_CORE_DIR . 'includes/shortcodes.php';

register_activation_hook( __FILE__, 'bk_core_activate' );
function bk_core_activate() {
    $defaults = bk_core_defaults();
    if ( false === get_option( 'bk_core_settings', false ) ) {
        add_option( 'bk_core_settings', $defaults );
    }
}

add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style( 'bk-core-auth', plugins_url( 'assets/auth.css', __FILE__ ), array(), BK_CORE_VERSION );
    wp_enqueue_script( 'bk-core-auth', plugins_url( 'assets/auth.js', __FILE__ ), array(), BK_CORE_VERSION, true );
});

add_action( 'wp_footer', function() {
    if ( is_admin() ) return;
    ?>
    <div class="bk-auth-modal" id="bk-auth-modal" aria-hidden="true">
        <div class="bk-auth-backdrop" data-bk-close></div>
        <div class="bk-auth-dialog" role="dialog" aria-modal="true" aria-labelledby="bk-auth-title">
            <button class="bk-auth-close" type="button" data-bk-close aria-label="بستن">×</button>
            <div class="bk-auth-icon">ب</div>
            <h2 id="bk-auth-title">ورود یا ثبت‌نام</h2>
            <p>شماره موبایل خود را وارد کنید تا کد تأیید برای شما ارسال شود.</p>
            <form class="bk-auth-form" action="#" method="post">
                <label for="bk-mobile">شماره موبایل</label>
                <input id="bk-mobile" name="mobile" type="tel" inputmode="numeric" autocomplete="tel" placeholder="۰۹۱۲۱۲۳۴۵۶۷" required>
                <button type="submit">دریافت کد تأیید <span>←</span></button>
            </form>
            <small>اتصال به پنل پیامکی بعداً از بخش تنظیمات افزونه انجام می‌شود.</small>
        </div>
    </div>
    <?php
});
