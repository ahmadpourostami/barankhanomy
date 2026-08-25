document.addEventListener('DOMContentLoaded',function(){
    const root=document.querySelector('[data-bk-marketplace]');
    if(!root)return;
    const track=root.querySelector('.bk-market-track');
    const cards=track?Array.from(track.querySelectorAll('.bk-market-card')):[];
    const dots=document.querySelector('[data-bk-market-dots]');
    let index=0,timer=null;
    const perView=()=>window.innerWidth<=760?1:(window.innerWidth<=1000?2:4);
    const pages=()=>Math.max(1,Math.ceil(cards.length/perView()));
    const renderDots=()=>{if(!dots)return;dots.innerHTML='';for(let i=0;i<pages();i++){const b=document.createElement('button');b.type='button';b.className=i===index?'is-active':'';b.setAttribute('aria-label','نمایش محصولات '+(i+1));b.addEventListener('click',()=>{index=i;render();restart()});dots.appendChild(b)}};
    const render=()=>{if(!track||!cards.length)return;const count=perView();const gap=parseFloat(getComputedStyle(track).gap)||0;const width=(track.clientWidth-(count-1)*gap)/count;track.style.transform='translateX('+((index*(width+gap)*count))+'px)';renderDots()};
    const restart=()=>{if(timer)clearInterval(timer);if(cards.length>perView())timer=setInterval(()=>{index=(index+1)%pages();render()},5500)};
    window.addEventListener('resize',()=>{index=Math.min(index,pages()-1);render();restart()});
    render();restart();

    const storageKey='bk_marketplace_wishlist';
    const getLiked=()=>{try{return JSON.parse(localStorage.getItem(storageKey)||'[]')}catch(e){return[]}};
    const setLiked=(items)=>{try{localStorage.setItem(storageKey,JSON.stringify(items))}catch(e){}};
    const syncWishlist=()=>{
        const liked=getLiked().map(String);
        document.querySelectorAll('.bk-market-wishlist[data-product-id]').forEach(button=>{
            const id=String(button.getAttribute('data-product-id'));
            const active=liked.indexOf(id)!==-1;
            button.classList.toggle('is-liked',active);
            button.setAttribute('aria-pressed',active?'true':'false');
            button.textContent=active?'♥':'♡';
            button.setAttribute('aria-label',active?'حذف محصول از علاقه‌مندی‌ها':'افزودن محصول به علاقه‌مندی‌ها');
        });
    };
    document.addEventListener('click',function(event){
        const button=event.target.closest('.bk-market-wishlist[data-product-id]');
        if(!button)return;
        event.preventDefault();
        event.stopPropagation();
        const id=String(button.getAttribute('data-product-id'));
        let liked=getLiked().map(String);
        if(liked.indexOf(id)!==-1){liked=liked.filter(item=>item!==id)}else{liked.push(id)}
        setLiked(liked);
        syncWishlist();
    });
    syncWishlist();
});
