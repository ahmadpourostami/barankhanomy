<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$posts_per_page = max( 1, min( 12, absint( $attributes['postsPerPage'] ?? 4 ) ) );
$columns = max( 1, min( 4, absint( $attributes['columns'] ?? 4 ) ) );
$category = sanitize_text_field( $attributes['category'] ?? '' );
$title = sanitize_text_field( $attributes['title'] ?? 'جدیدترین دوره‌ها' );
$show_title = ! empty( $attributes['showTitle'] );
$show_dots = ! empty( $attributes['showDots'] );
$show_more = ! empty( $attributes['showMoreButton'] );
$more_text = sanitize_text_field( $attributes['moreButtonText'] ?? 'مشاهده همه دوره‌ها ←' );

if ( ! function_exists( 'tutor' ) || ! function_exists( 'tutor_utils' ) ) return '<div class="bk-empty-state">برای نمایش دوره‌ها، Tutor LMS را نصب و فعال کنید.</div>';

$args = array(
    'post_type' => tutor()->course_post_type,
    'post_status' => 'publish',
    'posts_per_page' => $posts_per_page,
    'orderby' => 'date',
    'order' => 'DESC',
    'no_found_rows' => true,
);
if ( $category !== '' && taxonomy_exists( 'course-category' ) ) $args['tax_query'] = array( array( 'taxonomy' => 'course-category', 'field' => 'term_id', 'terms' => absint( $category ) ) );
$query = new WP_Query( $args );

ob_start();
if ( $show_title ) : ?><div class="bk-section-title"><span>دوره‌های آموزشی</span><h2><?php echo esc_html( $title ); ?></h2></div><?php endif; ?>
<div class="bk-course-grid bk-course-grid-block" style="--bk-course-columns:<?php echo esc_attr( $columns ); ?>">
<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); $course_id = get_the_ID(); $title_text = get_the_title(); $url = get_permalink(); $image = get_the_post_thumbnail_url( $course_id, 'large' ); $regular = (float) get_post_meta( $course_id, 'tutor_course_price', true ); $sale = (float) get_post_meta( $course_id, 'tutor_course_sale_price', true ); $discount = ( $regular > 0 && $sale > 0 && $sale < $regular ) ? round( ( ( $regular - $sale ) / $regular ) * 100 ) . '%' : ''; $currency = method_exists( tutor_utils(), 'currency_symbol' ) ? tutor_utils()->currency_symbol() : 'تومان'; $terms = get_the_terms( $course_id, 'course-category' ); ?>
<article class="bk-course-card"><a class="bk-course-image" href="<?php echo esc_url( $url ); ?>"><?php if ( $image ) : ?><img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title_text ); ?>"><?php else : ?><div class="bk-course-placeholder"></div><?php endif; ?><?php if ( $terms && ! is_wp_error( $terms ) ) : ?><span class="bk-course-category-pill"><?php echo esc_html( $terms[0]->name ); ?></span><?php endif; ?><?php if ( $discount ) : ?><span class="bk-discount"><?php echo esc_html( $discount ); ?></span><?php endif; ?></a><div class="bk-course-body"><h3><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $title_text ); ?></a></h3><div class="bk-course-price"><?php if ( $regular > 0 && $sale > 0 && $sale < $regular ) : ?><del><?php echo esc_html( number_format_i18n( $regular ) . ' ' . $currency ); ?></del><strong><?php echo esc_html( number_format_i18n( $sale ) . ' ' . $currency ); ?></strong><?php elseif ( $regular > 0 ) : ?><strong><?php echo esc_html( number_format_i18n( $regular ) . ' ' . $currency ); ?></strong><?php else : ?><strong>رایگان</strong><?php endif; ?></div><a href="<?php echo esc_url( $url ); ?>" class="bk-course-link">مشاهده دوره <span>←</span></a></div></article>
<?php endwhile; wp_reset_postdata(); else : ?><div class="bk-empty-state">دوره‌ای برای نمایش پیدا نشد.</div><?php endif; ?></div>
<?php if ( $show_dots ) : ?><div class="bk-dots"><i class="active"></i><i></i><i></i><i></i><i></i></div><?php endif; ?>
<?php if ( $show_more ) : ?><div class="bk-center"><a class="bk-btn bk-btn-outline" href="<?php echo esc_url( tutor_utils()->course_archive_page_url() ); ?>"><?php echo esc_html( $more_text ); ?></a></div><?php endif; ?>
<?php return ob_get_clean();
