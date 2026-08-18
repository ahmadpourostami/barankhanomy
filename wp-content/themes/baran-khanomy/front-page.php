<?php get_header(); ?>
<main>
<section class="bk-hero">
  <div class="bk-container bk-hero-grid">
    <div class="bk-hero-copy">
      <span class="bk-eyebrow">♡ <?php echo esc_html( bk_setting( 'hero_badge', 'فرصتِ خوب برای شروع' ) ); ?></span>
      <h1><?php echo wp_kses_post( bk_setting( 'hero_title', 'مهارت یاد بگیر،<br><strong>از هنر دست درآمد بساز</strong>' ) ); ?></h1>
      <p><?php echo esc_html( bk_setting( 'hero_text', 'آموزش‌های کاربردی و پروژه‌محور از مبتدی تا پیشرفته، همراه با پشتیبانی و راهنمایی برای ساخت محصولات حرفه‌ای.' ) ); ?></p>
      <div class="bk-hero-actions"><a class="bk-btn bk-btn-gold" href="#courses"><?php echo esc_html( bk_setting( 'hero_primary', 'شروع یادگیری' ) ); ?> <span>←</span></a><a class="bk-btn bk-btn-outline" href="#courses"><?php echo esc_html( bk_setting( 'hero_secondary', 'مشاهده دوره‌ها' ) ); ?></a></div>
    </div>
    <div class="bk-hero-media"><img src="<?php echo esc_url( bk_setting( 'hero_image' ) ); ?>" alt="آموزش و مهارت باران خانومی"><div class="bk-hero-glow"></div></div>
  </div>
</section>

<section class="bk-benefits"><div class="bk-container bk-benefits-grid">
  <div><span class="bk-benefit-icon">□</span><strong>دسترسی دائمی</strong><small>به تمام دوره‌ها</small></div>
  <div><span class="bk-benefit-icon">▷</span><strong>آموزش‌های کاربردی</strong><small>پروژه‌محور و درآمدزا</small></div>
  <div><span class="bk-benefit-icon">♧</span><strong>پشتیبانی و همراهی</strong><small>در تمام مسیر یادگیری</small></div>
</div></section>

<section class="bk-section" id="categories"><div class="bk-container">
  <div class="bk-section-head"><div><span>دسته‌بندی دوره‌ها</span><h2>مهارتت رو انتخاب کن</h2></div><a href="#courses">مشاهده همه ←</a></div>
  <div class="bk-category-grid">
    <?php $categories = array('پکیج‌های آموزشی','دوره‌های پیشرفته','دوتی‌سات','اکسسوری','کیف‌دوزی','تکنیک‌ها و ترفندها','همه دوره‌ها'); foreach($categories as $cat): ?>
      <a href="#courses" class="bk-category"><span><?php echo bk_icon('gift'); ?></span><strong><?php echo esc_html($cat); ?></strong></a>
    <?php endforeach; ?>
  </div>
</div></section>

<section class="bk-section bk-courses" id="courses"><div class="bk-container">
  <div class="bk-section-title"><span>پیشنهادهای منتخب</span><h2>دوره‌های منتخب</h2></div>
  <div class="bk-course-grid">
    <?php
    $courses = array(
      array('آموزش دوخت کیف دوشی','۲۸۰,۰۰۰ تومان','https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=700&q=80','۳۵٪'),
      array('آموزش دوخت کیف دستی','۳۶۰,۰۰۰ تومان','https://images.unsplash.com/photo-1594223274512-ad4803739b7c?auto=format&fit=crop&w=700&q=80','۲۰٪'),
      array('دوخت کیف دوشی زنانه','۲۴۸,۰۰۰ تومان','https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=700&q=80','۳۰٪'),
      array('پکیج آموزش اکسسوری','۴۴۰,۰۰۰ تومان','https://images.unsplash.com/photo-1594223274512-ad4803739b7c?auto=format&fit=crop&w=700&q=80','۲۵٪'),
    ); foreach($courses as $course): ?>
      <article class="bk-course-card"><div class="bk-course-image"><img src="<?php echo esc_url($course[2]); ?>" alt="<?php echo esc_attr($course[0]); ?>"><span class="bk-discount"><?php echo esc_html($course[3]); ?></span></div><div class="bk-course-body"><span class="bk-course-tag">ویژه</span><h3><?php echo esc_html($course[0]); ?></h3><p>آموزش کامل و پروژه‌محور برای شروع و ساخت محصول حرفه‌ای</p><strong><?php echo esc_html($course[1]); ?></strong><a href="#" class="bk-course-link">مشاهده دوره <span>←</span></a></div></article>
    <?php endforeach; ?>
  </div>
  <div class="bk-dots"><i></i><i class="active"></i><i></i><i></i><i></i></div>
</div></section>

<section class="bk-about" id="about"><div class="bk-container bk-about-card"><div class="bk-about-image"><img src="<?php echo esc_url( bk_setting('hero_image') ); ?>" alt="<?php echo esc_attr( bk_setting('brand_name','باران خانومی') ); ?>"></div><div class="bk-about-copy"><span class="bk-section-kicker">♡ با من بیشتر آشنا شو</span><h2><?php echo esc_html( bk_setting( 'about_title', 'با من، باران خانومی آشنا شوید' ) ); ?></h2><p><?php echo esc_html( bk_setting( 'about_text', 'من باران هستم؛ عاشق دوخت و آموزش. تجربه سال‌ها دوخت و طراحی محصولات دست‌دوز در کنار دوره‌های کاربردی و قابل فهم، کمک می‌کند از یک مهارت ساده به یک مسیر درآمدی برسید.' ) ); ?></p><div class="bk-stats"><div><strong>+۴۰</strong><small>آموزش کاربردی</small></div><div><strong>+۳۵۰۰</strong><small>هنرجوی دوره</small></div><div><strong>+۸</strong><small>سال تجربه</small></div></div><a href="#contact" class="bk-btn bk-btn-outline">درباره من بیشتر بدانید ←</a></div></div></section>

<section class="bk-section" id="mentors"><div class="bk-container"><div class="bk-section-title"><span>نمونه کارها</span><h2>نمونه‌کار هنرجویان من</h2></div><div class="bk-work-grid"><?php for($i=1;$i<=6;$i++): ?><div class="bk-work"><img src="https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=450&q=80" alt="نمونه کار هنرجو"></div><?php endfor; ?></div><div class="bk-center"><a class="bk-btn bk-btn-outline" href="#">مشاهده بیشتر ←</a></div></div></section>

<section class="bk-testimonials" id="blog"><div class="bk-container"><div class="bk-section-title"><span>تجربه هنرجویان</span><h2>هنرجویان من چه می‌گویند؟</h2></div><div class="bk-testimonial-grid"><?php $reviews=array(array('نگار حسینی','بعد از این دوره به جرأت می‌تونم بگم مسیرم رو پیدا کردم و با خیال راحت شروع کردم.'),array('فاطمه محمدی','تکنیک‌های آموزش داده شده عالی و کاربردی بود. پشتیبانی دوره هم فوق‌العاده است.'),array('مریم رحیمی','من هیچ تجربه‌ای در دوخت نداشتم اما با آموزش‌ها تونستم اولین کیف‌هام رو بسازم.'); foreach($reviews as $review): ?><article class="bk-review"><div class="bk-review-head"><div class="bk-avatar"></div><strong><?php echo esc_html($review[0]); ?></strong></div><div class="bk-stars">★★★★★</div><p><?php echo esc_html($review[1]); ?></p></article><?php endforeach; ?></div></div></section>
</main>
<?php get_footer(); ?>
