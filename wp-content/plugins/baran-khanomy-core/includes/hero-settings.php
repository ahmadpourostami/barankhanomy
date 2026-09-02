<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Extra hero controls kept in a separate option so the existing core settings
 * remain backwards compatible. The image is intentionally independent from
 * the hero CTA link.
 */
function bk_hero_extra_defaults() {
    return array(
        'image' => '',
        'button_text' => 'از اینجا شروع کن',
        'button_url' => '',
    );
}

function bk_hero_extra_get( $key = null ) {
    $settings = wp_parse_args( get_option( 'bk_hero_extra', array() ), bk_hero_extra_defaults() );
    return null === $key ? $settings : ( isset( $settings[ $key ] ) ? $settings[ $key ] : '' );
}

add_action( 'admin_init', function() {
    register_setting( 'bk_core_settings_group', 'bk_hero_extra', array(
        'type'              => 'array',
        'sanitize_callback' => function( $input ) {
            $input = is_array( $input ) ? $input : array();
            return array(
                'image'       => isset( $input['image'] ) ? esc_url_raw( $input['image'] ) : '',
                'button_text' => isset( $input['button_text'] ) ? sanitize_text_field( $input['button_text'] ) : 'از اینجا شروع کن',
                'button_url'  => isset( $input['button_url'] ) ? esc_url_raw( $input['button_url'] ) : '',
            );
        },
        'default' => bk_hero_extra_defaults(),
    ) );
} );

add_action( 'wp_head', function() {
    if ( ! is_front_page() ) return;
    ?>
    <style id="bk-hero-start-inline">
        .bk-hero-start{position:absolute;left:32px;bottom:28px;z-index:5;min-height:48px;padding:0 24px;border-radius:13px;display:inline-flex;align-items:center;justify-content:center;background:var(--bk-gold);color:#2b2330;font-size:13px;font-weight:800;box-shadow:0 10px 25px rgba(43,35,48,.14);transition:transform .2s ease,box-shadow .2s ease}
        .bk-hero-start:hover{transform:translateY(-2px);box-shadow:0 14px 30px rgba(43,35,48,.18);color:#2b2330}
        @media(max-width:760px){.bk-hero-start{left:18px;bottom:18px;min-height:44px;padding:0 18px;font-size:12px}}
    </style>
    <?php
} );

add_action( 'admin_footer', function() {
    $screen = get_current_screen();
    if ( ! $screen || 'toplevel_page_baran-khanomy-theme-settings' !== $screen->id ) return;
    $settings = bk_hero_extra_get();
    ?>
    <script>
    jQuery(function($){
        const form = $('.wrap form[action="options.php"]');
        if (!form.length || form.find('[data-bk-hero-extra]').length) return;
        const html = `
        <h2 data-bk-hero-extra>دکمه هیرو</h2>
        <table class="form-table" role="presentation" data-bk-hero-extra>
            <tr><th scope="row"><label for="bk-hero-extra-image">تصویر هیرو</label></th><td>
                <input type="hidden" id="bk-hero-extra-image" name="bk_hero_extra[image]" value="<?php echo esc_attr( $settings['image'] ); ?>">
                <div class="bk-hero-extra-preview" style="margin-bottom:10px"><?php if ( $settings['image'] ) : ?><img src="<?php echo esc_url( $settings['image'] ); ?>" alt="" style="display:block;max-width:220px;max-height:120px;border-radius:12px;object-fit:cover;"><?php endif; ?></div>
                <button type="button" class="button bk-hero-extra-select">انتخاب / آپلود تصویر</button>
                <button type="button" class="button bk-hero-extra-remove" <?php echo $settings['image'] ? '' : 'style="display:none"'; ?>>حذف</button>
            </td></tr>
            <tr><th scope="row"><label for="bk-hero-extra-text">متن دکمه</label></th><td><input class="regular-text" type="text" id="bk-hero-extra-text" name="bk_hero_extra[button_text]" value="<?php echo esc_attr( $settings['button_text'] ); ?>"></td></tr>
            <tr><th scope="row"><label for="bk-hero-extra-url">لینک دکمه</label></th><td><input class="large-text" type="url" id="bk-hero-extra-url" name="bk_hero_extra[button_url]" value="<?php echo esc_attr( $settings['button_url'] ); ?>" placeholder="https://example.com/"><p class="description">لینک مقصد دکمه «از اینجا شروع کن» را وارد کنید.</p></td></tr>
        </table>`;
        const heading = form.find('h2').first();
        if (heading.length) heading.after(html); else form.prepend(html);

        form.on('click', '.bk-hero-extra-select', function(e){
            e.preventDefault();
            const frame = wp.media({title:'انتخاب تصویر هیرو', button:{text:'استفاده از تصویر'}, multiple:false, library:{type:'image'}});
            frame.on('select', function(){
                const a = frame.state().get('selection').first().toJSON();
                $('#bk-hero-extra-image').val(a.url);
                $('.bk-hero-extra-preview').html('<img src="'+a.url.replace(/"/g,'&quot;')+'" alt="" style="display:block;max-width:220px;max-height:120px;border-radius:12px;object-fit:cover;">');
                $('.bk-hero-extra-remove').show();
            });
            frame.open();
        });
        form.on('click', '.bk-hero-extra-remove', function(e){
            e.preventDefault();
            $('#bk-hero-extra-image').val('');
            $('.bk-hero-extra-preview').empty();
            $(this).hide();
        });
    });
    </script>
    <?php
} );
