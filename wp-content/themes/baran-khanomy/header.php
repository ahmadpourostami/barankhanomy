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
      <span class="bk-logo-mark">ب</span>
      <span><strong><?php echo esc_html( bk_setting( 'brand_name', 'باران خانومی' ) ); ?></strong><small>مهارت • خلاقیت • درآمد</small></span>
    </a>
    <nav class="bk-nav" aria-label="منوی اصلی">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>">خانه</a>
      <a href="#courses">دوره‌ها</a>
      <a href="#categories">دسته‌بندی</a>
      <a href="#mentors">نمونه‌کار هنرجویان</a>
      <a href="#about">درباره من</a>
      <a href="#testimonials">نظرات هنرجویان</a>
      <a href="#contact">تماس با من</a>
    </nav>
    <div class="bk-header-actions">
      <button class="bk-search" type="button"><span><?php echo bk_icon( 'search' ); ?></span><em>جستجوی دوره...</em></button>
      <button class="bk-login bk-open-auth" type="button" data-bk-open-auth><span>♙</span> ورود / ثبت‌نام</button>
    </div>
  </div>
</header>
