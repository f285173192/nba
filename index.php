<?php
//namespace app;
//require "autoload.class.php";
//spl_autoload_register('Loader::autoload');
/**
  * wechat php test
  */

//define your token
require 'DBPDO.class.php';
require 'responseMsg.class.php';
define("TOKEN", "nbaenglish");
$wechatObj = new wechatCallbackapiTest();
$wechatObj->responseMsg();
//print_r($_SERVER);
//$wechatObj->definedItems();
//$wechatObj->valid();
//$wechatObj->getAccessToken();
//get_media_id($type='image');
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

    public function responseMsg()
    {
        //get post data, May be due to the different environments
        $resp=new responseMsg();
        $result=$resp->handle_postStr();//获取经过处理微信返回的数据对象
        //extract post data
        if (!empty($result)){
                
                switch ($result->MsgType){//关键词回复
                     case 'text':
                            $resp->kw_response();
                          break;
                     case 'image'://用户发送图片得到图文回复
                            $resp->news_response();
                          break;
                     case 'event'://用户关注
                            $resp->follow_response();
                          break;
                     case 'voice'://用户发送语音得到音乐回复
                            $resp->mu_response();
                           break;
                     /*case 'location'://用户发送地理位置    //以下类型测试用，如果需要自行根据需求开发
                            $resp->lo_response();
                            break;
                     case 'video'://用户发送视频消息  
                            $resp->vd_response();   
                            break; 
                     case 'shortvideo'://用户发送短视频消息  
                            $resp->vd_response();
                            break; 
                     case 'link'://用户发送链接消息
                            $resp->lk_response1();
                            break;*/                                 
                     default://其他调用图文回复
                            $resp->news_response();
                            break;
                } 
        }else{
            echo "";
            exit;
        }
    }
        
    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];    
                
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
    public function http_curl($url, $arr='') {
        //初始化curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        $info = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Errno'.curl_error($ch);
        }
        curl_close($ch);
        $res=json_decode($info,true);
        return $res;
//print_r($res);
//var_dump($info);
    }
     //返回access_token
    public function getAccessToken() {
        $appid = 'wxa331489eba40d451';//你的appid
        $secret= '3e19c91784db8e6d048e6d717291479a';//你的secret  
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret;
        $res = $this->http_curl($url, 'get', 'json'); 
        $access_token = $res['access_token'];
        $_SESSION['access_token'] = $access_token;
        $_SESSION['expire_time'] = time()+7000;
        return $access_token;
    }
    public function get_media_id($type='image'){
        $access_token=$this->getAccessToken();
        $filepath='http://47.105.106.28/weixin/timg.jpg';
        $filedata = array (
        "media" =>$filepath
        );
        $url = "https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=".$access_token."&type=".$type;
        $result = $this->http_curl($url,$filedata);
        var_dump($result); 
    }
     //自定义菜单
    public function definedItems() {
        header('content-type:text/html;charset=utf-8');
        echo $access_token = $this->getAccessToken();
         
        $url  = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
        $postArr = array(
           'button' => array(
           array(//第一个一级菜单
                'type'=>'view',
                'name'=>"nba官网",
                'url' => 'http://www.nba.com/news/'
            ),
            array(//第二个一级菜单 
                'type'=>'view',
                'name'=>"fox官网",
                'url' => 'https://www.foxsports.com/nba'
            ),
            array(//第三个一级菜单
                 'type'=>'view',
                'name'=>"espn官网",
                'url' => 'http://www.espn.com/nba/'
            )
          )
        );
       $postJson = json_encode($postArr);
       echo $postJson;
       $res = $this->http_curl($url,'post','json',$postJson);
        var_dump($res);
         
    }
}

?>