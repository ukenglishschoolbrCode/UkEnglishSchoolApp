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
                    nonce: gamipress_daily_login_rewards_shortcode_editor.nonce,
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
        placeholder: gamipress_daily_login_rewards_shortcode_editor.rewards_calendar_placeholder,
        allowClear: true,
        multiple: false
    };

    $( '#gamipress_rewards_calendar_id' ).gamipress_select2( rewards_calendar_select2 );

})( jQuery );