// Add functionality to close messages
(function ($, Drupal) {
    Drupal.behaviors.exampleAlertMessage = {
        attach: function (context, settings) {
            $('.messages i').once().click(function () {
                $(this).closest('.messages').fadeOut('fast');
            });
        }
    };
})(jQuery, Drupal);