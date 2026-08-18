<?php
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'BK_THEME_VERSION', '0.1.4' );
define( 'BK_THEME_DIR', get_template_directory() );
define( 'BK_THEME_URI', get_template_directory_uri() );

add_action( 'after_setup_theme', function() {
    load_theme_textdomain( 'baran-khanomy', BK_THEME_DIR . '/languages' );
    add_theme_support( 'title-tag' ); add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
    add_theme_support( 'custom-logo', array( 'height' => 80, 'width' => 180, 'flex-height' => true, 'flex-width' => true ) );
    register_nav_menus( array( 'primary' => 'منوی اصلی' ) );
});

add_action( 'customize_register', function( $wp_customize ) {
    $wp_customize->add_section( 'bk_header_settings', array( 'title' => 'باران خانومی - سربرگ', 'priority' => 30 ) );
    foreach ( array( 'bk_header_tagline' => array( 'مهارت • خلاقیت • درآمد', 'زیرعنوان لوگو' ), 'bk_search_placeholder' => array( 'جستجوی دوره...', 'متن جستجو' ), 'bk_login_label' => array( 'ورود / ثبت‌نام', 'متن دکمه ورود' ) ) as $setting => $data ) {
        $wp_customize->add_setting( $setting, array( 'default' => $data[0], 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( $setting, array( 'label' => $data[1], 'section' => 'bk_header_settings', 'type' => 'text' ) );
    }
});

add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style( 'bk-font', 'https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700;800&display=swap', array(), null );
    wp_enqueue_style( 'bk-main', BK_THEME_URI . '/assets/css/main.css', array(), BK_THEME_VERSION );
    wp_enqueue_style( 'bk-home', BK_THEME_URI . '/assets/css/home.css', array( 'bk-main' ), BK_THEME_VERSION );
    wp_enqueue_script( 'bk-main', BK_THEME_URI . '/assets/js/main.js', array(), BK_THEME_VERSION, true );
});

function bk_setting( $key, $fallback = '' ) {
    if ( function_exists( 'bk_core_get' ) ) { $value = bk_core_get( $key ); return $value !== '' ? $value : $fallback; }
    return $fallback;
}
function bk_icon( $name ) {
    $icons = array( 'grid' => '▦', 'bag' => '♧', 'gift' => '◇', 'award' => '✦', 'calendar' => '□', 'play' => '▷', 'headset' => '♧', 'heart' => '♡', 'arrow' => '←', 'menu' => '☰', 'search' => '⌕' );
    return isset( $icons[ $name ] ) ? $icons[ $name ] : '•';
}
function bk_tutor_is_active() { return function_exists( 'tutor_utils' ) && function_exists( 'tutor' ); }

function bk_tutor_course_discount( $course_id = 0 ) {
    $course_id = $course_id ? $course_id : get_the_ID();
    $regular = (float) get_post_meta( $course_id, 'tutor_course_price', true );
    $sale = (float) get_post_meta( $course_id, 'tutor_course_sale_price', true );
    if ( $regular <= 0 || $sale <= 0 || $sale >= $regular ) return '';
    return (string) round( ( ( $regular - $sale ) / $regular ) * 100 ) . '%';
}

function bk_tutor_course_price_parts( $course_id = 0 ) {
    $course_id = $course_id ? $course_id : get_the_ID();
    $regular = (float) get_post_meta( $course_id, 'tutor_course_price', true );
    $sale = (float) get_post_meta( $course_id, 'tutor_course_sale_price', true );
    $currency = function_exists( 'tutor_utils' ) && method_exists( tutor_utils(), 'currency_symbol' ) ? tutor_utils()->currency_symbol() : 'تومان';
    if ( $regular > 0 && $sale > 0 && $sale < $regular ) return array( 'regular' => number_format_i18n( $regular ) . ' ' . $currency, 'sale' => number_format_i18n( $sale ) . ' ' . $currency );
    if ( $regular > 0 ) return array( 'regular' => '', 'sale' => number_format_i18n( $regular ) . ' ' . $currency );
    return array( 'regular' => '', 'sale' => 'رایگان' );
}

function bk_render_course_card( $course_id = 0 ) {
    $course_id = $course_id ? $course_id : get_the_ID();
    $title = get_the_title( $course_id ); $url = get_permalink( $course_id );
    $image = get_the_post_thumbnail_url( $course_id, 'large' );
    $discount = bk_tutor_course_discount( $course_id ); $prices = bk_tutor_course_price_parts( $course_id );
    $terms = get_the_terms( $course_id, 'course-category' );
    ob_start(); ?>
    <article class="bk-course-card">
      <a class="bk-course-image" href="<?php echo esc_url( $url ); ?>">
        <?php if ( $image ) : ?><img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>"><?php else : ?><div class="bk-course-placeholder"></div><?php endif; ?>
        <?php if ( $terms && ! is_wp_error( $terms ) ) : ?><span class="bk-course-category-pill"><?php echo esc_html( $terms[0]->name ); ?></span><?php endif; ?>
        <?php if ( $discount ) : ?><span class="bk-discount"><?php echo esc_html( $discount ); ?></span><?php endif; ?>
      </a>
      <div class="bk-course-body">
        <h3><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $title ); ?></a></h3>
        <div class="bk-course-price"><?php if ( $prices['regular'] ) : ?><del><?php echo esc_html( $prices['regular'] ); ?></del><?php endif; ?><strong><?php echo esc_html( $prices['sale'] ); ?></strong></div>
        <a href="<?php echo esc_url( $url ); ?>" class="bk-course-link"><?php echo esc_html( bk_setting( 'course_button_label', 'مشاهده دوره' ) ); ?> <span>←</span></a>
      </div>
    </article>
    <?php return ob_get_clean();
}
