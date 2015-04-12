<?php
class Controller_Index extends Controller_Base {
	
	function init(){
		
	}
	
	function index(){
//		print_r($_SERVER);
		echo 'this is index action';
//		echo $this->_request('name');
		$model = new Model_Base($this->_register['db'], 'news');
		$rows = $model->get_row();
		print_r($rows);
	}
	
	function seePerson(){
		echo $this->_request('name');
		echo '<br>';
		echo $this->_request('sex');
		echo '<hr>';
//		print_r($this->_register['tp']);
		$this->_register['tp']->set('var', 'test var');
		$this->_register['tp']->show('index');
	}
	
	
}