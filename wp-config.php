<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'javaby');

/** MySQL database username */
define('DB_USER', 'javaby');

/** MySQL database password */
define('DB_PASSWORD', 'dyb2a0vkzTxh');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '`S=!SOR*Eu]:ge`_t4v.Rx:#^l~K|ui+Cr9Kk!gN<[znaPm]9a?D0:|SWh301Ip@');
define('SECURE_AUTH_KEY',  ';N(qQ]Qz-rc&`dG-X,l+NXxC-XlI;.?hh8$~F%()/lGXz~}J*#e!znp{Nr%bg}/4');
define('LOGGED_IN_KEY',    ',X~hW#7M([]Q(wd2&N _Y~5P!o2av;|NO(Ur$1*{#&K@Z) q0D!$PuxzHUe*`dK2');
define('NONCE_KEY',        'Z@(BokfEdw[7=x-ogll{!~]fR6m/UW)nO. Z$BLi|h!1TM%Zq@^O311uwGalLX`j');
define('AUTH_SALT',        '*-HvP^|L}`)%(2d x~S}cOTvg E2dH`y3%EY 1:G#n?Q;Up`+c_]W dp4ks.mdLK');
define('SECURE_AUTH_SALT', 'H)RV5|U|g;D=RBe-@pGMB@!{4:GZ> e]sBi}Dv2i] l@7Nh[S1tAq$[On0tB3jdW');
define('LOGGED_IN_SALT',   '/H3K1_QwQsYc^L0ziyN#@}X[A24UDl)rN^#]3?*-Ak3.9~j4vXXkjA}8VRgI9`sb');
define('NONCE_SALT',       '$RDYuvfK4tUQ5xF;J*P9NBCg*8j9&vY2i0_^mUvca(&fNVm=WqX75!;:!. ~R<=x');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
