<?php
defined( 'ABSPATH' ) || exit;
global $product;
get_header();
?>
<main class="bk-market-single">
    <div class="bk-container">
        <?php while ( have_posts() ) : the_post(); $product = wc_get_product( get_the_ID() ); if ( ! $product ) continue; $categories = wc_get_product_category_list( $product->get_id(), '، ' ); ?>
            <article id="product-<?php the_ID(); ?>" <?php wc_product_class( 'bk-market-single-card', $product ); ?> >
                <div class="bk-market-single-top">
                    <div class="bk-market-single-gallery">
                        <?php woocommerce_show_product_images(); ?>
                    </div>
                    <div class="bk-market-single-summary">
                        <?php if ( $categories ) : ?><div class="bk-market-category"><?php echo wp_kses_post( $categories ); ?></div><?php endif; ?>
                        <?php do_action( 'woocommerce_before_single_product' ); ?>
                        <?php woocommerce_template_single_title(); ?>
                        <?php woocommerce_template_single_rating(); ?>
                        <?php woocommerce_template_single_price(); ?>
                        <?php woocommerce_template_single_excerpt(); ?>
                        <?php woocommerce_template_single_add_to_cart(); ?>
                        <?php woocommerce_template_single_meta(); ?>
                    </div>
                </div>
                <div class="bk-market-single-description">
                    <h2>درباره این محصول</h2>
                    <?php the_content(); ?>
                </div>
                <?php if ( function_exists( 'woocommerce_output_product_data_tabs' ) ) : ?>
                    <div class="bk-market-single-tabs"><?php woocommerce_output_product_data_tabs(); ?></div>
                <?php endif; ?>
            </article>

            <?php
            $related_ids = wc_get_related_products( $product->get_id(), 4 );
            if ( $related_ids ) :
                $related_query = new WP_Query( array( 'post_type' => 'product', 'post__in' => $related_ids, 'orderby' => 'post__in', 'posts_per_page' => 4, 'post_status' => 'publish', 'no_found_rows' => true ) );
                if ( $related_query->have_posts() ) :
            ?>
                <section class="bk-market-related">
                    <h2>محصولات مشابه</h2>
                    <div class="products">
                        <?php while ( $related_query->have_posts() ) : $related_query->the_post(); echo bk_marketplace_product_card( wc_get_product( get_the_ID() ) ); endwhile; wp_reset_postdata(); ?>
                    </div>
                </section>
            <?php endif; endif; ?>
        <?php endwhile; ?>
    </div>
</main>
<?php get_footer(); ?>
