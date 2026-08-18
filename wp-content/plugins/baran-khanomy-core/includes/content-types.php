<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Baran Khanomy homepage content types.
 * Courses belong to Tutor LMS. This plugin only owns testimonials and student works.
 */
add_action( 'init', 'bk_register_content_types', 20 );
function bk_register_content_types() {
    register_post_type( 'bk_testimonial', array(
        'labels' => array( 'name' => 'نظرات هنرجویان', 'singular_name' => 'نظر هنرجو', 'add_new' => 'افزودن نظر', 'add_new_item' => 'افزودن نظر هنرجو', 'edit_item' => 'ویرایش نظر', 'new_item' => 'نظر جدید', 'view_item' => 'مشاهده نظر', 'search_items' => 'جستجوی نظرات', 'not_found' => 'نظری پیدا نشد', 'menu_name' => 'نظرات هنرجویان' ),
        'public' => false, 'show_ui' => true, 'show_in_rest' => true, 'menu_icon' => 'dashicons-format-chat', 'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
    ) );

    register_post_type( 'bk_student_work', array(
        'labels' => array( 'name' => 'نمونه‌کار هنرجویان', 'singular_name' => 'نمونه‌کار', 'add_new' => 'افزودن نمونه‌کار', 'add_new_item' => 'افزودن نمونه‌کار جدید', 'edit_item' => 'ویرایش نمونه‌کار', 'new_item' => 'نمونه‌کار جدید', 'view_item' => 'مشاهده نمونه‌کار', 'search_items' => 'جستجوی نمونه‌کارها', 'not_found' => 'نمونه‌کاری پیدا نشد', 'menu_name' => 'نمونه‌کار هنرجویان' ),
        'public' => true, 'show_ui' => true, 'show_in_rest' => true, 'has_archive' => true, 'rewrite' => array( 'slug' => 'student-works' ), 'menu_icon' => 'dashicons-format-image', 'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
    ) );
}

add_action( 'add_meta_boxes', 'bk_add_content_meta_boxes' );
function bk_add_content_meta_boxes() {
    add_meta_box( 'bk_testimonial_details', 'اطلاعات نمایش نظر', 'bk_testimonial_meta_box', 'bk_testimonial', 'normal', 'high' );
    add_meta_box( 'bk_student_work_details', 'اطلاعات نمایش نمونه‌کار', 'bk_student_work_meta_box', 'bk_student_work', 'normal', 'high' );
}

function bk_meta_input( $post_id, $key, $label, $type = 'text', $placeholder = '' ) {
    $value = get_post_meta( $post_id, $key, true );
    printf( '<p><label for="%1$s"><strong>%2$s</strong></label><br><input class="widefat" type="%3$s" id="%1$s" name="%1$s" value="%4$s" placeholder="%5$s"></p>', esc_attr( $key ), esc_html( $label ), esc_attr( $type ), esc_attr( $value ), esc_attr( $placeholder ) );
}

