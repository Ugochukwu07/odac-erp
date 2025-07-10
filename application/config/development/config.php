<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Development Environment Configuration
|--------------------------------------------------------------------------
| This file contains development-specific configuration overrides.
| These settings will override the main config.php when ENVIRONMENT = 'development'
|
*/

// PHP 8.2+ compatibility fix for dynamic property deprecation warnings
if (version_compare(PHP_VERSION, '8.2.0', '>=')) {
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
}

// PHP 8.2+ compatibility fix for dynamic property deprecation warnings
if (version_compare(PHP_VERSION, '8.2.0', '>=')) {
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
}

// Development base URL - typically localhost
$config['base_url'] = 'http://odeac.local/';

// Development logging - more verbose for debugging
$config['log_threshold'] = 4; // Log everything

// Development encryption key - should be different from production
$config['encryption_key'] = 'dev_encryption_key_12345678901234567890123456789012';

// Development error reporting - show all errors
$config['log_threshold'] = 4;

// Development cache settings - disable for easier debugging
$config['cache_dir'] = APPPATH . 'cache/';
$config['cache_default_expires'] = 7200;

// Development session settings
$config['sess_driver'] = 'files';
$config['sess_cookie_name'] = 'ci_session_dev';
$config['sess_expiration'] = 7200;
$config['sess_save_path'] = APPPATH . 'cache/sessions/';
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;

// Development cookie settings
$config['cookie_prefix']    = 'dev_';
$config['cookie_domain']    = '';
$config['cookie_path']      = '/';
$config['cookie_secure']    = FALSE;
$config['cookie_httponly']  = FALSE;

// Development CSRF settings
$config['csrf_protection'] = FALSE; // Disable for development convenience
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array();

// Development security settings
$config['global_xss_filtering'] = FALSE; // Disable for development
$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array();

// Development compression settings
$config['compress_output'] = FALSE; // Disable for easier debugging

// Development hooks
$config['enable_hooks'] = TRUE; // Enable hooks for development

// Development profiler
$config['enable_profiler'] = TRUE; // Enable profiler for development 