<?php
/**
 * Baran Khanomy – responsive rows and sliders
 * Keeps the existing markup and replaces the testimonial slider behavior with
 * a direction-safe, touch-friendly implementation.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_head', function(){ ?>
<style id="bk-responsive-sliders">
.bk-testimonial-carousel{position:relative;overflow:hidden}
.bk-testimonial-track{display:flex!important;flex-wrap:nowrap!important;will-change:transform;transition:transform .35s ease}
.bk-review{flex:0 0 calc((100% - 40px)/3);min-width:0}
.bk-testimonial-dots{display:flex;align-items:center;justify-content:center;gap:8px;margin-top:18px}
.bk-testimonial-dots[hidden]{display:none!important}
.bk-testimonial-dots button{width:9px;height:9px;padding:0;border:0;border-radius:50%;background:#d9cbe2;cursor:pointer;transition:transform .2s ease,background-color .2s ease}
.bk-testimonial-dots button.is-active{background:var(--bk-purple,#7f50b0);transform:scale(1.25)}
@media(max-width:1000px){.bk-review{flex-basis:calc((100% - 20px)/2)}}
@media(max-width:760px){.bk-review{flex-basis:100%}.bk-testimonial-track{gap:14px!important}.bk-testimonial-dots{margin-top:14px}}

/* Related-product rows become a clean horizontal scroller on small screens. */
@media(max-width:760px){
 .bk-market-related-track{display:flex!important;overflow-x:auto;scroll-snap-type:x mandatory;scrollbar-width:none;padding-bottom:5px}
 .bk-market-related-track::-webkit-scrollbar{display:none}
 .bk-market-related-track>*{flex:0 0 82%;scroll-snap-align:start}
}
</style>
<?php }, 125 );

add_action( 'wp_footer', function(){ ?>
<script>
document.addEventListener('DOMContentLoaded',function(){
 const carousel=document.querySelector('[data-bk-testimonials]');
 if(!carousel)return;
 const oldTrack=carousel.querySelector('.bk-testimonial-track');
 const dots=carousel.querySelector('[data-bk-testimonial-dots]');
 if(!oldTrack)return;
 const track=oldTrack.cloneNode(true);
 oldTrack.replaceWith(track);
 const cards=Array.from(track.querySelectorAll('.bk-review'));
 if(!cards.length)return;
 let index=0,timer=null,startX=0;
 const perView=()=>window.innerWidth<=760?1:(window.innerWidth<=1000?2:3);
 const pages=()=>Math.max(1,Math.ceil(cards.length/perView()));
 const render=()=>{
   const count=perView(),gap=parseFloat(getComputedStyle(track).gap)||0;
   const width=track.clientWidth;
   if(!width)return;
   const cardWidth=(width-(count-1)*gap)/count;
   index=Math.min(index,pages()-1);
   track.style.transform='translateX('+(-index*(cardWidth+gap)*count)+'px)';
   if(!dots)return;
   dots.innerHTML='';
   dots.hidden=pages()<=1;
   for(let i=0;i<pages();i++){
     const b=document.createElement('button');b.type='button';b.className=i===index?'is-active':'';b.setAttribute('aria-label','نمایش صفحه '+(i+1));
     b.addEventListener('click',function(){index=i;render();restart()});dots.appendChild(b);
   }
 };
 const restart=()=>{if(timer)clearInterval(timer);if(pages()>1)timer=setInterval(()=>{index=(index+1)%pages();render()},6000)};
 track.addEventListener('touchstart',e=>{startX=e.touches[0].clientX},{passive:true});
 track.addEventListener('touchend',e=>{const dx=e.changedTouches[0].clientX-startX;if(Math.abs(dx)>45&&pages()>1){index=(index+(dx<0?1:-1)+pages())%pages();render();restart()}},{passive:true});
 window.addEventListener('resize',()=>{render();restart()});
 render();restart();
});
</script>
<?php }, 100 );
