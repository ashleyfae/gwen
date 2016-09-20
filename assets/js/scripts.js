jQuery(document).ready(function ($) {

    var Gwen = {

        /**
         * Initialize click events.
         */
        init: function () {
            $('.menu-toggle, .sidebar-toggle').on('click', this.toggleArea);
        },

        /**
         * Toggle areas open/closed. Called on the navigation menu
         * and sidebar area.
         *
         * @param e Click event.
         */
        toggleArea: function (e) {
            e.preventDefault();

            if ($(this).attr('aria-expanded') == 'false') {
                $(this).attr('aria-expanded', 'true');
                $(this).next().addClass('toggled');
            } else {
                $(this).attr('aria-expanded', 'false');
                $(this).next().removeClass('toggled');
            }
        }

    };

    Gwen.init();

});