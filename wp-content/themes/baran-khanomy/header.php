<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="bk-header">
  <div class="bk-container bk-header-inner">
    <button class="bk-mobile-menu" type="button" aria-label="باز کردن منو" aria-expanded="false">☰</button>
    <a class="bk-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
      <?php $custom_logo_id = (int) get_theme_mod( 'custom_logo' ); if ( $custom_logo_id ) : ?>
        <span class="bk-custom-logo"><?php echo wp_get_attachment_image( $custom_logo_id, 'full', false, array( 'class' => 'custom-logo', 'alt' => get_bloginfo( 'name' ) ) ); ?></span>
      <?php else : ?>
        <span class="bk-logo-mark">ب</span>
      <?php endif; ?>
      <span class="bk-logo-text"><strong><?php echo esc_html( bk_setting( 'brand_name', 'باران خانومی' ) ); ?></strong><small><?php echo esc_html( get_theme_mod( 'bk_header_tagline', 'مهارت • خلاقیت • درآمد' ) ); ?></small></span>
    </a>
    <nav class="bk-nav" aria-label="منوی اصلی">
      <?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'fallback_cb' => function() { echo '<a href="' . esc_url( home_url( '/' ) ) . '">خانه</a><a href="#courses">دوره‌ها</a><a href="#categories">دسته‌بندی</a><a href="#mentors">نمونه‌کار هنرجویان</a><a href="#about">درباره من</a><a href="#testimonials">نظرات هنرجویان</a><a href="#contact">تماس با من</a>'; }, 'items_wrap' => '%3$s' ) ); ?>
    </nav>
    <div class="bk-header-actions">
      <form class="bk-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
        <span><?php echo bk_icon( 'search' ); ?></span>
        <input type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php echo esc_attr( get_theme_mod( 'bk_search_placeholder', 'جستجوی دوره...' ) ); ?>" aria-label="جستجوی دوره">
        <?php if ( bk_tutor_is_active() ) : ?><input type="hidden" name="post_type" value="<?php echo esc_attr( tutor()->course_post_type ); ?>"><?php endif; ?>
      </form>
      <?php if ( is_user_logged_in() ) : ?>
        <?php
        $bk_profile_url = home_url( '/dashboard/' );
        if ( function_exists( 'tutor_utils' ) ) {
            try {
                $bk_utils = tutor_utils();
                if ( is_object( $bk_utils ) && method_exists( $bk_utils, 'tutor_dashboard_url' ) ) {
                    $bk_profile_url = $bk_utils->tutor_dashboard_url();
                }
            } catch ( Throwable $e ) {
                // Keep the dashboard fallback URL.
            }
        }
        $bk_logout_url = wp_logout_url( home_url( '/' ) );
        ?>
        <div class="bk-user-actions" aria-label="حساب کاربری">
          <a class="bk-profile-link" href="<?php echo esc_url( $bk_profile_url ); ?>">
            <span class="bk-profile-icon" aria-hidden="true">♙</span>
            <span>پروفایل</span>
          </a>
          <a class="bk-logout-link" href="<?php echo esc_url( $bk_logout_url ); ?>">خروج</a>
        </div>
      <?php else : ?>
        <button class="bk-login bk-open-auth" type="button" data-bk-open-auth><span>♙</span> <?php echo esc_html( get_theme_mod( 'bk_login_label', 'ورود / ثبت‌نام' ) ); ?></button>
      <?php endif; ?>
    </div>
  </div>
</header>
