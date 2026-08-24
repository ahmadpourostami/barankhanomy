<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$title = isset( $attributes['title'] ) ? sanitize_text_field( $attributes['title'] ) : '';
$phone = isset( $attributes['phone'] ) ? sanitize_text_field( $attributes['phone'] ) : '';
$email = isset( $attributes['email'] ) ? sanitize_email( $attributes['email'] ) : '';
$address = isset( $attributes['address'] ) ? sanitize_text_field( $attributes['address'] ) : '';
$hours = isset( $attributes['hours'] ) ? sanitize_text_field( $attributes['hours'] ) : '';
$show_icons = ! isset( $attributes['showIcons'] ) || (bool) $attributes['showIcons'];
$alignment = isset( $attributes['alignment'] ) && in_array( $attributes['alignment'], array( 'right', 'center', 'left' ), true ) ? $attributes['alignment'] : 'right';
$items = array();
if ( $phone ) $items[] = array( 'phone', 'تلفن', $phone, 'tel:' . preg_replace( '/[^0-9+]/', '', strtr( $phone, array( '۰'=>'0','۱'=>'1','۲'=>'2','۳'=>'3','۴'=>'4','۵'=>'5','۶'=>'6','۷'=>'7','۸'=>'8','۹'=>'9' ) ) ) );
if ( $email ) $items[] = array( 'email', 'ایمیل', $email, 'mailto:' . $email );
if ( $address ) $items[] = array( 'address', 'آدرس', $address, '' );
if ( $hours ) $items[] = array( 'hours', 'ساعات پاسخگویی', $hours, '' );
if ( ! $items ) return;
?>
<div <?php echo get_block_wrapper_attributes( array( 'class' => 'bk-contact-info bk-contact-align-' . esc_attr( $alignment ) ) ); ?> dir="rtl">
    <?php if ( $title ) : ?><h3 class="bk-contact-title"><?php echo esc_html( $title ); ?></h3><?php endif; ?>
    <div class="bk-contact-items">
        <?php foreach ( $items as $item ) : ?>
            <div class="bk-contact-item">
                <?php if ( $show_icons ) : ?><span class="bk-contact-icon" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><path d="<?php echo esc_attr( array( 'phone'=>'M6.6 10.8c1.5 3 3.6 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1.1-.2 1.2.4 2.5.6 3.8.6.6 0 1.1.5 1.1 1.1V20c0 .6-.5 1.1-1.1 1.1C11.4 21.1 2.9 12.6 2.9 2.1 2.9 1.5 3.4 1 4 1h3.3c.6 0 1.1.5 1.1 1.1 0 1.3.2 2.6.6 3.8.1.4 0 .8-.2 1.1l-2.2 2.2Z','email'=>'M3 5h18a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Zm0 2 9 6 9-6H3Zm18 10V9l-8.4 5.6a1 1 0 0 1-1.2 0L3 9v8h18Z','address'=>'M12 2a7 7 0 0 0-7 7c0 5.1 7 13 7 13s7-7.9 7-13a7 7 0 0 0-7-7Zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5Z','hours'=>'M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm1 5v4.6l3.1 1.8-1 1.7-4.1-2.4V7Z' )[ $item[0] ] ); ?>"></path></svg></span><?php endif; ?>
                <div class="bk-contact-content"><span class="bk-contact-label"><?php echo esc_html( $item[1] ); ?></span><?php if ( $item[3] ) : ?><a class="bk-contact-value" href="<?php echo esc_url( $item[3] ); ?>"><?php echo esc_html( $item[2] ); ?></a><?php else : ?><span class="bk-contact-value"><?php echo esc_html( $item[2] ); ?></span><?php endif; ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
