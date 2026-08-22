<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function bk_sms_defaults() {
    return array(
        'api_key'       => '',
        'pattern_code'  => '',
        'line_number'   => '90008361',
        'number_format' => 'english',
        'attribute_key' => 'code',
        'otp_length'    => 6,
        'otp_ttl'       => 120,
    );
}

function bk_sms_get( $key, $fallback = '' ) {
    $settings = wp_parse_args( get_option( 'bk_sms_settings', array() ), bk_sms_defaults() );
    return isset( $settings[ $key ] ) ? $settings[ $key ] : $fallback;
}

add_action( 'admin_menu', function() {
    add_submenu_page( 'bk-core-settings', 'ورود و ثبت‌نام پیامکی', 'ورود و ثبت‌نام', 'manage_options', 'bk-sms-settings', 'bk_sms_settings_page' );
} );

add_action( 'admin_init', function() {
    register_setting( 'bk_sms_settings_group', 'bk_sms_settings', array(
        'sanitize_callback' => function( $input ) {
            $defaults = bk_sms_defaults();
            $output = $defaults;
            $output['api_key'] = isset( $input['api_key'] ) ? sanitize_text_field( $input['api_key'] ) : '';
            $output['pattern_code'] = isset( $input['pattern_code'] ) ? sanitize_text_field( $input['pattern_code'] ) : '';
            $output['line_number'] = isset( $input['line_number'] ) ? preg_replace( '/[^0-9]/', '', (string) $input['line_number'] ) : $defaults['line_number'];
            $output['number_format'] = isset( $input['number_format'] ) && 'persian' === $input['number_format'] ? 'persian' : 'english';
            $output['attribute_key'] = isset( $input['attribute_key'] ) ? sanitize_key( $input['attribute_key'] ) : 'code';
            $output['otp_length'] = isset( $input['otp_length'] ) ? min( 8, max( 4, absint( $input['otp_length'] ) ) ) : 6;
            $output['otp_ttl'] = isset( $input['otp_ttl'] ) ? min( 600, max( 60, absint( $input['otp_ttl'] ) ) ) : 120;
            return $output;
        },
    ) );
} );

function bk_sms_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) return;
    $settings = wp_parse_args( get_option( 'bk_sms_settings', array() ), bk_sms_defaults() );
    ?>
    <div class="wrap" dir="rtl">
        <h1>ورود و ثبت‌نام پیامکی</h1>
        <p>اتصال ورود و ثبت‌نام با شماره موبایل به FarazSMS. کلید API فقط در سرور استفاده می‌شود و به مرورگر ارسال نمی‌شود.</p>
        <form method="post" action="options.php">
            <?php settings_fields( 'bk_sms_settings_group' ); ?>
            <table class="form-table" role="presentation">
                <tr><th><label for="bk-sms-api-key">Api-Key</label></th><td><input id="bk-sms-api-key" class="regular-text" type="password" autocomplete="new-password" name="bk_sms_settings[api_key]" value="<?php echo esc_attr( $settings['api_key'] ); ?>"><p class="description">Static API Key پنل FarazSMS؛ از Login endpoint یا token موقت استفاده نشود.</p></td></tr>
                <tr><th><label for="bk-sms-pattern">Pattern UID</label></th><td><input id="bk-sms-pattern" class="regular-text" type="text" name="bk_sms_settings[pattern_code]" value="<?php echo esc_attr( $settings['pattern_code'] ); ?>"><p class="description">UID الگوی OTP ساخته‌شده در پنل FarazSMS.</p></td></tr>
                <tr><th><label for="bk-sms-line">شماره فرستنده</label></th><td><input id="bk-sms-line" class="regular-text" type="text" name="bk_sms_settings[line_number]" value="<?php echo esc_attr( $settings['line_number'] ); ?>"></td></tr>
                <tr><th><label for="bk-sms-attribute">نام متغیر OTP</label></th><td><input id="bk-sms-attribute" class="regular-text" type="text" name="bk_sms_settings[attribute_key]" value="<?php echo esc_attr( $settings['attribute_key'] ); ?>"><p class="description">باید دقیقاً با نام متغیر تعریف‌شده در Pattern یکی باشد؛ مقدار پیش‌فرض code است.</p></td></tr>
                <tr><th>فرمت اعداد</th><td><label><input type="radio" name="bk_sms_settings[number_format]" value="english" <?php checked( $settings['number_format'], 'english' ); ?>> انگلیسی</label> &nbsp; <label><input type="radio" name="bk_sms_settings[number_format]" value="persian" <?php checked( $settings['number_format'], 'persian' ); ?>> فارسی</label></td></tr>
                <tr><th><label for="bk-sms-length">طول کد</label></th><td><input id="bk-sms-length" class="small-text" type="number" min="4" max="8" name="bk_sms_settings[otp_length]" value="<?php echo esc_attr( $settings['otp_length'] ); ?>"></td></tr>
                <tr><th><label for="bk-sms-ttl">اعتبار کد</label></th><td><input id="bk-sms-ttl" class="small-text" type="number" min="60" max="600" name="bk_sms_settings[otp_ttl]" value="<?php echo esc_attr( $settings['otp_ttl'] ); ?>"> ثانیه</td></tr>
            </table>
            <h2>الگوی درخواست</h2>
            <pre style="background:#f6f6f6;padding:16px;max-width:760px;direction:ltr;text-align:left;overflow:auto;">POST https://api.iranpayamak.com/ws/v1/sms/pattern
