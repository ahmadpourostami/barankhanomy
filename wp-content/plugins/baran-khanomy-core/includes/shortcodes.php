<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_shortcode( 'baran_auth_button', function( $atts ) {
    $atts = shortcode_atts( array( 'label' => 'ورود / ثبت‌نام' ), $atts, 'baran_auth_button' );
    return '<button class="bk-open-auth" type="button" data-bk-open-auth>' . esc_html( $atts['label'] ) . '</button>';
});
