(function (blocks, element, blockEditor, components, data) {
    var el = element.createElement;
    var Fragment = element.Fragment;
    var InspectorControls = blockEditor.InspectorControls;
    var PanelBody = components.PanelBody;
    var RangeControl = components.RangeControl;
    var SelectControl = components.SelectControl;
    var TextControl = components.TextControl;
    var ToggleControl = components.ToggleControl;
    var useSelect = data.useSelect;

    blocks.registerBlockType('baran-khanomy/tutor-course-grid', {
        edit: function (props) {
            var a = props.attributes;
            var categories = useSelect(function (select) {
                return select('core').getEntityRecords('taxonomy', 'course-category', { per_page: 100, hide_empty: false });
            }, []);
            var options = [{ label: 'همه دسته‌ها', value: '' }];
            if (categories) categories.forEach(function (cat) { options.push({ label: cat.name, value: String(cat.id) }); });

            var controls = el(InspectorControls, {},
                el(PanelBody, { title: 'تنظیمات گرید دوره', initialOpen: true },
                    el(RangeControl, { label: 'تعداد دوره', value: a.postsPerPage, onChange: function (v) { props.setAttributes({ postsPerPage: v || 4 }); }, min: 1, max: 12 }),
                    el(RangeControl, { label: 'تعداد ستون', value: a.columns, onChange: function (v) { props.setAttributes({ columns: v || 4 }); }, min: 1, max: 4 }),
                    el(SelectControl, { label: 'دسته‌بندی', value: a.category, options: options, onChange: function (v) { props.setAttributes({ category: v }); } }),
                    el(ToggleControl, { label: 'نمایش عنوان', checked: a.showTitle, onChange: function (v) { props.setAttributes({ showTitle: v }); } }),
                    a.showTitle ? el(TextControl, { label: 'عنوان بخش', value: a.title, onChange: function (v) { props.setAttributes({ title: v }); } }) : null,
                    el(ToggleControl, { label: 'نمایش نقطه‌های اسلایدر', checked: a.showDots, onChange: function (v) { props.setAttributes({ showDots: v }); } }),
                    el(ToggleControl, { label: 'نمایش دکمه همه دوره‌ها', checked: a.showMoreButton, onChange: function (v) { props.setAttributes({ showMoreButton: v }); } }),
                    a.showMoreButton ? el(TextControl, { label: 'متن دکمه', value: a.moreButtonText, onChange: function (v) { props.setAttributes({ moreButtonText: v }); } }) : null
                )
            );

            return el(Fragment, {}, controls,
                el('div', { className: 'bk-block-course-grid-preview' },
                    a.showTitle ? el('div', { className: 'bk-section-title' }, el('span', {}, 'پیشنمایش'), el('h2', {}, a.title)) : null,
                    el('div', { className: 'bk-course-grid', style: { gridTemplateColumns: 'repeat(' + a.columns + ', minmax(0, 1fr))' } },
                        el('div', { className: 'bk-course-card bk-block-placeholder-card' }, el('div', { className: 'bk-course-image' }), el('div', { className: 'bk-course-body' }, el('h3', {}, 'دوره نمونه Tutor LMS'), el('div', { className: 'bk-course-price' }, el('strong', {}, '۴۵۰,۰۰۰ تومان')), el('a', { className: 'bk-course-link' }, 'مشاهده دوره ←'))),
                        el('div', { className: 'bk-course-card bk-block-placeholder-card' }, el('div', { className: 'bk-course-image' }), el('div', { className: 'bk-course-body' }, el('h3', {}, 'دوره نمونه Tutor LMS'), el('div', { className: 'bk-course-price' }, el('strong', {}, '۳۸۰,۰۰۰ تومان')), el('a', { className: 'bk-course-link' }, 'مشاهده دوره ←'))),
                        el('div', { className: 'bk-course-card bk-block-placeholder-card' }, el('div', { className: 'bk-course-image' }), el('div', { className: 'bk-course-body' }, el('h3', {}, 'دوره نمونه Tutor LMS'), el('div', { className: 'bk-course-price' }, el('strong', {}, '۲۹۰,۰۰۰ تومان')), el('a', { className: 'bk-course-link' }, 'مشاهده دوره ←')))
                    )
                )
            );
        },
        save: function () { return null; }
    });
})(window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components, window.wp.data);
