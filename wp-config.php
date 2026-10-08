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

define('DB_NAME', 'mysite_db');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');

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
define( 'AUTH_KEY',         '$]v3VApQBi[$fPsA8n{b^8JwzJr>8/*.^=pS[l7BRj<#_sQ>4Wg#|MDk?>~!^V*^' );
define( 'SECURE_AUTH_KEY',  '~y+$(M?oW^zk%jLO9Gl.cgwm!+_DW6iyP_EEg*((4qE*p(PuEBvZOx:WNe1*YM(K' );
define( 'LOGGED_IN_KEY',    'm.N?Y#:-`L;D#9cufVJ f#>Cq(3,/np9eTynd)4D::;9uZiB25vy:HR-k.S=iF2.' );
define( 'NONCE_KEY',        'jxn0o;Z>cPa4%fzO5;$B$x mG{FzGeuSgJw#G;w04f&^,6<{4B6V|JXha=t!J0Z|' );
define( 'AUTH_SALT',        'rhNhS7A$Qbw#m<6(KuIkd82Fe]E[>$~v(R.$9WV24M?{WH,N<(VE7Yy%u@.pIP,K' );
define( 'SECURE_AUTH_SALT', '9/jW|ckkON>)9DiDl$02MOsFIoN*u8bjPHvo K!:5CeE)Tr[rH|kJ!z7gFE=Ftx<' );
define( 'LOGGED_IN_SALT',   ' 3pE/D54KRF=6^XQbl#k>tH>L]=>a0[h8;/7Y+7^_:Z#xpK*E]]0BsS38u<ko O[' );
define( 'NONCE_SALT',       'a4,-%G#wy+fF;p&[xW0f6:vRh~}x)2kq*kSw<PDT~`]gmqHSf_q9{viXE/V:2T$v' );

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

 define( 'IQRA_SMTP_HOST',   'smtp.gmail.com' );
define( 'IQRA_SMTP_PORT',   587 );
define( 'IQRA_SMTP_SECURE', 'tls' );
define( 'IQRA_SMTP_USER',   'sharukhzzz05@gmail.com' );   // full Gmail address
define( 'IQRA_SMTP_PASS',   'zrjqivleqoknsmwf' );     // 16-character app password, no spaces
define( 'IQRA_MAIL_FROM',   'sharukhzzz05@gmail.com' );   // same address as the user
define( 'IQRA_FORM_TO',     'yourname@gmail.com' );   // where quote requests should arrive

/* Add any custom values between this line and the "stop editing" line. */

// Automatically use the visitor's own address (e.g. an ngrok share link)
// instead of the hardcoded "localhost", so the site works both locally
// and when shared with someone outside this machine.
if ( isset( $_SERVER['HTTP_HOST'] ) && strpos( $_SERVER['HTTP_HOST'], 'localhost' ) === false ) {
	// ngrok terminates HTTPS at its edge and forwards plain HTTP to Apache,
	// so tell WordPress the request is secure to avoid a redirect loop.
	if ( strpos( $_SERVER['HTTP_HOST'], 'ngrok' ) !== false ) {
		$_SERVER['HTTPS'] = 'on';
	}
	$protocol = ! empty( $_SERVER['HTTPS'] ) ? 'https://' : 'http://';
	define( 'WP_HOME', $protocol . $_SERVER['HTTP_HOST'] . '/wordpress' );
	define( 'WP_SITEURL', $protocol . $_SERVER['HTTP_HOST'] . '/wordpress' );
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
