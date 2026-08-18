<?php get_header(); ?>
<main>
<section class="bk-hero bk-hero-image-only">
  <div class="bk-container">
    <div class="bk-hero-single-image">
      <?php $hero_image = bk_setting( 'hero_image', '' ); ?>
      <?php if ( $hero_image ) : ?>
        <img src="<?php echo esc_url( $hero_image ); ?>" alt="<?php echo esc_attr( bk_setting( 'brand_name', 'باران خانومی' ) ); ?>">
      <?php else : ?>
        <div class="bk-image-placeholder">تصویر هیرو را از پیشخوان باران خانومی انتخاب کنید.</div>
      <?php endif; ?>
    </div>
  </div>
</section>

<section class="bk-benefits"><div class="bk-container bk-benefits-grid">
  <div><span class="bk-benefit-icon"><?php echo bk_icon( 'calendar' ); ?></span><strong><?php echo esc_html( bk_setting( 'benefit_1_title', 'دسترسی دائمی' ) ); ?></strong><small><?php echo esc_html( bk_setting( 'benefit_1_text', 'به تمام دوره‌ها' ) ); ?></small></div>
  <div><span class="bk-benefit-icon"><?php echo bk_icon( 'play' ); ?></span><strong><?php echo esc_html( bk_setting( 'benefit_2_title', 'آموزش‌های کاربردی' ) ); ?></strong><small><?php echo esc_html( bk_setting( 'benefit_2_text', 'پروژه‌محور و درآمدزا' ) ); ?></small></div>
  <div><span class="bk-benefit-icon"><?php echo bk_icon( 'headset' ); ?></span><strong><?php echo esc_html( bk_setting( 'benefit_3_title', 'پشتیبانی و همراهی' ) ); ?></strong><small><?php echo esc_html( bk_setting( 'benefit_3_text', 'در تمام مسیر یادگیری' ) ); ?></small></div>
</div></section>

<section class="bk-section" id="categories"><div class="bk-container">
  <div class="bk-section-head"><div><span><?php echo esc_html( bk_setting( 'categories_kicker', 'دسته‌بندی دوره‌ها' ) ); ?></span><h2><?php echo esc_html( bk_setting( 'categories_title', 'مهارتت رو انتخاب کن' ) ); ?></h2></div><?php if ( bk_tutor_is_active() ) : ?><a href="<?php echo esc_url( tutor_utils()->course_archive_page_url() ); ?>"><?php echo esc_html( bk_setting( 'categories_link', 'مشاهده همه ←' ) ); ?></a><?php endif; ?></div>
  <div class="bk-category-grid">
    <?php
    if ( bk_tutor_is_active() && taxonomy_exists( 'course-category' ) ) :
      $categories = get_terms( array( 'taxonomy' => 'course-category', 'hide_empty' => true, 'number' => 6, 'orderby' => 'term_id', 'order' => 'ASC' ) );
      if ( ! is_wp_error( $categories ) && $categories ) :
        foreach ( $categories as $category ) :
          $image_id = (int) get_term_meta( $category->term_id, '_bk_category_image_id', true );
          $image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'medium' ) : '';
    ?>
      <a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="bk-category">
        <span class="bk-category-image"><?php if ( $image_url ) : ?><img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $category->name ); ?>"><?php else : ?><span class="bk-category-placeholder"><?php echo bk_icon( 'grid' ); ?></span><?php endif; ?></span>
        <strong><?php echo esc_html( $category->name ); ?></strong>
      </a>
    <?php endforeach; endif; endif; ?>
    <?php if ( bk_tutor_is_active() ) : ?><a href="<?php echo esc_url( tutor_utils()->course_archive_page_url() ); ?>" class="bk-category"><span class="bk-category-image"><span class="bk-category-placeholder"><?php echo bk_icon( 'grid' ); ?></span></span><strong><?php echo esc_html( bk_setting( 'all_courses_label', 'همه دوره‌ها' ) ); ?></strong></a><?php endif; ?>
  </div>
</div></section>

