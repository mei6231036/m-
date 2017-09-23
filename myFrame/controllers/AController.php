<?php 
class AController extends Controller
{
	function say()
	{
		$this->view('a',['a'=>'troye sivan 出柜']);
	}

}

?>