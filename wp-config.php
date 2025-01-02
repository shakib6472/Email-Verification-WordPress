<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'byro123' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
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
define( 'AUTH_KEY',         'B@{NXRMlv<_f`)EGa#.UuhBg/Q0jGuYL8*UKue^lZYd;WBs<Ixm6*Z[|hR!y2Y%j' );
define( 'SECURE_AUTH_KEY',  'A&,0a^uQK%@Kkj1xv:LS/l+fjZGw{C)?&RX(o*pE@HLD|3S4/kvg_fX&[K3Omm*x' );
define( 'LOGGED_IN_KEY',    'I*x,dqv^WdZi+}f 1~~fB[Kl[0x0ij9yfq3TU_*l$yt5|:W^=Ea<u@{ZY0uyo?OL' );
define( 'NONCE_KEY',        '.B_Px%V=]E|EhKG&o?&i!zX+7`YlIdH&)l8M 0cpzmGfFqc7cDPvFim&GJBJ]~K?' );
define( 'AUTH_SALT',        ';xSu.|Ytd+4>)dvxUIE0dl@Od<NQiyB(;+X&n6Txc=Qmp;-E/+,TRx~V4&b~P(${' );
define( 'SECURE_AUTH_SALT', 'HpRbvO%hKsZjJS92kmDbE{AG:|hE2DSE[#LW0zHt(U:/@w88(6O1H2t(u%$|eXjx' );
define( 'LOGGED_IN_SALT',   '|#2,I&qIQFbSfbCY_zxC38I>CA/8K.(:#rWvGxzAG0vab`5#P/kT;-=0{M{2&H@Q' );
define( 'NONCE_SALT',       '1ts{l$n90t;YC:6cale2z Li1^f sB9%3$3-- #r c%009o3QOM5Y2eT^LI?o]Ci' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
