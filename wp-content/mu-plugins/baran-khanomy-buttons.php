<?php
/**
 * Baran Khanomy – Unified button system
 *
 * Presentation-only overrides. Keeps existing markup intact while providing
 * one consistent button hierarchy across the theme, marketplace and product pages.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'wp_head', function() {
    ?>
    <style id="bk-unified-buttons">
        :root{
            --bk-btn-radius:12px;
            --bk-btn-height-sm:40px;
            --bk-btn-height-md:44px;
            --bk-btn-height-lg:48px;
            --bk-btn-padding:0 18px;
            --bk-btn-font:14px;
        }

        .bk-btn,
        .bk-course-link,
        .bk-market-cart,
        .bk-market-more,
        .bk-product-buy,
        .single_add_to_cart_button,
        .woocommerce .button,
        .woocommerce a.button,
        .woocommerce button.button,
        .woocommerce input.button{
            min-height:var(--bk-btn-height-md);
            border-radius:var(--bk-btn-radius);
            padding:0 var(--bk-btn-padding);
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:8px;
            font-size:var(--bk-btn-font);
            font-weight:700;
            line-height:1.2;
            text-decoration:none;
            cursor:pointer;
            transition:transform .18s ease,box-shadow .18s ease,background-color .18s ease,border-color .18s ease,color .18s ease;
            box-sizing:border-box;
        }

        .bk-btn:hover,
        .bk-course-link:hover,
        .bk-market-cart:hover,
        .bk-market-more:hover,
        .bk-product-buy:hover,
        .single_add_to_cart_button:hover,
        .woocommerce .button:hover,
        .woocommerce a.button:hover,
        .woocommerce button.button:hover,
        .woocommerce input.button:hover{
            transform:translateY(-1px);
        }

        /* Gold is reserved for purchase/conversion actions. */
        .bk-btn-gold,
        .bk-product-buy,
        .single_add_to_cart_button,
        .woocommerce .single_add_to_cart_button{
            background:var(--bk-gold)!important;
            color:#2b2330!important;
            border:1px solid var(--bk-gold)!important;
            box-shadow:0 7px 18px rgba(215,156,38,.18);
        }

        .bk-btn-gold:hover,
        .bk-product-buy:hover,
        .single_add_to_cart_button:hover,
        .woocommerce .single_add_to_cart_button:hover{
            background:#c88f1d!important;
            border-color:#c88f1d!important;
            color:#2b2330!important;
        }

        /* Secondary action. */
        .bk-btn-outline,
        .bk-market-more,
        .bk-course-link{
            background:#fff!important;
            color:var(--bk-purple)!important;
            border:1px solid #cdb8db!important;
        }

        .bk-btn-outline:hover,
        .bk-market-more:hover,
        .bk-course-link:hover{
            background:#f8f1fb!important;
            border-color:#b89acb!important;
            color:var(--bk-purple-dark)!important;
        }

        /* Neutral WooCommerce actions should not look like purchase CTAs. */
        .woocommerce .button:not(.single_add_to_cart_button),
        .woocommerce a.button:not(.single_add_to_cart_button),
        .woocommerce button.button:not(.single_add_to_cart_button),
        .woocommerce input.button:not(.single_add_to_cart_button){
            background:#fff;
            color:var(--bk-purple);
            border:1px solid #cdb8db;
        }

        .woocommerce .button:not(.single_add_to_cart_button):hover,
        .woocommerce a.button:not(.single_add_to_cart_button):hover,
        .woocommerce button.button:not(.single_add_to_cart_button):hover,
        .woocommerce input.button:not(.single_add_to_cart_button):hover{
            background:#f8f1fb;
            color:var(--bk-purple-dark);
            border-color:#b89acb;
        }

        /* Small utility actions. */
        .bk-btn-sm{min-height:var(--bk-btn-height-sm)!important;font-size:13px!important;padding:0 14px!important}
        .bk-btn-lg{min-height:var(--bk-btn-height-lg)!important;font-size:15px!important;padding:0 22px!important}

        .bk-btn:focus-visible,
        .bk-course-link:focus-visible,
        .bk-market-cart:focus-visible,
        .bk-market-more:focus-visible,
        .bk-product-buy:focus-visible,
        .single_add_to_cart_button:focus-visible,
        .woocommerce .button:focus-visible{
            outline:3px solid rgba(127,80,176,.24);
            outline-offset:2px;
        }

        @media(max-width:760px){
            .bk-btn,
            .bk-course-link,
            .bk-market-cart,
            .bk-market-more,
            .bk-product-buy,
            .single_add_to_cart_button,
            .woocommerce .button,
            .woocommerce a.button,
            .woocommerce button.button,
            .woocommerce input.button{
                min-height:44px;
                font-size:13px;
            }
        }
    </style>
    <?php
}, 122 );
