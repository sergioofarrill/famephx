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
define('DB_NAME', 'wp-mcsaatchila');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'overtherainbow');

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
define('AUTH_KEY',         'dg2gmkNcVbbj9a8bfW1Rda7PdvJeoz19k4aQMClm0x6Xr4WLKuaLoaMNvyo8SkAO');
define('SECURE_AUTH_KEY',  'FbwB7JSI4ZPqYXun1Eg27frivneYy6LRmQOyn8pXXzG66hfb2KD7CNWJ1TV9cZUa');
define('LOGGED_IN_KEY',    'YY7MgG7JhTLh3I9IGVAfDMtx2MdsvbXYO6GurJE03UfCwd22Z6JmNsEbMfImZTi2');
define('NONCE_KEY',        'cQ3Fu75QrtjVcfSSrJB9qUMWD8KNoOwgBfmZS704F7Tyjiu1Vj6L6K8jGNY42m5g');
define('AUTH_SALT',        'ChfKslDuSKvR4vNgTSSO05CYPK3QmvFZ4lXwgH1uVSCMkwilrF2viAwcGzL1KjRT');
define('SECURE_AUTH_SALT', '5Nnyx4r32va4jnpxHEvtU1lWqLAjohgtQIAVlO6Syj5oKL3WkRWRNo9hIn6oLRIN');
define('LOGGED_IN_SALT',   'd51K5bPRz2cKzksNUH7Oqtrk32fSO4QX9l4ai5TWqAHPV1BRCsaSp6FE9XB32ymw');
define('NONCE_SALT',       '7lhTu1cqT6GMEC5sjzNJSSu8R3w2Z0Sg4fpZxkHZH9xmdxeaoZVBP3jVWpk1uCfW');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

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