<section class="bk-section bk-courses" id="courses"><div class="bk-container">
  <div class="bk-section-title"><span><?php echo esc_html( bk_setting( 'courses_kicker', 'پیشنهادهای منتخب' ) ); ?></span><h2><?php echo esc_html( bk_setting( 'courses_title', 'دوره‌های منتخب' ) ); ?></h2></div>
  <div class="bk-course-grid">
    <?php if ( ! bk_tutor_is_active() ) : ?>
      <div class="bk-empty-state"><strong>افزونه Tutor LMS فعال نیست.</strong><p>برای نمایش دوره‌ها، Tutor LMS را نصب و فعال کنید.</p></div>
    <?php else :
      $courses = new WP_Query( array( 'post_type' => tutor()->course_post_type, 'post_status' => 'publish', 'posts_per_page' => 4, 'orderby' => 'date', 'order' => 'DESC', 'no_found_rows' => true ) );
      if ( $courses->have_posts() ) :
        while ( $courses->have_posts() ) : $courses->the_post();
          $course_id = get_the_ID();
          $course_image = get_the_post_thumbnail_url( $course_id, 'large' );
          $course_discount = bk_tutor_course_discount( $course_id );
          $course_url = get_permalink( $course_id );
    ?>
      <article class="bk-course-card">
        <a class="bk-course-image" href="<?php echo esc_url( $course_url ); ?>">
          <?php if ( $course_image ) : ?><img src="<?php echo esc_url( $course_image ); ?>" alt="<?php the_title_attribute(); ?>"><?php else : ?><div class="bk-course-placeholder"></div><?php endif; ?>
          <?php if ( $course_discount ) : ?><span class="bk-discount"><?php echo esc_html( $course_discount ); ?></span><?php endif; ?>
        </a>
        <div class="bk-course-body">
          <?php $course_terms = get_the_terms( $course_id, 'course-category' ); if ( $course_terms && ! is_wp_error( $course_terms ) ) : ?><span class="bk-course-tag"><?php echo esc_html( $course_terms[0]->name ); ?></span><?php endif; ?>
          <h3><a href="<?php echo esc_url( $course_url ); ?>"><?php the_title(); ?></a></h3>
          <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 16 ) ); ?></p>
          <div class="bk-course-price"><?php echo bk_tutor_course_price( $course_id ); ?></div>
          <a href="<?php echo esc_url( $course_url ); ?>" class="bk-course-link"><?php echo esc_html( bk_setting( 'course_button_label', 'مشاهده دوره' ) ); ?> <span>←</span></a>
        </div>
      </article>
    <?php endwhile; wp_reset_postdata(); else : ?><div class="bk-empty-state"><strong><?php echo esc_html( bk_setting( 'no_courses_text', 'هنوز دوره‌ای منتشر نشده است.' ) ); ?></strong><p>دوره‌ها را از بخش Tutor LMS → Courses ایجاد کنید.</p></div><?php endif; endif; ?>
  </div>
  <?php if ( bk_tutor_is_active() ) : ?><div class="bk-center"><a class="bk-btn bk-btn-outline" href="<?php echo esc_url( tutor_utils()->course_archive_page_url() ); ?>"><?php echo esc_html( bk_setting( 'all_courses_button', 'مشاهده همه دوره‌ها ←' ) ); ?></a></div><?php endif; ?>
</div></section>

<section class="bk-about" id="about"><div class="bk-container bk-about-card">
  <div class="bk-about-image"><img src="<?php echo esc_url( bk_setting( 'about_image', '' ) ); ?>" alt="<?php echo esc_attr( bk_setting( 'about_title', 'با من، باران خانومی آشنا شوید' ) ); ?>"></div>
  <div class="bk-about-copy">
    <span class="bk-section-kicker"><?php echo esc_html( bk_setting( 'about_kicker', '♡ با من بیشتر آشنا شو' ) ); ?></span>
    <h2><?php echo esc_html( bk_setting( 'about_title', 'با من، باران خانومی آشنا شوید' ) ); ?></h2>
    <p><?php echo esc_html( bk_setting( 'about_text', 'من باران هستم؛ عاشق دوخت و آموزش. تجربه سال‌ها دوخت و طراحی محصولات دست‌دوز در کنار دوره‌های کاربردی و قابل فهم، کمک می‌کند از یک مهارت ساده به یک مسیر درآمدی برسید.' ) ); ?></p>
    <div class="bk-stats">
      <div><strong><?php echo esc_html( bk_setting( 'stat_courses', '+۴۰' ) ); ?></strong><small><?php echo esc_html( bk_setting( 'stat_courses_label', 'آموزش کاربردی' ) ); ?></small></div>
      <div><strong><?php echo esc_html( bk_setting( 'stat_students', '+۳۵۰۰' ) ); ?></strong><small><?php echo esc_html( bk_setting( 'stat_students_label', 'هنرجوی دوره' ) ); ?></small></div>
      <div><strong><?php echo esc_html( bk_setting( 'stat_experience', '+۸' ) ); ?></strong><small><?php echo esc_html( bk_setting( 'stat_experience_label', 'سال تجربه' ) ); ?></small></div>
    </div>
    <a href="#contact" class="bk-btn bk-btn-outline"><?php echo esc_html( bk_setting( 'about_button', 'درباره من بیشتر بدانید ←' ) ); ?></a>
  </div>
