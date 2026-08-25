<?php
/**
 * Baran Khanomy - Home Enhancements
 * Fourth benefit item, persistent hero image, and benefit sizing.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'admin_init', function() {
    register_setting( 'bk_core_settings_group', 'bk_benefit4_settings', array(
        'sanitize_callback' => function( $input ) {
            $input = is_array( $input ) ? $input : array();
            return array(
                'icon'  => isset( $input['icon'] ) ? esc_url_raw( $input['icon'] ) : '',
                'title' => isset( $input['title'] ) ? sanitize_text_field( $input['title'] ) : '',
                'text'  => isset( $input['text'] ) ? sanitize_text_field( $input['text'] ) : '',
            );
        },
        'default' => array( 'icon' => '', 'title' => '', 'text' => '' ),
    ) );
} );

add_action( 'admin_enqueue_scripts', function( $hook ) {
    if ( 'toplevel_page_bk-core-settings' !== $hook ) return;
    wp_enqueue_media();
} );

add_action( 'admin_footer', function() {
    if ( ! isset( $_GET['page'] ) || 'bk-core-settings' !== sanitize_key( wp_unslash( $_GET['page'] ) ) ) return;
    $settings = wp_parse_args( get_option( 'bk_benefit4_settings', array() ), array( 'icon' => '', 'title' => '', 'text' => '' ) );
    ?>
    <script>
    jQuery(function($){
        var table = $('h2').filter(function(){ return $.trim($(this).text()) === 'آمار و مزیت‌ها'; }).next('table.form-table');
        if (!table.length) return;
        table.append(
            '<tr><th scope="row">مزیت چهارم - آیکن</th><td><div class="bk-benefit4-media">' +
            '<input type="hidden" name="bk_benefit4_settings[icon]" class="bk-benefit4-icon" value="<?php echo esc_js( $settings['icon'] ); ?>">' +
            '<div class="bk-benefit4-preview" style="margin-bottom:10px"><?php if ( $settings['icon'] ) : ?><img src="<?php echo esc_url( $settings['icon'] ); ?>" style="max-width:90px;max-height:90px;object-fit:contain;border-radius:10px" alt=""><?php endif; ?></div>' +
            '<button type="button" class="button bk-benefit4-select">انتخاب / آپلود</button> ' +
            '<button type="button" class="button bk-benefit4-remove">حذف</button></div></td></tr>' +
            '<tr><th scope="row"><label for="bk-benefit4-title">مزیت چهارم - عنوان</label></th><td><input class="regular-text" id="bk-benefit4-title" type="text" name="bk_benefit4_settings[title]" value="<?php echo esc_attr( $settings['title'] ); ?>"></td></tr>' +
            '<tr><th scope="row"><label for="bk-benefit4-text">مزیت چهارم - توضیح</label></th><td><input class="regular-text" id="bk-benefit4-text" type="text" name="bk_benefit4_settings[text]" value="<?php echo esc_attr( $settings['text'] ); ?>"></td></tr>'
        );
        $(document).on('click','.bk-benefit4-select',function(e){
            e.preventDefault();
            var frame = wp.media({ title:'انتخاب آیکن مزیت چهارم', button:{text:'استفاده از تصویر'}, multiple:false, library:{type:'image'} });
            frame.on('select',function(){ var a=frame.state().get('selection').first().toJSON(); $('.bk-benefit4-icon').val(a.url); $('.bk-benefit4-preview').html('<img src="'+a.url.replace(/"/g,'&quot;')+'" style="max-width:90px;max-height:90px;object-fit:contain;border-radius:10px" alt="">'); });
            frame.open();
        });
        $(document).on('click','.bk-benefit4-remove',function(e){e.preventDefault();$('.bk-benefit4-icon').val('');$('.bk-benefit4-preview').empty();});
    });
    </script>
    <?php
} );

add_filter( 'pre_update_option_bk_core_settings', function( $value, $old_value ) {
    if ( is_array( $old_value ) && ! empty( $old_value['hero_image'] ) && is_array( $value ) && empty( $value['hero_image'] ) ) {
        $value['hero_image'] = $old_value['hero_image'];
    }
    return $value;
}, 10, 2 );

add_action( 'wp_head', function() {
    if ( ! is_front_page() ) return;
    $benefit = wp_parse_args( get_option( 'bk_benefit4_settings', array() ), array( 'icon' => '', 'title' => '', 'text' => '' ) );
    $icon = $benefit['icon'] ? esc_url( $benefit['icon'] ) : '';
    $title = esc_html( $benefit['title'] );
    $text = esc_html( $benefit['text'] );
    ?>
    <style id="bk-home-benefits-enhancements">
        .bk-benefits-grid{grid-template-columns:repeat(4,1fr)!important;min-height:118px!important}
        .bk-benefits-grid>div{min-width:0;padding:12px 16px;gap:16px!important}
        .bk-benefit-icon{width:90px!important;height:90px!important;min-width:90px!important;min-height:90px!important;display:grid!important;place-items:center!important;font-size:52px!important;line-height:1!important}
        .bk-benefit-icon img{display:block!important;width:90px!important;height:90px!important;max-width:90px!important;max-height:90px!important;object-fit:contain!important}
        .bk-benefit-copy strong{font-size:16px!important;line-height:1.6!important;display:block!important}
        .bk-benefit-copy small{font-size:12px!important;line-height:1.8!important;display:block!important}
        @media(max-width:1000px){.bk-benefits-grid{grid-template-columns:repeat(2,1fr)!important}.bk-benefits-grid>div:nth-child(2){border-left:0!important}}
        @media(max-width:760px){.bk-benefits-grid{grid-template-columns:1fr!important}.bk-benefits-grid>div{padding:12px 10px!important}.bk-benefit-icon,.bk-benefit-icon img{width:80px!important;height:80px!important;min-width:80px!important;min-height:80px!important;max-width:80px!important;max-height:80px!important}.bk-benefit-copy strong{font-size:15px!important}.bk-benefit-copy small{font-size:11px!important}}
    </style>
    <script>
    document.addEventListener('DOMContentLoaded',function(){
        var grid=document.querySelector('.bk-benefits-grid');
        if(!grid || grid.querySelector('[data-bk-benefit-four]')) return;
        var item=document.createElement('div');
        item.className='bk-benefit-item';
        item.setAttribute('data-bk-benefit-four','1');
        item.innerHTML='<div class="bk-benefit-icon"><?php echo $icon ? '<img src="'.esc_attr( $icon ).'" alt="">' : '<span aria-hidden="true">✦</span>'; ?></div><div class="bk-benefit-copy"><strong><?php echo $title; ?></strong><small><?php echo $text; ?></small></div>';
        grid.appendChild(item);
    });
    </script>
    <?php
}, 99 );
