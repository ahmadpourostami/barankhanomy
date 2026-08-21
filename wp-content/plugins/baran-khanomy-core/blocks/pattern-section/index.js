( function ( blocks, element, blockEditor, components, data ) {
    const el = element.createElement;
    const Fragment = element.Fragment;
    const useBlockProps = blockEditor.useBlockProps;
    const InspectorControls = blockEditor.InspectorControls;
    const PanelBody = components.PanelBody;
    const SelectControl = components.SelectControl;
    const Spinner = components.Spinner;
    const useSelect = data.useSelect;

    function Edit( props ) {
        const patternId = props.attributes.patternId || 0;
        const setAttributes = props.setAttributes;
        const patterns = useSelect( function( select ) {
            return select( 'core' ).getEntityRecords( 'postType', 'wp_block', {
                per_page: 100,
                orderby: 'title',
                order: 'asc'
            } );
        }, [] );

        const options = [ { label: '— انتخاب الگو —', value: 0 } ];
        if ( patterns ) {
            patterns.forEach( function( pattern ) {
                options.push( { label: pattern.title && pattern.title.rendered ? pattern.title.rendered : 'الگوی بدون عنوان', value: pattern.id } );
            } );
        }

        const selected = patterns && patterns.find( function( item ) { return item.id === patternId; } );
        const blockProps = useBlockProps( { className: 'bk-pattern-section-editor' } );

        return el( Fragment, null,
            el( InspectorControls, null,
                el( PanelBody, { title: 'الگوی فوتر / بخش ذخیره‌شده', initialOpen: true },
                    patterns ? el( SelectControl, {
                        label: 'الگوی موردنظر',
                        value: patternId,
                        options: options,
                        onChange: function( value ) { setAttributes( { patternId: parseInt( value, 10 ) || 0 } ); }
                    } ) : el( Spinner, null )
                )
            ),
            el( 'div', blockProps,
                selected ? el( 'div', { className: 'bk-pattern-section-placeholder' }, 'الگوی «' + ( selected.title && selected.title.rendered ? selected.title.rendered : 'بدون عنوان' ) + '» در اینجا نمایش داده می‌شود.' ) : el( 'div', { className: 'bk-pattern-section-empty' }, 'یک الگوی ذخیره‌شده را از تنظیمات بلوک انتخاب کنید.' )
            )
        );
    }

    blocks.registerBlockType( 'baran-khanomy/pattern-section', { edit: Edit, save: function() { return null; } } );
} )( window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components, window.wp.data );
