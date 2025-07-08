<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Production Environment Configuration
|--------------------------------------------------------------------------
| This file contains production-specific configuration overrides.
| These settings will override the main config.php when ENVIRONMENT = 'production'
|
*/

// PHP 8.2+ compatibility fix for dynamic property deprecation warnings
if (version_compare(PHP_VERSION, '8.2.0', '>=')) {
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
}

// Production base URL - should be your actual domain
$config['base_url'] = 'https://yourdomain.com/';

// Production logging - minimal for performance
$config['log_threshold'] = 1; // Only log errors

// Production encryption key - should be a strong, unique key
$config['encryption_key'] = 'prod_encryption_key_98765432109876543210987654321098';

// Production error reporting - minimal for security
$config['log_threshold'] = 1;

// Production cache settings - enable for performance
$config['cache_dir'] = APPPATH . 'cache/';
$config['cache_default_expires'] = 3600;

// Production session settings
$config['sess_driver'] = 'files';
$config['sess_cookie_name'] = 'ci_session_prod';
$config['sess_expiration'] = 7200;
$config['sess_save_path'] = APPPATH . 'cache/sessions/';
$config['sess_match_ip'] = TRUE; // More secure
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = TRUE; // More secure

// Production cookie settings
$config['cookie_prefix']    = 'prod_';
$config['cookie_domain']    = '.yourdomain.com'; // Set to your domain
$config['cookie_path']      = '/';
$config['cookie_secure']    = TRUE; // HTTPS only
$config['cookie_httponly']  = TRUE; // More secure

// Production CSRF settings
$config['csrf_protection'] = TRUE; // Enable for security
$config['csrf_token_name'] = 'csrf_token';
$config['csrf_cookie_name'] = 'csrf_cookie';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array();

// Production security settings
$config['global_xss_filtering'] = TRUE; // Enable for security
$config['csrf_protection'] = TRUE;
$config['csrf_token_name'] = 'csrf_token';
$config['csrf_cookie_name'] = 'csrf_cookie';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array();

// Production compression settings
$config['compress_output'] = TRUE; // Enable for performance

// Production hooks
$config['enable_hooks'] = FALSE; // Disable for performance

// Production profiler
$config['enable_profiler'] = FALSE; // Disable for security and performance 