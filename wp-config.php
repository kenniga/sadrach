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
define('DB_NAME', 'sandrach');

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

define( 'WP_MEMORY_LIMIT', '256M' );
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'C2j]q%fF,IY0^lBFU`{RCE[D#0{46RHVhQ0LfFQBPi%5B&b2m20{1Z{6yPm;25.|');
define('SECURE_AUTH_KEY',  'YO?N^NiW8t-g)cj??N|W5nIY#HY5yM+>%27wl&!FV0F6z<!7ZeLqUROzcT*&OgCa');
define('LOGGED_IN_KEY',    '.q}SQzng$&=AmTKp4B!1xLVV~cI[JiDOh]c/@)<|aq+s/)=;LU*}J}%Ot*OC>u|r');
define('NONCE_KEY',        'NulW(J8V`WDEVPD0Lt,]}8KVQw(vd!-RZ?j:%4d^#}pRgLcyQ ?9Yp0?^b1?GH3G');
define('AUTH_SALT',        'a*.a_g/ON]s&G);:}kIgfVH~y.5bpzwH/Ub~Agd,HJA?}?bHPm{8lu4ru;/T/:;5');
define('SECURE_AUTH_SALT', 'cnkXlvmeqyUJ4fLt_l^6hC^Uh`38UY9q9$pr!vYBA6TO)H6n.Q)Q!JBG&>h/tes?');
define('LOGGED_IN_SALT',   '^Xm/qZdbP+Z~KaDnOd4~C;}UI~EbDA*_u %rn9.J}yHes7>v^+LmAmy#jkYu4Ani');
define('NONCE_SALT',       '5k+g?2CONz{x55anHX_$dYtS&@0}FBSLNVf(`rlNGR(~mi7@p+bfVGU@PB1=QsYI');

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
