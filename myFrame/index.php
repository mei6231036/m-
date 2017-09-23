<?php 
header('content-type:text/html;charset=utf8');
//载入初始化类
require_once '/system/App.php';
//自动加载类库
spl_autoload_register(['App','loadClass']);
//初始化
App::init();


?>