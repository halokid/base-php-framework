<?php
/**
 * load core classes and register MVC
 *
 * @param unknown_type $class_name
 * @return unknown
 */

function __autoload($class_name) {

$filename = strtolower($class_name) . '.php';
$file = site_path.'core'.DS . $filename;
//echo site_path.DS.'classes'.DS . $filename;

if (file_exists($file) == false) {

return false;

}

include ($file);

}

$register = new Register();
