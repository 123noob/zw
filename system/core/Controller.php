<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Controller {
	private static $instance;

	function __construct()
	{
		self::$instance =& $this;

		foreach (is_loaded() as $var => $class) 
		{
			$this->$var =& load_class($class);
		}
		$this->load =& load_class('Loader','core');
		$this->load->initialize();
	}

	static function &get_instance()
	{
		return self::$instance;
	}
}