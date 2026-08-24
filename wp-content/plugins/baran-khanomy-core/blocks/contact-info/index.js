( function ( blocks, element, blockEditor, components ) {
    const el = element.createElement;
    const Fragment = element.Fragment;
    const useBlockProps = blockEditor.useBlockProps;
    const InspectorControls = blockEditor.InspectorControls;
    const PanelBody = components.PanelBody;
    const TextControl = components.TextControl;
    const ToggleControl = components.ToggleControl;
    const SelectControl = components.SelectControl;

    function Icon( name ) {
        const paths = {
            phone: 'M6.6 10.8c1.5 3 3.6 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1.1-.2 1.2.4 2.5.6 3.8.6.6 0 1.1.5 1.1 1.1V20c0 .6-.5 1.1-1.1 1.1C11.4 21.1 2.9 12.6 2.9 2.1 2.9 1.5 3.4 1 4 1h3.3c.6 0 1.1.5 1.1 1.1 0 1.3.2 2.6.6 3.8.1.4 0 .8-.2 1.1l-2.2 2.2Z',
            email: 'M3 5h18a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Zm0 2 9 6 9-6H3Zm18 10V9l-8.4 5.6a1 1 0 0 1-1.2 0L3 9v8h18Z',
            address: 'M12 2a7 7 0 0 0-7 7c0 5.1 7 13 7 13s7-7.9 7-13a7 7 0 0 0-7-7Zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5Z',
            hours: 'M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm1 5v4.6l3.1 1.8-1 1.7-4.1-2.4V7Z'
        };
        return el( 'svg', { viewBox: '0 0 24 24', 'aria-hidden': true }, el( 'path', { d: paths[name] } ) );
    }

    function Edit( props ) {
        const a = props.attributes;
        const setAttributes = props.setAttributes;
        const items = [
            [ 'phone', 'تلفن', a.phone ],
            [ 'email', 'ایمیل', a.email ],
            [ 'address', 'آدرس', a.address ],
            [ 'hours', 'ساعات پاسخگویی', a.hours ]
        ];
        const blockProps = useBlockProps( { className: 'bk-contact-info-editor' } );
        return el( Fragment, null,
            el( InspectorControls, null,
                el( PanelBody, { title: 'اطلاعات تماس', initialOpen: true },
                    el( TextControl, { label: 'عنوان', value: a.title, onChange: v => setAttributes( { title: v } ) } ),
                    el( TextControl, { label: 'شماره تماس', value: a.phone, placeholder: '۰۹۱۲۱۲۳۴۵۶۷', onChange: v => setAttributes( { phone: v } ) } ),
                    el( TextControl, { label: 'ایمیل', value: a.email, placeholder: 'info@example.com', onChange: v => setAttributes( { email: v } ) } ),
                    el( TextControl, { label: 'آدرس', value: a.address, placeholder: 'تهران، ...', onChange: v => setAttributes( { address: v } ) } ),
                    el( TextControl, { label: 'ساعات پاسخگویی', value: a.hours, placeholder: 'شنبه تا پنجشنبه، ۹ تا ۱۸', onChange: v => setAttributes( { hours: v } ) } ),
                    el( ToggleControl, { label: 'نمایش آیکن‌ها', checked: a.showIcons, onChange: v => setAttributes( { showIcons: v } ) } ),
                    el( SelectControl, { label: 'تراز', value: a.alignment, options: [ { label: 'راست', value: 'right' }, { label: 'وسط', value: 'center' }, { label: 'چپ', value: 'left' } ], onChange: v => setAttributes( { alignment: v } ) } )
                )
            ),
            el( 'div', blockProps,
                a.title && el( 'div', { className: 'bk-contact-title' }, a.title ),
                el( 'div', { className: 'bk-contact-items bk-contact-align-' + a.alignment }, items.filter( item => item[2] ).map( item =>
                    el( 'div', { className: 'bk-contact-item', key: item[0] },
                        a.showIcons && el( 'span', { className: 'bk-contact-icon' }, Icon( item[0] ) ),
                        el( 'div', { className: 'bk-contact-content' }, el( 'span', { className: 'bk-contact-label' }, item[1] ), el( 'span', { className: 'bk-contact-value' }, item[2] ) )
                    )
                ) ),
                !items.some( item => item[2] ) && el( 'div', { className: 'bk-contact-empty' }, 'اطلاعات تماس را از تنظیمات بلوک وارد کنید.' )
            )
        );
    }

    blocks.registerBlockType( 'baran-khanomy/contact-info', { edit: Edit, save: function () { return null; } } );
} )( window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components );
