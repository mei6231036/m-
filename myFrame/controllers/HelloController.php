<?php 
class HelloController extends Controller
{
	function say()
	{
		// echo '丑的出轨，帅的出柜';
		$model=new IndexModel;
		// $db=new query;
		// var_dump($db->from('play')->select());die;
		$this->view('say',['bb'=>'troye sivan 出柜']);
	}

}

?>