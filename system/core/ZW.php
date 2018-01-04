<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/*
ZW version
*/

define('ZW_VERSION', '0.1.1');

require(BASEPATH.'core/Common.php');

if(defined('ENVIRONMENT') && file_exists(APPPATH.'config/'.ENVIRONMENT.'/constants.php'))
{
	require(APPPATH.'config/'.ENVIRONMENT.'/constants.php');
}
else
{
	require(APPPATH.'config/constants.php');
}

$EXT = & load_class('Hooks', 'core');

$URI = & load_class('URI', 'core');

// p($URI->_fetch_uri_string());
// p($URI);
$RTR =& load_class('Router', 'core');
$RTR->_set_routing();

require BASEPATH.'core/Controller.php';






