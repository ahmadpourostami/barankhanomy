<?php
defined( 'ABSPATH' ) || exit;

$course_id = get_the_ID();
echo bk_render_course_card( $course_id );
