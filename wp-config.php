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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'boxofexpression' );

/** MySQL database username */
define( 'DB_USER', 'boxofexpression' );

/** MySQL database password */
define( 'DB_PASSWORD', '9yLjkRflSiLSt-H3' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '|*?W}L#[uv%]ipz// B$pzn+}E{S1]VM}GOtDVHtJu5Ou6G&zT4jhoE*nE)r/y1e' );
define( 'SECURE_AUTH_KEY',  'W$t__]EjPqU)DFl2g3z_osJ:.aPN=ewO5K8yyu?Nc76qg^k*RV4,KI{`4NX^?e+E' );
define( 'LOGGED_IN_KEY',    'KV$XB-j1/Ppd?Ry$lekue-]tG)SW8ys`3}8ORkNg5.G8!sRkOA[__vJI2 {u8U~4' );
define( 'NONCE_KEY',        'hj49KvC]#gw*(>-jf*Vgs^f)%*y5~p$##;g(@v% ,J[qh<ftDE2~iQcK}Bh88cS+' );
define( 'AUTH_SALT',        'S?M^GNP+h#Fs_rg^MiEl/l{,mC*E9&f(*esw%#^WmDH/bN.SOGY*nd(/lP1nm5+i' );
define( 'SECURE_AUTH_SALT', 'B1h; 6=I7%EA(MFEL;{j`]kBc$4D|OA W#mv)yG,nMy=*o&*e[K^we.+Ui!eX!Hp' );
define( 'LOGGED_IN_SALT',   'z?U{fV-%~ ^4ESV$Y|mjWXu${_|3MHI%$EE6+$wW0f3N f4XJlPn/R`u)+9<g@ib' );
define( 'NONCE_SALT',       '87BNm6WcAS|@wLkbB.|eO4,9> )4na3uR$x;8%~){<` FyP{8])^.W>cD++H5HYx' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
