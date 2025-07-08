<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| Development Environment Database Configuration
| -------------------------------------------------------------------
| This file contains development-specific database configuration overrides.
| These settings will override the main database.php when ENVIRONMENT = 'development'
|
*/

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => 'root', // Development typically uses root
	'password' => 'root', // No password for local development
	'database' => 'odac_erp', // Use existing database for now
	'dbdriver' => 'mysqli',
	'dbprefix' => 'pt_',
	'pconnect' => FALSE,
	'db_debug' => TRUE, // Enable debug for development
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE // Save queries for debugging
); 