// Add in help functionality. Scroll to the selected content.
(function ($, Drupal, drupalSettings) {
    Drupal.behaviors.help = {
        attach: function (context, settings) {
            $('.help').once().hover(function () {
                let targetEl = $(this).attr('data-target');
                $(targetEl).addClass('outline');

                let targetField = $(this).attr('data-target');
                $(targetField).addClass('active');

                let scrollTop = $(targetField).first().offset().top;
                let speed = (Math.abs(scrollTop)) * 1.5;
                speed = speed < 2000 ? speed : 2000;

                $('html, body').animate({scrollTop: scrollTop}, speed);
            }, function () {
                let targetField = $(this).attr('data-target');
                $(targetField).removeClass('active');
            });

            let $el = $('<a class="to-top"><i class="fa fa-arrow-circle-up"></i></a>');

            $el.click(function () {
                let $helpDiv = $('details.help').first();
                let scrollTop = ($('details.help summary').first().offset().top);
                let speed = (Math.abs(scrollTop)) * 1.5;
                speed = speed < 2000 ? speed : 2000;

                $helpDiv.animate({scrollTop: scrollTop}, speed);
            });

            $('details.help').once().append($el);
        }
    };
})(jQuery, Drupal, drupalSettings);
