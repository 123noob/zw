<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Router {

	function __construct()
	{
		$this->config =& load_class('Config', 'core');
		$this->uri =& load_class('URI', 'core');
	}

	function _set_routing()
	{
		if(defined('ENVIRONMENT') and is_file(APPPATH.'config/'.ENVIRONMENT.'/routes.php'))
		{
			include(APPPATH.'config/'.ENVIRONMENT.'/routes.php');
		}
		elseif(is_file(APPPATH.'config/routes.php'))
		{
			include(APPPATH.'config/routes.php');
		}

		$this->routes = (!isset($route) or !is_array($route)) ? array() : $route;

		//unset($route);

		$this->default_controller = ( ! isset($this->routes['default_controller']) OR $this->routes['default_controller'] == '') ? FALSE : strtolower($this->routes['default_controller']); 

		$this->uri->_fetch_uri_string();

		if($this->uri->uri_string == '')
		{
			return $this->_set_default_controller();
		}

		$this->uri->_explode_segments();

	}

	private function _set_default_controller()
	{
		if ($this->default_controller === FALSE)
		{
			exit("Unable to determine what should be displayed. A default route has not been specified in the routing file.");
		}

		if(strpos($this->default_controller, '/') !== false)
		{
			$x = explode('/', $this->default_controller);
			$this->set_class($x[0]);
			$this->set_method($x[1]);
			// $this->_set_request($x);
		}
		else
		{
			$this->set_class($this->default_controller);
			$this->set_method('index');
			// $this->_set_request(array($this->default_controller, 'index'));
		}

	}

	function set_class($class)
	{
		$this->class = str_replace(array('/','.'), '', $class);
	}

	function set_method($method)
	{
		$this->method = trim($method);
	}

	// private function _set_request($segments = array())
	// {

	// }
}