</div></section>

<section class="bk-section" id="mentors"><div class="bk-container">
  <div class="bk-section-title"><span><?php echo esc_html( bk_setting( 'works_kicker', 'نمونه کارها' ) ); ?></span><h2><?php echo esc_html( bk_setting( 'works_title', 'نمونه‌کار هنرجویان من' ) ); ?></h2></div>
  <div class="bk-work-grid">
    <?php $works = new WP_Query( array( 'post_type' => 'bk_student_work', 'post_status' => 'publish', 'posts_per_page' => 6, 'orderby' => 'menu_order date', 'order' => 'DESC' ) ); if ( $works->have_posts() ) : while ( $works->have_posts() ) : $works->the_post(); $work_url = get_post_meta( get_the_ID(), '_bk_student_work_url', true ); $work_url = $work_url ? $work_url : get_permalink(); ?>
      <a class="bk-work" href="<?php echo esc_url( $work_url ); ?>" aria-label="<?php the_title_attribute(); ?>"><?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'medium', array( 'alt' => get_the_title() ) ); else : ?><span><?php the_title(); ?></span><?php endif; ?></a>
    <?php endwhile; wp_reset_postdata(); endif; ?>
  </div>
  <div class="bk-center"><a class="bk-btn bk-btn-outline" href="<?php echo esc_url( get_post_type_archive_link( 'bk_student_work' ) ); ?>"><?php echo esc_html( bk_setting( 'works_button', 'مشاهده بیشتر ←' ) ); ?></a></div>
</div></section>

<section class="bk-testimonials" id="testimonials"><div class="bk-container">
  <div class="bk-section-title"><span><?php echo esc_html( bk_setting( 'testimonials_kicker', 'تجربه هنرجویان' ) ); ?></span><h2><?php echo esc_html( bk_setting( 'testimonials_title', 'هنرجویان من چه می‌گویند؟' ) ); ?></h2></div>
  <div class="bk-testimonial-grid">
    <?php $reviews = new WP_Query( array( 'post_type' => 'bk_testimonial', 'post_status' => 'publish', 'posts_per_page' => 3, 'orderby' => 'menu_order date', 'order' => 'DESC' ) ); if ( $reviews->have_posts() ) : while ( $reviews->have_posts() ) : $reviews->the_post(); $role = get_post_meta( get_the_ID(), '_bk_testimonial_role', true ); $avatar = get_post_meta( get_the_ID(), '_bk_testimonial_avatar', true ); $rating = max( 0, min( 5, (int) get_post_meta( get_the_ID(), '_bk_testimonial_rating', true ) ) ); ?>
      <article class="bk-review"><div class="bk-review-head"><?php if ( $avatar ) : ?><img class="bk-avatar" src="<?php echo esc_url( $avatar ); ?>" alt="<?php the_title_attribute(); ?>"><?php else : ?><div class="bk-avatar"></div><?php endif; ?><div><strong><?php the_title(); ?></strong><?php if ( $role ) : ?><small><?php echo esc_html( $role ); ?></small><?php endif; ?></div></div><div class="bk-stars"><?php echo esc_html( str_repeat( '★', $rating ) . str_repeat( '☆', 5 - $rating ) ); ?></div><p><?php echo esc_html( wp_strip_all_tags( get_the_content() ) ); ?></p></article>
    <?php endwhile; wp_reset_postdata(); else : ?><p><?php echo esc_html( bk_setting( 'no_testimonials_text', 'هنوز نظری ثبت نشده است.' ) ); ?></p><?php endif; ?>
  </div>
</div></section>
</main>
<?php get_footer(); ?>
