<?php
/**
 * Baran Khanomy – Mobile touch targets
 *
 * Scoped accessibility/usability refinements for touch devices.
 * Does not redefine the global button system.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'wp_head', function () {
    ?>
    <style id="bk-mobile-touch-targets">
        /* Keep interactive controls comfortable on touch screens without
         * changing the visual hierarchy of existing buttons. */
        @media (max-width: 760px) {
            .bk-mobile-menu,
            .bk-search-toggle,
            .bk-header-action,
            .bk-account-toggle,
            .bk-cart-toggle,
            .bk-wishlist-toggle,
            .bk-market-wishlist,
            .bk-market-single-wishlist,
            .bk-market-thumb,
            .bk-carousel-prev,
            .bk-carousel-next,
            .bk-slider-prev,
            .bk-slider-next,
            .bk-testimonial-prev,
            .bk-testimonial-next,
            .bk-review-prev,
            .bk-review-next {
                min-width: 44px;
                min-height: 44px;
            }

            .bk-nav a,
            .bk-mobile-nav a,
            .bk-footer a,
            .bk-market-tabs-nav a {
                min-height: 44px;
                display: inline-flex;
                align-items: center;
            }

            .bk-market-tabs-nav a {
                padding-top: 12px;
                padding-bottom: 12px;
            }

            /* Product quantity controls remain compact visually but retain
             * a usable input height. */
            .quantity input.qty,
            .bk-market-single-summary .quantity input {
                min-height: 44px;
            }

            input[type="checkbox"],
            input[type="radio"] {
                width: 20px;
                height: 20px;
                min-width: 20px;
                min-height: 20px;
            }

            /* Prevent accidental horizontal overflow caused by controls. */
            .bk-container,
            .bk-market-single .bk-container {
                max-width: 100%;
                box-sizing: border-box;
            }
        }

        /* Keyboard users still get a clear focus indication. */
        :where(a, button, input, select, textarea):focus-visible {
            outline: 2px solid rgba(127, 80, 176, .45);
            outline-offset: 2px;
        }
    </style>
    <?php
}, 124 );
