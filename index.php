<?php
/**
  * wechat php test
  */
include_once("config.php");
include_once('user.class.php');
include_once('step.class.php');
//define your token
define("TOKEN", "find");
$wechatObj = new wechatCallbackapiTest();
//$wechatObj->valid();
$wechatObj->responseMsg();

class wechatCallbackapiTest
{


    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
          $current_level =0;

      	//extract post data
		if (!empty($postStr)){
		          	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
		            $fromUsername = $postObj->FromUserName;
		            $toUsername = $postObj->ToUserName;
		            $keyword = trim($postObj->Content);
		            $msgType = trim($postObj->MsgType);

		            $user = new User();
					$userQuery = $user->fn_userStatus($fromUsername);
					$userStatus  = mysql_fetch_array($userQuery);

					//不存在数据表里面的用户 则增加用户进数据库并设置用户当前level = 1
					if(!$userStatus){
						$user->fn_insertUserStatus($fromUsername);
					}else{
						$current_level = $userStatus['current_level'];
					}
					//根据用户输入生成内容
					switch ($msgType){
						    case "text":
						        $resultStr = $this->receiveText($postObj,$current_level);
						        break;
						    case "event":
						        $resultStr = $this->receiveEvent($postObj);
						        break;
						    default:
						        $resultStr = "unknow msg type: ".$keyword;
						        break;
						}
        }else {
        	//发来的数据为空
        	echo "";
        	exit;
        }
    }

    private function receiveEvent($object){
		    $contentStr = "";
		    switch ($object->Event)
		    {
		        case "subscribe":
		            $contentStr = "您好，欢迎关注找你妹。为革命保护视力，眼保健操现在开始。在这里你需要集中注意力，在规定时间内找到特别的汉字。" .
		            		"你就可以获得金币过关。挑战视力极限，就来找你妹。新感觉，新体验！\n1【开始游戏】\n【个人记录回顾】\n【总分排行榜】";
		            break;
		    }
		    $resultStr = $this->transmitText($object, $contentStr);
		    return $resultStr;
    }


    private function receiveText($object,$current_level) {
        $funcFlag = 0;
        $keyword = trim($object->Content);
        $resultStr = "";
        if ($keyword == "Hello2BizUser"){
            $contentStr = "欢迎关注找你妹，新感觉，新体验。";
            $resultStr = $this->transmitText($object, $contentStr, $funcFlag);
            return $resultStr;
        }elseif($keyword == "1") {
        	//开始游戏
			$step = new Step();
			$step_id = $current_level +1;
			$array = $step->makegame($step_id);

			 $contentStr = "欢迎关注找你妹，新感觉，新体验。";
            $resultStr = $this->transmitText($object, $contentStr, $funcFlag);
            return $resultStr;

        }elseif($keyword == "2") {
            //个人记录回顾
        }elseif($keyword == "3") {
            //总分排行榜
        }else{
            $contentStr = "发送错误信息，请重新选择";
            $resultStr = $this->transmitText($object, $contentStr, $funcFlag);
             return $resultStr;
        }
    }


    private function transmitText($object, $content, $flag = 0){
        $textTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[text]]></MsgType>
					<Content><![CDATA[%s]]></Content>
					<FuncFlag>%d</FuncFlag>
					</xml>";
        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content, $flag);
        return $resultStr;
    }


}

?>