/**
 * Theme Customizer
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function ($) {

    var currentTime = new Date();

    // Site title and description.
    wp.customize('blogname', function (value) {
        value.bind(function (to) {
            $('.site-title a').text(to);
        });
    });
    wp.customize('blogdescription', function (value) {
        value.bind(function (to) {
            $('.site-description').text(to);
        });
    });

    // Header text color.
    wp.customize('header_textcolor', function (value) {
        value.bind(function (to) {
            if ('blank' === to) {
                $('.site-title a, .site-description').css({
                    'clip': 'rect(1px, 1px, 1px, 1px)',
                    'position': 'absolute'
                });

                $('body').addClass('hidden-header-text');
            } else {
                $('.site-title a, .site-description').css({
                    'color': to,
                    'clip': 'auto',
                    'position': 'relative'
                });

                $('body').removeClass('hidden-header-text');
            }
        });
    });

    // Background colour.
    wp.customize('background_color', function (value) {
        value.bind(function (to) {
            $('.entry-title > a, .entry-title > span').css({
                'background-color': to,
                'border-right-color': to
            });
        });
    });

    // Affiliate ID
    wp.customize('affiliate_id', function (value) {
        value.bind(function (to) {
            if (to) {
                $('#gwen-credits a').attr('href', 'https://shop.nosegraze.com/product/gwen-theme/?ref=' + to);
            } else {
                $('#gwen-credits a').attr('href', 'https://shop.nosegraze.com/product/gwen-theme/');
            }
        });
    });

    // Copyright
    wp.customize('copyright_message', function (value) {
        value.bind(function (to) {
            var newValue = to.replace('[current-year]', currentTime.getFullYear());
            $('#gwen-copyright').empty().append(newValue);
        });
    });

})(jQuery);