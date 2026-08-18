<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function bk_core_defaults() {
    return array(
        'brand_name' => 'باران خانومی',
        'hero_image' => '',
        'about_image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?auto=format&fit=crop&w=1200&q=85',
        'about_kicker' => '♡ با من بیشتر آشنا شو',
        'about_title' => 'با من، باران خانومی آشنا شوید',
        'about_text' => 'من باران هستم؛ عاشق دوخت و آموزش. تجربه سال‌ها دوخت و طراحی محصولات دست‌دوز در کنار دوره‌های کاربردی و قابل فهم، کمک می‌کند از یک مهارت ساده به یک مسیر درآمدی برسید.',
        'about_button' => 'درباره من بیشتر بدانید ←',
        'stat_courses' => '+۴۰',
        'stat_courses_label' => 'آموزش کاربردی',
        'stat_students' => '+۳۵۰۰',
        'stat_students_label' => 'هنرجوی دوره',
        'stat_experience' => '+۸',
        'stat_experience_label' => 'سال تجربه',
        'benefit_1_title' => 'دسترسی دائمی', 'benefit_1_text' => 'به تمام دوره‌ها',
        'benefit_2_title' => 'آموزش‌های کاربردی', 'benefit_2_text' => 'پروژه‌محور و درآمدزا',
        'benefit_3_title' => 'پشتیبانی و همراهی', 'benefit_3_text' => 'در تمام مسیر یادگیری',
        'categories_kicker' => 'دسته‌بندی دوره‌ها', 'categories_title' => 'مهارتت رو انتخاب کن', 'categories_link' => 'مشاهده همه ←', 'all_courses_label' => 'همه دوره‌ها',
        'courses_kicker' => 'پیشنهادهای منتخب', 'courses_title' => 'دوره‌های منتخب', 'course_button_label' => 'مشاهده دوره', 'all_courses_button' => 'مشاهده همه دوره‌ها ←', 'no_courses_text' => 'هنوز دوره‌ای منتشر نشده است.',
        'works_kicker' => 'نمونه کارها', 'works_title' => 'نمونه‌کار هنرجویان من', 'works_button' => 'مشاهده بیشتر ←',
        'testimonials_kicker' => 'تجربه هنرجویان', 'testimonials_title' => 'هنرجویان من چه می‌گویند؟', 'no_testimonials_text' => 'هنوز نظری ثبت نشده است.',
        'footer_cta' => 'آماده‌ای مسیر جدیدی رو شروع کنی؟', 'footer_description' => 'اولین قدم، انتخاب دوره‌ای است که تو را به درآمد نزدیک‌تر می‌کند.',
        'phone' => '۰۹۰۰ ۰۰۰ ۰۰۰۰', 'email' => 'barankhanomy@gmail.com', 'footer_brand_text' => 'مهارت، خلاقیت و ساختن یک مسیر درآمدی واقعی.', 'copyright' => 'تمامی حقوق این سایت متعلق به باران خانومی است.',
    );
}

function bk_core_get( $key ) {
    $settings = wp_parse_args( get_option( 'bk_core_settings', array() ), bk_core_defaults() );
    return isset( $settings[ $key ] ) ? $settings[ $key ] : '';
}

add_action( 'admin_menu', function() {
    add_menu_page( 'باران خانومی', 'باران خانومی', 'manage_options', 'bk-core-settings', 'bk_core_settings_page', 'dashicons-admin-customizer', 58 );
});

add_action( 'admin_enqueue_scripts', function( $hook ) {
    if ( 'toplevel_page_bk-core-settings' !== $hook ) return;
    wp_enqueue_media();
    wp_enqueue_script( 'jquery' );
});

add_action( 'admin_init', function() {
    register_setting( 'bk_core_settings_group', 'bk_core_settings', array(
        'sanitize_callback' => function( $input ) {
            $defaults = bk_core_defaults();
            $output = array();
            foreach ( $defaults as $key => $default ) {
                $value = isset( $input[ $key ] ) ? $input[ $key ] : $default;
                $output[ $key ] = in_array( $key, array( 'hero_image', 'about_image' ), true ) ? esc_url_raw( $value ) : sanitize_textarea_field( $value );
            }
            return $output;
        },
    ) );
});

