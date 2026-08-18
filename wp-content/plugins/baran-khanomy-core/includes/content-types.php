<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Baran Khanomy homepage content types.
 *
 * Courses are owned by Tutor LMS and must never be duplicated as a custom
 * post type in this plugin. This file only owns content that Tutor LMS does
 * not provide: student testimonials and student works.
 */
add_action( 'init', 'bk_register_content_types', 20 );
function bk_register_content_types() {
    register_post_type( 'bk_testimonial', array(
        'labels' => array(
            'name' => 'نظرات هنرجویان',
            'singular_name' => 'نظر هنرجو',
            'add_new' => 'افزودن نظر',
            'add_new_item' => 'افزودن نظر هنرجو',
            'edit_item' => 'ویرایش نظر',
            'new_item' => 'نظر جدید',
            'view_item' => 'مشاهده نظر',
            'search_items' => 'جستجوی نظرات',
            'not_found' => 'نظری پیدا نشد',
            'menu_name' => 'نظرات هنرجویان',
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-format-chat',
        'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
    ) );

    register_post_type( 'bk_student_work', array(
        'labels' => array(
            'name' => 'نمونه‌کار هنرجویان',
            'singular_name' => 'نمونه‌کار',
            'add_new' => 'افزودن نمونه‌کار',
            'add_new_item' => 'افزودن نمونه‌کار جدید',
            'edit_item' => 'ویرایش نمونه‌کار',
            'new_item' => 'نمونه‌کار جدید',
            'view_item' => 'مشاهده نمونه‌کار',
            'search_items' => 'جستجوی نمونه‌کارها',
            'not_found' => 'نمونه‌کاری پیدا نشد',
            'menu_name' => 'نمونه‌کار هنرجویان',
        ),
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'rewrite' => array( 'slug' => 'student-works' ),
        'menu_icon' => 'dashicons-format-image',
        'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
    ) );
}

add_action( 'add_meta_boxes', 'bk_add_content_meta_boxes' );
function bk_add_content_meta_boxes() {
    add_meta_box( 'bk_testimonial_details', 'اطلاعات نمایش نظر', 'bk_testimonial_meta_box', 'bk_testimonial', 'normal', 'high' );
    add_meta_box( 'bk_student_work_details', 'اطلاعات نمایش نمونه‌کار', 'bk_student_work_meta_box', 'bk_student_work', 'normal', 'high' );
}

function bk_meta_input( $post_id, $key, $label, $type = 'text', $placeholder = '' ) {
    $value = get_post_meta( $post_id, $key, true );
    printf(
        '<p><label for="%1$s"><strong>%2$s</strong></label><br><input class="widefat" type="%3$s" id="%1$s" name="%1$s" value="%4$s" placeholder="%5$s"></p>',
        esc_attr( $key ),
        esc_html( $label ),
        esc_attr( $type ),
        esc_attr( $value ),
        esc_attr( $placeholder )
    );
}

function bk_testimonial_meta_box( $post ) {
    wp_nonce_field( 'bk_save_content_meta', 'bk_content_meta_nonce' );
    bk_meta_input( $post->ID, '_bk_testimonial_role', 'عنوان / نقش', 'text', 'هنرجوی دوره کیف‌دوزی' );
    bk_meta_input( $post->ID, '_bk_testimonial_avatar', 'آدرس تصویر پروفایل', 'url' );
    bk_meta_input( $post->ID, '_bk_testimonial_rating', 'امتیاز', 'number', '5' );
}

function bk_student_work_meta_box( $post ) {
    wp_nonce_field( 'bk_save_content_meta', 'bk_content_meta_nonce' );
    bk_meta_input( $post->ID, '_bk_student_work_student', 'نام هنرجو', 'text' );
    bk_meta_input( $post->ID, '_bk_student_work_url', 'لینک جزئیات', 'url' );
}

add_action( 'save_post', 'bk_save_content_meta' );
function bk_save_content_meta( $post_id ) {
    if ( ! isset( $_POST['bk_content_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['bk_content_meta_nonce'] ) ), 'bk_save_content_meta' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $post_types = array( 'bk_testimonial', 'bk_student_work' );
    if ( ! in_array( get_post_type( $post_id ), $post_types, true ) ) return;

    $fields = array(
        '_bk_testimonial_role' => 'sanitize_text_field',
        '_bk_testimonial_avatar' => 'esc_url_raw',
        '_bk_testimonial_rating' => 'absint',
        '_bk_student_work_student' => 'sanitize_text_field',
        '_bk_student_work_url' => 'esc_url_raw',
    );

    foreach ( $fields as $key => $sanitize_callback ) {
        if ( ! isset( $_POST[ $key ] ) ) continue;
        $value = call_user_func( $sanitize_callback, wp_unslash( $_POST[ $key ] ) );
        if ( '' === $value || 0 === $value ) {
            delete_post_meta( $post_id, $key );
        } else {
            update_post_meta( $post_id, $key, $value );
        }
    }
}

/**
 * Seed the visual category names into Tutor LMS's own taxonomy.
 * No Tutor course is created here; courses must be created from Tutor LMS.
 */
function bk_seed_tutor_course_categories() {
    if ( ! taxonomy_exists( 'course-category' ) ) return;

    $terms = array( 'پکیج‌های آموزشی', 'دوره‌های پیشرفته', 'دوخت و طراحی', 'اکسسوری', 'کیف‌دوزی', 'تکنیک‌ها و ترفندها' );
    foreach ( $terms as $term ) {
        if ( ! term_exists( $term, 'course-category' ) ) {
            wp_insert_term( $term, 'course-category' );
        }
    }
}

function bk_seed_demo_content() {
    bk_seed_tutor_course_categories();

    if ( empty( wp_count_posts( 'bk_testimonial' )->publish ) ) {
        $reviews = array(
            array( 'نگار حسینی', 'بعد از این دوره به جرأت می‌تونم بگم مسیرم رو پیدا کردم و با خیال راحت شروع کردم.', 'هنرجوی دوره کیف‌دوزی' ),
            array( 'فاطمه محمدی', 'تکنیک‌های آموزش داده شده عالی و کاربردی بود. پشتیبانی دوره هم فوق‌العاده است.', 'هنرجوی دوره دوخت' ),
            array( 'مریم رحیمی', 'من هیچ تجربه‌ای در دوخت نداشتم اما با آموزش‌ها تونستم اولین کیف‌هام رو بسازم.', 'هنرجوی تازه‌کار' ),
        );
        foreach ( $reviews as $review ) {
            $post_id = wp_insert_post( array(
                'post_type' => 'bk_testimonial',
                'post_status' => 'publish',
                'post_title' => $review[0],
                'post_content' => $review[1],
            ) );
            if ( $post_id && ! is_wp_error( $post_id ) ) {
                update_post_meta( $post_id, '_bk_testimonial_role', $review[2] );
                update_post_meta( $post_id, '_bk_testimonial_rating', 5 );
            }
        }
    }

    if ( empty( wp_count_posts( 'bk_student_work' )->publish ) ) {
        $works = array(
            'نمونه‌کار کیف بنفش',
            'نمونه‌کار کیف پارچه‌ای',
            'نمونه‌کار کیف زرد',
            'نمونه‌کار کیف کرم',
            'نمونه‌کار کیف کلاسیک',
            'نمونه‌کار کیف دوشی',
        );
        foreach ( $works as $work ) {
            wp_insert_post( array(
                'post_type' => 'bk_student_work',
                'post_status' => 'publish',
                'post_title' => $work,
            ) );
        }
    }
}
