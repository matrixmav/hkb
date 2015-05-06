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
define('DB_NAME', 'wp_dayuse');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'pMw;}DTuQPAK[WT+I-vy0T8o|5s|qO<1/cBNHA:XdbV:nKn>LqR-.Na1z?z[O)Fv');
define('SECURE_AUTH_KEY',  'JWI3yX15tufChkBM*H}jescJbYvMAQV9S?L Q,s=Dw @(4ux%o*-~+K Ida8m}Kq');
define('LOGGED_IN_KEY',    '5-?dmg~?JULpAb`MEz1m3E(#qLcLv$IpwPrz=d>^2rc2q*u`!=I16n(=s6vNZL|o');
define('NONCE_KEY',        'z1O1#f-e6?6Or<0bmBBi+Q#xThZr*LaZqF{f0QtE7.~urL+.#=qxaIbVvL3C8qo*');
define('AUTH_SALT',        '2u-(WhQM-7Dirm#;w{4j-V]@:qZe &V5Wv`3vBETR:UB_N7{`rh@HjWqJP ~H|}3');
define('SECURE_AUTH_SALT', '+ Nnr4r&k%-|tk#o|euv]S_kd==B_f1KfF<d_-0csuS_jqns2j%tLd6]o6+m7nBS');
define('LOGGED_IN_SALT',   '!*K1z|d[uLs+uUpub!|qcQW,xyk@J-|R=xsL.wJ79| v(O+ygVV#Xg}?Fdm(-Y]y');
define('NONCE_SALT',       'ek#Tukf[ci_Zdw](2t<6c%Fm&gG%T={*44+9!(HAaLP7yY`AFf7#G_y!NF[F6a?l');

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
