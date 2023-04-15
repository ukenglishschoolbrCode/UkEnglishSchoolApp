<?php
define( 'WP_CACHE', true );

/**

 * The base configuration for WordPress

 *

 * The wp-config.php creation script uses this file during the installation.

 * You don't have to use the web site, you can copy this file to "wp-config.php"

 * and fill in the values.

 *

 * This file contains the following configurations:

 *

 * * Database settings

 * * Secret keys

 * * Database table prefix

 * * ABSPATH

 *

 * @link https://wordpress.org/support/article/editing-wp-config-php/

 *

 * @package WordPress

 */



// ** Database settings - You can get this info from your web host ** //

/** The name of the database for WordPress */

define( 'DB_NAME', 'ukinglesonline2' );



/** Database username */

define( 'DB_USER', 'ukinglesonline2' );



/** Database password */

define( 'DB_PASSWORD', '3UewaJw!$LzDfXR9@' );



/** Database hostname */

define( 'DB_HOST', 'localhost' );



/** Database charset to use in creating database tables. */

define( 'DB_CHARSET', 'utf8' );



/** The database collate type. Don't change this if in doubt. */

define( 'DB_COLLATE', '' );



/**#@+

 * Authentication unique keys and salts.

 *

 * Change these to different unique phrases! You can generate these using

 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.

 *

 * You can change these at any point in time to invalidate all existing cookies.

 * This will force all users to have to log in again.

 *

 * @since 2.6.0

 */

define('AUTH_KEY',         'KgD^iJ*eEXuW;bVb[],4wSS|!5vwZg+l+f0o?nW=3.;p`%g|-w!z;zc=p-Y&d$>K');
define('SECURE_AUTH_KEY',  'GmfF3R~u/g?hB $K#/-1gU(O61^>>zf1T^adh=EO-(XS^-6*@dX(m01IkZGqlf v');
define('LOGGED_IN_KEY',    ':>Q`1URlb-GS;f}_8+nqv1Ql$ ,N>~pXjTGN?l)Bw$>mh}=$v#n3hRvHGi.@YJ?:');
define('NONCE_KEY',        '`aN90<b]LYr^#NOCMeh;253-=>:Fk8?V3k|&IrSj3~+{5J`oyYCS&Vuu|C6-HMX#');
define('AUTH_SALT',        '-~T+qp?9r1--3qY5cEw!rLq6+nD4,i_I1qM{[YGA$j ^QZXrZ8g~W;5P#8&GUKY7');
define('SECURE_AUTH_SALT', '$|#D|tPfb70-A+4:+p-JFl UwO^QCE8@b}0en>+cGRFciNChMAG?/k]$@M-8PYFT');
define('LOGGED_IN_SALT',   'pI++2,#9sMhR^V$8|f3z4iN$w$keg+seS0V_B4M+y;b/HsHFO:%5?E>QM) 2@S.T');
define('NONCE_SALT',       '`$lmU+8+QtWZcpKWT -pz5O|=a3m5c+C9l.)58+C1RXFA&!#cWCW9xp`lgvPh|bV');


/**#@-*/



/**

 * WordPress database table prefix.

 *

 * You can have multiple installations in one database if you give each

 * a unique prefix. Only numbers, letters, and underscores please!

 */

$table_prefix = 'ufzwq_';



/**

 * For developers: WordPress debugging mode.

 *

 * Change this to true to enable the display of notices during development.

 * It is strongly recommended that plugin and theme developers use WP_DEBUG

 * in their development environments.

 *

 * For information on other constants that can be used for debugging,

 * visit the documentation.

 *

 * @link https://wordpress.org/support/article/debugging-in-wordpress/

 */

define( 'WP_DEBUG', false );
define('WP_POST_REVISIONS', 2);



/* Add any custom values between this line and the "stop editing" line. */







/* That's all, stop editing! Happy publishing. */



/** Absolute path to the WordPress directory. */

if ( ! defined( 'ABSPATH' ) ) {

	define( 'ABSPATH', __DIR__ . '/' );

}



/** Sets up WordPress vars and included files. */

require_once ABSPATH . 'wp-settings.php';
//Disable File Edits
define('DISALLOW_FILE_EDIT', false);