Api-Key: &lt;API_KEY&gt;
Content-Type: application/json

{
  "code": "&lt;PATTERN_UID&gt;",
  "attributes": { "&lt;ATTRIBUTE_KEY&gt;": "123456" },
  "recipient": "09120000000",
  "line_number": "90008361",
  "number_format": "english"
}</pre>
            <?php submit_button( 'ذخیره تنظیمات پیامک' ); ?>
        </form>
    </div>
    <?php
}

function bk_normalize_mobile( $mobile ) {
    $mobile = trim( (string) $mobile );
    $mobile = strtr( $mobile, array( '۰'=>'0','۱'=>'1','۲'=>'2','۳'=>'3','۴'=>'4','۵'=>'5','۶'=>'6','۷'=>'7','۸'=>'8','۹'=>'9' ) );
    $mobile = preg_replace( '/\s+/', '', $mobile );
    if ( preg_match( '/^\+98(9\d{9})$/', $mobile, $m ) ) $mobile = '0' . $m[1];
    if ( preg_match( '/^0098(9\d{9})$/', $mobile, $m ) ) $mobile = '0' . $m[1];
    return $mobile;
}

function bk_mobile_is_valid( $mobile ) {
    return (bool) preg_match( '/^09\d{9}$/', $mobile );
}

function bk_sms_send_otp( $mobile, $otp ) {
    $api_key = trim( (string) bk_sms_get( 'api_key' ) );
    $pattern = trim( (string) bk_sms_get( 'pattern_code' ) );
    $line = trim( (string) bk_sms_get( 'line_number', '90008361' ) );
    $attribute = trim( (string) bk_sms_get( 'attribute_key', 'code' ) );
    if ( ! $api_key || ! $pattern || ! $line || ! $attribute ) return new WP_Error( 'sms_not_configured', 'تنظیمات پیامک کامل نشده است.' );

    $response = wp_remote_post( 'https://api.iranpayamak.com/ws/v1/sms/pattern', array(
        'timeout' => 20,
        'headers' => array(
            'Accept' => 'application/json',
            'Api-Key' => $api_key,
            'Content-Type' => 'application/json',
        ),
        'body' => wp_json_encode( array(
            'code' => $pattern,
            'attributes' => array( $attribute => (string) $otp ),
            'recipient' => $mobile,
            'line_number' => $line,
            'number_format' => bk_sms_get( 'number_format', 'english' ),
        ) ),
    ) );

    if ( is_wp_error( $response ) ) return $response;
    $status = wp_remote_retrieve_response_code( $response );
    $body = json_decode( wp_remote_retrieve_body( $response ), true );
    if ( $status < 200 || $status >= 300 ) {
        $message = is_array( $body ) && ! empty( $body['message'] ) ? sanitize_text_field( $body['message'] ) : 'ارسال پیامک انجام نشد.';
        return new WP_Error( 'sms_api_error', $message, array( 'status' => $status, 'body' => $body ) );
    }
    if ( is_array( $body ) && isset( $body['status'] ) && 'success' !== strtolower( (string) $body['status'] ) ) return new WP_Error( 'sms_rejected', 'درخواست پیامک توسط سرویس پذیرفته نشد.', $body );
    return $body;
}

function bk_auth_request_otp() {
    check_ajax_referer( 'bk_auth_nonce', 'nonce' );
    $mobile = bk_normalize_mobile( isset( $_POST['mobile'] ) ? wp_unslash( $_POST['mobile'] ) : '' );
    if ( ! bk_mobile_is_valid( $mobile ) ) wp_send_json_error( array( 'message' => 'شماره موبایل را به شکل ۰۹۱۲۱۲۳۴۵۶۷ وارد کنید.' ), 422 );
    $key = 'bk_otp_' . md5( $mobile );
    if ( get_transient( $key . '_lock' ) ) wp_send_json_error( array( 'message' => 'لطفاً کمی صبر کنید و دوباره تلاش کنید.' ), 429 );
    $length = (int) bk_sms_get( 'otp_length', 6 );
    $otp = (string) wp_rand( pow( 10, $length - 1 ), pow( 10, $length ) - 1 );
    $sent = bk_sms_send_otp( $mobile, $otp );
    if ( is_wp_error( $sent ) ) wp_send_json_error( array( 'message' => $sent->get_error_message() ), 502 );
    set_transient( $key, array( 'hash' => wp_hash_password( $otp ), 'attempts' => 0 ), (int) bk_sms_get( 'otp_ttl', 120 ) );
    set_transient( $key . '_lock', 1, 60 );
    wp_send_json_success( array( 'message' => 'کد تأیید ارسال شد.', 'expires' => (int) bk_sms_get( 'otp_ttl', 120 ) ) );
}
add_action( 'wp_ajax_nopriv_bk_request_otp', 'bk_auth_request_otp' );
add_action( 'wp_ajax_bk_request_otp', 'bk_auth_request_otp' );

