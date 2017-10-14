<?php
define('ENVIRONMENT', 'development');

if (defined('ENVIRONMENT'))
{
	switch(ENVIRONMENT)
	{
		case 'development':
			error_reporting(E_ALL);
		break;
		
		case 'testing':
		case 'producting':
			error_reporting(0);
		break;
		
		default:
			exit('The application environment is not set correctly');		
	}
}

$system_path = 'system';
$application_folder = 'app';

// 入口文件
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME) );

define('EXT', '.php');

define('BASEPATH', $system_path.'/');

// 根目录路径
define('FCPATH', str_replace(SELF, '', __FILE__));

// 输出''
// define('SYSDIR', trim(strrchr(trim(BASEPATH, '/'), '/'), '/') );

define('APPPATH', $application_folder.'/');

require_once BASEPATH.'core/ZW.php';
