<?php
defined( 'ABSPATH' ) || exit;
get_header();
?>
<main class="bk-marketplace-archive">
    <div class="bk-container">
        <header class="bk-market-archive-head">
            <div>
                <span class="bk-section-kicker">بازارچه</span>
                <h1><?php echo esc_html( woocommerce_page_title( false ) ?: 'بازارچه' ); ?></h1>
                <p>محصولات دست‌ساز و خلاقانه برای دوست‌داران هنر و مهارت.</p>
            </div>
            <div class="bk-market-archive-count">
                <?php global $wp_query; echo esc_html( bk_to_persian_digits( (int) $wp_query->found_posts ) ); ?> محصول
            </div>
        </header>

        <?php if ( woocommerce_product_loop() ) : ?>
            <div class="bk-market-grid">
                <?php while ( have_posts() ) : the_post(); echo bk_marketplace_product_card( wc_get_product( get_the_ID() ) ); endwhile; ?>
            </div>
            <?php if ( function_exists( 'woocommerce_pagination' ) ) : ?>
                <nav class="bk-market-pagination" aria-label="صفحه‌بندی بازارچه">
                    <?php woocommerce_pagination(); ?>
                </nav>
            <?php endif; ?>
        <?php else : ?>
            <div class="bk-market-empty">
                <strong>هنوز محصولی در بازارچه قرار نگرفته است.</strong>
                <span>اولین محصول را از بخش محصولات ووکامرس اضافه کنید.</span>
            </div>
        <?php endif; ?>
    </div>
</main>
<?php get_footer(); ?>
