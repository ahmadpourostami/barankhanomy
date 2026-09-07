<?php
get_header();
while ( have_posts() ) : the_post();
    $student = get_post_meta( get_the_ID(), '_bk_student_work_student', true );
    $custom_url = get_post_meta( get_the_ID(), '_bk_student_work_url', true );
    ?>
    <main class="bk-work-single">
        <div class="bk-container">
            <div class="bk-work-single-card">
                <div class="bk-work-single-media">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'large', array( 'alt' => get_the_title() ) ); ?>
                    <?php else : ?>
                        <div class="bk-work-empty">تصویری برای این نمونه‌کار ثبت نشده است.</div>
                    <?php endif; ?>
                </div>
                <article class="bk-work-single-copy">
                    <span class="bk-section-kicker">نمونه‌کار هنرجو</span>
                    <h1><?php the_title(); ?></h1>
                    <?php if ( $student ) : ?><div class="bk-work-student">هنرجو: <?php echo esc_html( $student ); ?></div><?php endif; ?>
                    <?php if ( get_the_content() ) : ?><div class="bk-work-description"><?php the_content(); ?></div><?php endif; ?>
                    <?php if ( $custom_url ) : ?><p class="bk-work-back"><a class="bk-btn" href="<?php echo esc_url( $custom_url ); ?>" target="_blank" rel="noopener">مشاهده جزئیات</a></p><?php endif; ?>
                    <p class="bk-work-back"><a class="bk-btn bk-btn-outline" href="<?php echo esc_url( get_post_type_archive_link('bk_student_work') ); ?>">بازگشت به نمونه‌کارها</a></p>
                </article>
            </div>
        </div>
    </main>
    <?php
endwhile;
get_footer();
