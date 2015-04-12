<?php
/**
 * @todo 框架入口文件
 * @author jimmy
 */
//检查PHP版本和抛出异常
error_reporting(E_ALL);

if( version_compare(phpversion(), '5.1.0', '<') == true){
	die('PHP 5.1 ONLY');
}
//定义系统常量
define('DS', DIRECTORY_SEPARATOR);
//框架所在文件夹
$site_path = realpath(dirname(__FILE__).DS.'..'.DS).DS;
//项目所在文件夹
$project_path = dirname(__FILE__).DS;
define('site_path', $site_path);
define('project_path', $project_path);
//echo site_path.'<br>';
//加载启动注册和核心类库文件
include(site_path.'/core/startup.php');
//链接数据库
include($project_path.'config/db.php');
$db = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$pwd");
//$db->fetch
//$db->query("select * from news");
$register['db'] = $db;
////加载模板类
$template = new Template($register);
$register['tp'] = $template;
////加载路由类
$router = new Router($register);
$register['router'] = $router;
//设置控制器文件夹
$router->setPath($project_path.'controllers');
//echo $project_path.'controllers';

//$router->addRule('lx/todo/(.*)/(.*).html', array('controller' => 'index', 'action' => 'seePerson'), array(0 => 'sex', 1=> 'name' ));

$route = new Route_Regex('lx/todo/(.*)/(.*).html', array('controller' => 'index', 'action' => 'seePerson'), array(1 => 'sex', 2=> 'name' ));

$router->_addRules('route', $route);


$router->delegate();


