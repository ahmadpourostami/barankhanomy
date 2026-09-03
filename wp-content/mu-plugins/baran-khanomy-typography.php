<?php
/**
 * Baran Khanomy - Unified Typography System
 *
 * Keeps Estedad as the project font, establishes one type scale, and prevents
 * normal UI text from becoming too small on desktop or mobile.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_head', function() {
    ?>
    <style id="bk-unified-typography">
        :root{
            --bk-font-family:Estedad,Tahoma,sans-serif;
            --bk-font-xs:13px;
            --bk-font-sm:14px;
            --bk-font-md:16px;
            --bk-font-lg:20px;
            --bk-font-xl:30px;
            --bk-font-2xl:38px;
            --bk-font-display:48px;
            --bk-line-body:1.9;
            --bk-line-heading:1.45;
        }

        html,body,button,input,textarea,select{font-family:var(--bk-font-family)!important}
        body{font-size:var(--bk-font-sm);line-height:var(--bk-line-body)}

        /* Global hierarchy */
        h1,h2,h3,h4,h5,h6{font-family:var(--bk-font-family)!important;line-height:var(--bk-line-heading)}
        h1{font-size:var(--bk-font-display)}
        h2{font-size:var(--bk-font-xl)}
        h3{font-size:var(--bk-font-lg)}
        p,li,dd,dt,label,legend,figcaption,small{font-size:var(--bk-font-xs)}

        /* Header */
        .bk-nav{font-size:var(--bk-font-xs)!important}
        .bk-search input,.bk-search input::placeholder{font-size:var(--bk-font-xs)!important}
        .bk-login,.bk-profile-link,.bk-logout-link{font-size:var(--bk-font-xs)!important}

        /* Homepage */
        .bk-hero-image-only .bk-hero-content h1{font-size:clamp(32px,3.6vw,var(--bk-font-display))!important;line-height:1.4!important}
        .bk-hero-start,.bk-btn{font-size:var(--bk-font-xs)!important}
        .bk-section-head span,.bk-section-title span,.bk-section-kicker{font-size:var(--bk-font-xs)!important}
        .bk-section-head h2,.bk-section-title h2{font-size:var(--bk-font-xl)!important;line-height:var(--bk-line-heading)!important}
        .bk-section-head>a{font-size:var(--bk-font-xs)!important}
        .bk-benefit-copy strong{font-size:var(--bk-font-md)!important;line-height:1.6!important}
        .bk-benefit-copy small{font-size:var(--bk-font-xs)!important;line-height:1.8!important}
        .bk-category strong{font-size:var(--bk-font-xs)!important}
        .bk-course-body h3{font-size:var(--bk-font-md)!important;line-height:1.7!important;font-weight:800!important}
        .bk-course-body p{font-size:var(--bk-font-xs)!important;line-height:1.9!important}
        .bk-course-body>strong,.bk-course-price strong{font-size:var(--bk-font-sm)!important}
        .bk-course-price del,.bk-course-date,.bk-course-link{font-size:var(--bk-font-xs)!important}
        .bk-about-copy h2{font-size:var(--bk-font-xl)!important}
        .bk-about-copy p{font-size:var(--bk-font-sm)!important}
        .bk-stats strong{font-size:var(--bk-font-lg)!important}
        .bk-stats small{font-size:var(--bk-font-xs)!important}
        .bk-review-person strong{font-size:var(--bk-font-xs)!important}
        .bk-review-person small,.bk-review p{font-size:var(--bk-font-xs)!important}
        .bk-stars{font-size:var(--bk-font-xs)!important}

        /* Marketplace */
        .bk-marketplace-heading p,.bk-market-archive-head p,.bk-market-archive-count{font-size:var(--bk-font-xs)!important}
        .bk-market-card h3{font-size:var(--bk-font-md)!important;line-height:1.7!important}
        .bk-market-excerpt{font-size:var(--bk-font-xs)!important;line-height:1.9!important}
        .bk-market-rating,.bk-market-rating small,.bk-market-category-badge,.bk-market-discount{font-size:var(--bk-font-xs)!important}
        .bk-market-price .amount{font-size:var(--bk-font-sm)!important}
        .bk-market-price del{font-size:var(--bk-font-xs)!important}
        .bk-market-cart{font-size:var(--bk-font-xs)!important}
        .bk-market-archive-head h1{font-size:var(--bk-font-xl)!important}
        .bk-market-single-summary h1{font-size:var(--bk-font-2xl)!important;line-height:1.5!important}
        .bk-market-single-summary .woocommerce-product-rating{font-size:var(--bk-font-xs)!important}
        .bk-market-single-summary .woocommerce-product-details__short-description{font-size:var(--bk-font-sm)!important;line-height:2!important}
        .bk-market-product-specs>div,.bk-market-single-guarantee small,.bk-market-tabs-nav a,.bk-market-related-head a{font-size:var(--bk-font-xs)!important}
        .bk-market-single-guarantee strong,.bk-market-highlight strong,.bk-market-benefits strong{font-size:var(--bk-font-xs)!important}
        .bk-market-benefits small,.bk-market-highlight small{font-size:var(--bk-font-xs)!important}
        .bk-market-tab-content{font-size:var(--bk-font-sm)!important;line-height:2.15!important}
        .bk-market-related-head h2{font-size:var(--bk-font-lg)!important}
        .bk-market-empty strong{font-size:var(--bk-font-md)!important}

        /* Tutor LMS */
        .bk-course-breadcrumbs{font-size:var(--bk-font-xs)!important}
        .bk-course-hero h1{font-size:var(--bk-font-2xl)!important;line-height:1.45!important}
        .bk-course-excerpt{font-size:var(--bk-font-sm)!important;line-height:2.05!important}
        .bk-course-author-row strong{font-size:var(--bk-font-xs)!important}
        .bk-course-author-row span{font-size:var(--bk-font-xs)!important}
        .bk-course-rating-stars strong{font-size:var(--bk-font-lg)!important}
        .bk-course-rating-stars span{font-size:var(--bk-font-sm)!important}
        .bk-course-rating-stars small,.bk-course-rating-row>div:last-child span{font-size:var(--bk-font-xs)!important}
        .bk-course-rating-row>div:last-child strong{font-size:var(--bk-font-md)!important}
        .bk-course-feature-strip strong,.bk-course-feature-strip small{font-size:var(--bk-font-xs)!important}
        .bk-course-sale-badge,.bk-course-refund-note{font-size:var(--bk-font-xs)!important}
        .bk-course-price-large del{font-size:var(--bk-font-xs)!important}
        .bk-course-price-large strong{font-size:var(--bk-font-xl)!important}
        .bk-course-purchase-card .tutor-btn,.bk-course-purchase-card button,.bk-course-purchase-card .tutor-btn-primary{font-size:var(--bk-font-xs)!important}
        .bk-course-nav a{font-size:var(--bk-font-xs)!important}
        .bk-panel-heading span{font-size:var(--bk-font-xs)!important}
        .bk-panel-heading h2{font-size:var(--bk-font-lg)!important}
        .bk-panel-heading h3{font-size:var(--bk-font-md)!important}
        .bk-course-content-body,.bk-course-panel .tutor-course-details-tab,.bk-course-panel .tutor-course-content{font-size:var(--bk-font-xs)!important;line-height:2.1!important}
        .bk-course-panel .tutor-course-details-title,.bk-course-panel .tutor-course-content-title{font-size:var(--bk-font-lg)!important}
        .bk-course-panel .tutor-course-topic-title{font-size:var(--bk-font-sm)!important}
        .bk-course-benefits li,.bk-course-material li,.bk-course-side-card li{font-size:var(--bk-font-xs)!important}
        .bk-course-final-cta strong{font-size:var(--bk-font-lg)!important}
        .bk-course-final-cta span{font-size:var(--bk-font-xs)!important}
        .bk-course-final-cta a{font-size:var(--bk-font-xs)!important}

        /* Footer */
        .bk-footer-cta h2{font-size:var(--bk-font-lg)!important}
        .bk-footer-cta p,.bk-footer-grid a,.bk-footer-grid p,.bk-footer-grid .widget{font-size:var(--bk-font-xs)!important}
        .bk-footer-grid h3,.bk-footer-grid .widget-title{font-size:var(--bk-font-sm)!important}
        .bk-copyright,.bk-designer-signature{font-size:var(--bk-font-xs)!important}

        @media(max-width:760px){
            :root{
                --bk-font-xs:13px;
                --bk-font-sm:14px;
                --bk-font-md:15px;
                --bk-font-lg:18px;
                --bk-font-xl:25px;
                --bk-font-2xl:30px;
                --bk-font-display:34px;
            }
            body{font-size:14px}
            .bk-nav a{font-size:var(--bk-font-xs)!important}
            .bk-search input,.bk-search input::placeholder{font-size:13px!important}
            .bk-login,.bk-profile-link,.bk-logout-link{font-size:13px!important}
            .bk-hero-image-only .bk-hero-content h1{font-size:clamp(27px,8vw,34px)!important;line-height:1.45!important}
            .bk-hero-start,.bk-btn{font-size:13px!important}
            .bk-section-head h2,.bk-section-title h2{font-size:var(--bk-font-xl)!important}
            .bk-course-body h3{font-size:15px!important}
            .bk-course-body p{font-size:13px!important}
            .bk-about-copy h2{font-size:25px!important}
            .bk-about-copy p{font-size:14px!important}
            .bk-market-card h3{font-size:15px!important}
            .bk-market-excerpt{font-size:13px!important}
            .bk-market-single-summary h1{font-size:25px!important}
            .bk-market-single-summary .woocommerce-product-details__short-description{font-size:14px!important}
            .bk-course-hero h1{font-size:30px!important}
            .bk-course-excerpt{font-size:14px!important}
            .bk-course-content-body,.bk-course-panel .tutor-course-details-tab,.bk-course-panel .tutor-course-content{font-size:13px!important}
            .bk-footer-cta p,.bk-footer-grid a,.bk-footer-grid p,.bk-footer-grid .widget{font-size:13px!important}
        }
    </style>
    <?php
}, 110 );
