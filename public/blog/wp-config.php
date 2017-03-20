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
define('DB_NAME', 'ndp_blog');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'qwerty');

/** MySQL hostname */
define('DB_HOST', '127.0.0.1');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/** FTP username for updating theme. */
define( 'FTP_USER', 'estatebaron' );

/** FTP password for updating theme. */
define( 'FTP_PASS', 'estatebaronisawesome' );

/** FTP host for updating theme. */
define( 'FTP_HOST', 'ftp.estatebaron.com:21' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '-L z{v4qS*&Bm,t0qpO6zj1>p#$FR9v?{G+F??ga8CQaC#~{(I,IfALz0iNqEtMD');
define('SECURE_AUTH_KEY',  '_:5+)pl`fzCl,L5]P#u8l9v!w{~~>wv43sY;L-8,#a~Kw-IWA-rebBE[vG0KLraL');
define('LOGGED_IN_KEY',    'PS7Qu:>&<H7S1#^NezF9T{ANM/|opW`$U-L3d(T[ -Wg>t4Vsx?KiDb3Imj7MsYU');
define('NONCE_KEY',        'q!~Z6/>1OQ.{6eh!@?d8-.-+qKgNN.a|o/Jf!w_u8gf&5fh!1*%Wt-gy+pfP8Fik');
define('AUTH_SALT',        'U<x]O0pvZ_? JoW}Wp7,k,w<G2TJU^YqDF?0h}Gq`29 iy-4IZhMrT+5Ov-](Q71');
define('SECURE_AUTH_SALT', '}bgn-01uI{s]qS]WFa.u)LA<5ld[:tk!Y={.q6/j13?NEKZ=L@a_[2o4WQDioHqU');
define('LOGGED_IN_SALT',   '^ZUy0n+$1r78w~++1t|?$tBYona?z`m|f`L(#>+~^0 @C4J7CYFQ+P=[@?JcezIo');
define('NONCE_SALT',       'OQt##yuf7YWzj_wP,F(pUQF)wsK2/Z-rdHY+nt|Wc=YyG4)=/i-1,_GL)/i8Sb%W');

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
