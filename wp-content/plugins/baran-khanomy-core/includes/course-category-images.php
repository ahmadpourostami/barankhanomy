<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Editable course-category images for Tutor LMS plus a custom image for the
 * synthetic "All Courses" item shown on the homepage.
 */

function bk_course_category_image_field( $term = null ) {
    $image_id  = $term ? absint( get_term_meta( $term->term_id, '_bk_category_image_id', true ) ) : 0;
    $image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'medium' ) : '';
    ?>
    <div class="form-field bk-category-image-field-wrap">
        <label for="bk-category-image-id">تصویر دسته‌بندی</label>
        <input type="hidden" id="bk-category-image-id" name="bk_category_image_id" value="<?php echo esc_attr( $image_id ); ?>">
        <div id="bk-category-image-preview" style="margin:8px 0 12px;">
            <?php if ( $image_url ) : ?>
                <img src="<?php echo esc_url( $image_url ); ?>" alt="" style="display:block;width:120px;height:80px;object-fit:cover;border-radius:12px;">
            <?php endif; ?>
        </div>
        <button type="button" class="button bk-category-image-select">انتخاب / آپلود تصویر</button>
        <button type="button" class="button bk-category-image-remove" <?php echo $image_id ? '' : 'style="display:none;"'; ?>>حذف تصویر</button>
        <p class="description">اگر تصویر اختصاصی این دسته را انتخاب کنید، قالب در صفحه اصلی از آن استفاده می‌کند.</p>
    </div>
    <?php
}

add_action( 'course-category_add_form_fields', function() {
    bk_course_category_image_field();
} );

add_action( 'course-category_edit_form_fields', function( $term ) {
    $image_id  = absint( get_term_meta( $term->term_id, '_bk_category_image_id', true ) );
    $image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'medium' ) : '';
    ?>
    <tr class="form-field bk-category-image-field-wrap">
        <th scope="row"><label for="bk-category-image-id">تصویر دسته‌بندی</label></th>
        <td>
            <input type="hidden" id="bk-category-image-id" name="bk_category_image_id" value="<?php echo esc_attr( $image_id ); ?>">
            <div id="bk-category-image-preview" style="margin:8px 0 12px;">
                <?php if ( $image_url ) : ?>
                    <img src="<?php echo esc_url( $image_url ); ?>" alt="" style="display:block;width:160px;height:100px;object-fit:cover;border-radius:12px;">
                <?php endif; ?>
            </div>
            <button type="button" class="button bk-category-image-select">انتخاب / آپلود تصویر</button>
            <button type="button" class="button bk-category-image-remove" <?php echo $image_id ? '' : 'style="display:none;"'; ?>>حذف تصویر</button>
            <p class="description">این تصویر در کارت دسته‌بندی صفحه اصلی استفاده می‌شود و در صورت نبود تصویر Tutor LMS به‌عنوان تصویر جایگزین نمایش داده خواهد شد.</p>
        </td>
    </tr>
    <?php
} );

function bk_save_course_category_image( $term_id ) {
    if ( ! current_user_can( 'manage_categories' ) ) return;
    $image_id = isset( $_POST['bk_category_image_id'] ) ? absint( wp_unslash( $_POST['bk_category_image_id'] ) ) : 0;
    if ( $image_id ) {
        update_term_meta( $term_id, '_bk_category_image_id', $image_id );
    } else {
        delete_term_meta( $term_id, '_bk_category_image_id' );
    }
}
add_action( 'created_course-category', 'bk_save_course_category_image' );
add_action( 'edited_course-category', 'bk_save_course_category_image' );

add_action( 'admin_enqueue_scripts', function( $hook ) {
    if ( ! in_array( $hook, array( 'edit-tags.php', 'term.php' ), true ) ) return;
    $taxonomy = isset( $_GET['taxonomy'] ) ? sanitize_key( wp_unslash( $_GET['taxonomy'] ) ) : '';
    if ( 'course-category' !== $taxonomy ) return;
    wp_enqueue_media();
    wp_enqueue_script( 'jquery' );
    wp_add_inline_script( 'jquery', <<<'JS'
jQuery(function($){
    $(document).on('click','.bk-category-image-select',function(e){
        e.preventDefault();
        const field=$(this).closest('.bk-category-image-field-wrap');
        const frame=wp.media({title:'انتخاب تصویر دسته‌بندی',button:{text:'استفاده از تصویر'},multiple:false,library:{type:'image'}});
        frame.on('select',function(){
            const a=frame.state().get('selection').first().toJSON();
            field.find('#bk-category-image-id').val(a.id);
            field.find('#bk-category-image-preview').html('<img src="'+a.url.replace(/"/g,'&quot;')+'" alt="" style="display:block;width:160px;height:100px;object-fit:cover;border-radius:12px;">');
            field.find('.bk-category-image-remove').show();
        });
        frame.open();
    });
    $(document).on('click','.bk-category-image-remove',function(e){
        e.preventDefault();
        const field=$(this).closest('.bk-category-image-field-wrap');
        field.find('#bk-category-image-id').val('');
        field.find('#bk-category-image-preview').empty();
        $(this).hide();
    });
});
JS
    );
} );

add_action( 'customize_register', function( $wp_customize ) {
    $wp_customize->add_section( 'bk_course_category_images', array(
        'title'       => 'باران خانومی - دسته‌بندی دوره‌ها',
        'priority'    => 32,
        'description' => 'تصویر «همه دوره‌ها» از این بخش قابل تغییر است. تصویر هر دسته‌بندی واقعی از صفحه ویرایش همان دسته انتخاب می‌شود.',
    ) );

    $wp_customize->add_setting( 'bk_all_courses_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'bk_all_courses_image', array(
        'label'       => 'تصویر «همه دوره‌ها»',
        'section'     => 'bk_course_category_images',
        'description' => 'این تصویر جایگزین آیکن پیش‌فرض «همه دوره‌ها» در صفحه اصلی می‌شود.',
    ) ) );
} );

add_action( 'wp_enqueue_scripts', function() {
    $image = get_theme_mod( 'bk_all_courses_image', '' );
    if ( ! $image ) return;
    $css = '.bk-category-grid > .bk-category:last-child .bk-category-image{background-image:url("' . esc_url_raw( $image ) . '");background-size:cover;background-position:center;background-repeat:no-repeat;overflow:hidden}.bk-category-grid > .bk-category:last-child .bk-category-placeholder{display:none!important}';
    wp_add_inline_style( 'bk-home', $css );
}, 30 );
