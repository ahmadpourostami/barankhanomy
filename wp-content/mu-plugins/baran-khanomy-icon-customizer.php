<?php
/**
 * Baran Khanomy – SVG icon Customizer
 * Lets the site owner replace contextual course/product icons without editing theme files.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function bk_icon_customizer_sanitize_svg( $svg ) {
    $allowed = array(
        'svg' => array(
            'viewbox' => true, 'width' => true, 'height' => true,
            'fill' => true, 'stroke' => true, 'stroke-width' => true,
            'stroke-linecap' => true, 'stroke-linejoin' => true,
            'preserveaspectratio' => true, 'aria-hidden' => true,
            'focusable' => true, 'role' => true, 'class' => true,
        ),
        'path' => array(
            'd' => true, 'fill' => true, 'stroke' => true,
            'stroke-width' => true, 'stroke-linecap' => true,
            'stroke-linejoin' => true, 'class' => true,
        ),
        'circle' => array(
            'cx' => true, 'cy' => true, 'r' => true,
            'fill' => true, 'stroke' => true, 'stroke-width' => true,
            'class' => true,
        ),
        'rect' => array(
            'x' => true, 'y' => true, 'width' => true, 'height' => true,
            'rx' => true, 'ry' => true, 'fill' => true, 'stroke' => true,
            'stroke-width' => true, 'class' => true,
        ),
        'line' => array(
            'x1' => true, 'y1' => true, 'x2' => true, 'y2' => true,
            'fill' => true, 'stroke' => true, 'stroke-width' => true,
            'stroke-linecap' => true, 'stroke-linejoin' => true, 'class' => true,
        ),
        'polyline' => array(
            'points' => true, 'fill' => true, 'stroke' => true,
            'stroke-width' => true, 'stroke-linecap' => true,
            'stroke-linejoin' => true, 'class' => true,
        ),
        'polygon' => array(
            'points' => true, 'fill' => true, 'stroke' => true,
            'stroke-width' => true, 'stroke-linecap' => true,
            'stroke-linejoin' => true, 'class' => true,
        ),
    );

    return wp_kses( (string) $svg, $allowed );
}

function bk_icon_customizer_defaults() {
    return array(
        'bk_icon_course_clock' => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="8.5"></circle><path d="M12 7v5l3.5 2"></path></svg>',
        'bk_icon_course_level' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 17.5h16M6 13h12M8 8.5h8"></path><circle cx="5" cy="17.5" r="1"></circle><circle cx="19" cy="17.5" r="1"></circle></svg>',
        'bk_icon_course_access' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6.5 8.5A5.5 5.5 0 0 1 17 6l1.5 1.5"></path><path d="m16 4 2.5 3.5L22 5"></path><path d="M17.5 15.5A5.5 5.5 0 0 1 7 18l-1.5-1.5"></path><path d="m8 20-2.5-3.5L2 19"></path></svg>',
        'bk_icon_course_support' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 13v-1a8 8 0 0 1 16 0v1"></path><path d="M4 13h2.5A1.5 1.5 0 0 1 8 14.5v2A1.5 1.5 0 0 1 6.5 18H6a2 2 0 0 1-2-2v-3Z"></path><path d="M20 13h-2.5a1.5 1.5 0 0 0-1.5 1.5v2a1.5 1.5 0 0 0 1.5 1.5h.5a2 2 0 0 0 2-2v-3Z"></path><path d="M15 19.5c-.8.7-1.8 1-3 1h-1"></path></svg>',
        'bk_icon_course_update' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 11a8 8 0 0 0-13.5-5L5 7.5"></path><path d="M5 4v3.5h3.5"></path><path d="M4 13a8 8 0 0 0 13.5 5l1.5-1.5"></path><path d="M19 20v-3.5h-3.5"></path></svg>',
        'bk_icon_product_handmade' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8.5 12.5 5 9l2-2 4.5 4.5"></path><path d="m11 11 2-2a2 2 0 0 1 2.8 0l3.2 3.2a2 2 0 0 1 0 2.8l-3.8 3.8a2 2 0 0 1-2.8 0L9 15.4"></path><path d="M5.5 17.5 8 20"></path><path d="M14.5 5.5V3M17.5 7H20M16.7 6.3l1.4-1.4"></path></svg>',
        'bk_icon_product_quality' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="m12 3 2.2 1.4 2.6.2 1.1 2.3 1.9 1.8-.6 2.5.6 2.5-1.9 1.8-1.1 2.3-2.6.2L12 21l-2.2-1.4-2.6-.2-1.1-2.3-1.9-1.8.6-2.5-.6-2.5 1.9-1.8 1.1-2.3 2.6-.2L12 3Z"></path><path d="m8.5 12 2.2 2.2 4.8-5"></path></svg>',
        'bk_icon_product_return' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 7H5a2 2 0 0 0-2 2v2"></path><path d="m6 6-3 3 3 3"></path><path d="M3 9h10a7 7 0 0 1 7 7v2"></path><path d="M14 18h6"></path></svg>',
        'bk_icon_product_shipping' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h11v10H3zM14 9h4l3 3v4h-7z"></path><circle cx="7" cy="18" r="2"></circle><circle cx="18" cy="18" r="2"></circle><path d="M14 12h4"></path></svg>',
    );
}

add_action( 'customize_register', function( $wp_customize ) {
    $wp_customize->add_section( 'bk_icon_settings', array(
        'title'       => 'باران خانومی - آیکن‌ها',
        'priority'    => 40,
        'description' => 'کد SVG هر آیکن را می‌توانید جداگانه تغییر دهید. فقط کد خود SVG را وارد کنید.',
    ) );

    $labels = array(
        'bk_icon_course_clock'      => 'مدت دوره',
        'bk_icon_course_level'      => 'سطح دوره',
        'bk_icon_course_access'     => 'دسترسی همیشگی',
        'bk_icon_course_support'    => 'پشتیبانی',
        'bk_icon_course_update'     => 'آپدیت رایگان',
        'bk_icon_product_handmade'  => 'محصول دست‌ساز',
        'bk_icon_product_quality'   => 'کیفیت تضمین‌شده',
        'bk_icon_product_return'    => 'ضمانت بازگشت',
        'bk_icon_product_shipping'  => 'ارسال سریع',
    );

    foreach ( bk_icon_customizer_defaults() as $setting => $default ) {
        $wp_customize->add_setting( $setting, array(
            'default'           => $default,
            'sanitize_callback' => 'bk_icon_customizer_sanitize_svg',
            'transport'         => 'refresh',
        ) );

        $wp_customize->add_control( $setting, array(
            'label'       => $labels[ $setting ],
            'description' => 'کد SVG را وارد کنید.',
            'section'     => 'bk_icon_settings',
            'type'        => 'textarea',
            'input_attrs' => array(
                'dir'         => 'ltr',
                'rows'        => 5,
                'placeholder' => '<svg viewBox="0 0 24 24">...</svg>',
                'style'       => 'font-family:monospace;font-size:12px;direction:ltr;text-align:left;',
            ),
        ) );
    }
} );

add_action( 'wp_footer', function() {
    if ( is_admin() ) return;

    $icons = array();
    foreach ( bk_icon_customizer_defaults() as $key => $default ) {
        $icons[ $key ] = get_theme_mod( $key, $default );
    }
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const icons = <?php echo wp_json_encode( $icons ); ?>;
        const course = [
            'bk_icon_course_clock',
            'bk_icon_course_level',
            'bk_icon_course_access',
            'bk_icon_course_support',
            'bk_icon_course_update'
        ];
        document.querySelectorAll('.bk-course-feature-strip .bk-feature-icon').forEach(function (el, index) {
            if (course[index] && icons[course[index]]) el.innerHTML = icons[course[index]];
        });

        const product = [
            'bk_icon_product_handmade',
            'bk_icon_product_quality',
            'bk_icon_product_return',
            'bk_icon_product_shipping'
        ];
        document.querySelectorAll('.bk-market-benefits .bk-market-icon').forEach(function (el, index) {
            if (product[index] && icons[product[index]]) el.innerHTML = icons[product[index]];
        });
    });
    </script>
    <?php
}, 110 );
