<?php
//载入db配置文件
require_once './config/db_config.php';
//载入数据库操作类
require_once './class/Mysql.class.php';
//载入百度翻译类库
//require_once './translate/baidu.php';

$db = new Mysql($host, $user, $pwd, $dbname, $type);
$db->selectDb();