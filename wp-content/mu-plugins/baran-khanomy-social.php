<?php
/**
 * Plugin Name: Baran Khanomy Social Settings
 * Description: تنظیم لینک‌های شبکه‌های اجتماعی فوتر باران خانومی.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'bk_social_defaults' ) ) {
    function bk_social_defaults() {
        return array( 'instagram' => '', 'telegram' => '', 'whatsapp' => '' );
    }
}

if ( ! function_exists( 'bk_social_get' ) ) {
    function bk_social_get( $key, $fallback = '' ) {
        $settings = wp_parse_args( get_option( 'bk_social_settings', array() ), bk_social_defaults() );
        return isset( $settings[ $key ] ) && $settings[ $key ] !== '' ? $settings[ $key] : $fallback;
    }
}

add_action( 'admin_menu', function() {
    add_submenu_page( 'bk-core-settings', 'شبکه‌های اجتماعی', 'شبکه‌های اجتماعی', 'manage_options', 'bk-social-settings', 'bk_social_settings_page' );
}, 20 );

add_action( 'admin_init', function() {
    register_setting( 'bk_social_settings_group', 'bk_social_settings', array(
        'sanitize_callback' => function( $input ) {
            $input = is_array( $input ) ? $input : array();
            return array(
                'instagram' => isset( $input['instagram'] ) ? esc_url_raw( $input['instagram'] ) : '',
                'telegram'  => isset( $input['telegram'] ) ? esc_url_raw( $input['telegram'] ) : '',
                'whatsapp'  => isset( $input['whatsapp'] ) ? esc_url_raw( $input['whatsapp'] ) : '',
            );
        },
    ) );
} );

function bk_social_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) return;
    $settings = wp_parse_args( get_option( 'bk_social_settings', array() ), bk_social_defaults() );
    ?>
    <div class="wrap" dir="rtl">
        <h1>شبکه‌های اجتماعی</h1>
        <p>لینک‌ها را وارد کنید؛ فقط شبکه‌هایی که لینک دارند در فوتر نمایش داده می‌شوند.</p>
        <form method="post" action="options.php">
            <?php settings_fields( 'bk_social_settings_group' ); ?>
            <table class="form-table" role="presentation">
                <tr><th scope="row"><label for="bk-social-instagram">اینستاگرام</label></th><td><input class="regular-text ltr" type="url" id="bk-social-instagram" name="bk_social_settings[instagram]" value="<?php echo esc_attr( $settings['instagram'] ); ?>" placeholder="https://instagram.com/..."></td></tr>
                <tr><th scope="row"><label for="bk-social-telegram">تلگرام</label></th><td><input class="regular-text ltr" type="url" id="bk-social-telegram" name="bk_social_settings[telegram]" value="<?php echo esc_attr( $settings['telegram'] ); ?>" placeholder="https://t.me/..."></td></tr>
                <tr><th scope="row"><label for="bk-social-whatsapp">واتساپ</label></th><td><input class="regular-text ltr" type="url" id="bk-social-whatsapp" name="bk_social_settings[whatsapp]" value="<?php echo esc_attr( $settings['whatsapp'] ); ?>" placeholder="https://wa.me/..."></td></tr>
            </table>
            <?php submit_button( 'ذخیره لینک‌ها' ); ?>
        </form>
    </div>
    <?php
}

/* The theme still registers an old Google Fonts stylesheet; remove it so Estedad can be supplied locally by the site's font manager. */
add_action( 'wp_enqueue_scripts', function() {
    wp_dequeue_style( 'bk-font' );
    wp_deregister_style( 'bk-font' );
}, 9999 );

add_filter( 'style_loader_src', function( $src, $handle ) {
    if ( in_array( $handle, array( 'bk-main', 'bk-home' ), true ) ) {
        $src = add_query_arg( 'bk_rev', '20260820-1', $src );
    }
    return $src;
}, 9999, 2 );
