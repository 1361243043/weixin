<?php
/**
  * wechat
  */
//define your token
define("TOKEN", "ysweixin");
$wechatObj = new wechatCallbackapiTest();
//载入公共文件
require_once './config/common.php';
if (isset($_GET['echostr'])) {//验证微信
    $wechatObj->valid();
}else{ //回复消息
    $wechatObj->responseMsg();
}

class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }
    //获取消息类型并进行判断
    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
              //获取消息类型
           $msgType = $postObj->MsgType;    
            //判断消息类型
            switch ($msgType) {
                case "text" :
                    $this->handletext ( $postObj );
                    break;
                case "event" :
                    $this->handleEvent ( $postObj );
                    break;
                default :
                    $this->sendNotice ( $postObj );
            }

        }else {
        	echo "";
        	exit;
        }
    }
    /**
     *处理不支持的消息类型
     * 
     */
    public function sendNotice($postObj,$content="此功能暂不支持")
    {
        //接收消息的模板
        $xmlTpl="                
                 <xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    </xml>
                ";
        //发送者
        $fromUsername=$postObj->FromUserName;
        //开发者
        $toUsername=$postObj->ToUserName;
        //创建时间
        $time=time();
        //接收类型
        $msgType="text";
        //将模板中的变量进行替换
        $resultStr = sprintf($xmlTpl, $fromUsername, $toUsername, $time, $msgType, $content);
        echo $resultStr;
    }
    /**
     *处理文本text类型的消息
     *
    */	
    public function handletext($postObj){
        global $db;
        $keyWord=$postObj->Content;
        //查询数据库是否存在$Content关键词
        $sql="SELECT * FROM  `keyword` WHERE  `keyword`  LIKE  '%".$keyWord."%' AND  `isuse` =1";
        //查询是否有该关键词的存在
        $num=$db->getNum($sql);
        $arr=$db->getData($sql);
        if($num>0){
           //循环数据
           $content='';
           $i=1;
           foreach ($arr as $key => $value) {
              $content.=$i++.".".$value['reply']."\n";
           }
           $this->sendNotice($postObj,$content);
        }else{
           $this->sendNotice($postObj,$keyWord);
        }
    }
	/**
	 *处理事件Event类型的消息
	 */
	 
	 public function handleEvent($postObj){
		 //event事件类型分为 关注/取消关注事件，点击事件等
		 //获取事件类型
		 $event=$postObj->Event;
		 switch($event)
		 {
			 case 'subscribe':
				$this->handleSubscribe($postObj);
				break;
			 case 'unsubscribe':
				$this->handleUnsubscribe($postObj);
                break;
			 default:
			    $this->sendNotice($postObj);
		 }
	 }
	 /**
     *处理事件Event类型中的订阅事件
     */
	 public function handleSubscribe($postObj){
        global $db;
        //关注人的微信号
        $formUsername=$postObj->FromUserName;
        //获取关注着的IP
        $getIp=$_SERVER["REMOTE_ADDR"];
        //获取关注的时间
        $date=date("Y-m-d H:i:s");
        $sql="INSERT INTO  `wx_users` VALUES (NULL,'".$formUsername."','".$getIp."','".$date."')";
        $result = $db->query($sql);
        if($result){
            $this->sendNotice($postObj,'欢迎您关注永胜123公众号,请根据您的需要进行操作！');
        }
     }
     /**
     *处理事件Event类型中的 取消订阅事件
     */
     public function handleUnsubscribe($postObj){
        global $db;
        $formUsername=$postObj->FromUserName;
        $sql="delete from `wx_users` where `name`='".$formUsername."' ";
        $result = $db->query($sql); 
     }
    //系统自带不能删除,检验Signature
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

?>