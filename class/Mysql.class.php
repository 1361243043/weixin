<?php
/**
 * 数据库类
 */
abstract class Db
{
	protected $hostName ;
	protected $userName;
	protected $pwd;
	protected $dbName;
	protected $charSet;
	
	public function __construct($host,$user,$pwd,$dbname,$type)
	{
		$this->hostName = $host;
		$this->userName = $user;
		$this->dbName = $dbname;
		$this->pwd = $pwd;
		$this->charSet = $type;
	}
	
	public abstract function connect();
	public abstract function selectDb();
	public abstract function query($sql);
	public abstract function getData($sql);
	public abstract function getNum($sql);
	public abstract function getOne($sql);
}

/**
 * MYSQL类库
 */
class Mysql extends Db
{
	/**
	 * @desc 连接数据库方法
	 * @var none
	 * @return link
	 */
	public function connect()
	{
		$con = mysql_connect($this->hostName,$this->userName,$this->pwd) 
		or die('link faile');
		return $con;
	}
	
	/**
	 * @desc 选择数据库
	 * @var none 
	 * @return none
	 */
	public function selectDb()
	{
		mysql_select_db($this->dbName,$this->connect())
		or die('select database faile');
		mysql_set_charset($this->charSet);
	}
	
	/**
	 * @desc 执行SQL语句
	 * @var string
	 * @return BULL/INT
	 */
	public function query($sql){
		return mysql_query($sql);
	}
	
	/**
	 * @desc 读取数据
	 * @var string
	 * @return array（二维）
	 */
	public function getData($sql){
		$query = $this->query($sql);
		while ($rs = @mysql_fetch_assoc($query)){
			$result[] = $rs;
		}
		return $result;
	}
	
	/**
	 * @desc 读取数据条数
	 * @var string
	 * @return INT
	 */
	public function getNum($sql)
	{
		$query = $this->query($sql);
		return mysql_num_rows($query);
	}
	
	/**
	 * @desc 执行SQL语句
	 * @var string
	 * @return Array(一维)
	 */
	public function getOne($sql)
	{
		$query = $this->query($sql);
		return @mysql_fetch_assoc($query);
	}
	
}

/**
 * MSSQL(SQLserver)
 */



