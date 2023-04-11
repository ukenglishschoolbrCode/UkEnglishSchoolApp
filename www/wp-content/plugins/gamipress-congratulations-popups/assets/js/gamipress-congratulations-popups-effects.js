/**
 * Show the popup effect
 *
 * @since 1.0.0
 *
 * @param {object} popup The popup element
 */
function gamipress_congratulations_popups_show_effect( popup ) {

    switch ( popup.data('display-effect') ) {
        case 'fireworks':
            setTimeout( function() {
                gamipress_congratulations_popups_show_fireworks( popup, 1 );
            }, 200 );

            setTimeout( function() {
                gamipress_congratulations_popups_show_fireworks( popup, 2 );
            }, 800 );

            setTimeout( function() {
                gamipress_congratulations_popups_show_fireworks( popup, 3 );
            }, 1400 );
            break;
        case 'confetti':
            gamipress_congratulations_popups_show_confetti( popup );
            break;
        case 'stars':
            gamipress_congratulations_popups_show_stars( popup );
            break;
        case 'bubbles':
            gamipress_congratulations_popups_show_bubbles( popup );
            break;
    }

}

/**
 * Confetti fireworks effect
 *
 * @since 1.0.0
 *
 * @param {object} popup The popup element
 */
function gamipress_congratulations_popups_show_fireworks( popup, index ) {

    party.settings.zIndex = 2000;

    popup.css('z-index', 1050);

    if( ! popup.find('.gamipress-congratulations-popup-fireworks-1').length ) {
        popup.append('<div class="gamipress-congratulations-popup-fireworks-1" style="position: absolute; top: 20px; left: 0;"></div>' +
            '<div class="gamipress-congratulations-popup-fireworks-2" style="position: absolute; top: 35px; right: 0;"></div>' +
            '<div class="gamipress-congratulations-popup-fireworks-3" style="position: absolute; top: -10px; left: 50%; right: 50%;"></div>');
    }

    var fireworks = popup.find('.gamipress-congratulations-popup-fireworks-' + index);
    var min = gamipress_congratulations_popups_effects['fireworks']['particles']['min'];
    var max = gamipress_congratulations_popups_effects['fireworks']['particles']['max'];

    party.confetti(fireworks[0], {
        count: party.variation.range( min, max ),
        spread: party.variation.range( 40, 50 ),
        speed: party.variation.range( 300, 600 ),
        shapes: [ "square", "rectangle", "circle" ],
        color: function() {
            var color = popup.data('particles-color');

            if( color.length && color !== '#' ) {
                var hsl = gamipress_congratulations_popups_hex_to_hsl( color );
                return party.Color.fromHsl( hsl.h, hsl.s, party.random.randomRange( Math.max( hsl.l - 15, 0 ), Math.min( hsl.l + 15, 100 ) ) );
            } else {
                return party.Color.fromHsl( party.random.randomRange( 0, 360 ), 90, 60 );
            }

        }
    });

    fireworks.trigger('click');
}

/**
 * Confetti effect
 *
 * @since 1.0.0
 *
 * @param {object} popup The popup element
 */
function gamipress_congratulations_popups_show_confetti( popup ) {
    party.settings.zIndex = 2000;

    popup.css('z-index', 1050);

    if( ! popup.find('.gamipress-congratulations-popup-confetti').length ) {
        popup.append('<div class="gamipress-congratulations-popup-confetti" style="position: absolute; top: 20px; width: 100%;"></div>');
    }

    var confetti = popup.find('.gamipress-congratulations-popup-confetti');
    var min = gamipress_congratulations_popups_effects['confetti']['particles']['min'];
    var max = gamipress_congratulations_popups_effects['confetti']['particles']['max'];

    party.confetti(confetti[0], {
        count: party.variation.range( min, max ),
        spread: party.variation.range( 60, 70 ),
        speed: party.variation.range( 600, 800 ),
        shapes: [ "square", "rectangle", "circle" ],
        color: function() {
            var color = popup.data('particles-color');

            if( color.length && color !== '#' ) {
                var hsl = gamipress_congratulations_popups_hex_to_hsl( color );
                return party.Color.fromHsl( hsl.h, hsl.s, party.random.randomRange( Math.max( hsl.l - 15, 0 ), Math.min( hsl.l + 15, 100 ) ) );
            } else {
                return party.Color.fromHsl( party.random.randomRange( 0, 360 ), 90, 60 );
            }
        }
    });

    confetti.trigger('click');

}

