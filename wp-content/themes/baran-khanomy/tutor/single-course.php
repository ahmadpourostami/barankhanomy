<?php
/**
 * Baran Khanomy Tutor LMS single course override.
 *
 * The visual shell is custom, while course actions/content are delegated to
 * Tutor LMS templates and hooks so WooCommerce enrollment, curriculum,
 * reviews and enrolled-course behaviour remain plugin controlled.
 *
 * @see https://docs.themeum.com/tutor-lms/developers/override-templates/
 */
defined( 'ABSPATH' ) || exit;

use Tutor\Models\EnrollmentModel;

$course_id = get_the_ID();
$course_rating = tutor_utils()->get_course_rating( $course_id );
$is_enrolled = EnrollmentModel::is_enrolled( $course_id, get_current_user_id() );
$is_public = \TUTOR\Course_List::is_public( $course_id );
$student_must_login_to_view_course = tutor_utils()->get_option( 'student_must_login_to_view_course' );
$terms = get_the_terms( $course_id, 'course-category' );
$prices = function_exists( 'bk_tutor_course_price_parts' ) ? bk_tutor_course_price_parts( $course_id ) : array( 'regular' => '', 'sale' => '' );
$discount = function_exists( 'bk_tutor_course_discount' ) ? bk_tutor_course_discount( $course_id ) : '';
$duration = function_exists( 'get_tutor_course_duration_context' ) ? get_tutor_course_duration_context() : '';
$level = function_exists( 'get_tutor_course_level' ) ? get_tutor_course_level( $course_id ) : '';
$enrolled_count = function_exists( 'tutor_utils' ) ? tutor_utils()->count_enrolled_users_by_course() : 0;
$author_id = (int) get_post_field( 'post_author', $course_id );
$author_name = $author_id ? get_the_author_meta( 'display_name', $author_id ) : '';
$author_avatar = $author_id ? get_avatar_url( $author_id, array( 'size' => 96 ) ) : '';
$has_video = apply_filters( 'tutor_course_has_video', tutor_utils()->has_video_in_single(), $course_id );

get_header();

