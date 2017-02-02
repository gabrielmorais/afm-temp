<?php

// DATABASE

define( 'DB_NAME',     $_ENV['DB_NAME'] ?: getenv( 'DB_NAME' ) );
define( 'DB_USER',     $_ENV['DB_USER'] ?: getenv( 'DB_USER' ) );
define( 'DB_PASSWORD', $_ENV['DB_PASS'] ?: getenv( 'DB_PASS' ) );
define( 'DB_HOST',     $_ENV['DB_HOST'] ?: getenv( 'DB_HOST' ) );
define( 'DB_CHARSET',  'utf8' );
define( 'DB_COLLATE',  'utf8_general_ci' );

// LEGACY DATABASE
define( 'EXTERNAL_DB_USER',     $_ENV['EXTERNAL_DB_USER']     ?: getenv( 'EXTERNAL_DB_USER' ) );
define( 'EXTERNAL_DB_PASSWORD', $_ENV['EXTERNAL_DB_PASSWORD'] ?: getenv( 'EXTERNAL_DB_PASSWORD' ) );
define( 'EXTERNAL_DB_NAME',     $_ENV['EXTERNAL_DB_NAME']     ?: getenv( 'EXTERNAL_DB_NAME' ) );
define( 'EXTERNAL_DB_HOST',     $_ENV['EXTERNAL_DB_HOST']     ?: getenv( 'EXTERNAL_DB_HOST' ) );

// SPECIFIC ENVIRONMENT CONFIGURATION

define( 'WP_HOME',                 'http://' . ( $_ENV['DOMAIN'] ?: getenv( 'DOMAIN' ) ).'/site/' );

#print_r( WP_HOME ); exit;
define( 'WP_SITEURL',              WP_HOME);
define( 'FACEBOOK_APP_ID',         'xxxx' );
define( 'FACEBOOK_TAB_URL',        '' );
define( 'FACEBOOK_CANVAS_URL',     '' );
define( 'GA',                      'UA-xxx-1' ); // Google Analytics
define( 'WP_MEMORY_LIMIT',         '2048M' );
define( 'WP_MAX_MEMORY_LIMIT',     '2048M' );
define( 'WPLANG',                  'pt_BR' );
define( 'WP_CACHE',                false);
define( 'DISABLE_WP_CRON',         false);
define( 'DISALLOW_FILE_MODS',      false);
define( 'WP_HTTP_BLOCK_EXTERNAL',  false );
define( 'WP_ACCESSIBLE_HOSTS',     '' ); // Add the hosts allowed to make requests ex: 3bits.net
define( 'WP_POST_REVISIONS',       false);
define( 'WP_CONTENT_URL', WP_HOME . '/' . ( $_ENV['WP_CONTENT_DIR_NAME'] ?: getenv( 'WP_CONTENT_DIR_NAME' ) ) );
define( 'WP_CONTENT_DIR', ABSPATH . '/' . ( $_ENV['WP_CONTENT_DIR_NAME'] ?: getenv( 'WP_CONTENT_DIR_NAME' ) ) );
define( 'FORCE_SSL_LOGIN', false );
define( 'FORCE_SSL_ADMIN', false );
define( 'DISALLOW_FILE_EDIT', true );
define( 'WP_MAILCATCHER', true);

// SECURITY KEYS - Generate keys at https://api.wordpress.org/secret-key/1.1/salt/

define( 'AUTH_KEY',         '%8b33lU|[%Pc,g@#dC0vH3`SyPmg./W1S^p_Qzq2#hG|SCh|K =/seyz?Ich^WO%' );
define( 'SECURE_AUTH_KEY',  'k;kbh>7h=,q PSU+=fHUf]!8S|vVSdN**Pp$WK=hf&4!)YQ)#=3P~V_,0o+Bp^m#' );
define( 'LOGGED_IN_KEY',    '`{kO>1)-^1.sG]+m|}Iy1F+X2D&py^$L!3W[F-tZ|rXS |.-xNN4H&v1EhF|h8nX' );
define( 'NONCE_KEY',        '^Y@RRp+o*$I] *+vu*{%R~6dBe-K,}%Q4TTNij_A/Xr?lm3?D|!]ojE:/+)~7c-3' );
define( 'AUTH_SALT',        '6G? zMhD+@X=&o!zKsK%uFEHUO*{/0:bvO/iL~Ao(U<K?L/Y-vG+tVBG+QA)8Q9&' );
define( 'SECURE_AUTH_SALT', 'i0&T&(M4MRby#bhO+0N`s|0]uZD(!Mg_,3;lci!8-gq)<n[j2~,1(tV-WC@4[`8j' );
define( 'LOGGED_IN_SALT',   'aaOiZ76I_f`dmmmfYL7..IE7~gI~Ou94](ApX{EOz3#)_21IGx(SkfJBu-|[INhO' );
define( 'NONCE_SALT',       'RV3Ik*4Lx}Qw!I6WJJYe&M89KQ-NzFa<IcbA1%r~vGBzThI{4S&}.dP`,tf>v-`[' );

$table_prefix  = 'sxxx_'; // ADD UM CUSTOM TABLE PREFIX TO IMPROVE SECURITY OF TABLES

// Reverse Proxy
if ($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ) {
  $_SERVER['HTTPS'] = 'on';
}