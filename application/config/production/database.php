<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| Production Environment Database Configuration
| -------------------------------------------------------------------
| This file contains production-specific database configuration overrides.
| These settings will override the main database.php when ENVIRONMENT = 'production'
|
*/

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => 'u359265976_user',
	'password' => 'f8U$/vItI4',
	'database' => 'u359265976_db',
	'dbdriver' => 'mysqli',
	'dbprefix' => 'pt_',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
); 