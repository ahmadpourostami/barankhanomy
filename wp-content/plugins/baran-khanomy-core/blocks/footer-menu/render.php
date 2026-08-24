<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$menu_id = absint( $attributes['menuId'] ?? 0 );
$title = sanitize_text_field( $attributes['title'] ?? '' );
$style = in_array( $attributes['style'] ?? 'list', array( 'list', 'cards' ), true ) ? $attributes['style'] : 'list';
$alignment = in_array( $attributes['alignment'] ?? 'right', array( 'right', 'center', 'left' ), true ) ? $attributes['alignment'] : 'right';
$show_arrow = ! empty( $attributes['showArrow'] );
$classes = 'bk-footer-menu bk-footer-menu-' . $style . ' bk-footer-menu-align-' . $alignment;
if ( ! $menu_id ) return;
$items = wp_get_nav_menu_items( $menu_id );
if ( empty( $items ) ) return;
?>
<nav class="<?php echo esc_attr( $classes ); ?>" aria-label="<?php echo esc_attr( $title ?: 'منوی فوتر' ); ?>">
    <?php if ( $title ) : ?><h3 class="bk-footer-menu-title"><?php echo esc_html( $title ); ?></h3><?php endif; ?>
    <ul class="bk-footer-menu-list">
        <?php foreach ( $items as $item ) : ?>
            <li class="bk-footer-menu-item">
                <a href="<?php echo esc_url( $item->url ); ?>" target="<?php echo esc_attr( $item->target ?: '_self' ); ?>" <?php echo $item->target === '_blank' ? 'rel="noopener noreferrer"' : ''; ?>>
                    <span><?php echo esc_html( $item->title ); ?></span>
                    <?php if ( $show_arrow ) : ?><span class="bk-footer-menu-arrow" aria-hidden="true">←</span><?php endif; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
