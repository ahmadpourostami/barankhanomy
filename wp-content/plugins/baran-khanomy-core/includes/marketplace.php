<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function bk_marketplace_defaults() {
    return array( 'home_count' => 4 );
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
            return array( 'home_count' => max( 1, min( 12, absint( $input['home_count'] ?? 4 ) ) ) );
        },
    ) );
} );

function bk_marketplace_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) return;
    ?>
    <div class="wrap" dir="rtl">
        <h1>تنظیمات بازارچه</h1>
        <p>محصولات بازارچه از ووکامرس مدیریت می‌شوند. این بخش فقط تعداد محصولاتی را که در صفحه اصلی نمایش داده می‌شود کنترل می‌کند.</p>
        <form method="post" action="options.php">
            <?php settings_fields( 'bk_marketplace_settings_group' ); ?>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><label for="bk-marketplace-home-count">تعداد محصولات بازارچه در صفحه اصلی</label></th>
                    <td>
                        <input id="bk-marketplace-home-count" class="small-text" type="number" min="1" max="12" name="bk_marketplace_settings[home_count]" value="<?php echo esc_attr( bk_marketplace_get( 'home_count', 4 ) ); ?>">
                        <span>محصول</span>
                        <p class="description">بین ۱ تا ۱۲ محصول انتخاب کنید. بقیه محصولات در صفحه کامل بازارچه نمایش داده می‌شوند.</p>
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
    wp_enqueue_style( 'bk-marketplace', $theme_uri . '/assets/css/marketplace.css', array( 'bk-main' ), '1.0.1' );
    wp_enqueue_script( 'bk-marketplace', $theme_uri . '/assets/js/marketplace.js', array(), '1.0.0', true );
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
        <a class="bk-market-card-image" href="<?php echo esc_url( $url ); ?>">
            <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="lazy">
            <?php if ( $discount ) : ?><span class="bk-market-discount"><?php echo esc_html( bk_to_persian_digits( $discount ) ); ?>٪</span><?php endif; ?>
            <?php if ( $categories ) : ?><span class="bk-market-category-badge"><?php echo wp_kses_post( $categories ); ?></span><?php endif; ?>
            <span class="bk-market-wishlist" aria-hidden="true">♡</span>
        </a>
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
    $query = new WP_Query( array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => $count,
        'orderby' => 'date',
        'order' => 'DESC',
        'no_found_rows' => true,
    ) );
    if ( ! $query->have_posts() ) return '';
    ob_start();
    ?>
    <section class="bk-marketplace-home bk-section" id="marketplace">
        <div class="bk-container">
            <div class="bk-section-title bk-marketplace-heading">
                <span>بازارچه</span>
                <h2>محصولات دست‌ساز هنرجویان</h2>
                <p>محصولاتی که با عشق و هنر دست ساخته شده‌اند.</p>
            </div>
            <div class="bk-market-carousel" data-bk-marketplace>
                <div class="bk-market-track">
                    <?php while ( $query->have_posts() ) : $query->the_post(); $product = wc_get_product( get_the_ID() ); echo bk_marketplace_product_card( $product ); endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
            <div class="bk-market-dots" data-bk-market-dots></div>
            <div class="bk-center"><a class="bk-btn bk-btn-outline" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">مشاهده کل بازارچه <span>←</span></a></div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
