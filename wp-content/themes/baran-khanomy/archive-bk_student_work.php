<?php
get_header();
$works = new WP_Query(array(
    'post_type'      => 'bk_student_work',
    'post_status'    => 'publish',
    'posts_per_page' => 12,
    'orderby'        => 'menu_order date',
    'order'          => 'DESC',
));
?>
<main class="bk-work-single">
    <div class="bk-container">
        <header class="bk-works-page-head">
            <div>
                <span>نمونه کارها</span>
                <h1>نمونه‌کار هنرجویان من</h1>
            </div>
            <p>بخشی از کارهای انجام‌شده توسط هنرجویان؛ نتیجه‌ی یادگیری، تمرین و خلاقیت.</p>
        </header>
        <?php if ( $works->have_posts() ) : ?>
            <div class="bk-work-grid">
                <?php while ( $works->have_posts() ) : $works->the_post();
                    $student = get_post_meta( get_the_ID(), '_bk_student_work_student', true );
                ?>
                    <a class="bk-work" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'large', array( 'alt' => get_the_title(), 'loading' => 'lazy' ) ); ?>
                        <?php endif; ?>
                        <span class="bk-work-info">
                            <strong><?php the_title(); ?></strong>
                            <?php if ( $student ) : ?><small><?php echo esc_html( $student ); ?></small><?php endif; ?>
                        </span>
                    </a>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
            <?php
            $pagination = paginate_links(array(
                'total'   => $works->max_num_pages,
                'current' => max(1, get_query_var('paged')),
                'type'    => 'list',
            ));
            if ( $pagination ) echo '<nav class="bk-center" aria-label="صفحات نمونه‌کارها">' . $pagination . '</nav>';
            ?>
        <?php else : ?>
            <div class="bk-work-empty">هنوز نمونه‌کاری منتشر نشده است.</div>
        <?php endif; ?>
    </div>
</main>
<?php get_footer(); ?>
