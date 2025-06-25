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
define( 'DB_NAME', 'vinyl' );

/** Database username */
define( 'DB_USER', 'user' );

/** Database password */
define( 'DB_PASSWORD', 'password' );

/** Database hostname */
define( 'DB_HOST', 'mysql' );

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
define( 'AUTH_KEY',         'a@LBVh8|t,+{oGv(QetXob;9NP8+[~)DFEWJgg.GqGyCH1>P$[QG?EpuQ?i=0E(T' );
define( 'SECURE_AUTH_KEY',  'Y<)O8LqHZ&j:a8TxC&t{{H91{~OWL~~4;55>bU+Gh$%|swS[Tx{obfa@M|-=tU8?' );
define( 'LOGGED_IN_KEY',    'Bb;hROD*MYiTwIsrP uNsLz,=IX:Hp&y^+BegUeM;}OAsbb![IDp[<C0.`z%g8dr' );
define( 'NONCE_KEY',        '7F#cvgXU&w}ax}Ylxs;GkjCFDI0SBqh*R _Tsh<pQd.p:W>g$]C]Ej@yY%}fJikl' );
define( 'AUTH_SALT',        '~_}O+|g>Nz1,&[q0=Y4,GqGHgO57H|%DI*RQ//uHh:<DySlzH}l%;C3[Ocrk<,f1' );
define( 'SECURE_AUTH_SALT', 'ku?9cHEi?,nw_IRn}nC{r ?yyU%;&SK^xuU9vJ}>gXWVO1a|h!1*S@D41T6MIj=$' );
define( 'LOGGED_IN_SALT',   'N%tV.=YHip%~~+z^6Pk|`Yq%e>KXOQw!2.yy^Yr)K7V)WL|u1e1-:vVUbN*.J/(g' );
define( 'NONCE_SALT',       'W_U<Q)!>:cJblXuLad`$6b(&HoZW[H#uGUC>|[:Qy8|2_`0Z?b]xLYT!>lemon9Q' );

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