function bk_testimonial_meta_box( $post ) {
    wp_nonce_field( 'bk_save_content_meta', 'bk_content_meta_nonce' );
    $avatar_id  = absint( get_post_meta( $post->ID, '_bk_testimonial_avatar_id', true ) );
    $avatar_url = $avatar_id ? wp_get_attachment_image_url( $avatar_id, 'medium' ) : get_post_meta( $post->ID, '_bk_testimonial_avatar', true );
    ?>
    <p><strong>عکس هنرجو</strong></p>
    <input type="hidden" id="_bk_testimonial_avatar_id" name="_bk_testimonial_avatar_id" value="<?php echo esc_attr( $avatar_id ); ?>">
    <div id="bk-testimonial-avatar-preview" style="margin:0 0 12px;">
        <?php if ( $avatar_url ) : ?><img src="<?php echo esc_url( $avatar_url ); ?>" alt="" style="width:90px;height:90px;display:block;object-fit:cover;border-radius:50%;border:1px solid #e7dced;">
        <?php else : ?><div style="width:90px;height:90px;border-radius:50%;background:#f6eff9;border:1px solid #e7dced;display:grid;place-items:center;color:#8b72a0;">بدون عکس</div><?php endif; ?>
    </div>
    <p>
        <button type="button" class="button button-primary" id="bk-testimonial-select-avatar">انتخاب / آپلود عکس هنرجو</button>
        <button type="button" class="button" id="bk-testimonial-remove-avatar" <?php echo $avatar_url ? '' : 'style="display:none;"'; ?>>حذف عکس</button>
    </p>
    <p class="description">عکس مستقیماً از کتابخانه رسانه وردپرس انتخاب یا آپلود می‌شود. تصویر در سایت به صورت مربعی و بدون کشیدگی نمایش داده می‌شود.</p>
    <?php
    bk_meta_input( $post->ID, '_bk_testimonial_role', 'عنوان / نقش', 'text', 'هنرجوی دوره کیف‌دوزی' );
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
    if ( ! in_array( get_post_type( $post_id ), array( 'bk_testimonial', 'bk_student_work' ), true ) ) return;

    $fields = array( '_bk_testimonial_role' => 'sanitize_text_field', '_bk_testimonial_avatar' => 'esc_url_raw', '_bk_testimonial_avatar_id' => 'absint', '_bk_testimonial_rating' => 'absint', '_bk_student_work_student' => 'sanitize_text_field', '_bk_student_work_url' => 'esc_url_raw' );
    foreach ( $fields as $key => $sanitize_callback ) {
        if ( ! isset( $_POST[ $key ] ) ) continue;
        $value = call_user_func( $sanitize_callback, wp_unslash( $_POST[ $key ] ) );
        if ( '' === $value || 0 === $value ) delete_post_meta( $post_id, $key ); else update_post_meta( $post_id, $key, $value );
    }
}

add_action( 'admin_enqueue_scripts', 'bk_testimonial_media_scripts' );
function bk_testimonial_media_scripts( $hook ) {
    global $post;
    if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) || ! $post || 'bk_testimonial' !== get_post_type( $post ) ) return;
    wp_enqueue_media();
    wp_add_inline_script( 'jquery', "jQuery(function($){let frame;$('#bk-testimonial-select-avatar').on('click',function(e){e.preventDefault();frame=wp.media({title:'انتخاب عکس هنرجو',button:{text:'استفاده از این عکس'},multiple:false,library:{type:'image'}});frame.on('select',function(){const a=frame.state().get('selection').first().toJSON();$('#_bk_testimonial_avatar_id').val(a.id);$('#bk-testimonial-avatar-preview').html('<img src=\"'+a.url.replace(/\"/g,'&quot;')+'\" alt=\"\" style=\"width:90px;height:90px;display:block;object-fit:cover;border-radius:50%;border:1px solid #e7dced;\">');$('#bk-testimonial-remove-avatar').show();});frame.open();});$('#bk-testimonial-remove-avatar').on('click',function(e){e.preventDefault();$('#_bk_testimonial_avatar_id').val('');$('#_bk-testimonial-avatar-preview').html('<div style=\"width:90px;height:90px;border-radius:50%;background:#f6eff9;border:1px solid #e7dced;display:grid;place-items:center;color:#8b72a0;\">بدون عکس</div>');$(this).hide();});});" );
}

/** Tutor LMS category image field. */
add_action( 'course-category_add_form_fields', 'bk_category_add_image_field' );
function bk_category_add_image_field() { ?>
    <div class="form-field"><label for="bk-category-image">تصویر دسته‌بندی</label><input type="hidden" name="bk_category_image_id" id="bk-category-image" value=""><div id="bk-category-image-preview"></div><button type="button" class="button bk-category-select-image">انتخاب تصویر</button><p>تصویر این دسته در کارت دسته‌بندی صفحه اصلی نمایش داده می‌شود.</p></div>
<?php }
add_action( 'course-category_edit_form_fields', 'bk_category_edit_image_field' );
function bk_category_edit_image_field( $term ) { $image_id = (int) get_term_meta( $term->term_id, '_bk_category_image_id', true ); $image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'medium' ) : ''; ?>
    <tr class="form-field"><th scope="row"><label for="bk-category-image">تصویر دسته‌بندی</label></th><td><input type="hidden" name="bk_category_image_id" id="bk-category-image" value="<?php echo esc_attr( $image_id ); ?>"><div id="bk-category-image-preview" style="margin-bottom:10px;"><?php if ( $image_url ) : ?><img src="<?php echo esc_url( $image_url ); ?>" style="width:120px;height:80px;object-fit:cover;border-radius:8px;"><?php endif; ?></div><button type="button" class="button bk-category-select-image">انتخاب تصویر</button><button type="button" class="button bk-category-remove-image" <?php echo $image_id ? '' : 'style="display:none;"'; ?>>حذف تصویر</button><p class="description">این تصویر در بخش دسته‌بندی دوره‌های صفحه اصلی استفاده می‌شود.</p></td></tr>
