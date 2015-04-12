<?php
//路由器重写规则的类
class Route_Regex{
	public $route;
	public $controller_action;
	public $rewrite_args_keys;
	
	function __construct( $route, $controller_action, $rewrite_args_keys ){
		$this->route = $route;
		$this->controller_action = $controller_action;
		$this->rewrite_args_keys = $rewrite_args_keys;
	}
}
?>