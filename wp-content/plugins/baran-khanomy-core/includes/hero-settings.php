<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/** Dedicated hero settings: image, button text and button URL. */
function bk_hero_extra_defaults() {
    return array(
        'image'       => '',
        'button_text' => 'از اینجا شروع کن',
        'button_url'  => '',
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
        .bk-hero-grid{position:relative}
        .bk-hero-start{position:absolute;right:32px;left:auto;bottom:28px;z-index:5;min-height:48px;padding:0 24px;border-radius:13px;display:inline-flex;align-items:center;justify-content:center;background:var(--bk-gold);color:#2b2330;font-size:13px;font-weight:800;box-shadow:0 10px 25px rgba(43,35,48,.14);transition:transform .2s ease,box-shadow .2s ease}
        .bk-hero-start:hover{transform:translateY(-2px);box-shadow:0 14px 30px rgba(43,35,48,.18);color:#2b2330}
        @media(max-width:760px){.bk-hero-start{right:18px;left:auto;bottom:18px;min-height:44px;padding:0 18px;font-size:12px}}
    </style>
    <?php
} );

/**
 * Keep all hero controls in the existing "هیرو" section of the Baran Khanomy
 * settings page, displayed as one row on desktop.
 */
add_action( 'admin_footer', function() {
    $screen = get_current_screen();
    if ( ! $screen || 'toplevel_page_baran-khanomy-theme-settings' !== $screen->id ) return;

    $settings = bk_hero_extra_get();
    ?>
    <style id="bk-hero-admin-style">
        .bk-hero-settings-table{width:100%;border-collapse:separate;border-spacing:12px 0;margin-top:4px}
        .bk-hero-settings-table td{padding:0;vertical-align:top;width:33.333%}
        .bk-hero-setting-card{background:#fff;border:1px solid #dcdcde;border-radius:12px;padding:14px;min-height:150px;box-sizing:border-box}
        .bk-hero-setting-card label{display:block;font-weight:600;margin-bottom:8px}
        .bk-hero-setting-card input[type=text],.bk-hero-setting-card input[type=url]{width:100%;box-sizing:border-box}
        .bk-hero-preview{height:86px;margin-bottom:10px;border-radius:9px;background:#f6f7f7;display:flex;align-items:center;justify-content:center;overflow:hidden}
        .bk-hero-preview img{display:block;width:100%;height:100%;object-fit:cover}
        .bk-hero-preview-empty{color:#646970;font-size:12px;text-align:center;padding:10px}
        .bk-hero-setting-actions{display:flex;gap:6px;align-items:center;flex-wrap:wrap}
        .bk-hero-setting-help{display:block;color:#646970;font-size:11px;margin-top:7px}
        @media(max-width:900px){.bk-hero-settings-table{border-spacing:0;display:block}.bk-hero-settings-table tbody,.bk-hero-settings-table tr{display:block}.bk-hero-settings-table td{display:block;width:100%;margin-bottom:12px}.bk-hero-setting-card{min-height:0}}
    </style>
    <script>
    jQuery(function($){
        const form = $('.wrap form[action="options.php"]');
        if (!form.length) return;

        const heroHeading = form.find('h2').filter(function(){
            return $.trim($(this).text()) === 'هیرو';
        }).first();
        if (!heroHeading.length || heroHeading.data('bkHeroReady')) return;
        heroHeading.data('bkHeroReady', true);

        // Remove the old image-only row and replace it with the complete hero row.
        heroHeading.next('table.form-table').remove();

        const image = <?php echo wp_json_encode( $settings['image'] ); ?>;
        const buttonText = <?php echo wp_json_encode( $settings['button_text'] ); ?>;
        const buttonUrl = <?php echo wp_json_encode( $settings['button_url'] ); ?>;
        const esc = value => $('<div>').text(value || '').html();
        const preview = image
            ? '<img src="' + esc(image) + '" alt="">'
            : '<div class="bk-hero-preview-empty">هنوز تصویری انتخاب نشده است</div>';

        const html = `
        <table class="bk-hero-settings-table" role="presentation" data-bk-hero-extra>
            <tbody><tr>
                <td><div class="bk-hero-setting-card">
                    <label for="bk-hero-extra-image">تصویر هیرو</label>
                    <div class="bk-hero-preview">${preview}</div>
                    <input type="hidden" id="bk-hero-extra-image" name="bk_hero_extra[image]" value="${esc(image)}">
                    <div class="bk-hero-setting-actions">
                        <button type="button" class="button bk-hero-extra-select">انتخاب / آپلود تصویر</button>
                        <button type="button" class="button bk-hero-extra-remove" ${image ? '' : 'style="display:none"'}>حذف</button>
                    </div>
                </div></td>
                <td><div class="bk-hero-setting-card">
                    <label for="bk-hero-extra-text">متن دکمه</label>
                    <input class="regular-text" type="text" id="bk-hero-extra-text" name="bk_hero_extra[button_text]" value="${esc(buttonText)}">
                    <span class="bk-hero-setting-help">متنی که روی دکمه هیرو نمایش داده می‌شود.</span>
                </div></td>
                <td><div class="bk-hero-setting-card">
                    <label for="bk-hero-extra-url">لینک دکمه</label>
                    <input class="large-text" type="url" id="bk-hero-extra-url" name="bk_hero_extra[button_url]" value="${esc(buttonUrl)}" placeholder="https://example.com/">
                    <span class="bk-hero-setting-help">مقصد دکمه «از اینجا شروع کن» را وارد کنید.</span>
                </div></td>
            </tr></tbody>
        </table>`;

        heroHeading.after(html);

        form.on('click', '.bk-hero-extra-select', function(e){
            e.preventDefault();
            const frame = wp.media({title:'انتخاب تصویر هیرو',button:{text:'استفاده از تصویر'},multiple:false,library:{type:'image'}});
            frame.on('select', function(){
                const attachment = frame.state().get('selection').first().toJSON();
                $('#bk-hero-extra-image').val(attachment.url);
                $('.bk-hero-preview').html('<img src="'+String(attachment.url).replace(/"/g,'&quot;')+'" alt="">');
                $('.bk-hero-extra-remove').show();
            });
            frame.open();
        });

        form.on('click', '.bk-hero-extra-remove', function(e){
            e.preventDefault();
            $('#bk-hero-extra-image').val('');
            $('.bk-hero-preview').html('<div class="bk-hero-preview-empty">هنوز تصویری انتخاب نشده است</div>');
            $(this).hide();
        });
    });
    </script>
    <?php
} );
