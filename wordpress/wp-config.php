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
define( 'DB_NAME', 'example_db' );

/** Database username */
define( 'DB_USER', 'admin' );

/** Database password */
define( 'DB_PASSWORD', '@del13Phikos' );

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
define( 'AUTH_KEY',         ')3l$,>oi=jKReZh?9Gr~HN|d6!%_1]~m<P}2<>2EBniE_pyv[=IGT@3N0xJ/Aa=M' );
define( 'SECURE_AUTH_KEY',  '.s$Vi>u#/]{#KPC.N52b23_t}QPp9i^buUs_F^z$mtR>*`@gdDq(_x9$=QeYsT&X' );
define( 'LOGGED_IN_KEY',    'fe:kTpi-|pb{VeQ3r8r-oJP|taI^S/~e$&RR^Uip4j._yt H+{7P[06LG(5ox9;9' );
define( 'NONCE_KEY',        ',zj%q oc0][bgy70/QS.E*%t)$1=(1!UFi+e;8 g:FQd~U)A##h[,+f>O9@*-1R@' );
define( 'AUTH_SALT',        'a nPiF9m!lmG+,H/*Zd8 V{<[_m9{*yS5}S&RWzB#^}UTW5pQl~zb*<MX#zq`G7|' );
define( 'SECURE_AUTH_SALT', '^J8O{C+{A$SROA*r#._Nt1R}~AL$Q#.ln:gqwoDr6l}G|G_XK!YALXoii;w^^v&g' );
define( 'LOGGED_IN_SALT',   '6&2Aoy%,dteYw-F55eC;<P?+vaiklYnshobCtQG3XdwV <Rdv9epr%T[26e5(Vb8' );
define( 'NONCE_SALT',       'vGDem&{/wI`Z#M3;HI<N(%Y0&~zf#k+uyQxp&pLxx-H{$!;Q+86e2f*V|m:t* dH' );

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

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
