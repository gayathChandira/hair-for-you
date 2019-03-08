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
define('DB_NAME', 'hair-for-you');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'Dt?OKj{gs)k-?;^J2b;HNvRM!<7btukJZU_qVAFkLDgADb#tyOG[Vbr&sXUG3@N,');
define('SECURE_AUTH_KEY',  'L! *SpmuJ<MpM^!~HbB^^DIS|x7G{(X[XUev2<4V6Rf6.3/diP@>:IZ*:kcb&~y ');
define('LOGGED_IN_KEY',    'CD&v,Tg@w5 .S<c(`H|@&YTutwls)oRRxJHme8Q~$n(^2nkigZR&I2ZNF1EH=}7s');
define('NONCE_KEY',        ']VS0W|L&0WAcQ$KnOeUVL*[:M9uIcxdsf_u-7J_GO.or3wNa]26oOB)TT84`*r~`');
define('AUTH_SALT',        '&@H5&c91-hr8-=(,l w{y0J;mfnm~8)eB$BJZ%hiL(%9x}oU~w@Q|GcG_$ugnO@_');
define('SECURE_AUTH_SALT', 'ckg=:YLu]5UR]ero^9T0i2M6gq]0Y+*pYW)y4O U6wm2]T%!pS0@pG>!,h3)(ybA');
define('LOGGED_IN_SALT',   '#_>`cTFZR`WCVl|pW:r,U56w?OVa`.__)bJHO.S #$?@4~|0=OND451kn^_ptDE;');
define('NONCE_SALT',       'tl>p%uFh1klXt,S0D+8ol`qh0H{BB[7S1g96xYiQ3Q>EGC~MshJhlclCn:au5LB5');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'hair_for_you_';

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

define('WP_ALLOW_REPAIR', true);
