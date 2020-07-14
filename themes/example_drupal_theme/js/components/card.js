(function ($, Drupal, drupalSettings) {
    Drupal.behaviors.exampleCardFilter = {
        attach: function (context, settings) {
            let $inputFilter = $('.example-input-filter');

            if ($inputFilter.length) {
                $inputFilter.focus();

                if ($inputFilter.hasClass('example-ui-card-search')) {
                    $inputFilter.keyup(function () {
                        let input = this.value;
                        let targetId = $(this).attr('data-example-target');
                        exampleFilterCard(input, targetId);
                    });
                }
            }

            /**
             *
             * @param input, the user's input
             * @param targetCardContainerId, the parent container
             */
            function exampleFilterCard(input, targetCardContainerId) {
                let $exampleTarget = $('#' + targetCardContainerId);
                let $exampleCards = $exampleTarget.find('.example-card');
                let $exampleCardContainer = $exampleTarget.find('.example-menu-container');

                if (input.length > 0) {
                    // Find all text
                    let text, index;

                    $exampleCards.each(function (key, card) {
                        text = card.innerText;
                        index = text.toUpperCase().indexOf(input.toUpperCase());
                        index > -1 ? $(this).show() : $(this).fadeOut('fast');

                        if (index > -1) {
                            $(this).show();
                            $(this).closest('details').show();
                        }
                        else {
                            $(this).fadeOut('fast');
                            if (!$(this).siblings('.example-card:visible').length) {
                                $(this).closest('details').hide();
                            }
                        }
                    });
                }
                else {
                    $exampleCards.fadeIn('fast');
                    $exampleCardContainer.fadeIn('fast');
                }
            }
        }
    };
})(jQuery, Drupal, drupalSettings);
