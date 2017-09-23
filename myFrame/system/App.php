<?php 
class App
{
	static function init()
	{
		//定义路径
		self::setPath();
		//载入系统配置文件
        self::loadConfig();
		//配置路由
		self::setRoute();
		//实例化类并转发
		self::newObj();
	}
	


	static function setPath()
	{
		define('BASE_PATH',dirname(__DIR__).'\\');
		define('CONTROLLERS_PATH',BASE_PATH.'controllers\\');
		define('MODELS_PATH',BASE_PATH.'models\\');
		define('VIEWS_PATH',BASE_PATH.'views\\');
		define('SYSTEM_PATH',BASE_PATH.'system\\');
	}

	static function loadConfig(){
        $GLOBALS['config'] = require_once SYSTEM_PATH.'\\Config.php';
        require_once dirname(__FILE__).'/GetConfig.php';
        require_once SYSTEM_PATH.'Controller.php';
		require_once SYSTEM_PATH.'Query.php';
		require_once SYSTEM_PATH.'Model.php';
    }

	static function setRoute()
	{
		$path=isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] :'';
		if($path)
		{
			$url=explode('/',$path);
			$controllerName=ucfirst($url[1]);
			$action=isset($url[2])?$url[2]:getConfig('DEFAULT_METHOD');
			unset($url[0],$url[1],$url[2]);
			if($url)
			{
					foreach ($url as $key => $value) {
					if($key%2)
					{
						$_GET[$value]=isset($url[$key+1])?$url[$key+1]:'';
					}
				}
			}
			
		}else
		{
			$controllerName=isset($_GET['c']) ? ucfirst($_GET['c']) :getConfig('DEFAULT_CONTROLLER');
			$action    =isset($_GET['a']) ? $_GET['a']          :getConfig('DEFAULT_METHOD');
			unset($_GET['c'],$_GET['a']);
		}
		define('CONTROLLER_CLASS_NAME',$controllerName.'Controller');
		define('ACTION_NAME',$action);
		define('CONTROLLER_NAME',$controllerName);
		define('CONTROLLER_CLASS',CONTROLLERS_PATH.CONTROLLER_CLASS_NAME.'.php');
	}

	static function loadClass($className)
	{
		$cc=preg_match('#\w*Controller#', $className);
		$mm=preg_match('#\w*Model#', $className);
		if($cc)
		{
			//加载控制器类
			if(is_file(CONTROLLER_CLASS)&&file_exists(CONTROLLER_CLASS))
			{
				require_once CONTROLLER_CLASS;
			}else
			{
					try
					{
						throw new exception('<h1>控制器不存在:(</h1>');
					}catch(exception $a)
					{
						echo $a->getMessage();die;
					}

			}
		}else if($mm)
		{
			//加载模型类
			if(is_file(MODELS_PATH.$className.'.php')&&file_exists(MODELS_PATH.$className.'.php'))
			{
				require_once MODELS_PATH.$className.'.php';
			}else
			{
					try
					{
						throw new exception('<h1>模型不存在:(</h1>');
					}catch(exception $a)
					{
						echo $a->getMessage();die;
					}

			}
		}
		
		
		
	}

	static function newObj()
	{
		//控制器类名
		$className=CONTROLLER_CLASS_NAME;
		//方法名
		$methodName=ACTION_NAME;
		//实例化对象
		if(class_exists($className)){
			$obj=new $className(CONTROLLER_NAME,ACTION_NAME);
		}else
		{
				try
				{
					throw new exception('<h1>控制器类不存在:(</h1>');
				}catch(exception $a)
				{
					echo $a->getMessage();die;
				}
		}
		//检测方法是否存在
		if(method_exists($obj,$methodName))
		{
			call_user_func_array([$obj,$methodName],func_get_args());  
		}else
		{
				try
				{
					throw new exception('<h1>方法不存在:(</h1>');
				}catch(exception $a)
				{
					echo $a->getMessage();die;
				}
		}
	}
}






?>