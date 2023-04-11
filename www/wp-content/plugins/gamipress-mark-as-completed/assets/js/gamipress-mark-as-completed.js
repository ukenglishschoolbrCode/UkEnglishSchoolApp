(function( $ ) {

    // Listen for checkbox changes
    $('body').on('change', '.gamipress-mark-as-completed-checkbox', function( e ) {

        // Don't allow to uncheck this
        if( ! $(this).prop('checked') ) {
            e.preventDefault();
            $(this).prop( 'checked', true );
            return false;
        }

        // Update li classes
        $(this).closest('li').addClass('user-has-earned');

        // Notice about this on ajax
        gamipress_mark_as_completed_ajax( $(this), $(this).data('id') );
    });

    // Listen for button clicks
    $('body').on('click', '.gamipress-mark-as-completed-button', function( e ) {

        var disabled = $(this).data('disabled');

        if( disabled === undefined ) {
            disabled = false;
        }

        if( typeof disabled == 'string' ) {
            disabled = ( disabled === 'true' );
        }

        if( disabled ) {
            e.preventDefault();
            return false;
        }

        // Update button
        $(this).data('disabled', 'true');
        $(this).text($(this).data('text-completed'));

        // Update li classes
        $(this).closest('li').addClass('user-has-earned');

        // Notice about this on ajax
        gamipress_mark_as_completed_ajax( $(this), $(this).data('id') );
    });

    // Notify about the mark as completed through ajax
    function gamipress_mark_as_completed_ajax( element, post_id ) {

        $.ajax({
            url: gamipress_mark_as_completed.ajaxurl,
            method: 'POST',
            data: {
                action: 'gamipress_mark_as_completed',
                nonce: gamipress_mark_as_completed.nonce,
                post_id: post_id,
            },
            success: function( response ) {

                /**
                 * Event mark as completed success
                 * Example: $('body').on( 'gamipress_mark_as_completed_success', '.gamipress-mark-as-completed-checkbox, .gamipress-mark-as-completed-button', function(e) {});
                 *
                 * @since 1.0.0
                 *
                 * @selector    .gamipress-mark-as-completed-checkbox, .gamipress-mark-as-completed-button
                 * @event       gamipress_mark_as_completed_success
                 */
                element.trigger( 'gamipress_mark_as_completed_success' );

                if( response.data.parent_completed ) {

                    if( element.closest('.single-achievement').length ) {

                        // Add the class earned to the achievement on single template
                        element.closest('.single-achievement').addClass('user-has-earned');
                        element.closest('.user-has-not-earned[class*="post"]').removeClass('user-has-not-earned').addClass('user-has-earned');

                    } else if( element.closest('.gamipress-achievement.user-has-not-earned').length ) {

                        // Add the class earned to the achievement on shortcode template
                        element.closest('.gamipress-achievement.user-has-not-earned').removeClass('user-has-not-earned').addClass('user-has-earned');

                    } else if( element.closest('.single-rank').length ) {

                        // Add the class earned to the rank on single template
                        element.closest('.single-rank').addClass('user-has-earned');
                        element.closest('.user-has-not-earned[class*="post"]').removeClass('user-has-not-earned').addClass('user-has-earned');

                    } else if( element.closest('.gamipress-rank.user-has-not-earned').length ) {

                        // Add the class earned to the rank on shortcode template
                        element.closest('.gamipress-rank.user-has-not-earned').removeClass('user-has-not-earned').addClass('user-has-earned');

                    }

                    /**
                     * Event marked as completed parent completed
                     * Example: $('body').on( 'gamipress_mark_as_completed_parent_completed', '.gamipress-mark-as-completed-checkbox, .gamipress-mark-as-completed-button', function(e) {});
                     *
                     * @since 1.0.0
                     *
                     * @selector    .gamipress-mark-as-completed-checkbox, .gamipress-mark-as-completed-button
                     * @event       gamipress_mark_as_completed_parent_completed
                     */
                    element.trigger( 'gamipress_mark_as_completed_parent_completed' );
                }

            }
        });

    }

})( jQuery );