/**
 * Stars effect
 *
 * @since 1.0.0
 *
 * @param {object} popup The popup element
 */
function gamipress_congratulations_popups_show_stars( popup ) {
    party.settings.zIndex = 2000;

    popup.css('z-index', 3000);

    var min = gamipress_congratulations_popups_effects['stars']['particles']['min'];
    var max = gamipress_congratulations_popups_effects['stars']['particles']['max'];

    party.sparkles(popup[0], {
        lifetime: party.variation.range( 1, 2 ),
        count: party.variation.range( min, max ),
        speed: party.variation.range( 200, 300 ),
        shapes: [ "star" ],
        color: function () {
            var color = popup.data('particles-color');

            if( ! color.length || color === '#' ) {
                color = '#FFE566';
            }

            var hsl = gamipress_congratulations_popups_hex_to_hsl( color );
            return party.Color.fromHsl( hsl.h, hsl.s, party.random.randomRange( Math.max( hsl.l - 15, 0 ), Math.min( hsl.l + 15, 100 ) ) );
        },
    });

    popup.trigger('click');
}

/**
 * Bubbles effect
 *
 * @since 1.0.0
 *
 * @param {object} popup The popup element
 */
function gamipress_congratulations_popups_show_bubbles( popup ) {
    party.settings.zIndex = 2000;

    popup.css('z-index', 3000);

    var min = gamipress_congratulations_popups_effects['bubbles']['particles']['min'];
    var max = gamipress_congratulations_popups_effects['bubbles']['particles']['max'];

    party.sparkles(popup[0], {
        lifetime: party.variation.range( 1, 2 ),
        count: party.variation.range( min, max ),
        speed: party.variation.range( 200, 300 ),
        shapes: [ "circle" ],
        color: function () {
            var color = popup.data('particles-color');

            if( ! color.length || color === '#' ) {
                color = '#667AFF';
            }

            var hsl = gamipress_congratulations_popups_hex_to_hsl( color );
            return party.Color.fromHsl( hsl.h, hsl.s, party.random.randomRange( Math.max( hsl.l - 15, 0 ), Math.min( hsl.l + 15, 100 ) ) );
        },
    });

    popup.trigger('click');
}

/**
 * Convert hex to HSL
 *
 * @since 1.0.0
 *
 * @param {string} H The color in hex format
 */
function gamipress_congratulations_popups_hex_to_hsl(H) {
    // Convert hex to RGB first
    let r = 0, g = 0, b = 0;
    if (H.length == 4) {
        r = "0x" + H[1] + H[1];
        g = "0x" + H[2] + H[2];
        b = "0x" + H[3] + H[3];
    } else if (H.length == 7) {
        r = "0x" + H[1] + H[2];
        g = "0x" + H[3] + H[4];
        b = "0x" + H[5] + H[6];
    }
    // Then to HSL
    r /= 255;
    g /= 255;
    b /= 255;
    let cmin = Math.min(r,g,b),
        cmax = Math.max(r,g,b),
        delta = cmax - cmin,
        h = 0,
        s = 0,
        l = 0;

    if (delta == 0)
        h = 0;
    else if (cmax == r)
        h = ((g - b) / delta) % 6;
    else if (cmax == g)
        h = (b - r) / delta + 2;
    else
        h = (r - g) / delta + 4;

    h = Math.round(h * 60);

    if (h < 0)
        h += 360;

    l = (cmax + cmin) / 2;
    s = delta == 0 ? 0 : delta / (1 - Math.abs(2 * l - 1));
    s = +(s * 100).toFixed(1);
    l = +(l * 100).toFixed(1);

    return {
        h: h,
        s: s,
        l: l,
    };
}