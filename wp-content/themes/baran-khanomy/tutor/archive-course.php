<?php
/**
 * Baran Khanomy Tutor LMS course archive override.
 * Keeps Tutor LMS filtering, pagination and archive hooks intact.
 */
defined( 'ABSPATH' ) || exit;

use TUTOR\Input;

get_header();

$get = isset( $_GET['course_filter'] ) ? Input::sanitize_array( $_GET ) : array(); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
if ( isset( $get['course_filter'] ) ) {
    $filter = ( new \Tutor\Course_Filter( false ) )->load_listing( $get, true );
    query_posts( $filter );
}
?>
<main class="bk-tutor-page bk-tutor-archive">
    <section class="bk-tutor-hero">
        <div class="bk-container">
            <span class="bk-section-kicker">دوره‌های آموزشی</span>
            <h1><?php echo esc_html( bk_setting( 'courses_archive_title', 'همه دوره‌ها را ببین و مهارتت را شروع کن' ) ); ?></h1>
            <p><?php echo esc_html( bk_setting( 'courses_archive_text', 'دوره مناسب خودت را پیدا کن و قدم بعدی مسیر یادگیری را بردار.' ) ); ?></p>
        </div>
    </section>

    <section class="bk-tutor-archive-content bk-section">
        <div class="bk-container">
            <?php
            tutor_load_template(
                'archive-course-init',
                array_merge(
                    $get,
                    array(
                        'course_filter'    => (bool) tutor_utils()->get_option( 'course_archive_filter', false ),
                        'supported_filters'=> tutor_utils()->get_option( 'supported_course_filters', array() ),
                        'loop_content_only'=> false,
                    )
                )
            );
            ?>
        </div>
    </section>
</main>
<?php get_footer(); ?>
