<?php 
class Query
{
	static protected $databaseType;
	static protected $host;
	static protected $dbname;
	static protected $user;
	static protected $pass;
	static protected $tableName;
	static protected $db;
	static protected $field='*';
	static protected $self='';

	function __construct()
	{
        $dbConfig = getConfig('DB_CONFIG');
		self::$databaseType=$dbConfig['DB_TYPE'];
		self::$host=$dbConfig['DB_HOST'];
		self::$dbname=$dbConfig['DB_NAME'];
		self::$user=$dbConfig['DB_USERNAME'];
		self::$pass=$dbConfig['DB_PASSWORD'];
		self::$db =  new PDO(self::$databaseType.':host='.self::$host.';dbname='.self::$dbname,self::$user,self::$pass);
		self::$db->exec("set names 'utf8'");
	}

	static public function getSelf()
	{
		if(self::$self instanceof self)
		{
			return self::$self;
		}else
		{
			self::$self=new self;
			return self::$self;
		}
	}

	static function select()
	{
		$obj=self::$db->query('SELECT '.self::$field.' FROM '.self::$tableName);
		if($obj)
		{
			return $obj->fetchAll(PDO::FETCH_ASSOC);
		}else
		{
					try
					{
						throw new exception(self::$db->errorInfo()[2]);
					}catch(exception $a)
					{
						echo $a->getMessage();die;
					}
		}
	}
	static function from($table)
	{
		self::$tableName=$table;
		return self::getSelf();
	}

	static function field($field='*')
	{
		if($field&&is_array($field))
		{
			self::$field=implode(',',$field);
		}else
		{
			self::$field=$field;
		}
		return self::getSelf();
	}

	static function add($data='')
	{
		if($data&&is_array($data))
		{
			$sql='insert into '.self::$tableName.' (';
			$sql.=implode(',',array_keys($data));
			$sql.=") values('";
			$sql.=implode("','",array_values($data))."')";
			return self::$db->exec($sql);
		}else
		{
			return false;
		}
	}


}
