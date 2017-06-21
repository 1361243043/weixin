<?php
/**
 * 分页类库
 */
class Page
{
	public $nowPage;
	public $tableName;
    public  $db;
	public $size;
	public $page = array();
	public function __construct($now,$table,$size)
	{
		global $db;
		$this->nowPage = $now;
		$this->tableName = $table;
		$this->size = $size;
		$this->db = $db;
	}
	
	/**
	 * 
	 */
	public function getPage()
	{
		$sql = "select * from `".$this->tableName."` 
		        where 1 ";
		$dataNum = $this->db->getNum($sql);
		$totalPage = ceil($dataNum/$this->size);
		if($this->nowPage <= 1)
		{
			$up = 1;
			$down = $this->nowPage+1;
		}
		if($this->nowPage >= $totalPage)
		{ 
			$up = $this->nowPage-1;
			$down = $totalPage;
		}
		if($this->nowPage>1 && $this->nowPage<$totalPage)
		{
			$up = $this->nowPage-1;
			$down = $this->nowPage+1;
		}
		
		$this->page['up'] = $up;
		$this->page['down'] = $down;
		$this->page['total'] = $totalPage;
		return $this->page;
	}
	
	/**
	 * 
	 */
	public function getList()
	{
		$start = ($this->nowPage-1)*$this->size;
		$sql = "select * from `".$this->tableName."`
		       limit $start,$this->size";
		$data = $this->db->getData($sql);
		return $data;
	}
}