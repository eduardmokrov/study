(function ($) {
    // Add Upgrade Message
    if ('undefined' !== typeof matrix_button) {
        webhunt = $('<a class="prefix-webhunt-link" target="_blank"></a>')
            .attr('href', matrix_button.prefixURL)
            .attr('target', '_blank')
            .text(matrix_button.prefixLabel)
            .css({
                'display': 'inline-block',
                'background-color': 'rgb(231, 76, 60)',
                'color': '#fff',
                'text-transform': 'uppercase',
                'margin-top': '6px',
                'padding': '3px 6px',
                'font-size': '9px',
                'letter-spacing': '1px',
                'line-height': '1.5',
                'clear': 'both'
            })
        ;
        setTimeout(function () {
            $('.preview-notice').append(webhunt);
            $('#customize-info .preview-notice').append('<p style="color: #cc0000">'+matrix_button.proDesc+'</p>');
            $('.customize-panel-back').css('height', '97px');
        }, 200);
        // Remove accordion click event
        $('.prefix-webhunt-link').on('click', function (e) {
            e.stopPropagation();
        });
    }
})(jQuery);