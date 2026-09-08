<?php
/**
 * Baran Khanomy – Unified iconography
 * Presentation-only icon normalization for the theme's existing icon slots.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_head', function() { ?>
<style id="bk-unified-icons">
.bk-benefit-icon,.bk-category-placeholder{display:grid;place-items:center}
.bk-benefit-icon{width:90px;height:90px;flex:0 0 90px}
.bk-benefit-icon img{display:block;width:90px;height:90px;object-fit:contain}
.bk-benefit-icon .bk-svg-icon,.bk-category-placeholder .bk-svg-icon{display:block;width:32px;height:32px}
.bk-category-image{display:grid;place-items:center}
.bk-category-image img{display:block;width:64px;height:64px;object-fit:cover;border-radius:16px}
.bk-category-placeholder{width:64px;height:64px;border-radius:16px}
.bk-header-actions a,.bk-header-actions button,.bk-menu-toggle{display:inline-flex;align-items:center;justify-content:center;min-width:44px;min-height:44px}
.bk-market-wishlist,.bk-market-single-wishlist{display:grid;place-items:center}
.bk-market-wishlist svg,.bk-market-single-wishlist svg{display:block}
@media(max-width:760px){
 .bk-benefit-icon{width:64px;height:64px;flex-basis:64px}
 .bk-benefit-icon img{width:64px;height:64px}
 .bk-benefit-icon .bk-svg-icon{width:28px;height:28px}
 .bk-category-image img,.bk-category-placeholder{width:56px;height:56px}
}
</style>
<?php }, 124 );

add_action( 'wp_footer', function() {
    if ( is_admin() ) return;
    ?>
<script>
document.addEventListener('DOMContentLoaded',function(){
  const svg={
    '□':'<svg class="bk-svg-icon" viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="4" width="16" height="16" rx="3" fill="none" stroke="currentColor" stroke-width="1.7"/><path d="M8 9h8M8 13h5" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>',
    '▷':'<svg class="bk-svg-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="8.5" fill="none" stroke="currentColor" stroke-width="1.7"/><path d="m10 8 6 4-6 4V8Z" fill="currentColor"/></svg>',
    '♧':'<svg class="bk-svg-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 8.5a3 3 0 1 1 5-2.24A3 3 0 1 1 17 8.5c0 2.7-2.4 3.55-5 5.5-2.6-1.95-5-2.8-5-5.5Z" fill="none" stroke="currentColor" stroke-width="1.7"/><path d="M12 14v6M9 20h6" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>',
    '✦':'<svg class="bk-svg-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="m12 3 1.8 5.2L19 10l-5.2 1.8L12 17l-1.8-5.2L5 10l5.2-1.8L12 3Z" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="m18 16 .8 2.2L21 19l-2.2.8L18 22l-.8-2.2L15 19l2.2-.8L18 16Z" fill="none" stroke="currentColor" stroke-width="1.4"/></svg>',
    '▦':'<svg class="bk-svg-icon" viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="4" width="6" height="6" rx="1" fill="none" stroke="currentColor" stroke-width="1.7"/><rect x="14" y="4" width="6" height="6" rx="1" fill="none" stroke="currentColor" stroke-width="1.7"/><rect x="4" y="14" width="6" height="6" rx="1" fill="none" stroke="currentColor" stroke-width="1.7"/><rect x="14" y="14" width="6" height="6" rx="1" fill="none" stroke="currentColor" stroke-width="1.7"/></svg>'
  };
  document.querySelectorAll('.bk-benefit-icon,.bk-category-placeholder').forEach(function(el){
    if(el.querySelector('img')) return;
    const text=(el.textContent||'').trim();
    if(svg[text]) el.innerHTML=svg[text];
  });
});
</script>
<?php }, 98 );