<?php
/**
 * register the MVC base object
 *
 */
class Register implements ArrayAccess{
	private $vars = array();
	
	//set the obj
	public function set($key, $var){
		if(isset($this->vars[$key]) == true){
			throw new Exception('Unable to set var '.$key.',because it already set');
		}
		$this->vars[$key] = $var;
		return true;
	}
	//get the obj
	public function get($key){
		if(isset($this->vars[$key]) == false){
			return null;
		}
		return $this->vars[$key];
	}
	//remove the obj
	public function remove($key){
		if( isset($this->vars[$key])){
			unset($this->vars[$key]);
		}
		return ;
	}
	
	function offsetExists($offset){
		return isset($this->vars[$offset]);
	}
	
	function offsetGet($offset){
		return $this->get($offset);
	}
	function offsetSet($offset, $value){
		$this->set($offset, $value);
	}
	function offsetUnset($offset){
		unset($this->vars[$offset]);
	}
}