(function( $ ) {

    var initial_load = true;

    // Style visibility
    $('body').on('change', '#_gamipress_congratulations_popups_display_effect', function() {

        var show_cb = ( initial_load ? 'show' : 'slideDown' );
        var hide_cb = ( initial_load ? 'hide' : 'slideUp' );

        if( $(this).val() === 'none' ) {
            $('.cmb2-id--gamipress-congratulations-popups-particles-color')[hide_cb]();
            $('.cmb2-id--gamipress-congratulations-popups-preview')[hide_cb]();
        } else {
            $('.cmb2-id--gamipress-congratulations-popups-particles-color')[show_cb]();
            $('.cmb2-id--gamipress-congratulations-popups-preview')[show_cb]();
        }

    });

    $('#_gamipress_congratulations_popups_display_effect').trigger('change');

    // Condition visibility
    $('body').on('change', '#_gamipress_congratulations_popups_condition', function() {

        var points = $('.cmb2-id--gamipress-congratulations-popups-points');
        var achievement_type = $('.cmb2-id--gamipress-congratulations-popups-achievement-type');
        var achievement = $('.cmb2-id--gamipress-congratulations-popups-achievement');
        var rank = $('.cmb2-id--gamipress-congratulations-popups-rank');

        var show_cb = ( initial_load ? 'show' : 'slideDown' );
        var hide_cb = ( initial_load ? 'hide' : 'slideUp' );

        switch( $(this).val() ) {
            case 'points-balance':
                points[show_cb]();
                achievement_type[hide_cb]();
                achievement[hide_cb]();
                rank[hide_cb]();
                break;
            case 'specific-rank':
                points[hide_cb]();
                achievement_type[hide_cb]();
                achievement[hide_cb]();
                rank[show_cb]();
                break;
            case 'specific-achievement':
                points[hide_cb]();
                achievement_type[hide_cb]();
                achievement[show_cb]();
                rank[hide_cb]();
                break;
            case 'any-achievement':
                points[hide_cb]();
                achievement_type[show_cb]();
                achievement[hide_cb]();
                rank[hide_cb]();
                break;
            case 'all-achievements':
                points[hide_cb]();
                achievement_type[show_cb]();
                achievement[hide_cb]();
                rank[hide_cb]();
                break;
        }

        initial_load = false;

    });

    $('#_gamipress_congratulations_popups_condition').trigger('change');

    // Preview
    $('body').on('click', '.gamipress-congratulations-popup-preview-button', function() {

        $('.cmb2-id--gamipress-congratulations-popups-preview .gamipress-congratulations-popup-wrapper').data( 'display-effect', $('#_gamipress_congratulations_popups_display_effect').val() );
        $('.cmb2-id--gamipress-congratulations-popups-preview .gamipress-congratulations-popup-wrapper').data( 'particles-color', $('#_gamipress_congratulations_popups_particles_color').val() );

        gamipress_congratulations_popups_show_effect( $(this).prev() );
    });

})( jQuery );