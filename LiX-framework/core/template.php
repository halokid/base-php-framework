<?php
/**
 * template class, view and get params for URL
 *
 */
class Template{
	private $register;
	private $vars = array();
	function __construct($register){
		$this->register = $register;
	}
	
	//使用来自模型和控制器的资料
	function set($varname, $value, $overwrite = false){
		if( isset($this->vars[$varname]) == true && $overwrite == false){
			trigger_error('Unable to set var '.$varname.' Already set,and overwrite not allowed', E_USER_NOTICE);
		    return false;
		}
		$this->vars[$varname] = $value;
	    return true;
	}
	//去除一个模板的变量
	function remove($varname){
		unset($this->vars[$varname]);
		return true;
	}
	//显示模板
	function show($name){
		$path = project_path.'templates'.DS.$name.'.php';
//		echo $path;
		if( file_exists($path) == false){
			trigger_error('Template '.$name.' does not exists', E_USER_NOTICE);
			return false;
		}
		//装载变量
		foreach ($this->vars as $key=>$value){
			$$key = $value;
		}
		//include the template file
		include($path);
	}
}



























