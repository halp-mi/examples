// Add feedback to user's input on form fields.
(function ($, Drupal, drupalSettings) {
    Drupal.behaviors.exampleForm = {
        attach: function (context, settings) {
            let $exampleFormField = $('.example-form-field');
            let $form = $(".multistep-form");

            // Initialize multistep form
            $form.once().steps({
                headerTag: "h3",
                bodyTag: ".form-section",
                transitionEffect: "slideLeft",
                enableFinishButton: true,
                onStepChanging: function(event, currentIndex, newIndex) {
                    let $fields = $form.find('.form-field');
                    let nextStep = true;

                    $.each($fields, function() {
                        if (!isFieldValid($(this))) {
                            nextStep = false;
                            return false;
                        }
                    });

                    return nextStep;
                },
                onFinished: function(event, currentIndex) {
                    $(".btn-submit")[0].click();
                }
            });

            // Generate an unique id
            function uniqId() {
                return Math.round(new Date().getTime() + (Math.random() * 100));
            }

            // Disable the enter button on all .example-form-field
            $exampleFormField.keypress(function (e) {
                if (e.which === 13) {
                    e.preventDefault();
                    return false;
                }
            });

            $exampleFormField.on('keyup blur', function () {
                let isValid = isFieldValid($(this));
                fieldFeedback($(this), isValid);
            });

            // Validate the field's input
            function isFieldValid($field) {
                let regex = $field.attr('data-example-regex');
                let text = $field.val();

                if (regex && text.length > 0) {
                    let pattern = new RegExp(regex);
                    return pattern.test(text);
                }

                return true;
            }

            function fieldFeedback($field, isValid) {
                let text = $field.val();

                if (text.length > 0) {
                    let errorMsg = '<br>' + $field.attr('data-error-msg');

                    // Find the description field
                    let $desc = $field.siblings('div.description').eq(0);

                    // Get the HTML instead of just the text to avoid overwriting any styling
                    let descText = $desc.html();

                    if (isValid) {
                        $field.css('background', 'rgba(0,255,0,.1)');

                        if (descText.indexOf(errorMsg) > -1) {
                            descText = descText.replace(errorMsg, '');
                            $desc.html(descText);
                            $desc.css('color', 'initial');
                        }
                    }
                    else {
                        $field.css('background', 'rgba(244,67,54,.1)');

                        // Display the error by replacing the entire description field
                        if (descText.indexOf(errorMsg) < 0) {
                            $desc.fadeIn('fast');
                            $desc.css('color', 'red');
                            descText += errorMsg;
                            $desc.html(descText);
                        }
                    }
                }
                else {
                    $field.css('background', 'initial');
                }
            }
        }
    };
})(jQuery, Drupal, drupalSettings);

