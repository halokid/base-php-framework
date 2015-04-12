<?php
/**
 * @author maoyong
 * @todo for the URL route and call controller
 *
 */
class Router
{
	protected  $_resgiter;
	public $path;
	public $args = array ();
	//这两个是重写规则的属性
	public $rewrite_rule = '';
	public $rewrite_controller_action = array ();
	public $rewrite_args_keys = array ();
	//
	protected $_routes = array ();
	//	public $args = array();
	function __construct($register)
	{
		$this->_resgiter = $register;
	}
	//设置控制器的路径
	public function setPath($path)
	{
		//if in linux , can not do this
		//$path = trim($path, '/\\');
		$path .= DS;
		//echo $path;
		if (is_dir($path) == false)
		{
			throw new Exception('Invalid controller path: '.$path);
			//			echo ('Invalid controller path: '.$path)."<br>";
		}
		$this->path = $path;
	}

	//获得控制器和动作
	public function getController( & $file, & $controller, & $action, & $args)
	{
		//判断控制器名称, .htaccess 设置所有参数键名为route
		$route = ( empty($_GET['q']))?'':$_GET['q'];
//		echo $route."<hr>";
		if ( empty($route))
		{
			$route = 'index';
		}
		//去掉index.php
		$route = str_replace('index.php', '', $route);
		//获得访问的元素
		$route = trim($route, '/\\');
//		echo $route."<hr>";
		$parts = explode('/', $route);
		//找到正确的控制器
		$cmd_path = $this->path;
		foreach ($parts as $part)
		{
			$full_path = $cmd_path.$part;
			//is there a dir with this path?
			//如果是有目录的话，可以在目录下面寻找控制器，假如以这个框架为根目录的话
			if (is_dir($full_path))
			{
				$cmd_path .= $part.DS;
				array_shift($parts);
				continue ;
			}
			//找到控制器的文件
			if (is_file($full_path.'.php'))
			{
				$controller = $part;
				array_shift($parts);
				break;
			}
		}
		if ( empty($controller))
		{
			$controller = 'index';
		}
		//获得动作
		$action = array_shift($parts);
		if ( empty($action))
		{
			$action = 'index';
		}
		$file = $cmd_path.$controller.'.php';
		//		echo $this->path;
		//		echo $file;
		//		$args = $parts;
		$this->args = $parts;
	}

	//路由重写函数，自定义路由分发
	public function addRule($rewrite_rule, $rewrite_controller_action, $rewrite_args_keys)
	{
		//声明要进行重写
		$this->rewrite_rule = $rewrite_rule;
		$this->rewrite_controller_action = $rewrite_controller_action;
		$this->rewrite_args_keys = $rewrite_args_keys;


	}



	public function _addRules($name, Route_Regex $route)
	{
		$this->_routes[$name] = $route;
	}

	//访问的分派函数
	public function delegate()
	{

		$request_url = $_SERVER['REQUEST_URI'];
		//		echo $request_url.'<br>';
		//匹配URL
		//		echo '#^'.$this->rewrite_rule.'$#i'.'<br>';
		//		preg_match('#^/'.$this->rewrite_rule.'$#i', $request_url, $match_arr );
		//如果没有进行规则重写
		if ( empty($this->_routes))
		{
			//解释路由器
			$this->getController($file, $controller, $action, $args);
			//检查文件
			if (is_readable($file) == false)
			{
				die ('404 NOT FOUND');
			}
			//加载文件
			include ($file);
			//初始化控制器
			$class = 'Controller_'.$controller;
			//加载系统注册变量
			$controller = new $class($this->_resgiter);
			//给控制器赋变量值
			$controller->args = $this->args;
			//检查动作是否合法
			if (is_callable( array ($controller, $action)) == false)
			{
				die ('the controller or the action can not be called!');
			}
			//运行动作
			$controller->$action();
		}
		//如果进行规则重写
		else
		{
			//找到匹配的每条重写记录
			foreach ($this->_routes as $route)
			{
				preg_match('#^/'.$route->route.'$#i', $request_url, $match_arr);
				if (! empty($match_arr))
				{
					break;
				}
			}
			//		print_r($match_arr);
			if (! empty($match_arr))
			{
				$file = $this->path.$route->controller_action['controller'].'.php';
				include ($file);
				$class = 'Controller_'.$route->controller_action['controller'];
				$controller = new $class($this->_resgiter);
				$action = $route->controller_action['action'];
				//检查动作是否合法
				if (is_callable( array ($controller, $action)) == false)
				{
					die ('重写找不到ACTION!');
				}

				//分发重写规则的变量
				foreach ($route->rewrite_args_keys as $key=>$value)
				{
					$this->args[$value] = $match_arr[$key];
					//			echo $value.'<br>';
				}
				//		print_r($this->args);

				//运行动作
				//		print_r($this->args);

				$controller->rewrite = 1;
				$controller->args = $this->args;
				$controller->$action();

			}
			else
			{
				//throw new Exception('重写URL有误');
				//解释路由器
				$this->getController($file, $controller, $action, $args);
				//检查文件
				if (is_readable($file) == false)
				{
					die ('404 NOT FOUND');
				}
				//加载文件
				include ($file);
				//初始化控制器
				$class = 'Controller_'.$controller;
				//加载系统注册变量
				$controller = new $class($this->_resgiter);
				//给控制器赋变量值
				$controller->args = $this->args;
				//检查动作是否合法
				if (is_callable( array ($controller, $action)) == false)
				{
					die ('the controller or the action can not be called!');
				}
				//运行动作
				$controller->$action();
			}


		}
	}





}





