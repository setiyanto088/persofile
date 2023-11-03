<?php
defined('BASEPATH') || exit('No direct script access allowed');

include("/var/www/file/cfg.php");

$config['base_url'] = $main_url;

$config['index_page'] = '';
$config['uri_protocol']	= 'REQUEST_URI';
$config['url_suffix'] = '';
$config['language']	= 'english';
$config['charset'] = 'UTF-8';
$config['enable_hooks'] = TRUE;

$config['subclass_prefix'] = 'MY_'; 
$config['composer_autoload'] = "./vendor/autoload.php";
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';


$config['allow_get_array'] = TRUE;
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';

$config['log_threshold'] = 4;
$config['log_path'] = '';
$config['log_file_extension'] = '';
$config['log_file_permissions'] = 0644;

$config['log_date_format'] = 'Y-m-d H:i:s';
$config['error_views_path'] = '';

$config['cache_path'] = '';
$config['cache_query_string'] = FALSE;
$config['encryption_key'] = '';

$config['sess_driver'] = 'files';
// $config['sess_cookie_name'] = 'ci_session_pmis2';
$config['sess_cookie_name'] = 'ci_session_maria'; 
$config['sess_expiration'] = 7200;
//$config['sess_save_path'] = APPPATH . '/tmp/';
$config['sess_save_path'] = '/var/www/html/tmp/';
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 60;
$config['sess_regenerate_destroy'] = FALSE;
$config['cookie_prefix']	= 'unicsv2_';
// $config['cookie_prefix']	= 'pmis2_';
$config['cookie_domain']	= '';
$config['cookie_path']		= '/';
$config['cookie_secure']	= FALSE;
$config['cookie_httponly'] 	= FALSE;
$config['standardize_newlines'] = FALSE;

$config['global_xss_filtering'] = FALSE;

/*
|--------------------------------------------------------------------------
| Cross Site Request Forgery
|--------------------------------------------------------------------------
| Enables a CSRF cookie token to be set. When set to TRUE, token will be
| checked on a submitted form. If you are accepting user data, it is strongly
| recommended CSRF protection be enabled.
|
| 'csrf_token_name' = The token name
| 'csrf_cookie_name' = The cookie name
| 'csrf_expire' = The number in seconds the token should expire.
| 'csrf_regenerate' = Regenerate token on every submission
| 'csrf_exclude_uris' = Array of URIs which ignore CSRF checks
*/
$config['csrf_protection'] = false; 
// $config['csrf_token_name'] = 'csrf_pmis_secure';
// $config['csrf_cookie_name'] = 'csrf_pmis_nameSecure';
$config['csrf_token_name'] = 'csrf_unics_secure';
$config['csrf_cookie_name'] = 'csrf_unics_nameSecure';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array();


$config['compress_output'] = FALSE;
$config['time_reference'] = 'local';
$config['rewrite_short_tags'] = TRUE;
$config['proxy_ips'] = '';
