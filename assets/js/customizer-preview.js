/**
 * Theme Customizer
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function ($) {

    var currentTime = new Date();

    // Header image
    wp.customize('header_image', function (value) {
        value.bind(function (to) {
            var banner = $('#site-banner');

            // Check if we're removing the image.
            if (to == 'remove-header') {
                banner.remove();

                return;
            }

            if (banner.length > 0) {
                banner.find('img').attr('src', to);
            } else {
                $('.site-branding').prepend('<a href="' + '" rel="home" id="site-banner"><img src="' + to + '" alt=""></a>');
            }
        });
    });

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
            } else {
                $('.site-title a, .site-description').css({
                    'clip': 'auto',
                    'position': 'relative'
                });

                $('.site-title a').css('color', to);
            }
        });
    });

    // Featured image
    wp.customize('auto_add_featured', function (value) {
        value.bind(function (to) {
            if (to) {
                $('.featured-image').show();
            } else {
                $('.featured-image').hide();
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