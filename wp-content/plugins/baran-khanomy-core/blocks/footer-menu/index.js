( function ( blocks, element, blockEditor, components ) {
    const el = element.createElement;
    const Fragment = element.Fragment;
    const useBlockProps = blockEditor.useBlockProps;
    const InspectorControls = blockEditor.InspectorControls;
    const PanelBody = components.PanelBody;
    const SelectControl = components.SelectControl;
    const TextControl = components.TextControl;
    const ToggleControl = components.ToggleControl;
    const Placeholder = components.Placeholder;
    const useSelect = wp.data.useSelect;

    function Edit( props ) {
        const a = props.attributes;
        const setAttributes = props.setAttributes;
        const menus = useSelect( function( select ) {
            return select( 'core' ).getEntityRecords( 'root', 'menu', { per_page: 100 } );
        }, [] ) || [];
        const options = [ { label: 'انتخاب منو...', value: 0 } ].concat( menus.map( function( menu ) {
            return { label: menu.name, value: menu.id };
        } ) );
        const selected = menus.find( menu => Number( menu.id ) === Number( a.menuId ) );
        const blockProps = useBlockProps( { className: 'bk-footer-menu-editor' } );

        return el( Fragment, null,
            el( InspectorControls, null,
                el( PanelBody, { title: 'تنظیمات منوی فوتر', initialOpen: true },
                    el( SelectControl, { label: 'منو', value: a.menuId, options: options, onChange: v => setAttributes( { menuId: Number( v ) } ) } ),
                    el( TextControl, { label: 'عنوان', value: a.title, placeholder: 'لینک‌های مهم', onChange: v => setAttributes( { title: v } ) } ),
                    el( SelectControl, { label: 'سبک نمایش', value: a.style, options: [ { label: 'لیست مینیمال', value: 'list' }, { label: 'کارت‌دار', value: 'cards' } ], onChange: v => setAttributes( { style: v } ) } ),
                    el( ToggleControl, { label: 'نمایش فلش کنار لینک‌ها', checked: a.showArrow, onChange: v => setAttributes( { showArrow: v } ) } ),
                    el( SelectControl, { label: 'تراز', value: a.alignment, options: [ { label: 'راست', value: 'right' }, { label: 'وسط', value: 'center' }, { label: 'چپ', value: 'left' } ], onChange: v => setAttributes( { alignment: v } ) } )
                )
            ),
            el( 'div', blockProps,
                a.title && el( 'div', { className: 'bk-footer-menu-title' }, a.title ),
                selected ? el( 'div', { className: 'bk-footer-menu-preview bk-footer-menu-' + a.style },
                    el( 'strong', null, selected.name ),
                    el( 'div', null, 'منوی انتخاب‌شده در سایت نمایش داده می‌شود.' )
                ) : el( Placeholder, { icon: 'menu-alt3', label: 'منوی فوتر باران خانومی', instructions: 'از تنظیمات بلوک یک منوی وردپرس انتخاب کنید.' } )
            )
        );
    }
    blocks.registerBlockType( 'baran-khanomy/footer-menu', { edit: Edit, save: function() { return null; } } );
} )( window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components );
