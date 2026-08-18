<?php get_header(); ?>
<main>
<section class="bk-hero">
  <div class="bk-container bk-hero-grid">
    <div class="bk-hero-copy">
      <span class="bk-eyebrow">♡ <?php echo esc_html( bk_setting( 'hero_badge', 'فرصتِ خوب برای شروع' ) ); ?></span>
      <h1><?php echo wp_kses_post( bk_setting( 'hero_title', 'مهارت یاد بگیر،<br><strong>از هنر دست درآمد بساز</strong>' ) ); ?></h1>
      <p><?php echo esc_html( bk_setting( 'hero_text', 'آموزش‌های کاربردی و پروژه‌محور از مبتدی تا پیشرفته، همراه با پشتیبانی و راهنمایی برای ساخت محصولات حرفه‌ای.' ) ); ?></p>
      <div class="bk-hero-actions">
        <a class="bk-btn bk-btn-gold" href="#courses"><?php echo esc_html( bk_setting( 'hero_primary', 'شروع یادگیری' ) ); ?> <span>←</span></a>
        <a class="bk-btn bk-btn-outline" href="#courses"><?php echo esc_html( bk_setting( 'hero_secondary', 'مشاهده دوره‌ها' ) ); ?></a>
      </div>
    </div>
    <div class="bk-hero-media"><img src="<?php echo esc_url( bk_setting( 'hero_image' ) ); ?>" alt="<?php echo esc_attr( bk_setting( 'brand_name', 'باران خانومی' ) ); ?>"><div class="bk-hero-glow"></div></div>
  </div>
</section>

<section class="bk-benefits"><div class="bk-container bk-benefits-grid">
  <div><span class="bk-benefit-icon">□</span><strong><?php echo esc_html( bk_setting( 'benefit_1_title', 'دسترسی دائمی' ) ); ?></strong><small><?php echo esc_html( bk_setting( 'benefit_1_text', 'به تمام دوره‌ها' ) ); ?></small></div>
  <div><span class="bk-benefit-icon">▷</span><strong><?php echo esc_html( bk_setting( 'benefit_2_title', 'آموزش‌های کاربردی' ) ); ?></strong><small><?php echo esc_html( bk_setting( 'benefit_2_text', 'پروژه‌محور و درآمدزا' ) ); ?></small></div>
  <div><span class="bk-benefit-icon">♧</span><strong><?php echo esc_html( bk_setting( 'benefit_3_title', 'پشتیبانی و همراهی' ) ); ?></strong><small><?php echo esc_html( bk_setting( 'benefit_3_text', 'در تمام مسیر یادگیری' ) ); ?></small></div>
</div></section>

<section class="bk-section" id="categories"><div class="bk-container">
  <div class="bk-section-head"><div><span>دسته‌بندی دوره‌ها</span><h2>مهارتت رو انتخاب کن</h2></div><a href="#courses">مشاهده همه ←</a></div>
  <div class="bk-category-grid">
    <?php
    $categories = get_terms( array( 'taxonomy' => 'bk_course_category', 'hide_empty' => false, 'number' => 6, 'orderby' => 'term_id', 'order' => 'ASC' ) );
    if ( ! is_wp_error( $categories ) ) :
      foreach ( $categories as $category ) :
    ?>
      <a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="bk-category"><span><?php echo bk_icon( 'gift' ); ?></span><strong><?php echo esc_html( $category->name ); ?></strong></a>
    <?php endforeach; endif; ?>
    <a href="<?php echo esc_url( get_post_type_archive_link( 'bk_course' ) ); ?>" class="bk-category"><span><?php echo bk_icon( 'grid' ); ?></span><strong>همه دوره‌ها</strong></a>
  </div>
</div></section>

<section class="bk-section bk-courses" id="courses"><div class="bk-container">
  <div class="bk-section-title"><span>پیشنهادهای منتخب</span><h2>دوره‌های منتخب</h2></div>
  <div class="bk-course-grid">
    <?php
    $courses = new WP_Query( array( 'post_type' => 'bk_course', 'post_status' => 'publish', 'posts_per_page' => 4, 'orderby' => 'menu_order date', 'order' => 'DESC' ) );
    if ( $courses->have_posts() ) :
      while ( $courses->have_posts() ) : $courses->the_post();
        $course_image = get_post_meta( get_the_ID(), '_bk_course_image', true );
        $course_price = get_post_meta( get_the_ID(), '_bk_course_price', true );
        $course_discount = get_post_meta( get_the_ID(), '_bk_course_discount', true );
        $course_badge = get_post_meta( get_the_ID(), '_bk_course_badge', true );
        $course_url = get_post_meta( get_the_ID(), '_bk_course_url', true );
        $course_url = $course_url ? $course_url : get_permalink();
        $course_image = $course_image ? $course_image : get_the_post_thumbnail_url( get_the_ID(), 'large' );
    ?>
      <article class="bk-course-card">
        <div class="bk-course-image">
          <?php if ( $course_image ) : ?><img src="<?php echo esc_url( $course_image ); ?>" alt="<?php the_title_attribute(); ?>"><?php endif; ?>
          <?php if ( $course_discount ) : ?><span class="bk-discount"><?php echo esc_html( $course_discount ); ?></span><?php endif; ?>
        </div>
        <div class="bk-course-body">
          <?php if ( $course_badge ) : ?><span class="bk-course-tag"><?php echo esc_html( $course_badge ); ?></span><?php endif; ?>
          <h3><?php the_title(); ?></h3>
          <p><?php echo esc_html( get_the_excerpt() ); ?></p>
          <?php if ( $course_price ) : ?><strong><?php echo esc_html( $course_price ); ?></strong><?php endif; ?>
          <a href="<?php echo esc_url( $course_url ); ?>" class="bk-course-link">مشاهده دوره <span>←</span></a>
        </div>
      </article>
    <?php endwhile; wp_reset_postdata(); else : ?>
      <p>هنوز دوره‌ای ثبت نشده است.</p>
    <?php endif; ?>
  </div>
  <div class="bk-dots"><i></i><i class="active"></i><i></i><i></i><i></i></div>
