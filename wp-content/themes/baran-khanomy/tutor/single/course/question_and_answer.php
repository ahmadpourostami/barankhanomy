<?php
/**
 * Tutor LMS Question and Answer template override.
 *
 * This file intentionally mirrors the active Tutor LMS template supplied for
 * the site, so the Q&A functionality remains compatible with Tutor LMS.
 *
 * @package BaranKhanomy
 */

use TUTOR\Input;

global $post;
if ( null === $post && Input::has( 'course_id' ) ) {
	$post = get_post( Input::post( 'course_id' ) );
}

$disable_qa_for_this_course = get_post_meta( $post->ID, '_tutor_enable_qa', true ) != 'yes';
$enable_q_and_a_on_course   = tutor_utils()->get_option( 'enable_q_and_a_on_course' );

if ( ! $enable_q_and_a_on_course || $disable_qa_for_this_course ) {
	tutor_load_template( 'single.course.q_and_a_turned_off' );
	return;
}

$per_page     = tutor_utils()->get_option( 'pagination_per_page', 10 );
$current_page = max( 1, Input::post( 'current_page', 1, Input::TYPE_INT ) );
$offset       = (int) ( $per_page * $current_page ) - $per_page;
$is_load_more = 'tutor_q_and_a_load_more' === Input::post( 'action' );

$questions = tutor_utils()->get_qa_questions(
	$offset,
	$per_page,
	'',
	null,
	null,
	null,
	null,
	false,
	array( 'course_id' => $post->ID )
);

$total_questions = tutor_utils()->get_qa_questions(
	0,
	0,
	'',
	null,
	null,
	null,
	null,
	true,
	array( 'course_id' => $post->ID )
);

$load_more_btn = '';
$max_page      = (int) ceil( $total_questions / $per_page );
$data          = array(
	'layout' => array(
		'type'           => 'load_more',
		'load_more_text' => __( 'Load More', 'tutor' ),
		'class'          => 'tutor-qna-load-more',
	),
	'ajax'   => array(
		'action'           => 'tutor_q_and_a_load_more',
		'current_page_num' => $current_page,
		'course_id'        => $post->ID,
	),
);

$template = tutor()->path . 'templates/dashboard/elements/load-more.php';
if ( file_exists( $template ) && $max_page > $current_page ) {
	ob_start();
	tutor_load_template_from_custom_path( $template, $data );
	$load_more_btn = apply_filters( 'tutor_q_and_a_load_more_button', ob_get_clean() );
}

if ( $current_page >= $max_page ) {
	echo '<input type="hidden" id="tutor-hide-comment-load-more-btn">';
}

do_action( 'tutor_course/question_and_answer/before' );

if ( $is_load_more ) {
	$loaded_ids = '';
	if ( is_array( $questions ) && count( $questions ) ) {
		$loaded_ids = implode( ',', array_column( $questions, 'comment_ID' ) );
	}

	echo "<input type='hidden' class='tutor-load-more-qna-ids' value='" . esc_attr( $loaded_ids ) . "'>";
	foreach ( $questions as $question ) {
		tutor_load_template_from_custom_path(
			tutor()->path . '/views/qna/qna-single.php',
			array(
				'question_id'      => $question->comment_ID,
				'context'          => 'course-single-qna-single',
				'is_qna_load_more' => true,
			),
			false
		);
	}
	return;
}
?>
<h3 class="tutor-fs-5 tutor-fw-bold tutor-color-black tutor-mb-20">
	<?php esc_html_e( 'Question & Answer', 'tutor' ); ?>
</h3>

<?php
tutor_load_template_from_custom_path(
	tutor()->path . '/views/qna/qna-new.php',
	array(
		'course_id' => get_the_ID(),
		'context'   => 'course-single-qna-single',
	),
	false
);
?>

<div class="tutor-pagination-wrapper-replaceable">
	<div class="tutor-pagination-content-appendable">
		<?php foreach ( $questions as $question ) : ?>
			<?php
			tutor_load_template_from_custom_path(
				tutor()->path . '/views/qna/qna-single.php',
				array(
					'question_id'      => $question->comment_ID,
					'context'          => 'course-single-qna-single',
					'is_qna_load_more' => $is_load_more,
				),
				false
			);
			?>
		<?php endforeach; ?>
	</div>
	<div class="tutor-button-wrapper tutor-mt-12 tutor-mb-24 tutor-d-flex tutor-justify-end">
		<?php echo $load_more_btn; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
</div>

<?php do_action( 'tutor_course/question_and_answer/after' ); ?>
