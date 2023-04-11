(function( $ ) {

    // on change progress map type, change fields visibility
    $('.cmb2-id--gamipress-progress-map-type select').on('change', function() {

        var type = $(this).val();

        var achievements = $('.cmb2-id--gamipress-progress-map-achievements');
        var achievement_type = $('.cmb2-id--gamipress-progress-map-achievement-type');
        var achievements_tab = $('#progress-map-display-options-tab-achievement');

        var ranks = $('.cmb2-id--gamipress-progress-map-ranks');
        var rank_type = $('.cmb2-id--gamipress-progress-map-rank-type');
        var ranks_tab = $('#progress-map-display-options-tab-rank');

        achievements.hide();
        achievement_type.hide();
        achievements_tab.hide();
        ranks.hide();
        rank_type.hide();
        ranks_tab.hide();

        switch( type ) {
            case 'specific-achievements':
                achievements.show();
                achievements_tab.show();
                break;
            case 'all-achievements':
                achievement_type.show();
                achievements_tab.show();
                break;
            case 'specific-ranks':
                ranks.show();
                ranks_tab.show();
                break;
            case 'all-ranks':
                rank_type.show();
                ranks_tab.show();
                break;
        }

    }).trigger('change');

    // On change progress map direction, change alignment fields visibility

    $('.cmb2-id--gamipress-progress-map-direction input').on('change', function() {
        var direction = $(this).closest('.cmb2-id--gamipress-progress-map-direction').find('input:checked').val();
        var target = $('.cmb2-id--gamipress-progress-map-alignment');
        var target_checked = target.find('input:checked');
        var target_checked_val = target.find('input:checked').val();

        if( direction === 'vertical' ) {
            // Toggle visibility top left and right
            target.find('input[value="left"], input[value="right"]').parent().show();
            target.find('input[value="top"], input[value="bottom"]').parent().hide();

            // Toggle center class to vertical
            target.find('input[value="center"]').parent().removeClass('horizontal').addClass('vertical');

            if( target_checked_val === 'top' ) {

                // if top checked, turn it to left
                target_checked.prop('checked', false);
                target.find('input[value="left"]').prop('checked', true);

            } else if( target_checked_val === 'bottom' ) {

                // if bottom checked, turn it to right
                target_checked.prop('checked', false);
                target.find('input[value="right"]').prop('checked', true);

            }
        } else if( direction === 'horizontal' ) {
            // Toggle visibility top topp and bottom
            target.find('input[value="left"], input[value="right"]').parent().hide();
            target.find('input[value="top"], input[value="bottom"]').parent().show();

            // Toggle center class to horizontal
            target.find('input[value="center"]').parent().removeClass('vertical').addClass('horizontal');

            if( target_checked_val === 'left' ) {

                // if left checked, turn it to top
                target_checked.prop('checked', false);
                target.find('input[value="top"]').prop('checked', true);

            } else if( target_checked_val === 'right' ) {

                // if right checked, turn it to bottom
                target_checked.prop('checked', false);
                target.find('input[value="bottom"]').prop('checked', true);

            }
        }
    });

    // Trigger change on initially checked direction option

    $('.cmb2-id--gamipress-progress-map-direction input:checked').trigger('change');

})( jQuery );