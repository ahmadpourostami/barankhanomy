<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function bk_marketplace_defaults() {
    return array(
        'home_count'       => 4,
        'kicker'           => 'بازارچه',
        'title'            => 'محصولات دست‌ساز هنرجویان',
        'description'      => 'محصولاتی که با عشق و هنر دست ساخته شده‌اند.',
        'button_label'     => 'مشاهده کل بازارچه',
        'category_ids'     => array(),
    );
}

function bk_marketplace_get( $key, $fallback = '' ) {
    $settings = wp_parse_args( get_option( 'bk_marketplace_settings', array() ), bk_marketplace_defaults() );
    return isset( $settings[ $key ] ) ? $settings[ $key ] : $fallback;
}

add_action( 'admin_menu', function() {
    add_submenu_page( 'bk-core-settings', 'بازارچه', 'بازارچه', 'manage_options', 'bk-marketplace-settings', 'bk_marketplace_settings_page' );
} );

add_action( 'admin_init', function() {
    register_setting( 'bk_marketplace_settings_group', 'bk_marketplace_settings', array(
        'sanitize_callback' => function( $input ) {
            $defaults = bk_marketplace_defaults();
            $category_ids = isset( $input['category_ids'] ) && is_array( $input['category_ids'] )
                ? array_values( array_filter( array_map( 'absint', $input['category_ids'] ) ) )
                : array();

            return array(
                'home_count'   => max( 1, min( 12, absint( $input['home_count'] ?? $defaults['home_count'] ) ) ),
                'kicker'       => sanitize_text_field( $input['kicker'] ?? $defaults['kicker'] ),
                'title'        => sanitize_text_field( $input['title'] ?? $defaults['title'] ),
                'description'  => sanitize_textarea_field( $input['description'] ?? $defaults['description'] ),
                'button_label' => sanitize_text_field( $input['button_label'] ?? $defaults['button_label'] ),
                'category_ids' => $category_ids,
            );
        },
    ) );
} );

