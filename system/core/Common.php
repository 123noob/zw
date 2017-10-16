<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

function &get_config($replace = array())
{
	static $_config;

	if(isset($_config))
	{
		return $_config[0];
	}

	if(!defined('ENVIRONMENT') || !file_exists($file_path = APPPATH.'config/'.ENVIRONMENT.'/config.php'))
	{
		$file_path = APPPATH.'config/config.php';
	}

	if(!file_exists($file_path))
	{
		exit('The configuration file does not exist');
	}

	require($file_path);

	if(!isset($config) || !is_array($config))
	{
		exit('Your config file does not appear to be formatted correctly');
	}

	if(count($replace) > 0)
	{
		foreach ($replace as $key => $val)
		{
			if(isset($config[$key]))
			{
				$config[$key] = $val;
			}
		}
	}

	$_config[0] =& $config;
	return $_config[0];
}

function config_item($item)
{
	static $_config_item = array();

	if(!isset($_config_item[$item]))
	{
		$config =& get_config();

		if(!isset($config[$item]))
		{
			return false;
		}
		$_config_item[$item] = $config[$item];
	}

	return $_config_item[$item];
}

/**
*跟踪载入了多少类库
*/
function &is_laoded($class='')
{
	static $_is_loaded = array();

	if($class !='')	
	{
		$_is_loaded[strtolower($class)] = $class;
	}

	return $_is_loaded;
}

function &load_class($class, $directory = 'libraries')
{
	static $_classes = array();

	if(isset($_classes[$class]))
	{
		return $_classes[$class];
	}

	$name = false;

	foreach (array(APPPATH, BASEPATH) as $path) 
	{
		if(file_exists($path.$directory.'/'.$class.'.php'))
		{
			$name = $class;

			if(class_exists($name) === false)
			{
				require($path.$directory.'/'.$class.'.php');
			}

			break;
		}
	}

	if(file_exists(APPPATH.$directory.'/'.config_item('subclass_prefix').$class.'.php'))
	{
		$name = config_item('subclass_prefix').$class;

		if(class_exists($name) === false)
		{
			require(APPPATH.$directory.'/'.config_item('subclass_prefix').$class.'.php');
		}
	}

	if($name === false)
	{
		exit('Unable to locate the specified class: '.$class.'.php');
	}

	is_loaded($class);

	$_classes[$class] = new $name();
	return $_classes[$class];
}

function p($arr)
{
	echo '<pre>';
	print_r($arr);
	die;
}