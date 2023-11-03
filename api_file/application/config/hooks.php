<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

$hook['post_controller_constructor'][] = array(
	// 'class' => 'Authentication',
	// 'function' => 'check_token',
	// 'filename' => 'Authentication.php',
	// 'filepath' => 'hooks'
);

$hook['post_controller_constructor'][] = array(
	// 'class' => 'Authentication',
	// 'function' => 'check_login',
	// 'filename' => 'Authentication.php',
	// 'filepath' => 'hooks'
);

//
// CSRF Protection hooks, don't touch these unless you know what you're
// doing.
//
// THE ORDER OF THESE HOOKS IS EXTREMELY IMPORTANT!!
//
 
// THIS HAS TO GO FIRST IN THE post_controller_constructor HOOK LIST.
// Mind the "[]", this is not the only post_controller_constructor hook


 
// Generates the token (MUST HAPPEN AFTER THE VALIDATION HAS BEEN MADE, BUT BEFORE THE CONTROLLER
// IS EXECUTED, OTHERWISE USER HAS NO ACCESS TO A VALID TOKEN FOR CUSTOM FORMS).



 
// This injects tokens on all forms
$hook['display_override'] = array(
  'class'    => 'CSRF_Protection',
  'function' => 'inject_tokens',
  'filename' => 'Csrf.php',
  'filepath' => 'hooks'
);


$hook['post_controller_constructor'][] = array('class' => 'Usertracking',
	'function' => 'auto_track',
	'filename' => 'Usertracking.php',
	'filepath' => 'libraries');		
 
