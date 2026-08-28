<?php
defined( 'ABSPATH' ) || exit;
global $product;
get_header();
?>
<main class="bk-market-single">
<div class="bk-container">
<?php while ( have_posts() ) : the_post(); $product = wc_get_product( get_the_ID() ); if ( ! $product ) continue; $categories = wc_get_product_category_list( $product->get_id(), '، ' ); $gallery_ids = $product->get_gallery_image_ids(); $regular = (float) $product->get_regular_price(); $sale = (float) $product->get_sale_price(); $discount = ( $regular > 0 && $sale > 0 && $sale < $regular ) ? round( ( ( $regular - $sale ) / $regular ) * 100 ) . '%' : ''; ?>
<div class="bk-market-breadcrumb"><?php woocommerce_breadcrumb( array( 'delimiter' => '<span>›</span>' ) ); ?></div>
<article id="product-<?php the_ID(); ?>" <?php wc_product_class( 'bk-market-single-card', $product ); ?>>
<div class="bk-market-single-top">
<div class="bk-market-single-gallery">
<div class="bk-market-main-image">
<button type="button" class="bk-market-single-wishlist" aria-label="افزودن به علاقه‌مندی" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>"><svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78Z"/></svg></button>
<?php if ( $discount ) : ?><span class="bk-market-single-discount"><?php echo esc_html( $discount ); ?> تخفیف</span><?php endif; ?>
<?php echo wp_get_attachment_image( $product->get_image_id(), 'large', false, array( 'class' => 'bk-market-main-img', 'alt' => esc_attr( $product->get_name() ) ) ); ?>
</div>
<?php if ( $gallery_ids ) : ?><div class="bk-market-thumbs"><?php foreach ( array_slice( $gallery_ids, 0, 5 ) as $image_id ) : ?><button type="button" class="bk-market-thumb"><?php echo wp_get_attachment_image( $image_id, 'thumbnail' ); ?></button><?php endforeach; ?></div><?php endif; ?>
</div>
<div class="bk-market-single-summary">
<?php if ( $categories ) : ?><div class="bk-market-single-category"><?php echo wp_kses_post( $categories ); ?></div><?php endif; ?>
<?php woocommerce_template_single_title(); ?>
<?php woocommerce_template_single_rating(); ?>
<div class="bk-market-single-price"><?php woocommerce_template_single_price(); ?></div>
<?php woocommerce_template_single_excerpt(); ?>
<div class="bk-market-product-specs">
<div><span>دسته‌بندی</span><strong><?php echo wp_kses_post( $categories ?: '—' ); ?></strong></div>
<div><span>وضعیت</span><strong><?php echo $product->is_in_stock() ? 'موجود در بازارچه' : 'ناموجود'; ?></strong></div>
<div><span>شناسه محصول</span><strong>#<?php echo esc_html( $product->get_sku() ?: $product->get_id() ); ?></strong></div>
</div>
<?php woocommerce_template_single_add_to_cart(); ?>
<div class="bk-market-single-guarantee"><span class="bk-market-icon bk-market-icon-heart" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78Z"/></svg></span><div><strong>خریدی مطمئن</strong><small>محصول دست‌ساز با عشق آماده شده است</small></div></div>
</div>
</div>
<div class="bk-market-benefits">
<div><span class="bk-market-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M20 7.5 12 3 4 7.5v9L12 21l8-4.5v-9ZM12 3v18M4 7.5l8 4.5 8-4.5"/></svg></span><div><strong>محصول دست‌ساز</strong><small>ساخته شده با عشق</small></div></div>
<div><span class="bk-market-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="m12 3 2.35 4.76 5.25.76-3.8 3.7.9 5.23L12 15l-4.7 2.45.9-5.23-3.8-3.7 5.25-.76L12 3Z"/></svg></span><div><strong>کیفیت تضمین‌شده</strong><small>انتخاب با خیال راحت</small></div></div>
<div><span class="bk-market-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M9 7H5a2 2 0 0 0-2 2v10h10v-4M7 13 3 9l4-4M3 9h11a7 7 0 0 1 7 7v2"/></svg></span><div><strong>ضمانت بازگشت</strong><small>طبق شرایط فروشگاه</small></div></div>
<div><span class="bk-market-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M3 6h11v10H3zM14 9h4l3 3v4h-7zM7 19a2 2 0 1 0 0-4 2 2 0 0 0 0 4ZM18 19a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/></svg></span><div><strong>ارسال سریع</strong><small>ارسال به سراسر کشور</small></div></div>
</div>
<div class="bk-market-single-content">
<div class="bk-market-tabs-nav"><a class="is-active" href="#description">توضیحات محصول</a><a href="#attributes">مشخصات محصول</a><a href="#reviews">نظرات (<?php echo esc_html( $product->get_review_count() ); ?>)</a><a href="#faq">سوالات متداول</a></div>
<div id="description" class="bk-market-tab-content"><div class="bk-market-description-copy"><?php the_content(); ?></div><div class="bk-market-highlight">
<div><span class="bk-market-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="m12 3 2.35 4.76 5.25.76-3.8 3.7.9 5.23L12 15l-4.7 2.45.9-5.23-3.8-3.7 5.25-.76L12 3Z"/></svg></span><strong>الهام از طبیعت</strong><small>طراحی شده با توجه به زیبایی طبیعت</small></div>
<div><span class="bk-market-icon bk-market-icon-heart" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78Z"/></svg></span><strong>ساخته شده با عشق</strong><small>هر محصول با دقت و ظرافت آماده شده است</small></div>
<div><span class="bk-market-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M12 3 4.5 7.5v9L12 21l7.5-4.5v-9L12 3Zm0 0v18M4.5 7.5 12 12l7.5-4.5"/></svg></span><strong>منحصربه‌فرد</strong><small>هیچ دو محصولی کاملاً مشابه نیستند</small></div>
</div></div>
<div id="attributes" class="bk-market-tab-content"><?php do_action( 'woocommerce_product_additional_information', $product ); ?></div>
<div id="reviews" class="bk-market-tab-content"><?php comments_template(); ?></div>
<div id="faq" class="bk-market-tab-content"><p>برای اطلاعات بیشتر درباره محصول و شرایط ارسال، می‌توانید از بخش تماس با ما با پشتیبانی در ارتباط باشید.</p></div>
</div>
</article>
<?php $related_ids = wc_get_related_products( $product->get_id(), 5 ); if ( $related_ids ) : $related_query = new WP_Query( array( 'post_type' => 'product', 'post__in' => $related_ids, 'orderby' => 'post__in', 'posts_per_page' => 5, 'post_status' => 'publish', 'no_found_rows' => true ) ); if ( $related_query->have_posts() ) : ?>
<section class="bk-market-related bk-market-related-carousel"><div class="bk-market-related-head"><h2>محصولات مشابه</h2><a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">مشاهده همه ←</a></div><div class="bk-market-related-track"><?php while ( $related_query->have_posts() ) : $related_query->the_post(); echo bk_marketplace_product_card( wc_get_product( get_the_ID() ) ); endwhile; wp_reset_postdata(); ?></div><div class="bk-market-related-dots"><button class="is-active"></button><button></button><button></button></div></section>
<?php endif; endif; ?>
<?php endwhile; ?>
</div>
</main>
<?php get_footer(); ?>