function bk_find_user_by_mobile( $mobile ) {
    $users = get_users( array( 'meta_key' => 'bk_mobile', 'meta_value' => $mobile, 'number' => 1, 'fields' => 'all' ) );
    return ! empty( $users ) ? $users[0] : false;
}

function bk_auth_verify_otp() {
    check_ajax_referer( 'bk_auth_nonce', 'nonce' );
    $mobile = bk_normalize_mobile( isset( $_POST['mobile'] ) ? wp_unslash( $_POST['mobile'] ) : '' );
    $otp = preg_replace( '/\D/', '', (string) ( isset( $_POST['otp'] ) ? wp_unslash( $_POST['otp'] ) : '' ) );
    if ( ! bk_mobile_is_valid( $mobile ) || ! preg_match( '/^\d{4,8}$/', $otp ) ) wp_send_json_error( array( 'message' => 'شماره موبایل یا کد تأیید نامعتبر است.' ), 422 );
    $key = 'bk_otp_' . md5( $mobile );
    $record = get_transient( $key );
    if ( ! is_array( $record ) || empty( $record['hash'] ) ) wp_send_json_error( array( 'message' => 'کد منقضی شده است. دوباره درخواست کد کنید.' ), 410 );
    $attempts = isset( $record['attempts'] ) ? absint( $record['attempts'] ) : 0;
    if ( $attempts >= 5 ) { delete_transient( $key ); wp_send_json_error( array( 'message' => 'تعداد تلاش‌ها بیش از حد مجاز است.' ), 429 ); }
    if ( ! wp_check_password( $otp, $record['hash'] ) ) {
        $record['attempts'] = $attempts + 1;
        set_transient( $key, $record, (int) bk_sms_get( 'otp_ttl', 120 ) );
        wp_send_json_error( array( 'message' => 'کد تأیید اشتباه است.' ), 422 );
    }
    delete_transient( $key );
    $user = bk_find_user_by_mobile( $mobile );
    if ( ! $user ) {
        $username = 'bk_' . substr( hash( 'sha256', $mobile ), 0, 20 );
        $user_id = wp_insert_user( array( 'user_login' => $username, 'user_pass' => wp_generate_password( 32, true, true ), 'display_name' => $mobile, 'role' => 'subscriber' ) );
        if ( is_wp_error( $user_id ) ) wp_send_json_error( array( 'message' => 'ساخت حساب کاربری انجام نشد.' ), 500 );
        update_user_meta( $user_id, 'bk_mobile', $mobile );
        $user = get_user_by( 'id', $user_id );
    }
    wp_set_current_user( $user->ID );
    wp_set_auth_cookie( $user->ID, true );
    wp_send_json_success( array( 'message' => 'ورود با موفقیت انجام شد.', 'redirect' => home_url( '/' ) ) );
}
add_action( 'wp_ajax_nopriv_bk_verify_otp', 'bk_auth_verify_otp' );
add_action( 'wp_ajax_bk_verify_otp', 'bk_auth_verify_otp' );

add_action( 'wp_enqueue_scripts', function() {
    wp_localize_script( 'bk-core-auth', 'BKAuth', array(
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce( 'bk_auth_nonce' ),
    ) );
}, 20 );

add_action( 'wp_footer', function() {
    if ( is_admin() ) return;
    ?>
    <div class="bk-auth-modal" id="bk-auth-modal" aria-hidden="true">
        <div class="bk-auth-backdrop" data-bk-close></div>
        <div class="bk-auth-dialog" role="dialog" aria-modal="true" aria-labelledby="bk-auth-title">
            <button class="bk-auth-close" type="button" data-bk-close aria-label="بستن">×</button>
            <div class="bk-auth-icon">ب</div>
            <h2 id="bk-auth-title">ورود یا ثبت‌نام</h2>
            <p class="bk-auth-message">شماره موبایل خود را وارد کنید تا کد تأیید برای شما ارسال شود.</p>
            <form class="bk-auth-form" id="bk-auth-phone-form" action="#" method="post">
                <label for="bk-mobile">شماره موبایل</label>
                <input id="bk-mobile" name="mobile" type="tel" inputmode="numeric" autocomplete="tel" placeholder="۰۹۱۲۱۲۳۴۵۶۷" maxlength="11" required>
                <button type="submit">دریافت کد تأیید <span>←</span></button>
            </form>
            <form class="bk-auth-form" id="bk-auth-otp-form" action="#" method="post" style="display:none">
                <label for="bk-otp">کد تأیید</label>
                <input id="bk-otp" name="otp" type="tel" inputmode="numeric" autocomplete="one-time-code" placeholder="۱۲۳۴۵۶" maxlength="8" required>
                <button type="submit">تأیید و ورود <span>←</span></button>
                <button type="button" class="bk-auth-back" id="bk-auth-back">ویرایش شماره</button>
            </form>
            <small id="bk-auth-status">ورود و ثبت‌نام با شماره موبایل انجام می‌شود.</small>
        </div>
    </div>
    <?php
} );
