<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'webtmdt' );

/** MySQL database username */
define( 'DB_USER', 'webtmdt' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Binh2810' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         '-Czst)TPk8S(%7>0FQ=v?!B*}FJFro R|b}2;R^2ngVMqNr(FTdrx|sJKN&`lNpU' );
define( 'SECURE_AUTH_KEY',  '9?n8jjtQvJ=9IU=g&T|yVy%<14t0(y%-`5hR+{e_Qy7[N9 Wjk9Dwfx1+3=^GI8.' );
define( 'LOGGED_IN_KEY',    'z4pKAW[QWiX[g% #Cv(WWd)j5|=PxfMo=0}<J*[:IZ<TtqPi:2iRTIQtyP-?Y Y;' );
define( 'NONCE_KEY',        'l))cQiHQX<lIvib`5JJvs/upxMm3nfbHx)c#pewW80eId^Y(j8Q8Y]~W`J{2 >i@' );
define( 'AUTH_SALT',        'HnO!6|9C[dqKX|na-*Q%v>&pK^| i(B82:|g^Z/gCOH0gIOS(Tg%Cj-mxmbN<>3S' );
define( 'SECURE_AUTH_SALT', 'n/{lPsWvKBU[:rT{?_([W@75]-hVLeGyVc|;DYV<K+bzj&}C;XEgp1t_3zb8Q^:f' );
define( 'LOGGED_IN_SALT',   'Z(Y}kh4r#dY#:AwfRoDr_DKX6&fRL5}(>G_S%W<,<y@bt=!dLmjzgvw7AjalQ#9I' );
define( 'NONCE_SALT',       'm|(yR&;SD~56q*Y=nF3tbgQ+^2><9D5fV}.L)rBif?KcQt^.P]N+=<[tXTSNQTj5' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}
// define('ALLƠ_UNFILTERED_UOLOASD', true);

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
