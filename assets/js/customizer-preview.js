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

    // Primary colour
    wp.customize('primary_colour', function (value) {
        value.bind(function (to) {
            $('.entry-title, .page-title, .comments-title, #reply-title, a, .button, button, input[type="submit"], #pagination a, h1, h2, h3, h4, h5, h6, .entry-footer .more-link').css('color', to);

        });
    });

    // Secondary colour
    wp.customize('secondary_colour', function (value) {
        value.bind(function (to) {
            $('#page').css('border-top-color', to);
            $('blockquote').css('border-left-color', to);
            $('.button, button, input[type="submit"], #pagination a').css({
                'background': to,
                'border-color': to
            });
            $('#footer, ol li:before, ul li:before, table thead th').css('background', to);

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