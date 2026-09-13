<?php
/**
 * Baran Khanomy – Contextual iconography
 * Replaces placeholder/generic glyphs in the course and marketplace UI
 * with a consistent, semantic SVG icon set.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_head', function() {
    ?>
    <style id="bk-contextual-icons">
        .bk-course-feature-strip .bk-feature-icon {
            width: 30px;
            height: 30px;
            margin: 0 0 6px;
            display: grid;
            place-items: center;
            font-size: 0;
            line-height: 1;
            color: #8752a6;
        }
        .bk-course-feature-strip .bk-feature-icon svg,
        .bk-market-benefits .bk-market-icon svg {
            display: block;
            width: 22px;
            height: 22px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.75;
            stroke-linecap: round;
            stroke-linejoin: round;
        }
        .bk-market-benefits .bk-market-icon {
            flex: 0 0 42px;
            color: var(--bk-purple, #7f50b0);
        }
        .bk-market-benefits .bk-market-icon svg {
            width: 21px;
            height: 21px;
        }
        @media (max-width: 760px) {
            .bk-course-feature-strip .bk-feature-icon {
                width: 28px;
                height: 28px;
            }
        }
    </style>
    <?php
}, 126 );

add_action( 'wp_footer', function() {
    if ( is_admin() ) return;
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const icons = {
            clock: '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="8.5"></circle><path d="M12 7v5l3.5 2"></path></svg>',
            level: '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 17.5h16M6 13h12M8 8.5h8"></path><circle cx="5" cy="17.5" r="1"></circle><circle cx="19" cy="17.5" r="1"></circle></svg>',
            access: '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6.5 8.5A5.5 5.5 0 0 1 17 6l1.5 1.5"></path><path d="m16 4 2.5 3.5L22 5"></path><path d="M17.5 15.5A5.5 5.5 0 0 1 7 18l-1.5-1.5"></path><path d="m8 20-2.5-3.5L2 19"></path></svg>',
            support: '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 13v-1a8 8 0 0 1 16 0v1"></path><path d="M4 13h2.5A1.5 1.5 0 0 1 8 14.5v2A1.5 1.5 0 0 1 6.5 18H6a2 2 0 0 1-2-2v-3Z"></path><path d="M20 13h-2.5a1.5 1.5 0 0 0-1.5 1.5v2a1.5 1.5 0 0 0 1.5 1.5h.5a2 2 0 0 0 2-2v-3Z"></path><path d="M15 19.5c-.8.7-1.8 1-3 1h-1"></path></svg>',
            update: '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 11a8 8 0 0 0-13.5-5L5 7.5"></path><path d="M5 4v3.5h3.5"></path><path d="M4 13a8 8 0 0 0 13.5 5l1.5-1.5"></path><path d="M19 20v-3.5h-3.5"></path></svg>',
            handmade: '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8.5 12.5 5 9l2-2 4.5 4.5"></path><path d="m11 11 2-2a2 2 0 0 1 2.8 0l3.2 3.2a2 2 0 0 1 0 2.8l-3.8 3.8a2 2 0 0 1-2.8 0L9 15.4"></path><path d="M5.5 17.5 8 20"></path><path d="M14.5 5.5V3M17.5 7H20M16.7 6.3l1.4-1.4"></path></svg>',
            quality: '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="m12 3 2.2 1.4 2.6.2 1.1 2.3 1.9 1.8-.6 2.5.6 2.5-1.9 1.8-1.1 2.3-2.6.2L12 21l-2.2-1.4-2.6-.2-1.1-2.3-1.9-1.8.6-2.5-.6-2.5 1.9-1.8 1.1-2.3 2.6-.2L12 3Z"></path><path d="m8.5 12 2.2 2.2 4.8-5"></path></svg>',
            return: '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 7H5a2 2 0 0 0-2 2v2"></path><path d="m6 6-3 3 3 3"></path><path d="M3 9h10a7 7 0 0 1 7 7v2"></path><path d="M14 18h6"></path></svg>',
            shipping: '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h11v10H3zM14 9h4l3 3v4h-7z"></path><circle cx="7" cy="18" r="2"></circle><circle cx="18" cy="18" r="2"></circle><path d="M14 12h4"></path></svg>'
        };

        const courseKeys = ['clock', 'level', 'access', 'support', 'update'];
        document.querySelectorAll('.bk-course-feature-strip .bk-feature-icon').forEach(function (el, index) {
            if (courseKeys[index] && icons[courseKeys[index]]) el.innerHTML = icons[courseKeys[index]];
        });

        const productKeys = ['handmade', 'quality', 'return', 'shipping'];
        document.querySelectorAll('.bk-market-benefits .bk-market-icon').forEach(function (el, index) {
            if (productKeys[index] && icons[productKeys[index]]) el.innerHTML = icons[productKeys[index]];
        });
    });
    </script>
    <?php
}, 100 );
