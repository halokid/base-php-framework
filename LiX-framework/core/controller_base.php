<?php
/**
 * Controller base class,for controller init
 *@author maoyong
 */
abstract class Controller_Base{
	protected $_register;
	public $tp;
	public $args;
	public $rewrite = 0;
	protected static $_instance = null;
	
	public function __construct($register){
		$this->_register = $register;
		$this->init();
	}
	function init(){}
	abstract function  index();
	
	/**
	 * @获得传递来参数的键和值
	 */
	function _request($key){
		if($this->rewrite == 0){ 
		if ( trim($key) == '' or !in_array($key, $this->args) ) { throw new Exception('非法的键名'); }
		for($i = 0; $i < count($this->args); $i++ ){
			if( $this->args[$i] == $key ){
				//检查键是单数还是双数
				if ( $i % 2 != 0){
					throw new Exception('键名不是单数,这个键名请求是非法的');
				}
				return $this->args[$i+1];
				break;
			}
		}
	}
	//假如有重写规则
	else{
		return $this->args[$key];
	}
	}
	
	public static function getInstance(){
		return new Controller_Base;
	}

}