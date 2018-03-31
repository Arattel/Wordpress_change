<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'spital_base');

/** MySQL database username */
define('DB_USER', 'spital_root');

/** MySQL database password */
define('DB_PASSWORD', 'mn140373');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         '97&v%~yM%_.[vabkk3g$$~LYatyB._3WfL=`BdBYSXk~|^~,8hl>N K<rDs6U e}');
define('SECURE_AUTH_KEY',  'JTN8aY%+,=aS[ZZlV@GmjyB=}7_5dQY+3-iC)i!rdCkkpWPhaD`&PgIbP$x#(B^9');
define('LOGGED_IN_KEY',    'HF?(D3zD~r|6mS_AeA`l@4|@#30(9oFOFhy+R3d#[S_-95xT+=rT$^N.nsiNpL1b');
define('NONCE_KEY',        '{M I)ISBoZY:B*79([00dT=poD2J?Dx.r+YULkMB|?Ql4e!yZ2B>gzI`e)QeZ$1`');
define('AUTH_SALT',        'cipL=% TF<;GJA|{X8JE}1|5BL6LB:IR>cQEMQD/7R%2Q(13z?L}=xqf~Ue?vD!6');
define('SECURE_AUTH_SALT', '02Xi*tdrhe#s8qj!4RV7IT?,hud_WI5rOo/=v+(&pj>(I`i D)B~W]i`7::J{1FQ');
define('LOGGED_IN_SALT',   'D8Gu5A23-mE5$WNI@N)<N|?~)Il.t) &3o)+#J}(^BFD?jhnCyIX{b,M/c/1k!H.');
define('NONCE_SALT',       '+vMRtxNV-2,E(}eR52Tl<8(tRnzQOYpWk-OY*r4oXxVpx3&ViTQsfs.A~9wI>Ln#');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
