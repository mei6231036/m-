<?php 
class Controller
{
	static public $c;
	static public $a;
	public function __construct($c,$a)
	{
		self::$c=$c;
		self::$a=$a;
		$_GET=self::clean($_GET);
		$_POST=self::clean($_POST);
		$_COOKIE=self::clean($_COOKIE);
	}

	public function view($view='',$data=array())
	{
		if(file_exists(VIEWS_PATH.self::$c.'\\'.$view.'.php'))
		{
			extract($data);
			$str=file_get_contents(VIEWS_PATH.self::$c.'\\'.$view.'.php');
			preg_match('#\{include:(.*)\}#isU',$str,$file);
			if($file)
			{
				if(file_exists(VIEWS_PATH.self::$c.'\\'.$file[1]))
				{
					$string=file_get_contents(VIEWS_PATH.self::$c.'\\'.$file[1]);
					$str=str_replace($file[0],$string,$str);
				}
			}
			$str=str_replace('{$', '<?=$',$str);
			$str=str_replace('}', '?>',$str);
			@eval('?>'.$str);
		}
	}


	public function alert($var)
	{
		echo "<script>alert('$var')</script>";
	}

	static public function clean($var)
	{
		static $arr;
		if($var)
		{
				foreach ($var as $key => &$value) {
				if(!is_array($value)&&$value)
				{
					$value=htmlentities($value);
					$value=strip_tags($value);
					$value=htmlspecialchars($value);
					$arr[$key]=$value;
				}else if($value)
				{
					self::clean($arr[$key]);
				}
				
			}
		}
		
		return $arr;
	}


}






 ?>