<footer class="bk-footer" id="contact">
  <div class="bk-container">
    <section class="bk-footer-cta">
      <div><h2><?php echo esc_html( bk_setting( 'footer_cta', 'آماده‌ای مسیر جدیدی رو شروع کنی؟' ) ); ?></h2><p><?php echo esc_html( bk_setting( 'footer_description', 'اولین قدم، انتخاب دوره‌ای است که تو را به درآمد نزدیک‌تر می‌کند.' ) ); ?></p></div>
      <a class="bk-btn bk-btn-gold" href="#courses">مشاهده همه دوره‌ها <span>←</span></a>
      <div class="bk-footer-illustration">✧</div>
    </section>
    <div class="bk-footer-grid">
      <div><h3>دسترسی سریع</h3><a href="<?php echo esc_url( home_url( '/' ) ); ?>">خانه</a><a href="#courses">دوره‌ها</a><a href="#mentors">نمونه‌کار هنرجویان</a><a href="#testimonials">نظرات هنرجویان</a></div>
      <div><h3>راهنما</h3><a href="#">سوالات متداول</a><a href="#">شرایط استفاده</a><a href="#">حریم خصوصی</a><a href="#">قوانین و مقررات</a></div>
      <div><h3>ارتباط با من</h3><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', bk_setting( 'phone', '09000000000' ) ) ); ?>"><?php echo esc_html( bk_setting( 'phone', '۰۹۰۰ ۰۰۰ ۰۰۰۰' ) ); ?></a><a href="mailto:<?php echo esc_attr( bk_setting( 'email', 'barankhanomy@gmail.com' ) ); ?>"><?php echo esc_html( bk_setting( 'email', 'barankhanomy@gmail.com' ) ); ?></a><div class="bk-socials"><span>◎</span><span>◌</span><span>✈</span></div></div>
      <div class="bk-footer-brand"><div class="bk-logo-mark">ب</div><strong><?php echo esc_html( bk_setting( 'brand_name', 'باران خانومی' ) ); ?></strong><p><?php echo esc_html( bk_setting( 'footer_brand_text', 'مهارت، خلاقیت و ساختن یک مسیر درآمدی واقعی.' ) ); ?></p></div>
    </div>
    <div class="bk-copyright"><?php echo esc_html( bk_setting( 'copyright', 'تمامی حقوق این سایت متعلق به باران خانومی است.' ) ); ?></div>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