function bk_marketplace_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) return;

    $categories = array();
    if ( taxonomy_exists( 'product_cat' ) ) {
        $categories = get_terms( array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => false,
            'orderby'    => 'name',
            'order'      => 'ASC',
        ) );
    }

    $selected_categories = (array) bk_marketplace_get( 'category_ids', array() );
    ?>
    <div class="wrap" dir="rtl">
        <h1>تنظیمات بازارچه</h1>
        <p>از این بخش محتوای بخش بازارچه صفحه اصلی، تعداد محصولات و دسته‌بندی محصولاتی که باید نمایش داده شوند را مدیریت کنید.</p>

        <form method="post" action="options.php">
            <?php settings_fields( 'bk_marketplace_settings_group' ); ?>

            <h2>محتوای بخش بازارچه</h2>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><label for="bk-marketplace-kicker">برچسب بالای عنوان</label></th>
                    <td>
                        <input id="bk-marketplace-kicker" class="regular-text" type="text" name="bk_marketplace_settings[kicker]" value="<?php echo esc_attr( bk_marketplace_get( 'kicker', 'بازارچه' ) ); ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bk-marketplace-title">عنوان بخش</label></th>
                    <td>
                        <input id="bk-marketplace-title" class="regular-text" type="text" name="bk_marketplace_settings[title]" value="<?php echo esc_attr( bk_marketplace_get( 'title', 'محصولات دست‌ساز هنرجویان' ) ); ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bk-marketplace-description">توضیح بخش</label></th>
                    <td>
                        <textarea id="bk-marketplace-description" class="large-text" rows="3" name="bk_marketplace_settings[description]"><?php echo esc_textarea( bk_marketplace_get( 'description', 'محصولاتی که با عشق و هنر دست ساخته شده‌اند.' ) ); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bk-marketplace-button">متن دکمه بازارچه</label></th>
                    <td>
                        <input id="bk-marketplace-button" class="regular-text" type="text" name="bk_marketplace_settings[button_label]" value="<?php echo esc_attr( bk_marketplace_get( 'button_label', 'مشاهده کل بازارچه' ) ); ?>">
                    </td>
                </tr>
            </table>

            <h2>محصولات صفحه اصلی</h2>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><label for="bk-marketplace-home-count">تعداد محصولات</label></th>
                    <td>
                        <input id="bk-marketplace-home-count" class="small-text" type="number" min="1" max="12" name="bk_marketplace_settings[home_count]" value="<?php echo esc_attr( bk_marketplace_get( 'home_count', 4 ) ); ?>">
                        <span>محصول</span>
                        <p class="description">تعداد محصولاتی که در کاروسل بازارچه صفحه اصلی نمایش داده می‌شوند.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">دسته‌بندی محصولات</th>
                    <td>
                        <?php if ( ! class_exists( 'WooCommerce' ) || ! taxonomy_exists( 'product_cat' ) ) : ?>
                            <p class="notice notice-warning inline">ووکامرس فعال نیست یا دسته‌بندی محصولات در دسترس نیست.</p>
                        <?php elseif ( empty( $categories ) ) : ?>
                            <p>هنوز دسته‌بندی محصولی ایجاد نشده است.</p>
                        <?php else : ?>
                            <fieldset style="max-height:320px;overflow:auto;border:1px solid #ddd;padding:14px;border-radius:8px;background:#fff;max-width:520px;">
                                <?php foreach ( $categories as $category ) : ?>
                                    <label style="display:block;margin:0 0 10px;">
                                        <input type="checkbox" name="bk_marketplace_settings[category_ids][]" value="<?php echo esc_attr( $category->term_id ); ?>" <?php checked( in_array( (int) $category->term_id, array_map( 'intval', $selected_categories ), true ) ); ?>>
                                        <?php echo esc_html( $category->name ); ?>
                                        <span style="color:#777;">(<?php echo esc_html( number_format_i18n( $category->count ) ); ?>)</span>
                                    </label>
                                <?php endforeach; ?>
                            </fieldset>
                            <p class="description">اگر هیچ دسته‌ای انتخاب نشود، محصولات جدید ووکامرس از همه دسته‌ها نمایش داده می‌شوند. با انتخاب یک یا چند دسته، فقط محصولات همان دسته‌ها در بازارچه صفحه اصلی قرار می‌گیرند.</p>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>

            <?php submit_button( 'ذخیره تنظیمات بازارچه' ); ?>
        </form>
    </div>
    <?php
}

add_action( 'after_setup_theme', function() {
    add_theme_support( 'woocommerce' );
}, 12 );

add_action( 'wp_enqueue_scripts', function() {
    if ( ! class_exists( 'WooCommerce' ) ) return;
    $theme_uri = get_template_directory_uri();
    wp_enqueue_style( 'bk-marketplace', $theme_uri . '/assets/css/marketplace.css', array( 'bk-main' ), '1.0.3' );
    wp_enqueue_script( 'bk-marketplace', $theme_uri . '/assets/js/marketplace.js', array(), '1.0.2', true );
} );

