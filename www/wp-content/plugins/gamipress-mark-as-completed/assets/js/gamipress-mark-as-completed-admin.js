(function( $ ) {

    // Listen for changes to our trigger type selectors
    $('.requirements-list').on( 'change', '.select-trigger-type', function() {

        // Grab our selected trigger type
        var trigger_type = $(this).val();
        var options = $(this).siblings('.gamipress-mark-as-completed-options');

        options.hide();

        if( trigger_type === 'gamipress_mark_as_completed' ) {
            options.show();

            // Trigger change event in our field
            $(this).siblings('.input-mark-as-completed-show-as').trigger('change');
        }

    });

    // Listen for changes to our field
    $('.requirements-list').on( 'change', '.input-mark-as-completed-show-as', function() {

        var button_options = $(this).siblings('.gamipress-mark-as-completed-button-options');

        button_options.hide();

        if( $(this).val() === 'button' ) {
            button_options.show();
        }

    });

    // Loop requirement list items to show/hide inputs on initial load
    $('.requirements-list li').each(function() {

        // Grab our selected trigger type
        var trigger_type = $(this).find('.select-trigger-type').val();
        var options = $(this).find('.gamipress-mark-as-completed-options');

        options.hide();

        if( trigger_type === 'gamipress_mark_as_completed' ) {
            options.show();

            // Trigger change event in our field
            $(this).find('.input-mark-as-completed-show-as').trigger('change');
        }

    });

    $('.requirements-list').on( 'update_requirement_data', '.requirement-row', function(e, requirement_details, requirement) {

        // Add the custom fields
        if( requirement_details.trigger_type === 'gamipress_mark_as_completed' ) {
            requirement_details.mark_as_completed_show_as = requirement.find( '.input-mark-as-completed-show-as' ).val();
            requirement_details.mark_as_completed_position = requirement.find( '.input-mark-as-completed-position' ).val();
            requirement_details.mark_as_completed_button_text = requirement.find( '.input-mark-as-completed-button-text' ).val();
            requirement_details.mark_as_completed_button_text_completed = requirement.find( '.input-mark-as-completed-button-text-completed' ).val();
        }

    });

})( jQuery );