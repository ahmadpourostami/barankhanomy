<?php
/**
 * Baran Khanomy – Icon size controls
 * Adds editable SVG size controls to the existing icon customizer section.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'customize_register', function( $wp_customize ) {
    if ( ! $wp_customize->get_section( 'bk_icon_settings' ) ) return;

    $controls = array(
        'bk_course_icon_size' => array(
            'label'   => 'اندازه آیکن‌های صفحه دوره',
            'default' => 52,
            'min'     => 28,
            'max'     => 80,
        ),
        'bk_product_icon_size' => array(
            'label'   => 'اندازه آیکن‌های صفحه محصول',
            'default' => 36,
            'min'     => 24,
            'max'     => 64,
        ),
    );

    foreach ( $controls as $setting => $args ) {
        $wp_customize->add_setting( $setting, array(
            'default'           => $args['default'],
            'sanitize_callback' => function( $value ) use ( $args ) {
                return max( $args['min'], min( $args['max'], absint( $value ) ) );
            },
            'transport'         => 'refresh',
        ) );

        $wp_customize->add_control( $setting, array(
            'label'       => $args['label'],
            'description' => sprintf( 'مقدار بین %d تا %d پیکسل.', $args['min'], $args['max'] ),
            'section'     => 'bk_icon_settings',
            'type'        => 'range',
            'input_attrs' => array(
                'min'  => $args['min'],
                'max'  => $args['max'],
                'step' => 1,
            ),
        ) );
    }
}, 20 );

add_action( 'wp_head', function() {
    if ( is_admin() ) return;

    $course_size  = max( 28, min( 80, absint( get_theme_mod( 'bk_course_icon_size', 52 ) ) ) );
    $product_size = max( 24, min( 64, absint( get_theme_mod( 'bk_product_icon_size', 36 ) ) ) );
    ?>
    <style id="bk-custom-icon-sizes">
        .bk-course-feature-strip .bk-feature-icon svg {
            width: <?php echo esc_attr( $course_size ); ?>px !important;
            height: <?php echo esc_attr( $course_size ); ?>px !important;
            max-width: none !important;
            max-height: none !important;
        }
        .bk-market-single .bk-market-icon svg,
        .bk-market-benefits .bk-market-icon svg {
            width: <?php echo esc_attr( $product_size ); ?>px !important;
            height: <?php echo esc_attr( $product_size ); ?>px !important;
            max-width: none !important;
            max-height: none !important;
        }
        @media (max-width: 760px) {
            .bk-course-feature-strip .bk-feature-icon svg {
                width: min(<?php echo esc_attr( $course_size ); ?>px, 100%) !important;
                height: min(<?php echo esc_attr( $course_size ); ?>px, 100%) !important;
            }
            .bk-market-single .bk-market-icon svg,
            .bk-market-benefits .bk-market-icon svg {
                width: min(<?php echo esc_attr( $product_size ); ?>px, 100%) !important;
                height: min(<?php echo esc_attr( $product_size ); ?>px, 100%) !important;
            }
        }
    </style>
    <?php
}, 999 );
