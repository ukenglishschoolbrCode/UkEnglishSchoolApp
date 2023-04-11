(function( $ ) {

    function gamipress_progress_map_update_horizontal_center() {

        // Repositionate horizontal center progress map
        $('.gamipress-progress-map-horizontal.gamipress-progress-map-center').each(function() {
            var $this = $(this);
            var bar = $this.find('.gamipress-progress-map-bar');
            var completed_bar = $this.find('.gamipress-progress-map-completed-bar');

            // First get max even height
            var max_even_height = 0;

            $this.find('.gamipress-progress-map-item:even').each(function () {
                $(this).css({ height: 'auto' });
                if( $(this).outerHeight( true ) > max_even_height ) {
                    max_even_height = $(this).outerHeight( true );
                }
            });

            // Apply max even height to even items, bar and completed bar
            $this.find('.gamipress-progress-map-item:even').css({height: max_even_height + 'px'});
            bar.css({top: max_even_height + 'px'});
            completed_bar.css({top: max_even_height + 'px'});

            // Get max odd height
            var max_odd_height = 0;

            $this.find('.gamipress-progress-map-item:odd').each(function () {
                // Apply max even height to odd items
                $(this).css({top: max_even_height + 'px'});

                if( $(this).outerHeight( true ) > max_odd_height ) {
                    max_odd_height = $(this).outerHeight( true );
                }
            });

            $this.css({height: ( max_even_height + max_odd_height + 20 ) + 'px'});
        });

    }

    function gamipress_progress_map_update_horizontal_completion_bars() {

        $('.gamipress-progress-map-horizontal:not(.no-recalculate)').each(function() {
            var $this = $(this);
            var bar = $this.find('.gamipress-progress-map-bar');
            var completed_bar = $this.find('.gamipress-progress-map-completed-bar');
            var last_completed = $this.find('.gamipress-progress-map-completed').last();

            // TODO: Not fixable with CSS
            bar.css({ width: $this[0].scrollWidth + 'px' });

            if( last_completed.length ) {

                var next = last_completed.next('.gamipress-progress-map-item.gamipress-progress-map-incompleted');

                if( next.length ) {
                    // Progress completed until next item
                    completed_bar.css({ width: ( ( next.offset().left - $this.offset().left ) + 40 ) + 'px' });
                } else {
                    // Full completed
                    completed_bar.css({ width: $this[0].scrollWidth + 'px' });
                    $this.addClass('no-recalculate');
                }

            } else {
                // Nothing completed
                completed_bar.css({ width: '0px' });
                $this.addClass('no-recalculate');
            }
        });

    }

    function gamipress_progress_map_update_vertical_completion_bars() {

        // Vertical
        $('.gamipress-progress-map-vertical:not(.no-recalculate)').each(function() {
            var $this = $(this);
            var completed_bar = $this.find('.gamipress-progress-map-completed-bar');
            var last_completed = $this.find('.gamipress-progress-map-completed').last();

            if( last_completed.length ) {

                var next = last_completed.next('.gamipress-progress-map-item.gamipress-progress-map-incompleted');

                if( next.length ) {
                    // Progress completed until next item
                    completed_bar.css({ height: ( ( next.offset().top - $this.offset().top ) + 40 ) + 'px' });
                } else {
                    // Full completed
                    completed_bar.css({ height: '100%' });
                    $this.addClass('no-recalculate');
                }
            } else {
                // Nothing completed
                completed_bar.css({ height: '0px' });
                $this.addClass('no-recalculate');
            }

        });

    }


    gamipress_progress_map_update_horizontal_completion_bars();
    gamipress_progress_map_update_vertical_completion_bars();

    // Add an interval to recalculate position on collapse/expand steps
    if( $('.gamipress-progress-map-horizontal.gamipress-progress-map-center').length ) {
        gamipress_progress_map_update_horizontal_center();

        setInterval( gamipress_progress_map_update_horizontal_center, 100 );
    }

    if( $('.gamipress-progress-map-vertical:not(.no-recalculate)').length ) {
        setInterval( gamipress_progress_map_update_vertical_completion_bars, 100 );
    }
})( jQuery );