</div></section>

<section class="bk-about" id="about"><div class="bk-container bk-about-card">
  <div class="bk-about-image"><img src="<?php echo esc_url( bk_setting( 'hero_image' ) ); ?>" alt="<?php echo esc_attr( bk_setting( 'brand_name', 'باران خانومی' ) ); ?>"></div>
  <div class="bk-about-copy">
    <span class="bk-section-kicker">♡ با من بیشتر آشنا شو</span>
    <h2><?php echo esc_html( bk_setting( 'about_title', 'با من، باران خانومی آشنا شوید' ) ); ?></h2>
    <p><?php echo esc_html( bk_setting( 'about_text', 'من باران هستم؛ عاشق دوخت و آموزش. تجربه سال‌ها دوخت و طراحی محصولات دست‌دوز در کنار دوره‌های کاربردی و قابل فهم، کمک می‌کند از یک مهارت ساده به یک مسیر درآمدی برسید.' ) ); ?></p>
    <div class="bk-stats">
      <div><strong><?php echo esc_html( bk_setting( 'stat_courses', '+۴۰' ) ); ?></strong><small>آموزش کاربردی</small></div>
      <div><strong><?php echo esc_html( bk_setting( 'stat_students', '+۳۵۰۰' ) ); ?></strong><small>هنرجوی دوره</small></div>
      <div><strong><?php echo esc_html( bk_setting( 'stat_experience', '+۸' ) ); ?></strong><small>سال تجربه</small></div>
    </div>
    <a href="#contact" class="bk-btn bk-btn-outline">درباره من بیشتر بدانید ←</a>
  </div>
</div></section>

<section class="bk-section" id="mentors"><div class="bk-container">
  <div class="bk-section-title"><span>نمونه کارها</span><h2>نمونه‌کار هنرجویان من</h2></div>
  <div class="bk-work-grid">
    <?php
    $works = new WP_Query( array( 'post_type' => 'bk_student_work', 'post_status' => 'publish', 'posts_per_page' => 6, 'orderby' => 'menu_order date', 'order' => 'DESC' ) );
    if ( $works->have_posts() ) :
      while ( $works->have_posts() ) : $works->the_post();
        $work_image = get_post_meta( get_the_ID(), '_bk_student_work_image', true );
        $work_url = get_post_meta( get_the_ID(), '_bk_student_work_url', true );
        $work_url = $work_url ? $work_url : get_permalink();
        if ( ! $work_image ) $work_image = get_the_post_thumbnail_url( get_the_ID(), 'medium' );
    ?>
      <a class="bk-work" href="<?php echo esc_url( $work_url ); ?>" aria-label="<?php the_title_attribute(); ?>">
        <?php if ( $work_image ) : ?><img src="<?php echo esc_url( $work_image ); ?>" alt="<?php the_title_attribute(); ?>"><?php endif; ?>
      </a>
    <?php endwhile; wp_reset_postdata(); endif; ?>
  </div>
  <div class="bk-center"><a class="bk-btn bk-btn-outline" href="<?php echo esc_url( get_post_type_archive_link( 'bk_student_work' ) ); ?>">مشاهده بیشتر ←</a></div>
</div></section>

<section class="bk-testimonials" id="testimonials"><div class="bk-container">
  <div class="bk-section-title"><span>تجربه هنرجویان</span><h2>هنرجویان من چه می‌گویند؟</h2></div>
  <div class="bk-testimonial-grid">
    <?php
    $reviews = new WP_Query( array( 'post_type' => 'bk_testimonial', 'post_status' => 'publish', 'posts_per_page' => 3, 'orderby' => 'menu_order date', 'order' => 'DESC' ) );
    if ( $reviews->have_posts() ) :
      while ( $reviews->have_posts() ) : $reviews->the_post();
        $role = get_post_meta( get_the_ID(), '_bk_testimonial_role', true );
        $avatar = get_post_meta( get_the_ID(), '_bk_testimonial_avatar', true );
        $rating = max( 0, min( 5, (int) get_post_meta( get_the_ID(), '_bk_testimonial_rating', true ) ) );
    ?>
      <article class="bk-review">
        <div class="bk-review-head">
          <?php if ( $avatar ) : ?><img class="bk-avatar" src="<?php echo esc_url( $avatar ); ?>" alt="<?php the_title_attribute(); ?>"><?php else : ?><div class="bk-avatar"></div><?php endif; ?>
          <div><strong><?php the_title(); ?></strong><?php if ( $role ) : ?><small><?php echo esc_html( $role ); ?></small><?php endif; ?></div>
        </div>
        <div class="bk-stars"><?php echo esc_html( str_repeat( '★', $rating ) . str_repeat( '☆', 5 - $rating ) ); ?></div>
        <p><?php echo esc_html( wp_strip_all_tags( get_the_content() ) ); ?></p>
      </article>
    <?php endwhile; wp_reset_postdata(); else : ?>
      <p>هنوز نظری ثبت نشده است.</p>
    <?php endif; ?>
  </div>
</div></section>
</main>
<?php get_footer(); ?>
