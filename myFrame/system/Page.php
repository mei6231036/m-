<?php
class Page{

	public $page = 1;	//当前页
	public $page_num = 5;	//每页显示条数

	public $count;		//数据总条数
	public $page_total;	//总页数
	public $limit = 0;	//偏移量

	public function __construct($count, $param = array()){

		if(!empty($param)) $this->setParam($param);

		$this->page = $_GET['p'] > 1 ? $_GET['p'] : 1;

		$this->count = $count;

		$this->page_total = ceil($this->count / $this->page_num);

		if($this->page > $this->page_total &&$this->page_total!=0) $this->page=$this->page_total;
		
		$this->limit = ($this->page - 1) * $this->page_num;
	}

	public function setParam($param){

		//每页显示条数
		if($param['page_num']){
			$this->page_num = $param['page_num'];
		}

	}

	public function getPage(){

		//起始页
		$start = $this->page - 3;	
		if($start < 1) $start = 1;

		//结束页
		$end = $start + 6;
		if($end > $this->page_total) $end = $this->page_total;
		
		//循环拼接页码数
		$page_str = '';
		for($i = $start; $i<= $end; $i++){
			if($this->page == $i){
				$page_str .= '<span class="current" id="nowPage">'.$i.'</span> ';
			}else{
				$page_str .= '<a href="javascript:void(0)" class="page" opt="'.$i.'">'.$i.'</a> ';
			}
		}

		//上一页
		$prev = $this->page - 1 > 1 ? $this->page - 1 : 1;
		$prev_str = '<a href="javascript:void(0)" class="page" opt="'.$prev.'">上一页</a> ';

		//下一页
		$next = $this->page + 1 > $this->page_total ? $this->page_total : $this->page + 1;
		$next_str = '<a href="javascript:void(0)" class="page" opt="'.$next.'">下一页</a> ';

		//自定义页码数
		$box = '<input type="text" size="2" id="page" onkeyup="go(this)" value="'.$this->page.'"/><a href="javascript:void(0)" class="page" opt="" id="go">GO</a> ';

		$str = ' |总页数：'.$this->page_total;

		$script = '<script>function go(obj){document.getElementById("go").attributes["opt"].nodeValue = obj.value;}</script>';		

		//当前页大于1，展示上一页
		if($this->page > 1) $page_str = $prev_str.$page_str;

		//当前页小于总页数，展示下一页
		if($this->page < $this->page_total) $page_str = $page_str.$next_str;
		$page_str=$page_str.$box.$str.$script;
		if($this->page <=1&&$this->page_total<=1) $page_str='';
		return $page_str;

	}
}






