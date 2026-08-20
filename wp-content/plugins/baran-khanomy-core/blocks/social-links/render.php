<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$items = array(
    'instagram' => array( 'label' => 'اینستاگرام', 'url' => $attributes['instagram'] ?? '' ),
    'telegram'  => array( 'label' => 'تلگرام', 'url' => $attributes['telegram'] ?? '' ),
    'whatsapp'  => array( 'label' => 'واتساپ', 'url' => $attributes['whatsapp'] ?? '' ),
    'youtube'   => array( 'label' => 'یوتیوب', 'url' => $attributes['youtube'] ?? '' ),
);

$icons = array(
    'instagram' => '<path d="M12 7.2A4.8 4.8 0 1 0 12 16.8 4.8 4.8 0 0 0 12 7.2Zm0 7.9A3.1 3.1 0 1 1 12 9a3.1 3.1 0 0 1 0 6.1Zm6.1-8.1a1.1 1.1 0 1 1-2.2 0 1.1 1.1 0 0 1 2.2 0ZM22 12c0-2.7 0-3.1-.1-4.2a6.1 6.1 0 0 0-1.7-4 6.1 6.1 0 0 0-4-1.7C15.1 2 14.7 2 12 2s-3.1 0-4.2.1a6.1 6.1 0 0 0-4 1.7 6.1 6.1 0 0 0-1.7 4C2 8.9 2 9.3 2 12s0 3.1.1 4.2a6.1 6.1 0 0 0 1.7 4 6.1 6.1 0 0 0 4 1.7c1.1.1 1.5.1 4.2.1s3.1 0 4.2-.1a6.1 6.1 0 0 0 4-1.7 6.1 6.1 0 0 0 1.7-4c.1-1.1.1-1.5.1-4.2Zm-2 5.9a4.1 4.1 0 0 1-2.3 2.3c-.8.3-1.4.4-3.7.4h-4c-2.3 0-2.9-.1-3.7-.4A4.1 4.1 0 0 1 4 17.9c-.3-.8-.4-1.4-.4-3.7v-4c0-2.3.1-2.9.4-3.7A4.1 4.1 0 0 1 6.3 4.2c.8-.3 1.4-.4 3.7-.4h4c2.3 0 2.9.1 3.7.4A4.1 4.1 0 0 1 20 6.5c.3.8.4 1.4.4 3.7v4c0 2.3-.1 2.9-.4 3.7Z"/>',
    'telegram' => '<path d="M21.8 3.4 18.5 21c-.2 1.2-.9 1.5-1.8.9l-5-3.7-2.4 2.3c-.3.3-.5.5-1 .5l.4-5.1 9.3-8.4c.4-.4-.1-.6-.6-.2L6 14.6l-5-1.6c-1.1-.3-1.1-1.1.2-1.6L20.7 3c.9-.3 1.7.2 1.1.4Z"/>',
    'whatsapp' => '<path d="M20.5 3.5A11.7 11.7 0 0 0 12.1 0C5.6 0 .3 5.3.3 11.8c0 2.1.5 4.1 1.6 5.9L.2 24l6.5-1.7a11.8 11.8 0 0 0 5.4 1.3h.1c6.5 0 11.8-5.3 11.8-11.8 0-3.1-1.2-6-3.5-8.3ZM12.1 21.7h-.1c-1.7 0-3.4-.5-4.8-1.4l-.3-.2-3.8 1 1-3.7-.2-.4a9.8 9.8 0 0 1-1.5-5.2c0-5.4 4.4-9.8 9.8-9.8 2.6 0 5.1 1 6.9 2.9a9.7 9.7 0 0 1 2.9 6.9c0 5.5-4.4 9.9-9.9 9.9Zm5.4-7.4c-.3-.2-1.8-.9-2.1-1-.3-.1-.5-.2-.7.2-.2.3-.8 1-.9 1.2-.2.2-.3.2-.6.1-.3-.2-1.3-.5-2.5-1.6-.9-.8-1.6-1.8-1.8-2.1-.2-.3 0-.5.2-.7l.5-.6c.2-.2.2-.4.3-.6.1-.2 0-.5 0-.7-.1-.2-.7-1.7-1-2.3-.3-.6-.5-.5-.7-.5h-.6c-.2 0-.6.1-.9.4-.3.3-1.1 1-1.1 2.5s1.1 2.9 1.3 3.1c.2.2 2.2 3.4 5.4 4.8.8.3 1.4.5 1.9.7.8.2 1.5.2 2 .1.6-.1 1.8-.7 2.1-1.4.3-.7.3-1.3.2-1.4 0-.2-.2-.3-.5-.4Z"/>',
    'youtube' => '<path d="M23.5 6.2a3 3 0 0 0-2.1-2.1C19.5 3.6 12 3.6 12 3.6s-7.5 0-9.4.5A3 3 0 0 0 .5 6.2C0 8.1 0 12 0 12s0 3.9.5 5.8a3 3 0 0 0 2.1 2.1c1.9.5 9.4.5 9.4.5s7.5 0 9.4-.5a3 3 0 0 0 2.1-2.1c.5-1.9.5-5.8.5-5.8s0-3.9-.5-5.8ZM9.6 15.6V8.4l6.3 3.6-6.3 3.6Z"/>',
);

$size = max(32, min(64, absint( $attributes['size'] ?? 44 )));
$gap = max(4, min(28, absint( $attributes['gap'] ?? 10 )));
$shape = in_array( $attributes['shape'] ?? 'circle', array( 'circle', 'rounded', 'square' ), true ) ? $attributes['shape'] : 'circle';
$alignment = in_array( $attributes['alignment'] ?? 'right', array( 'right', 'center', 'left' ), true ) ? $attributes['alignment'] : 'right';
$title = sanitize_text_field( $attributes['title'] ?? '' );

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'bk-social-links bk-social-links--' . $shape . ' bk-social-links--' . $alignment ) );
?>
<div <?php echo $wrapper_attributes; ?>>
    <?php if ( $title ) : ?><div class="bk-social-links__title"><?php echo esc_html( $title ); ?></div><?php endif; ?>
    <div class="bk-social-links__items" style="--bk-social-size:<?php echo esc_attr( $size ); ?>px;--bk-social-gap:<?php echo esc_attr( $gap ); ?>px;">
        <?php foreach ( $items as $key => $item ) : if ( empty( $item['url'] ) ) continue; $url = esc_url( $item['url'] ); if ( ! $url ) continue; ?>
            <a class="bk-social-links__item bk-social-links__item--<?php echo esc_attr( $key ); ?>" href="<?php echo $url; ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $item['label'] ); ?>">
                <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><?php echo $icons[ $key ]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></svg>
            </a>
        <?php endforeach; ?>
    </div>
</div>
