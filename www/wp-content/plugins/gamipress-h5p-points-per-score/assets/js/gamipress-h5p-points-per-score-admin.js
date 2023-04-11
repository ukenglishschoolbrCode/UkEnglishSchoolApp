(function($) {

    var prefix = '_gamipress_h5p_points_per_score_';

    // Award points listener
    $('#' + prefix + 'award_points').on('change', function() {
        if( $(this).prop('checked') ) {
            $(this).closest('.cmb-row').siblings('.cmb-row').show();
        } else {
            $(this).closest('.cmb-row').siblings('.cmb-row').hide();
        }
    });

    $('#' + prefix + 'award_points').trigger('change');

})(jQuery);