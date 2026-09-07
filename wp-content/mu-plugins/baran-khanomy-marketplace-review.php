<?php
/**
 * Baran Khanomy – Marketplace section refinement
 * Presentation-only refinements for the marketplace cards and controls.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_head', function() {
    ?>
    <style id="bk-marketplace-review">
        .bk-marketplace-home{padding:72px 0 78px;background:linear-gradient(180deg,#fff 0%,#fcf9fe 100%)}
        .bk-marketplace-heading{max-width:760px;margin:0 auto 30px;text-align:center}
        .bk-marketplace-heading>span{display:inline-block;margin-bottom:7px;color:var(--bk-purple);font-size:13px;font-weight:800}
        .bk-marketplace-heading h2{margin:0;font-size:28px;line-height:1.55}
        .bk-marketplace-heading p{max-width:620px;margin:8px auto 0;color:var(--bk-muted);font-size:14px;line-height:2}

        .bk-market-card{border:1px solid var(--bk-border);border-radius:22px;box-shadow:0 8px 28px rgba(66,39,83,.055)}
        .bk-market-card:hover{transform:translateY(-5px);box-shadow:0 18px 40px rgba(66,39,83,.105)}
        .bk-market-card-image{height:260px;background:#f7f1fa}
        .bk-market-card-image img{transition:transform .35s ease}
        .bk-market-card:hover .bk-market-card-image img{transform:scale(1.035)}
        .bk-market-category-badge{left:14px;bottom:14px;max-width:52%;min-height:32px;padding:5px 12px;font-size:11px}
        .bk-market-wishlist{top:14px;left:14px;width:42px;height:42px;font-size:23px}
        .bk-market-discount{right:14px;bottom:14px;padding:5px 10px;font-size:11px}
        .bk-market-card-body{padding:18px 17px 17px}
        .bk-market-card h3{min-height:51px;margin:0 0 6px;font-size:16px;line-height:1.7}
        .bk-market-excerpt{min-height:49px;margin:0 0 11px;color:var(--bk-muted);font-size:13px;line-height:1.9}
        .bk-market-meta{min-height:34px}
        .bk-market-rating{font-size:12px}
        .bk-market-rating small{font-size:10px}
        .bk-market-price .amount{font-size:15px}
        .bk-market-price del{font-size:10px}
        .bk-market-card-actions{gap:9px;margin-top:14px}
        .bk-market-cart,.bk-market-more{min-height:44px;height:44px;border-radius:12px;font-size:12px}
        .bk-market-more{width:44px}

        .bk-market-controls{display:flex;align-items:center;justify-content:center;gap:12px;margin-top:20px}
        .bk-market-controls button{width:44px;height:44px;min-width:44px;padding:0;border:1px solid var(--bk-border);border-radius:50%;background:#fff;color:var(--bk-purple);display:grid;place-items:center;cursor:pointer;font-size:17px;transition:all .2s ease}
        .bk-market-controls button:hover{background:var(--bk-purple);border-color:var(--bk-purple);color:#fff}
        .bk-market-dots{margin-top:0}
        .bk-market-dots button{min-width:44px;width:44px;height:44px;background:transparent;position:relative}
        .bk-market-dots button:after{content:"";width:7px;height:7px;border-radius:50%;background:#d9c9e2;display:block;margin:auto}
        .bk-market-dots button.is-active:after{width:18px;border-radius:8px;background:var(--bk-purple)}

        .bk-market-empty{max-width:760px;margin:0 auto;padding:48px 24px;border:1px dashed #dbcbe4;border-radius:22px;background:#fff;text-align:center}
        .bk-market-empty strong{font-size:18px}
        .bk-market-empty p{font-size:14px;line-height:2;color:var(--bk-muted)}

        @media(max-width:1000px){.bk-market-card-image{height:240px}}
        @media(max-width:760px){
            .bk-marketplace-home{padding:52px 0 58px}
            .bk-marketplace-heading{margin-bottom:22px}
            .bk-marketplace-heading h2{font-size:24px}
            .bk-marketplace-heading p{font-size:13px}
            .bk-market-card-image{height:230px}
            .bk-market-card h3{min-height:auto;font-size:15px}
            .bk-market-excerpt{min-height:auto;font-size:13px}
            .bk-market-cart{font-size:12px}
            .bk-market-controls{gap:8px}
        }
    </style>
    <?php
}, 121 );
