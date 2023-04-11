(function( $ ) {

    if( $('.gamipress-daily-login-popup').length ) {

        var overlay = $('.gamipress-daily-login-overlay');

        setTimeout( function() {

            var first_popup = $('.gamipress-daily-login-popup').first();

            // Add the last-earned class to the last earned calendar reward
            first_popup.find('.user-has-earned').last().addClass('last-earned');

            // Add the current-reward class to the first not earned calendar reward
            first_popup.find('.user-has-not-earned').first().addClass('current-reward');

            // Show the popup and the overlay
            overlay.fadeIn( 500 );
            first_popup.fadeIn( 500 );

        }, 300 );

        $('.gamipress-daily-login-popup-button, .gamipress-daily-login-overlay').on('click', function() {

            var current_popup = $('.gamipress-daily-login-popup:visible');
            var rewards_calendar_id = current_popup.attr('id').replace('gamipress-daily-login-popup-', '');

            // Hide this popup
            current_popup.fadeOut( 500, function() {

                if( $('.gamipress-daily-login-popup:not(#gamipress-daily-login-popup-' + rewards_calendar_id + ')').length ) {

                    var next_popup = $(this).next('.gamipress-daily-login-popup');

                    // Add the last-earned class to the last earned calendar reward
                    next_popup.find('.user-has-earned').last().addClass('last-earned');

                    // Add the current-reward class to the first not earned calendar reward
                    next_popup.find('.user-has-not-earned').first().addClass('current-reward');

                    // Show the next popup
                    next_popup.fadeIn( 500 )

                } else {
                    // There is no more popups, so hide overlay too
                    overlay.fadeOut( 500 );
                }

                // Remove current popup
                $(this).remove();
            } );

            // Make a request to update an user meta
            $.ajax({
                url: gamipress_daily_login_rewards.ajaxurl,
                data: {
                    action: 'gamipress_daily_login_rewards_calendar_shown',
                    nonce: gamipress_daily_login_rewards.nonce,
                    rewards_calendar_id: rewards_calendar_id
                },
                success: function( response ) {
                    console.log(response);
                }
            });
        });

    }

})( jQuery );