<?php
class Model {
 	static private $_db = null;
 	// 	public function __construct()
	// {	
	// 	preg_match('#(.*)Model#',__CLASS__,$table);
	// 	self::from($table[1]);
	// 	var_dump($table);die;		
	// }
    static private function _getInstance(){
        if(is_null(self::$_db)){
            self::$_db = query::getSelf();
        }
        return self::$_db;
    }


	static function select()
	{
		return self::_getInstance()->select();
	}
	static function from($table)
	{
		self::_getInstance()->from($table);
	}

	static function field($field='*')
	{
		self::_getInstance()->field($field);
	}

	static function add($data='')
	{
		self::_getInstance()->add($data);
	}


   
}