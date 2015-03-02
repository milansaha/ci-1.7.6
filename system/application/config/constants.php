<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 					'ab');
define('FOPEN_READ_WRITE_CREATE', 				'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 			'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
|--------------------------------------------------------------------------
| Microfin360 related constants
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/


// Define Ajax Request
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
//  

define('ROW_PER_PAGE', 20); //	Used in pagination
// Image
define('IMAGE_UPLOAD_PATH', 'media/images/members_pic/'); 
define('IMAGE_UPLOAD_SIZE', 200);
define('IMAGE_UPLOAD_MAX_WIDTH', 1000);
define('IMAGE_UPLOAD_MAX_HEIGHT', 1000);
define('IMAGE_UPLOAD_ALLOWED_TYPES', 'gif|jpg|png');

//sytem message for end users
define('DELETE_CONFIRMATION_MESSAGE','Are you sure want to delete this data?'); //	Message for delete confirmation
define('DEPENDENT_DATA_FOUND', 'Cound not delete. Dependent data found.');
define('ADD_MESSAGE', 'Data has been added successfully');
define('EDIT_MESSAGE', 'Data has been updated successfully');
define('DELETE_MESSAGE', 'Data has been deleted successfully');
/* End of file constants.php */
/* Location: ./system/application/config/constants.php */
