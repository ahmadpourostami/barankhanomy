<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function bk_core_defaults() {
    return array(
        'brand_name' => 'باران خانومی',
        'hero_badge' => 'فرصتِ خوب برای شروع',
        'hero_title' => 'مهارت یاد بگیر،<br><strong>از هنر دست درآمد بساز</strong>',
        'hero_text' => 'آموزش‌های کاربردی و پروژه‌محور از مبتدی تا پیشرفته، همراه با پشتیبانی و راهنمایی برای ساخت محصولات حرفه‌ای.',
        'hero_primary' => 'شروع یادگیری',
        'hero_secondary' => 'مشاهده دوره‌ها',
        'hero_image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?auto=format&fit=crop&w=1200&q=85',
        'about_title' => 'با من، باران خانومی آشنا شوید',
        'about_text' => 'من باران هستم؛ عاشق دوخت و آموزش. تجربه سال‌ها دوخت و طراحی محصولات دست‌دوز در کنار دوره‌های کاربردی و قابل فهم، کمک می‌کند از یک مهارت ساده به یک مسیر درآمدی برسید.',
        'footer_cta' => 'آماده‌ای مسیر جدیدی رو شروع کنی؟',
    );
}

function bk_core_get( $key ) {
    $settings = wp_parse_args( get_option( 'bk_core_settings', array() ), bk_core_defaults() );
    return isset( $settings[ $key ] ) ? $settings[ $key ] : '';
}

add_action( 'admin_menu', function() {
    add_menu_page(
        'باران خانومی',
        'باران خانومی',
        'manage_options',
        'bk-core-settings',
        'bk_core_settings_page',
        'dashicons-admin-customizer',
        58
    );
});

add_action( 'admin_init', function() {
    register_setting( 'bk_core_settings_group', 'bk_core_settings', array(
        'sanitize_callback' => function( $input ) {
            $defaults = bk_core_defaults();
            $output = array();
            foreach ( $defaults as $key => $default ) {
                $value = isset( $input[ $key ] ) ? $input[ $key ] : $default;
                $output[ $key ] = ( 'hero_title' === $key ) ? wp_kses_post( $value ) : sanitize_textarea_field( $value );
            }
            return $output;
        },
    ) );
});

function bk_core_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) return;
    $settings = wp_parse_args( get_option( 'bk_core_settings', array() ), bk_core_defaults() );
    ?>
    <div class="wrap" dir="rtl">
        <h1>تنظیمات باران خانومی</h1>
        <p>تمام متن‌های اصلی صفحه خانه از این بخش قابل تغییر هستند و در قالب hard-code نشده‌اند.</p>
        <form method="post" action="options.php">
            <?php settings_fields( 'bk_core_settings_group' ); ?>
            <table class="form-table" role="presentation">
                <?php
                $fields = array(
                    'brand_name' => 'نام برند',
                    'hero_badge' => 'برچسب هیرو',
                    'hero_title' => 'عنوان هیرو (HTML ساده مجاز)',
                    'hero_text' => 'توضیح هیرو',
                    'hero_primary' => 'دکمه اصلی',
                    'hero_secondary' => 'دکمه دوم',
                    'hero_image' => 'آدرس تصویر هیرو',
                    'about_title' => 'عنوان معرفی',
                    'about_text' => 'متن معرفی',
                    'footer_cta' => 'عنوان CTA پایین صفحه',
                );
                foreach ( $fields as $key => $label ) : ?>
                    <tr>
                        <th scope="row"><label for="bk-<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label></th>
                        <td>
                            <?php if ( in_array( $key, array( 'hero_text', 'about_text', 'hero_title' ), true ) ) : ?>
                                <textarea class="large-text" rows="4" id="bk-<?php echo esc_attr( $key ); ?>" name="bk_core_settings[<?php echo esc_attr( $key ); ?>]"><?php echo esc_textarea( $settings[ $key ] ); ?></textarea>
                            <?php else : ?>
                                <input class="regular-text" type="text" id="bk-<?php echo esc_attr( $key ); ?>" name="bk_core_settings[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( $settings[ $key ] ); ?>">
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <?php submit_button( 'ذخیره تنظیمات' ); ?>
        </form>
    </div>
    <?php
}
