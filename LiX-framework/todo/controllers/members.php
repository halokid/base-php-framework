<?php
class Controller_Members extends Controller_Base {
	function index(){
		echo "default index of the member controller!";
	}
	function view(){
		echo "you are viewing the members/view request";
		print_r($this->register['db']->getAvailableDrivers());
	}
}