function bk_marketplace_product_card( $product ) {
    if ( ! $product || ! is_a( $product, 'WC_Product' ) ) return '';
    $id = $product->get_id();
    $title = $product->get_name();
    $url = get_permalink( $id );
    $image_id = $product->get_image_id();
    $image = $image_id ? wp_get_attachment_image_url( $image_id, 'large' ) : wc_placeholder_img_src( 'woocommerce_single' );
    $categories = wc_get_product_category_list( $id, '، ' );
    $rating = (float) $product->get_average_rating();
    $count = (int) $product->get_rating_count();
    $description = wp_trim_words( wp_strip_all_tags( $product->get_short_description() ?: $product->get_description() ), 13, '…' );
    $regular = (float) $product->get_regular_price();
    $sale = (float) $product->get_sale_price();
    $price_html = $product->get_price_html();
    $discount = ( $regular > 0 && $sale > 0 && $sale < $regular ) ? round( ( ( $regular - $sale ) / $regular ) * 100 ) : 0;
    ob_start();
    ?>
    <article class="bk-market-card">
        <div class="bk-market-card-image">
            <a class="bk-market-card-image-link" href="<?php echo esc_url( $url ); ?>" aria-label="مشاهده <?php echo esc_attr( $title ); ?>">
                <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="lazy">
            </a>
            <?php if ( $discount ) : ?><span class="bk-market-discount"><?php echo esc_html( bk_to_persian_digits( $discount ) ); ?>٪</span><?php endif; ?>
            <?php if ( $categories ) : ?><span class="bk-market-category-badge"><?php echo wp_kses_post( $categories ); ?></span><?php endif; ?>
            <button type="button" class="bk-market-wishlist" data-product-id="<?php echo esc_attr( $id ); ?>" aria-label="افزودن <?php echo esc_attr( $title ); ?> به علاقه‌مندی‌ها" aria-pressed="false">♡</button>
        </div>
        <div class="bk-market-card-body">
            <h3><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $title ); ?></a></h3>
            <?php if ( $description ) : ?><p class="bk-market-excerpt"><?php echo esc_html( $description ); ?></p><?php endif; ?>
            <div class="bk-market-meta">
                <?php if ( $count || $rating ) : ?><span class="bk-market-rating"><b>★</b> <?php echo esc_html( number_format_i18n( $rating, 1 ) ); ?> <small>(<?php echo esc_html( bk_to_persian_digits( $count ) ); ?>)</small></span><?php endif; ?>
                <div class="bk-market-price"><?php echo wp_kses_post( $price_html ); ?></div>
            </div>
            <div class="bk-market-card-actions">
                <a class="bk-market-cart" href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" data-quantity="1" data-product_id="<?php echo esc_attr( $id ); ?>" data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>"><?php echo esc_html( $product->is_type( 'simple' ) && $product->is_purchasable() ? 'افزودن به سبد خرید' : 'مشاهده محصول' ); ?></a>
                <a class="bk-market-more" href="<?php echo esc_url( $url ); ?>" aria-label="مشاهده <?php echo esc_attr( $title ); ?>">←</a>
            </div>
        </div>
    </article>
    <?php
    return ob_get_clean();
}

function bk_marketplace_home_section() {
    if ( ! class_exists( 'WooCommerce' ) ) return '';
    $count = max( 1, min( 12, (int) bk_marketplace_get( 'home_count', 4 ) ) );
    $category_ids = array_values( array_filter( array_map( 'absint', (array) bk_marketplace_get( 'category_ids', array() ) ) ) );

    $query_args = array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => $count,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'no_found_rows'  => true,
    );

    if ( ! empty( $category_ids ) ) {
        $query_args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => $category_ids,
                'operator' => 'IN',
            ),
        );
    }

    $query = new WP_Query( $query_args );
    if ( ! $query->have_posts() ) return '';

    $kicker = bk_marketplace_get( 'kicker', 'بازارچه' );
    $title = bk_marketplace_get( 'title', 'محصولات دست‌ساز هنرجویان' );
    $description = bk_marketplace_get( 'description', 'محصولاتی که با عشق و هنر دست ساخته شده‌اند.' );
    $button_label = bk_marketplace_get( 'button_label', 'مشاهده کل بازارچه' );

    ob_start();
    ?>
    <section class="bk-marketplace-home bk-section" id="marketplace">
        <div class="bk-container">
            <div class="bk-section-title bk-marketplace-heading">
                <?php if ( $kicker ) : ?><span><?php echo esc_html( $kicker ); ?></span><?php endif; ?>
                <?php if ( $title ) : ?><h2><?php echo esc_html( $title ); ?></h2><?php endif; ?>
                <?php if ( $description ) : ?><p><?php echo esc_html( $description ); ?></p><?php endif; ?>
            </div>
            <div class="bk-market-carousel" data-bk-marketplace>
                <div class="bk-market-track">
                    <?php while ( $query->have_posts() ) : $query->the_post(); $product = wc_get_product( get_the_ID() ); echo bk_marketplace_product_card( $product ); endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
            <div class="bk-market-dots" data-bk-market-dots></div>
            <div class="bk-center"><a class="bk-btn bk-btn-outline" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php echo esc_html( $button_label ); ?> <span>←</span></a></div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
