<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class URI {

	var $uri_string;

	function _fetch_uri_string()
	{
		if($uri = $this->_detect_uri())
		{
			// $this->_set_uri_string($uri);
			$this->uri_string = ($uri == '/') ? '' : $uri;
			return;
		}
	}

	private function _detect_uri()
	{
		//先检查必要条件，防止抛出不必要异常
		if(!isset($_SERVER['REQUEST_URI']) or !isset($_SERVER['SCRIPT_NAME']))
		{
			return '';
		}

		$uri = $_SERVER['REQUEST_URI'];
		/*对2种情况进行处理
		$_SERVER['REQUEST_URI'] $_SERVER['SCRIPT_NAME']
		/index.php/welcome/index /index.php
		/welcome/index /index.php
		*/
		if(strpos($uri, $_SERVER['SCRIPT_NAME']) === 0)
		{
			$uri = substr($uri, strlen($_SERVER['SCRIPT_NAME']));
		}
		elseif(strpos($uri, dirname($_SERVER['SCRIPT_NAME']) ) === 0)
		{
			$uri = substr($uri, strlen(dirname($_SERVER['SCRIPT_NAME'])));
		}

		if($uri == '/' or empty($uri))
		{
			return '/';
		}

		return str_replace(array('//', '../'), '/', trim($uri, '/'));
	}
}