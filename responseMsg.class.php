<?php
//namespace app;

/*
*对回复消息进行打包
*
*/
class responseMsg{
  //常量容器
  private $configstr=[];
	//保存基本数据
  private $postData;
  //保存数据库对象
  private $DB;

	
    public function __construct(){
       require 'config.inc.php';//导入常用配置
       $this->configstr = $config_array;
    	 $this->handle_postStr();//调用处理微信服务器传过来的数据的方法
       $this->DB = new DBPDO();//保存数据库对象
    } 
    /*
    *关注回复
    *
    */               
    public function follow_response(){
    	if($this->postData->MsgType =="event"){//判断是否是event类型
    		if($this->postData->event =="subscribe"){//判断是否是关注
	        $contentStr = $this->configstr['follow_reply'];
	        $this->text_reply($contentStr);
	        } 
        }
    }
    /*
    *回复图文
    *
    */
    public function news_response(){
              $sql="select id,title,typeid,litpic,description from app_archives order by id desc limit 10";
              $new_count=$this->DB->count($sql);//文章数量
              $result=$this->DB->select($sql);//结果（二维数组）
                 $str="<Articles>";
                 foreach ($result as $key => $val) 
                 {
                   $str.="<item>
                              <Title><![CDATA[{$val['title']}]]></Title> 
                              <Description><![CDATA[{$val['description']}]]></Description>
                              <PicUrl><![CDATA[{$val['litpic']}]]></PicUrl>
                              <Url><![CDATA[http://47.105.106.28/plus/view.php?aid={$val['id']}]]></Url>
                         </item>";
                  }     
                 $str.="</Articles>";
                 
                 $resultStr= sprintf($this->configstr['mnewTpl'], $this->postData->FromUserName, $this->postData->ToUserName, time(), $this->configstr['REPLY_TYPE_NEWS'], $new_count, $str);
                 echo $resultStr;
    }
    /*
    *关键词回复
    *
    */
    public function kw_response(){
      $keyword=trim($this->postData->Content);
    	if(!empty( $keyword )){//判断关键词是否为空
           switch ($keyword) {
              case '1':
                  $contentStr = $this->configstr['nba_website'];
                  break;
              case '2':
                  $contentStr = $this->configstr['fox_website'];
                   break;
              case '3':
                  $contentStr = $this->configstr['espn_website'];
                  break;
              case '文章':
                  $this->news_response();
                  break;  
              case '音乐':
                  $this->mu_response($keyword);
                  exit;
                  break; 
              default://回复其他调用图文回复
                 //$contentStr=$this->tl_response($this->postData->keyword);//图灵自动回复，测试功能用，正式上线如需要打开注释
                  $contentStr = $this->configstr['text_reply'];
                  break;
            }     
          $this->text_reply($contentStr);
    	}          
    }   
    /*
    *音乐回复
    *@param keyword //用户输入的关键词
    *
    */
    public function mu_response($keyword=''){//音乐回复
         if($this->postData->MsgType =="voice" || $keyword =="音乐"){
            $title="2010年nba全明星主题曲More";
            $des ="More是Usher的歌曲，出自专辑：《running hits》。是2010NBA全明星赛的主题曲";
            $MusicURL='http://47.105.106.28/weixin/music/More.mp3';          
            $HQMusicUrl='http://47.105.106.28/weixin/music/More.mp3';
            $resultStr = sprintf($this->configstr['musTpl'], $this->postData->FromUserName, $this->postData->ToUserName, time(), $this->configstr['REPLY_TYPE_MUS'], $title, $des, $MusicURL, $HQMusicUrl);
            echo $resultStr;
         }
    }
    /*
    *处理地理位置消息并回复
    *
    */
    public function lo_response(){
          if($this->postData->MsgType =="location"){
             $contentStr = "您发送的是地理位置消息，您的位置：经度{$this->postData->Location_Y}，维度{$this->postData->Location_X}";
              $this->text_reply($contentStr);
          }
    }
    /*
    *处理视频消息并回复
    *
    */
    public function vd_response(){
          if($this->postData->MsgType =="video" || $this->postData->MsgType =="shortvideo")
          {
              $contentStr = "您发送的是视频消息";
              $this->text_reply($contentStr);
          }
    }
    /*
    *处理链接消息并回复
    *
    */
    public function lk_response(){
        if($this->postData->MsgType == "link")
        {
              echo $this->postData->MsgType;
              $contentStr = "您发送的是链接消息";
              $this->text_reply($contentStr);
        }
    }
    /*
    *输入其他关键词调用图灵自动回复
    *
    */
    public function tl_response($info=''){
       $url="http://www.tuling123.com/openapi/api?key=".$this->configstr['apikey']."&info=".$info."";
       $str=file_get_contents($url);
       $returnarray=json_decode($str,true);
       return $returnarray['text'];
    }
    /*
    *封装文本回复
    *
    *
    */
    private function text_reply($contentStr=''){
         $resultStr = sprintf($this->configstr['textTpl'], $this->postData->FromUserName, $this->postData->ToUserName, time(), $this->configstr['MSG_TYPE_TEXT'], $contentStr);
         echo $resultStr;
    }
    /*
    *微信服务器发来的数据，存到一个数组中
    *
    */
    public function handle_postStr(){//处理微信服务器传过来的数据，封装到数组
    	 $this->postStr = file_get_contents("php://input");
	     $postObj = simplexml_load_string($this->postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
       $this->postData=$postObj;//对象存储到变量中
       return $this->postData;
    }

}