<?php }
add_action( 'created_course-category', 'bk_save_category_image' ); add_action( 'edited_course-category', 'bk_save_category_image' );
function bk_save_category_image( $term_id ) { if ( ! current_user_can( 'manage_categories' ) || ! isset( $_POST['bk_category_image_id'] ) ) return; $image_id = absint( $_POST['bk_category_image_id'] ); if ( $image_id ) update_term_meta( $term_id, '_bk_category_image_id', $image_id ); else delete_term_meta( $term_id, '_bk_category_image_id' ); }
add_action( 'admin_enqueue_scripts', 'bk_category_media_scripts' );
function bk_category_media_scripts( $hook ) { if ( ! in_array( $hook, array( 'edit-tags.php', 'term.php' ), true ) ) return; $taxonomy = isset( $_GET['taxonomy'] ) ? sanitize_key( $_GET['taxonomy'] ) : ''; if ( 'course-category' !== $taxonomy ) return; wp_enqueue_media(); wp_add_inline_script( 'jquery', "jQuery(function($){let frame;$('.bk-category-select-image').on('click',function(e){e.preventDefault();frame=wp.media({title:'انتخاب تصویر دسته‌بندی',button:{text:'استفاده از تصویر'},multiple:false,library:{type:'image'}});frame.on('select',function(){const a=frame.state().get('selection').first().toJSON();$('#bk-category-image').val(a.id);$('#bk-category-image-preview').html('<img src=\"'+a.url+'\" style=\"width:120px;height:80px;object-fit:cover;border-radius:8px;\">');$('.bk-category-remove-image').show();});frame.open();});$('.bk-category-remove-image').on('click',function(){ $('#bk-category-image').val('');$('#bk-category-image-preview').empty();$(this).hide();});});" ); }

function bk_seed_tutor_course_categories() { if ( ! taxonomy_exists( 'course-category' ) ) return; $terms = array( 'پکیج‌های آموزشی', 'دوره‌های پیشرفته', 'دوخت و طراحی', 'اکسسوری', 'کیف‌دوزی', 'تکنیک‌ها و ترفندها' ); foreach ( $terms as $term ) if ( ! term_exists( $term, 'course-category' ) ) wp_insert_term( $term, 'course-category' ); }
function bk_seed_demo_content() {
    bk_seed_tutor_course_categories();
    if ( empty( wp_count_posts( 'bk_testimonial' )->publish ) ) { $reviews = array( array( 'نگار حسینی', 'بعد از این دوره به جرأت می‌تونم بگم مسیرم رو پیدا کردم و با خیال راحت شروع کردم.', 'هنرجوی دوره کیف‌دوزی' ), array( 'فاطمه محمدی', 'تکنیک‌های آموزش داده شده عالی و کاربردی بود. پشتیبانی دوره هم فوق‌العاده است.', 'هنرجوی دوره دوخت' ), array( 'مریم رحیمی', 'من هیچ تجربه‌ای در دوخت نداشتم اما با آموزش‌ها تونستم اولین کیف‌هام رو بسازم.', 'هنرجوی تازه‌کار' ) ); foreach ( $reviews as $review ) { $post_id = wp_insert_post( array( 'post_type' => 'bk_testimonial', 'post_status' => 'publish', 'post_title' => $review[0], 'post_content' => $review[1] ) ); if ( $post_id && ! is_wp_error( $post_id ) ) { update_post_meta( $post_id, '_bk_testimonial_role', $review[2] ); update_post_meta( $post_id, '_bk_testimonial_rating', 5 ); } } }
    if ( empty( wp_count_posts( 'bk_student_work' )->publish ) ) foreach ( array( 'نمونه‌کار کیف بنفش', 'نمونه‌کار کیف پارچه‌ای', 'نمونه‌کار کیف زرد', 'نمونه‌کار کیف کرم', 'نمونه‌کار کیف کلاسیک', 'نمونه‌کار کیف دوشی' ) as $work ) wp_insert_post( array( 'post_type' => 'bk_student_work', 'post_status' => 'publish', 'post_title' => $work ) );
}