function bk_media_field( $key, $label, $value ) {
    ?>
    <tr>
        <th scope="row"><?php echo esc_html( $label ); ?></th>
        <td>
            <div class="bk-media-field" data-bk-media-field="<?php echo esc_attr( $key ); ?>">
                <input type="hidden" class="bk-media-value" id="bk-<?php echo esc_attr( $key ); ?>" name="bk_core_settings[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( $value ); ?>">
                <div class="bk-media-preview" style="margin-bottom:10px;">
                    <?php if ( $value ) : ?><img src="<?php echo esc_url( $value ); ?>" alt="" style="display:block;max-width:360px;max-height:220px;border-radius:10px;object-fit:cover;">
                    <?php endif; ?>
                </div>
                <button type="button" class="button bk-select-media">انتخاب تصویر</button>
                <button type="button" class="button bk-remove-media" <?php echo $value ? '' : 'style="display:none;"'; ?>>حذف تصویر</button>
                <p class="description">تصویر را از کتابخانه رسانه انتخاب یا آپلود کنید.</p>
            </div>
        </td>
    </tr>
    <?php
}

function bk_text_field( $settings, $key, $label, $textarea = false ) {
    ?>
    <tr>
        <th scope="row"><label for="bk-<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label></th>
        <td>
            <?php if ( $textarea ) : ?>
                <textarea class="large-text" rows="4" id="bk-<?php echo esc_attr( $key ); ?>" name="bk_core_settings[<?php echo esc_attr( $key ); ?>]"><?php echo esc_textarea( $settings[ $key ] ); ?></textarea>
            <?php else : ?>
                <input class="regular-text" type="text" id="bk-<?php echo esc_attr( $key ); ?>" name="bk_core_settings[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( $settings[ $key ] ); ?>">
            <?php endif; ?>
        </td>
    </tr>
    <?php
}

