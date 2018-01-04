<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loader {
	function __construct()
	{
		$this->_ci_ob_level  = ob_get_level();
		// p($this->_ci_ob_level);
		$this->_ci_library_paths = array(APPPATH, BASEPATH);
		$this->_ci_helper_paths = array(APPPATH, BASEPATH);
		$this->_ci_model_paths = array(APPPATH);
		$this->_ci_view_paths = array(APPPATH.'views/'	=> TRUE);
	}

	function initialize()
	{
		$this->_ci_classes = array();
		$this->_ci_loaded_files = array();
		$this->_ci_models = array();

		$this->_base_classes =& is_loaded();
		$this->_ci_autoloader();

		return $this;
	}

	private function _ci_autoloader()
	{
		if (defined('ENVIRONMENT') AND file_exists(APPPATH.'config/'.ENVIRONMENT.'/autoload.php'))
		{
			include(APPPATH.'config/'.ENVIRONMENT.'/autoload.php');
		}
		else
		{
			include(APPPATH.'config/autoload.php');
		}

		if ( ! isset($autoload))
		{
			return FALSE;
		}

		// Autoload packages
		if (isset($autoload['packages']))
		{
			foreach ($autoload['packages'] as $package_path)
			{
				$this->add_package_path($package_path);
			}
		}
	}

	function add_package_path($path,$view_cascade=TRUE)
	{
		
	}
}