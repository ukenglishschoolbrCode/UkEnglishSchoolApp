(function( $ ) {

    var rewards_calendar_select2 = {
        ajax: {
            url: ajaxurl,
            dataType: 'json',
            delay: 250,
            type: 'POST',
            data: function( params ) {
                return {
                    q: params.term,
                    action: 'gamipress_daily_login_rewards_get_rewards_calendars_options',
                    nonce: gamipress_daily_login_rewards_admin_widgets.nonce,
                };
            },
            processResults: function( results, page ) {
                if( results === null ) {
                    return { results: [] };
                }

                var formatted_results = [];

                results.data.forEach(function(item) {
                    formatted_results.push({
                        id: item.ID,
                        text: item.post_title + ' (#' + item.ID + ')',
                    });
                });

                return { results: formatted_results };
            }
        },
        theme: 'default gamipress-select2',
        placeholder: gamipress_daily_login_rewards_admin_widgets.rewards_calendar_placeholder,
        allowClear: true,
        multiple: false
    };

    $( 'select[id^="widget-gamipress_rewards_calendar"][id$="[rewards_calendar_id]"]:not(.select2-hidden-accessible)' ).gamipress_select2( rewards_calendar_select2 );

    // Initialize on widgets area
    $(document).on('widget-updated widget-added', function(e, widget) {
        widget.find( 'select[id^="widget-gamipress_rewards_calendar"][id$="[rewards_calendar_id]"]:not(.select2-hidden-accessible)' ).gamipress_select2( rewards_calendar_select2 );
    });

})( jQuery );