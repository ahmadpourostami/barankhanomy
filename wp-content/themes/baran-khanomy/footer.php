<footer class="bk-footer" id="contact">
  <div class="bk-container">
    <section class="bk-footer-cta">
      <div><h2><?php echo esc_html( bk_setting( 'footer_cta', 'آماده‌ای مسیر جدیدی رو شروع کنی؟' ) ); ?></h2><p><?php echo esc_html( bk_setting( 'footer_description', 'اولین قدم، انتخاب دوره‌ای است که تو را به درآمد نزدیک‌تر می‌کند.' ) ); ?></p></div>
      <a class="bk-btn bk-btn-gold" href="#courses">مشاهده همه دوره‌ها <span>←</span></a>
      <div class="bk-footer-illustration">✧</div>
    </section>

    <div class="bk-footer-grid">
      <div class="bk-footer-widget-col">
        <?php if ( is_active_sidebar( 'footer_col_1' ) ) : ?>
          <?php dynamic_sidebar( 'footer_col_1' ); ?>
        <?php else : ?>
          <section class="widget"><h3 class="widget-title">دسترسی سریع</h3><a href="<?php echo esc_url( home_url( '/' ) ); ?>">خانه</a><a href="#courses">دوره‌ها</a><a href="#mentors">نمونه‌کار هنرجویان</a><a href="#testimonials">نظرات هنرجویان</a></section>
        <?php endif; ?>
        <?php if ( is_active_sidebar( 'footer_social' ) ) : ?>
          <div class="bk-footer-social-widget-area"><?php dynamic_sidebar( 'footer_social' ); ?></div>
        <?php elseif ( function_exists( 'bk_social_get' ) ) : ?>
          <div class="bk-socials" aria-label="شبکه‌های اجتماعی">
            <?php if ( bk_social_get( 'instagram' ) ) : ?><a href="<?php echo esc_url( bk_social_get( 'instagram' ) ); ?>" target="_blank" rel="noopener noreferrer" aria-label="اینستاگرام">◎</a><?php endif; ?>
            <?php if ( bk_social_get( 'telegram' ) ) : ?><a href="<?php echo esc_url( bk_social_get( 'telegram' ) ); ?>" target="_blank" rel="noopener noreferrer" aria-label="تلگرام">✈</a><?php endif; ?>
            <?php if ( bk_social_get( 'whatsapp' ) ) : ?><a href="<?php echo esc_url( bk_social_get( 'whatsapp' ) ); ?>" target="_blank" rel="noopener noreferrer" aria-label="واتساپ">◌</a><?php endif; ?>
          </div>
        <?php endif; ?>
      </div>

      <div class="bk-footer-widget-col">
        <?php if ( is_active_sidebar( 'footer_col_2' ) ) : ?>
          <?php dynamic_sidebar( 'footer_col_2' ); ?>
        <?php else : ?>
          <section class="widget"><h3 class="widget-title">راهنما</h3><a href="#">سوالات متداول</a><a href="#">شرایط استفاده</a><a href="#">حریم خصوصی</a><a href="#">قوانین و مقررات</a></section>
        <?php endif; ?>
      </div>

      <div class="bk-footer-widget-col">
        <?php if ( is_active_sidebar( 'footer_col_3' ) ) : ?>
          <?php dynamic_sidebar( 'footer_col_3' ); ?>
        <?php else : ?>
          <section class="widget"><h3 class="widget-title">ارتباط با من</h3><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', bk_setting( 'phone', '09000000000' ) ) ); ?>"><?php echo esc_html( bk_setting( 'phone', '۰۹۰۰ ۰۰۰ ۰۰۰۰' ) ); ?></a><a href="mailto:<?php echo esc_attr( bk_setting( 'email', 'barankhanomy@gmail.com' ) ); ?>"><?php echo esc_html( bk_setting( 'email', 'barankhanomy@gmail.com' ) ); ?></a></section>
        <?php endif; ?>
      </div>

      <div class="bk-footer-widget-col">
        <?php if ( is_active_sidebar( 'footer_col_4' ) ) : ?>
          <?php dynamic_sidebar( 'footer_col_4' ); ?>
        <?php else : ?>
          <section class="widget bk-footer-brand"><div class="bk-logo-mark">ب</div><strong><?php echo esc_html( bk_setting( 'brand_name', 'باران خانومی' ) ); ?></strong><p><?php echo esc_html( bk_setting( 'footer_brand_text', 'مهارت، خلاقیت و ساختن یک مسیر درآمدی واقعی.' ) ); ?></p></section>
        <?php endif; ?>
      </div>
    </div>

    <div class="bk-footer-bottom">
      <div class="bk-copyright"><?php echo esc_html( bk_setting( 'copyright', 'تمامی حقوق این سایت متعلق به باران خانومی است.' ) ); ?></div>
      <div class="bk-designer-signature">طراحی شده با <span aria-hidden="true">♥</span> توسط <a href="http://sabkekar.ir" target="_blank" rel="noopener noreferrer">سبک کار</a></div>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
