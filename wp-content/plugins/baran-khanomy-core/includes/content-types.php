<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Homepage content model.
 * Content is managed from WordPress admin instead of being hard-coded in templates.
 */
add_action( 'init', 'bk_register_content_types' );
function bk_register_content_types() {
    register_post_type( 'bk_course', array(
        'labels' => array(
            'name' => 'دوره‌ها',
            'singular_name' => 'دوره',
            'add_new' => 'افزودن دوره',
            'add_new_item' => 'افزودن دوره جدید',
            'edit_item' => 'ویرایش دوره',
            'new_item' => 'دوره جدید',
            'view_item' => 'مشاهده دوره',
            'search_items' => 'جستجوی دوره‌ها',
            'not_found' => 'دوره‌ای پیدا نشد',
            'menu_name' => 'دوره‌ها',
        ),
        'public' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-welcome-learn-more',
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
        'has_archive' => true,
        'rewrite' => array( 'slug' => 'courses' ),
    ) );

    register_taxonomy( 'bk_course_category', 'bk_course', array(
        'labels' => array(
            'name' => 'دسته‌بندی دوره‌ها',
            'singular_name' => 'دسته‌بندی دوره',
            'menu_name' => 'دسته‌بندی‌ها',
        ),
        'public' => true,
        'show_in_rest' => true,
        'hierarchical' => true,
        'rewrite' => array( 'slug' => 'course-category' ),
    ) );

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
        'public' => false,
        'show_ui' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-format-image',
        'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
    ) );
}

add_action( 'add_meta_boxes', 'bk_add_content_meta_boxes' );
function bk_add_content_meta_boxes() {
    add_meta_box( 'bk_course_details', 'اطلاعات نمایش دوره', 'bk_course_meta_box', 'bk_course', 'normal', 'high' );
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

function bk_course_meta_box( $post ) {
    wp_nonce_field( 'bk_save_content_meta', 'bk_content_meta_nonce' );
    bk_meta_input( $post->ID, '_bk_course_image', 'آدرس تصویر دوره', 'url' );
    bk_meta_input( $post->ID, '_bk_course_price', 'قیمت', 'text', '۲۸۰,۰۰۰ تومان' );
    bk_meta_input( $post->ID, '_bk_course_discount', 'تخفیف', 'text', '۳۵٪' );
    bk_meta_input( $post->ID, '_bk_course_badge', 'برچسب', 'text', 'ویژه' );
    bk_meta_input( $post->ID, '_bk_course_url', 'لینک دوره', 'url' );
    echo '<p class="description">توضیح کوتاه را از بخش «خلاصه» وردپرس وارد کنید.</p>';
}

function bk_testimonial_meta_box( $post ) {
    wp_nonce_field( 'bk_save_content_meta', 'bk_content_meta_nonce' );
    bk_meta_input( $post->ID, '_bk_testimonial_role', 'عنوان / نقش', 'text', 'هنرجوی دوره کیف‌دوزی' );
    bk_meta_input( $post->ID, '_bk_testimonial_avatar', 'آدرس تصویر پروفایل', 'url' );
    bk_meta_input( $post->ID, '_bk_testimonial_rating', 'امتیاز', 'number', '5' );
}

function bk_student_work_meta_box( $post ) {
    wp_nonce_field( 'bk_save_content_meta', 'bk_content_meta_nonce' );
    bk_meta_input( $post->ID, '_bk_student_work_image', 'آدرس تصویر نمونه‌کار', 'url' );
    bk_meta_input( $post->ID, '_bk_student_work_student', 'نام هنرجو', 'text' );
    bk_meta_input( $post->ID, '_bk_student_work_url', 'لینک جزئیات', 'url' );
}

add_action( 'save_post', 'bk_save_content_meta' );
function bk_save_content_meta( $post_id ) {
    if ( ! isset( $_POST['bk_content_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['bk_content_meta_nonce'] ) ), 'bk_save_content_meta' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $post_types = array( 'bk_course', 'bk_testimonial', 'bk_student_work' );
    if ( ! in_array( get_post_type( $post_id ), $post_types, true ) ) return;

    $fields = array(
        '_bk_course_image' => 'esc_url_raw',
        '_bk_course_price' => 'sanitize_text_field',
        '_bk_course_discount' => 'sanitize_text_field',
        '_bk_course_badge' => 'sanitize_text_field',
        '_bk_course_url' => 'esc_url_raw',
        '_bk_testimonial_role' => 'sanitize_text_field',
        '_bk_testimonial_avatar' => 'esc_url_raw',
        '_bk_testimonial_rating' => 'absint',
        '_bk_student_work_image' => 'esc_url_raw',
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

function bk_seed_course_categories() {
    $terms = array( 'پکیج‌های آموزشی', 'دوره‌های پیشرفته', 'دوخت و طراحی', 'اکسسوری', 'کیف‌دوزی', 'تکنیک‌ها و ترفندها' );
    foreach ( $terms as $term ) {
        if ( ! term_exists( $term, 'bk_course_category' ) ) {
            wp_insert_term( $term, 'bk_course_category' );
        }
    }
}
