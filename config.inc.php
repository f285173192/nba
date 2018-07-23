<?php
$config_array=['textTpl'=>'<xml>
                 <ToUserName><![CDATA[%s]]></ToUserName>
			     <FromUserName><![CDATA[%s]]></FromUserName>
				 <CreateTime>%s</CreateTime>
				 <MsgType><![CDATA[%s]]></MsgType>
				 <Content><![CDATA[%s]]></Content>
				 <FuncFlag>0</FuncFlag>
			</xml>',//文本回复模板
  'newTpl'=>'<xml>
                 <ToUserName><![CDATA[%s]]></ToUserName>
                 <FromUserName><![CDATA[%s]]></FromUserName>
                 <CreateTime>%s</CreateTime>
                 <MsgType><![CDATA[%s]]></MsgType>
                 <ArticleCount>1</ArticleCount>
                        <Articles>
                             <item>
                               <Title><![CDATA[%s]]></Title> 
                               <Description><![CDATA[%s]]></Description>
                               <PicUrl><![CDATA[%s]]></PicUrl>
                               <Url><![CDATA[%s]]></Url>
                             </item>                         
                        </Articles>
             </xml>',//单条图文回复模板
   'mnewTpl'=>'<xml>
                 <ToUserName><![CDATA[%s]]></ToUserName>
                 <FromUserName><![CDATA[%s]]></FromUserName>
                 <CreateTime>%s</CreateTime>
                 <MsgType><![CDATA[%s]]></MsgType>
                 <ArticleCount>%s</ArticleCount>               
                     %s                         
                 </xml>',//多条回复文本          
   'musTpl'=>'<xml>
                  <ToUserName><![CDATA[%s]]></ToUserName>
                  <FromUserName><![CDATA[%s]]></FromUserName>
                  <CreateTime>%s</CreateTime>
                  <MsgType><![CDATA[%s]]></MsgType>
                     <Music>
                           <Title><![CDATA[%s]]></Title>
                           <Description><![CDATA[%s]]></Description>
                           <MusicUrl><![CDATA[%s]]></MusicUrl>
                           <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
                     </Music>
              </xml>',//音乐回复模板 
    'MSG_TYPE_TEXT'  => 'text',//文本回复类型
    'REPLY_TYPE_NEWS'=> 'news',//图文消息类型
    'REPLY_TYPE_MUS' => 'music',//音乐回复类型
    'apikey'         => 'e3ac7bbf5b7d4e00a2b8ca1745b80ef1',//图灵apikey
    'follow_reply'   => "Hi,欢迎关注nba英文文章!"."\n"."回复数字【1】进入nba英文官网"."\n"."回复数字'【2】'进入fox英文官网"."\n"."回复数字'【3】'进入espn英文官网"."\n"."回复'【音乐】'或一段语音,有惊喜"."\n"."回复【文章】获取最新nba英文新闻",
    'text_reply'     => "回复数字【1】进入nba英文官网"."\n"."回复数字【2】进入fox英文官网"."\n"."回复数字【3】进入espn英文官网"."\n"."回复【音乐】或一段语音,有惊喜"."\n"."回复【文章】获取最新nba英文新闻",
    'nba_website'    => "nba英文官网\n"."http://www.nba.com/news/",
    'fox_website'    => "福克斯nba英文官网\n"."https://www.foxsports.com/nba",
    'espn_website'   => "espnn英文官网\n"."http://www.espn.com/nba/"        			
];