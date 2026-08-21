<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$pattern_id = isset( $attributes['patternId'] ) ? absint( $attributes['patternId'] ) : 0;
if ( ! $pattern_id ) return;

$pattern = get_post( $pattern_id );
if ( ! $pattern || 'wp_block' !== $pattern->post_type || 'publish' !== $pattern->post_status ) return;

echo do_blocks( $pattern->post_content );