function bk_core_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) return;
    $settings = wp_parse_args( get_option( 'bk_core_settings', array() ), bk_core_defaults() );
    ?>
    <div class="wrap" dir="rtl">
        <h1>تنظیمات قالب باران خانومی</h1>
        <p>محتوای قابل تغییر صفحه اصلی از این بخش مدیریت می‌شود. دوره‌ها همچنان از Tutor LMS و نظرات و نمونه‌کارها از منوهای اختصاصی مدیریت می‌شوند.</p>
        <form method="post" action="options.php">
            <?php settings_fields( 'bk_core_settings_group' ); ?>
            <h2>هیرو</h2>
            <p>برای هیرو فقط تصویر انتخاب می‌شود؛ متن و دکمه‌های نسخه قبلی از هیرو حذف شده‌اند.</p>
            <table class="form-table" role="presentation">
                <?php bk_media_field( 'hero_image', 'تصویر هیرو', $settings['hero_image'] ); ?>
            </table>

            <h2>معرفی باران خانومی</h2>
            <table class="form-table" role="presentation">
                <?php
                bk_media_field( 'about_image', 'تصویر بخش معرفی', $settings['about_image'] );
                bk_text_field( $settings, 'about_kicker', 'برچسب معرفی' );
                bk_text_field( $settings, 'about_title', 'عنوان معرفی' );
                bk_text_field( $settings, 'about_text', 'متن معرفی', true );
                bk_text_field( $settings, 'about_button', 'متن دکمه معرفی' );
                ?>
            </table>

            <h2>آمار و مزیت‌ها</h2>
            <table class="form-table" role="presentation">
                <?php
                bk_text_field( $settings, 'stat_courses', 'عدد آموزش‌ها' ); bk_text_field( $settings, 'stat_courses_label', 'عنوان آموزش‌ها' );
                bk_text_field( $settings, 'stat_students', 'عدد هنرجویان' ); bk_text_field( $settings, 'stat_students_label', 'عنوان هنرجویان' );
                bk_text_field( $settings, 'stat_experience', 'عدد سابقه' ); bk_text_field( $settings, 'stat_experience_label', 'عنوان سابقه' );
                bk_text_field( $settings, 'benefit_1_title', 'مزیت اول - عنوان' ); bk_text_field( $settings, 'benefit_1_text', 'مزیت اول - توضیح' );
                bk_text_field( $settings, 'benefit_2_title', 'مزیت دوم - عنوان' ); bk_text_field( $settings, 'benefit_2_text', 'مزیت دوم - توضیح' );
                bk_text_field( $settings, 'benefit_3_title', 'مزیت سوم - عنوان' ); bk_text_field( $settings, 'benefit_3_text', 'مزیت سوم - توضیح' );
                ?>
            </table>

            <h2>عنوان بخش‌ها</h2>
            <table class="form-table" role="presentation">
                <?php
                bk_text_field( $settings, 'categories_kicker', 'دسته‌بندی - برچسب' ); bk_text_field( $settings, 'categories_title', 'دسته‌بندی - عنوان' ); bk_text_field( $settings, 'categories_link', 'دسته‌بندی - لینک' ); bk_text_field( $settings, 'all_courses_label', 'برچسب همه دوره‌ها' );
                bk_text_field( $settings, 'courses_kicker', 'دوره‌ها - برچسب' ); bk_text_field( $settings, 'courses_title', 'دوره‌ها - عنوان' ); bk_text_field( $settings, 'course_button_label', 'دوره‌ها - دکمه' ); bk_text_field( $settings, 'all_courses_button', 'دوره‌ها - دکمه همه' ); bk_text_field( $settings, 'no_courses_text', 'دوره‌ها - حالت خالی' );
                bk_text_field( $settings, 'works_kicker', 'نمونه‌کار - برچسب' ); bk_text_field( $settings, 'works_title', 'نمونه‌کار - عنوان' ); bk_text_field( $settings, 'works_button', 'نمونه‌کار - دکمه' );
                bk_text_field( $settings, 'testimonials_kicker', 'نظرات - برچسب' ); bk_text_field( $settings, 'testimonials_title', 'نظرات - عنوان' ); bk_text_field( $settings, 'no_testimonials_text', 'نظرات - حالت خالی' );
                ?>
            </table>

            <h2>فوتر و اطلاعات تماس</h2>
            <table class="form-table" role="presentation">
                <?php bk_text_field( $settings, 'footer_cta', 'عنوان CTA' ); bk_text_field( $settings, 'footer_description', 'توضیح CTA', true ); bk_text_field( $settings, 'phone', 'شماره تماس' ); bk_text_field( $settings, 'email', 'ایمیل' ); bk_text_field( $settings, 'footer_brand_text', 'توضیح برند', true ); bk_text_field( $settings, 'copyright', 'کپی‌رایت' );
                ?>
            </table>
            <?php submit_button( 'ذخیره تنظیمات' ); ?>
        </form>
    </div>
    <script>
    jQuery(function($){
        $('.bk-select-media').on('click', function(e){
            e.preventDefault();
            const button = $(this), field = button.closest('.bk-media-field');
            const frame = wp.media({ title:'انتخاب تصویر', button:{text:'استفاده از تصویر'}, multiple:false, library:{type:'image'} });
            frame.on('select', function(){
                const attachment = frame.state().get('selection').first().toJSON();
                field.find('.bk-media-value').val(attachment.url);
                field.find('.bk-media-preview').html('<img src="'+attachment.url.replace(/"/g,'&quot;')+'" alt="" style="display:block;max-width:360px;max-height:220px;border-radius:10px;object-fit:cover;">');
                field.find('.bk-remove-media').show();
            });
            frame.open();
        });
        $('.bk-remove-media').on('click', function(){
            const field = $(this).closest('.bk-media-field');
            field.find('.bk-media-value').val(''); field.find('.bk-media-preview').empty(); $(this).hide();
        });
    });
    </script>
    <?php
}
