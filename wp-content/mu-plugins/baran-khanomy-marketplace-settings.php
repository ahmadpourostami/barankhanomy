<?php
/**
 * Baran Khanomy – Marketplace settings bridge
 *
 * The marketplace settings page already exists in the core plugin, but its
 * submenu was registered against an old/non-existent parent slug. Register
 * the same page under the current Baran Khanomy settings menu.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'admin_menu', function() {
    if ( ! function_exists( 'bk_marketplace_settings_page' ) ) return;

    add_submenu_page(
        'baran-khanomy-theme-settings',
        'بازارچه',
        'بازارچه',
        'manage_options',
        'bk-marketplace-settings',
        'bk_marketplace_settings_page'
    );
}, 100 );
