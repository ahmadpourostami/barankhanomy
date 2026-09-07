<?php
/**
 * Baran Khanomy — Testimonials UI
 *
 * Presentation-only overrides for the testimonial section.
 * Keeps testimonial content/admin data untouched.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'wp_head', function () {
    ?>
    <style id="bk-testimonials-ui">
        .bk-testimonials {
            padding: 72px 0 80px;
            background: var(--bk-surface, #fbf9fc);
        }

        .bk-testimonials .bk-section-head {
            margin-bottom: 34px;
            text-align: center;
        }

        .bk-testimonial-carousel {
            position: relative;
            overflow: hidden;
            padding: 4px 2px 12px;
        }

        .bk-testimonial-track {
            display: flex;
            gap: 20px;
            align-items: stretch;
            direction: rtl;
            transition: transform .45s ease;
            will-change: transform;
        }

        .bk-testimonial-track .bk-review {
            flex: 0 0 calc((100% - 40px) / 3);
            min-width: 0;
        }

        .bk-review {
            position: relative;
            display: flex;
            flex-direction: column;
            min-height: 286px;
            padding: 26px;
            background: #fff;
            border: 1px solid var(--bk-border, #eadff1);
            border-radius: 22px;
            box-shadow: 0 12px 34px rgba(65, 37, 81, .07);
            overflow: hidden;
            transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
        }

        .bk-review::before {
            content: "“";
            position: absolute;
            top: 4px;
            left: 18px;
            font-family: Georgia, serif;
            font-size: 88px;
            line-height: 1;
            color: rgba(127, 80, 176, .09);
            pointer-events: none;
        }

        .bk-review:hover {
            transform: translateY(-4px);
            border-color: rgba(127, 80, 176, .24);
            box-shadow: 0 18px 42px rgba(65, 37, 81, .11);
        }

        .bk-review-head {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
            margin-bottom: 20px;
        }

        .bk-avatar {
            flex: 0 0 64px;
            width: 64px;
            height: 64px;
            border: 2px solid #fff;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 5px 15px rgba(65, 37, 81, .14);
        }

        .bk-review-person {
            min-width: 0;
        }

        .bk-review-person strong {
            display: block;
            margin-bottom: 4px;
            color: var(--bk-text, #2b2330);
            font-size: 16px;
            line-height: 1.6;
            font-weight: 700;
        }

        .bk-review-person span {
            display: block;
            color: var(--bk-muted, #766b7c);
            font-size: 13px;
            line-height: 1.7;
        }

        .bk-stars {
            position: relative;
            z-index: 1;
            margin-bottom: 16px;
            color: var(--bk-gold, #d79c26);
            font-size: 15px;
            line-height: 1;
            letter-spacing: 2px;
        }

        .bk-review p {
            position: relative;
            z-index: 1;
            flex: 1;
            margin: 0;
            color: var(--bk-text, #2b2330);
            font-size: 14px;
            line-height: 2.05;
        }

        .bk-testimonial-controls {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 24px;
        }

        .bk-testimonial-controls button,
        .bk-testimonial-dots button {
            min-width: 44px;
            min-height: 44px;
        }

        .bk-testimonial-controls button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--bk-border, #eadff1);
            border-radius: 50%;
            background: #fff;
            color: var(--bk-purple, #7f50b0);
            cursor: pointer;
        }

        .bk-testimonial-dots {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 2px;
        }

        .bk-testimonial-dots button {
            position: relative;
            padding: 0;
            border: 0;
            background: transparent;
            cursor: pointer;
        }

        .bk-testimonial-dots button::after {
            content: "";
            display: block;
            width: 7px;
            height: 7px;
            margin: auto;
            border-radius: 99px;
            background: #d9c9e2;
            transition: width .2s ease, background .2s ease;
        }

        .bk-testimonial-dots button.is-active::after {
            width: 18px;
            background: var(--bk-purple, #7f50b0);
        }

        @media (max-width: 1024px) {
            .bk-testimonial-track .bk-review {
                flex-basis: calc((100% - 20px) / 2);
            }
        }

        @media (max-width: 760px) {
            .bk-testimonials {
                padding: 52px 0 58px;
            }

            .bk-testimonial-carousel {
                padding-inline: 0;
            }

            .bk-testimonial-track {
                gap: 14px;
            }

            .bk-testimonial-track .bk-review {
                flex: 0 0 100%;
            }

            .bk-review {
                min-height: 0;
                padding: 21px;
                border-radius: 18px;
            }

            .bk-review::before {
                font-size: 72px;
                top: 2px;
                left: 12px;
            }

            .bk-review-head {
                gap: 12px;
                margin-bottom: 17px;
            }

            .bk-avatar {
                flex-basis: 56px;
                width: 56px;
                height: 56px;
            }

            .bk-review-person strong {
                font-size: 15px;
            }

            .bk-review-person span,
            .bk-review p {
                font-size: 13px;
            }

            .bk-stars {
                font-size: 14px;
                margin-bottom: 13px;
            }
        }
    </style>
    <?php
}, 120 );
