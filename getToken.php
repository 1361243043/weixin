<?php
header("Content-Type: text/html; charset=utf-8");
$url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx6b96a6b0a765591a&secret=1fa42d5fd11329fdbb3c64dd62fb3004";
$res = file_get_contents($url); //获取文件内容或获取网络请求的内容
//echo $res;
$result = json_decode($res, true); //接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
$access_token = $result['access_token'];
//echo $access_token;

$url2 = "https://api.weixin.qq.com/cgi-bin/get_current_autoreply_info?access_token=".$access_token;
$output = file_get_contents($url2);
$contentStr = json_decode($output, true);

$data=<<<EOF 
{
  "is_add_friend_reply_open": 0,
  "is_autoreply_open": 0,
  "add_friend_autoreply_info": {
    "type": "text",
    "content": "欢迎关注，永胜123公众号！"
  },
  "message_default_autoreply_info": {
    "type": "text",
    "content": "你好，这是消息自动回复"
  },
  "keyword_autoreply_info": {
    "list": [
      {
        "rule_name": "打招呼",
        "create_time": 1497839242,
        "reply_mode": "reply_all",
        "keyword_list_info": [
          {
            "type": "text",
            "match_mode": "contain",
            "content": "hello"
          },
          {
            "type": "text",
            "match_mode": "contain",
            "content": "您好"
          },
          {
            "type": "text",
            "match_mode": "contain",
            "content": "你好"
          }
        ],
        "reply_list_info": [
          {
            "type": "text",
            "content": "北京欢迎你"
          }
        ]
      }
    ]
  }
}
EOF;
$ch = curl_init(); 

curl_setopt($ch, CURLOPT_URL, $MENU_URL); 
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_AUTOREFERER, 1); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

$info = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Errno'.curl_error($ch);
}
curl_close($ch);

var_dump($info);
?>