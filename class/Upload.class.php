<?php
/**
 * 上传文件类库
 */
class Upload
{
	protected $_kj;
	public $address;
	public $DB;
	public $dir;

	public function __construct($kj,$addr,$db)
	{
		$this->_kj  = $kj;
		$this->address = $addr;
		$this->DB = $db;

	}
	
	/**
	 * @desc 上传文件
	 * @var none
	 * @return 
	 */
	public function upFile()
	{
		$oldName = $_FILES[$this->_kj]['name'];
		$extendName = strrchr($oldName,'.');
		$newName = time().$extendName;
		
		
		$this->dir = $this->address.'/'.$newName;
		if(is_uploaded_file($_FILES[$this->_kj]['tmp_name']))
		{
			if(move_uploaded_file($_FILES[$this->_kj]['tmp_name'], $this->dir))
			{
				return 1;
			}
			else 
			{
				return 0;
			}
		}
	}
	
	/**
	 * 插入数据库
	 */
	public function addFile($sql)
	{
		
			if($this->DB->query($sql))
			  echo 'the success of adding file';
			else 
			  echo 'the faile of adding file';
			

	}
	
	
}