if ( ! is_user_logged_in() && ! $is_public && $student_must_login_to_view_course ) {
    echo '<main class="bk-tutor-page bk-tutor-login-required"><div class="bk-container">';
    tutor_load_template( 'login' );
    echo '</div></main>';
    get_footer();
    return;
}
?>
<main class="bk-tutor-page bk-single-course">
    <section class="bk-course-hero">
        <div class="bk-container">
            <div class="bk-course-breadcrumbs">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">خانه</a><span>‹</span>
                <?php if ( $terms && ! is_wp_error( $terms ) ) : ?><a href="<?php echo esc_url( get_term_link( $terms[0] ) ); ?>"><?php echo esc_html( $terms[0]->name ); ?></a><span>‹</span><?php endif; ?>
                <span><?php the_title(); ?></span>
            </div>
            <div class="bk-course-hero-grid">
                <div class="bk-course-hero-media">
                    <?php if ( $has_video ) : ?>
                        <div class="bk-course-preview-media"><?php tutor_course_video(); ?><span class="bk-course-preview-badge">مشاهده پیش‌نمایش دوره</span></div>
                    <?php elseif ( has_post_thumbnail( $course_id ) ) : ?>
                        <div class="bk-course-preview-media"><?php the_post_thumbnail( 'large', array( 'loading' => 'eager' ) ); ?><span class="bk-course-play" aria-hidden="true">▶</span><span class="bk-course-preview-badge">مشاهده پیش‌نمایش دوره</span></div>
                    <?php else : ?>
                        <div class="bk-course-placeholder"><span>تصویر دوره</span></div>
                    <?php endif; ?>
                    <div class="bk-course-purchase-card">
                        <?php if ( $discount ) : ?><span class="bk-course-sale-badge"><?php echo esc_html( $discount ); ?> تخفیف</span><?php endif; ?>
                        <div class="bk-course-price-large"><?php if ( ! empty( $prices['regular'] ) ) : ?><del><?php echo esc_html( $prices['regular'] ); ?></del><?php endif; ?><strong><?php echo esc_html( $prices['sale'] ); ?></strong></div>
                        <?php tutor_load_template( 'single.course.course-entry-box' ); ?>
                        <p class="bk-course-refund-note">ضمانت بازگشت وجه طبق شرایط دوره</p>
                    </div>
                </div>
                <div class="bk-course-hero-copy">
                    <?php if ( $terms && ! is_wp_error( $terms ) ) : ?><a class="bk-course-badge" href="<?php echo esc_url( get_term_link( $terms[0] ) ); ?>"><?php echo esc_html( $terms[0]->name ); ?></a><?php endif; ?>
                    <h1><?php the_title(); ?></h1>
                    <?php if ( has_excerpt() ) : ?><div class="bk-course-excerpt"><?php echo wp_kses_post( get_the_excerpt() ); ?></div><?php endif; ?>
                    <div class="bk-course-author-row"><?php if ( $author_avatar ) : ?><img src="<?php echo esc_url( $author_avatar ); ?>" alt="<?php echo esc_attr( $author_name ); ?>"><?php endif; ?><div><strong>مدرس: <?php echo esc_html( $author_name ); ?></strong><span>مدرس و طراح کیف</span></div></div>
                    <div class="bk-course-rating-row"><div class="bk-course-rating-stars"><strong><?php echo $course_rating && isset( $course_rating->rating_avg ) ? esc_html( number_format_i18n( (float) $course_rating->rating_avg, 1 ) ) : '۰'; ?></strong><span>★★★★★</span><?php if ( $course_rating && isset( $course_rating->rating_count ) ) : ?><small>(<?php echo esc_html( number_format_i18n( (int) $course_rating->rating_count ) ); ?> نظر)</small><?php endif; ?></div><div><strong><?php echo esc_html( number_format_i18n( (int) $enrolled_count ) ); ?></strong><span>دانشجو</span></div></div>
                    <div class="bk-course-feature-strip">
                        <div><span class="bk-feature-icon">◷</span><strong><?php echo $duration ? esc_html( $duration ) : '—'; ?></strong><small>مدت دوره</small></div>
                        <div><span class="bk-feature-icon">◉</span><strong><?php echo $level ? esc_html( $level ) : 'همه سطوح'; ?></strong><small>سطح دوره</small></div>
                        <div><span class="bk-feature-icon">↻</span><strong>دسترسی</strong><small>همیشگی</small></div>
                        <div><span class="bk-feature-icon">♧</span><strong>پشتیبانی</strong><small>دارد</small></div>
                        <div><span class="bk-feature-icon">▣</span><strong>آپدیت</strong><small>رایگان</small></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bk-course-nav-wrap"><div class="bk-container"><nav class="bk-course-nav" aria-label="ناوبری دوره"><a href="#course-about" class="is-active">درباره دوره</a><a href="#course-curriculum">سرفصل‌ها</a><a href="#course-instructor">مدرس</a><a href="#course-reviews">نظرات دانشجویان</a><a href="#course-faq">پرسش و پاسخ</a></nav></div></section>
    <section class="bk-course-main bk-section">
        <div class="bk-container">
            <?php do_action( 'tutor_course/single/before/wrap' ); ?>
            <div <?php tutor_post_class( 'bk-course-layout tutor-page-wrap' ); ?>>
                <div class="bk-course-content">
                    <section id="course-about" class="bk-course-panel bk-course-about"><div class="bk-panel-heading"><span>درباره دوره</span><h2>درباره این دوره</h2></div><div class="bk-course-content-body"><?php do_action( 'tutor_course/single/before/inner-wrap' ); ?><?php tutor_load_template( 'single.course.course-content' ); ?><?php do_action( 'tutor_course/single/after/inner-wrap' ); ?></div></section>
                    <section id="course-curriculum" class="bk-course-panel bk-course-curriculum"><div class="bk-panel-heading"><span>مسیر یادگیری</span><h2>سرفصل‌های دوره</h2></div><?php tutor_load_template( 'single.course.course-topics' ); ?></section>
                    <section class="bk-course-panel bk-course-benefits"><div class="bk-panel-heading"><span>برای شما چه دارد؟</span><h2>این دوره برای شما مناسب است اگر...</h2></div><?php tutor_load_template( 'single.course.course-benefits' ); ?></section>
                    <section class="bk-course-panel bk-course-material"><div class="bk-panel-heading"><span>آنچه دریافت می‌کنید</span><h2>مزایای دوره</h2></div><?php tutor_load_template( 'single.course.material-includes' ); ?></section>
                    <section id="course-instructor" class="bk-course-panel bk-course-instructor"><div class="bk-panel-heading"><span>مدرس دوره</span><h2>مدرس این دوره</h2></div><?php tutor_course_instructors_html(); ?></section>
                    <section id="course-reviews" class="bk-course-panel bk-course-reviews"><div class="bk-panel-heading"><span>بازخورد هنرجویان</span><h2>نظرات دانشجویان</h2></div><?php tutor_load_template( 'single.course.reviews' ); ?></section>
                    <section id="course-faq" class="bk-course-panel bk-course-qa"><div class="bk-panel-heading"><span>پشتیبانی</span><h2>پرسش و پاسخ</h2></div><?php tutor_load_template( 'single.course.question_and_answer' ); ?></section>
                </div>
                <aside class="bk-course-side-content">
                    <div class="bk-course-side-card"><div class="bk-panel-heading"><span>پیش‌نیازها</span><h3>قبل از شروع بدانید</h3></div><?php tutor_load_template( 'single.course.course-requirements' ); ?></div>
                    <div class="bk-course-side-card"><div class="bk-panel-heading"><span>مخاطبان دوره</span><h3>این دوره مناسب چه کسانی است؟</h3></div><?php tutor_load_template( 'single.course.course-target-audience' ); ?></div>
                    <div class="bk-course-side-card bk-course-share"><div class="bk-panel-heading"><span>اشتراک‌گذاری</span><h3>این دوره را به دوستانتان معرفی کنید</h3></div><div class="bk-share-links"><a href="https://t.me/share/url?url=<?php echo rawurlencode( get_permalink() ); ?>" target="_blank" rel="noopener" aria-label="Telegram">↗</a><a href="https://wa.me/?text=<?php echo rawurlencode( get_the_title() . ' ' . get_permalink() ); ?>" target="_blank" rel="noopener" aria-label="WhatsApp">◔</a><a href="https://twitter.com/intent/tweet?url=<?php echo rawurlencode( get_permalink() ); ?>&text=<?php echo rawurlencode( get_the_title() ); ?>" target="_blank" rel="noopener" aria-label="X">𝕏</a><button type="button" class="bk-copy-course-url" data-url="<?php echo esc_attr( get_permalink() ); ?>" aria-label="کپی لینک">⌁</button></div></div>
                </aside>
            </div>
            <?php do_action( 'tutor_course/single/after/wrap' ); ?>
        </div>
    </section>
    <section class="bk-course-final-cta"><div class="bk-container"><div><strong>برای شروع یادگیری آماده‌اید؟</strong><span>همین حالا دوره را تهیه کنید و مسیر یادگیری خود را شروع کنید.</span></div><a href="#course-about">مشاهده و خرید دوره <span>←</span></a></div></section>
</main>
<script>document.addEventListener('click',function(e){var b=e.target.closest('.bk-copy-course-url');if(!b)return;var u=b.dataset.url;if(navigator.clipboard){navigator.clipboard.writeText(u).then(function(){b.textContent='✓';setTimeout(function(){b.textContent='⌁'},1500);});}});</script>
<?php get_footer(); ?>
