<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Hooks {
	var $enabled = false;

	var $in_progress = false;

	function __construct()
	{
		$this->_initialize();

	}

	function _initialize()
	{
		$CFG =& load_class('Config', 'core');

		if($CFG->item('enable_hooks') == false)
		{
			return;
		}

		if(defined('ENVIRONMENT') && is_file(APPPATH.'config/'.ENVIRONMENT.'/hooks.php'))
		{
			include(APPPATH.'config/'.ENVIRONMENT.'/hooks.php');
		}
		elseif(is_file(APPPATH.'config/hooks.php'))
		{
			include(APPPATH.'config/hooks.php');
		}

		if(!isset($hook) || !is_array($hook))
		{
			return;
		}

		$this->hooks =& $hook;
		$this->enabled = true;
	}

	function _call_hook($which = '')
	{
		if(!$this->enabled || !isset($this->hooks[$which]))
		{
			return false;
		}
		if(isset($this->hooks[$which][0]) && is_array($this->hooks[$which][0]))
		{
			foreach ($this->hooks[$which] as $val) 
			{
				$this->_run_hook($val);
			}
		}
		else
		{
			$this->_run_hook($this->hooks[$which]);
		}

		return true;
	}

	function _run_hook($data)
	{
		if(!is_array($data))
		{
			return false;
		}

		/*
		*调用hook，防止hook里又调用相同hook进而形成死循环，设置一个开关有效防止这种情况
		*/
		if($this->in_progress == true)
		{
			return;
		}

		if(!isset($data['filepath']) || !isset($data['filename']))
		{
			return false;
		}

		$filepath = APPPATH.$data['filepath'].'/'.$data['filename'];

		if(!file_exists($filepath))
		{
			return false;
		}

		$class = false;
		$function = false;
		$params = '';

		if(isset($data['class']) && $data['class'] != '')
		{
			$class = $data['class'];
		}

		if(isset($data['function']))
		{
			$function = $data['function'];
		}

		if(isset($data['params']))
		{
			$params = $data['params'];
		}

		if($class === false && $function === false)
		{
			return false;
		}

		$this->in_progress = true;

		if($class !== false)
		{
			if(!class_exists($class))	
			{
				require($filepath);
			}

			$HOOK = new $class;
			$HOOK->$function($params);
		}
		else
		{
			if(!function_exists($function))
			{
				require($filepath);
			}

			$function($params);
		}

		$this->in_progress = false;
		return true;
	}
}
