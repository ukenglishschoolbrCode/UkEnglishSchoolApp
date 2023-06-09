(function( $ ) {

    var initial_load = true;

    // Periodicity visibility
    $('body').on('change', '#_gamipress_admin_emails_condition', function() {

        var points = $('.cmb2-id--gamipress-admin-emails-points');
        var achievement_type = $('.cmb2-id--gamipress-admin-emails-achievement-type');
        var achievement = $('.cmb2-id--gamipress-admin-emails-achievement');
        var rank = $('.cmb2-id--gamipress-admin-emails-rank');

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

    $('#_gamipress_admin_emails_condition').trigger('change');

})( jQuery );