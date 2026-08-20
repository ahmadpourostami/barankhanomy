<?php
/**
 * Baran Khanomy Tutor LMS single course override.
 * Based on Tutor LMS current single-course template structure and hooks.
 */
defined( 'ABSPATH' ) || exit;

use Tutor\Models\EnrollmentModel;

$course_id = get_the_ID();
$course_rating = tutor_utils()->get_course_rating( $course_id );
$is_enrolled = EnrollmentModel::is_enrolled( $course_id, get_current_user_id() );
$course_nav_item = apply_filters( 'tutor_course/single/nav_items', tutor_utils()->course_nav_items(), $course_id );
$is_public = \TUTOR\Course_List::is_public( $course_id );
$is_mobile = wp_is_mobile();
$enrollment_box_position = tutor_utils()->get_option( 'enrollment_box_position_in_mobile', 'bottom' );
if ( '-1' === $enrollment_box_position ) $enrollment_box_position = 'bottom';
$student_must_login_to_view_course = tutor_utils()->get_option( 'student_must_login_to_view_course' );

get_header();

if ( ! is_user_logged_in() && ! $is_public && $student_must_login_to_view_course ) {
    echo '<main class="bk-tutor-page bk-tutor-login-required"><div class="bk-container">';
    tutor_load_template( 'login' );
    echo '</div></main>';
    get_footer();
    return;
}

$has_video = apply_filters( 'tutor_course_has_video', tutor_utils()->has_video_in_single(), $course_id );
?>
<main class="bk-tutor-page bk-single-course">
    <section class="bk-course-hero">
        <div class="bk-container">
            <div class="bk-course-hero-grid">
                <div class="bk-course-hero-copy">
                    <?php $terms = get_the_terms( $course_id, 'course-category' ); ?>
                    <?php if ( $terms && ! is_wp_error( $terms ) ) : ?>
                        <a class="bk-course-breadcrumb" href="<?php echo esc_url( get_term_link( $terms[0] ) ); ?>"><?php echo esc_html( $terms[0]->name ); ?></a>
                    <?php endif; ?>
                    <h1><?php the_title(); ?></h1>
                    <div class="bk-course-hero-meta">
                        <span>انتشار: <?php echo esc_html( bk_jalali_date( get_post_time( 'U', true, $course_id ) ) ); ?></span>
                        <?php if ( $course_rating && ! empty( $course_rating->rating_avg ) ) : ?><span>★ <?php echo esc_html( $course_rating->rating_avg ); ?></span><?php endif; ?>
                    </div>
                </div>
                <div class="bk-course-hero-media">
                    <?php if ( has_post_thumbnail( $course_id ) ) : the_post_thumbnail( 'large', array( 'loading' => 'eager' ) ); else : ?><div class="bk-course-placeholder"></div><?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="bk-course-main bk-section">
        <div class="bk-container">
            <?php do_action( 'tutor_course/single/before/wrap' ); ?>
            <div <?php tutor_post_class( 'bk-course-layout tutor-page-wrap' ); ?>>
                <main class="bk-course-content">
                    <?php if ( $has_video ) : tutor_course_video(); else : get_tutor_course_thumbnail(); endif; ?>
                    <?php do_action( 'tutor_course/single/before/inner-wrap' ); ?>

                    <div class="bk-course-tabs">
                        <?php if ( is_array( $course_nav_item ) && count( $course_nav_item ) > 1 ) : ?>
                            <nav class="bk-course-tab-nav" aria-label="بخش‌های دوره">
                                <?php foreach ( $course_nav_item as $key => $subpage ) : ?>
                                    <a href="#tutor-course-details-tab-<?php echo esc_attr( $key ); ?>" class="<?php echo 'info' === $key ? 'is-active' : ''; ?>"><?php echo esc_html( $subpage['title'] ?? $key ); ?></a>
                                <?php endforeach; ?>
                            </nav>
                        <?php endif; ?>

                        <div class="bk-course-tab-content">
                            <?php foreach ( $course_nav_item as $key => $subpage ) : ?>
                                <section id="tutor-course-details-tab-<?php echo esc_attr( $key ); ?>" class="bk-course-tab-item <?php echo 'info' === $key ? 'is-active' : ''; ?>">
                                    <?php
                                    do_action( 'tutor_course/single/tab/' . $key . '/before' );
                                    $method = $subpage['method'];
                                    if ( is_string( $method ) ) {
                                        $method();
                                    } else {
                                        $_object = $method[0];
                                        $_method = $method[1];
                                        $_object->$_method( get_the_ID() );
                                    }
                                    do_action( 'tutor_course/single/tab/' . $key . '/after' );
                                    ?>
                                </section>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php do_action( 'tutor_course/single/after/inner-wrap' ); ?>
                </main>

                <aside class="bk-course-sidebar">
                    <?php do_action( 'tutor_course/single/before/sidebar' ); ?>
                    <?php if ( ( $is_mobile && 'bottom' === $enrollment_box_position ) || ! $is_mobile ) : ?>
                        <div class="bk-course-purchase-card">
                            <?php tutor_load_template( 'single.course.course-entry-box' ); ?>
                        </div>
                    <?php endif; ?>
                    <div class="bk-course-sidebar-more">
                        <?php tutor_course_instructors_html(); ?>
                        <?php tutor_course_requirements_html(); ?>
                        <?php tutor_course_tags_html(); ?>
                        <?php tutor_course_target_audience_html(); ?>
                    </div>
                    <?php do_action( 'tutor_course/single/after/sidebar' ); ?>
                </aside>
            </div>
            <?php do_action( 'tutor_course/single/after/wrap' ); ?>
        </div>
    </section>
</main>
<?php get_footer(); ?>
