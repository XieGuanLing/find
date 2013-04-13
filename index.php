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

					//���������ݱ�������û� �������û������ݿⲢ�����û���ǰlevel = 1
					if(!$userStatus){
						$user->fn_insertUserStatus($fromUsername);
					}else{
						$current_level = $userStatus['current_level'];
					}
					//�����û�������������
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
        	//����������Ϊ��
        	echo "";
        	exit;
        }
    }

    private function receiveEvent($object){
		    $contentStr = "";
		    switch ($object->Event)
		    {
		        case "subscribe":
		            $contentStr = "���ã���ӭ��ע�����á�Ϊ���������������۱��������ڿ�ʼ������������Ҫ����ע�������ڹ涨ʱ�����ҵ��ر�ĺ��֡�" .
		            		"��Ϳ��Ի�ý�ҹ��ء���ս�������ޣ����������á��¸о��������飡\n1����ʼ��Ϸ��\n�����˼�¼�عˡ�\n���ܷ����а�";
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
            $contentStr = "��ӭ��ע�����ã��¸о��������顣";
            $resultStr = $this->transmitText($object, $contentStr, $funcFlag);
            return $resultStr;
        }elseif($keyword == "1") {
        	//��ʼ��Ϸ
			$step = new Step();
			$step_id = $current_level +1;
			$array = $step->makegame($step_id);

			 $contentStr = "��ӭ��ע�����ã��¸о��������顣";
            $resultStr = $this->transmitText($object, $contentStr, $funcFlag);
            return $resultStr;

        }elseif($keyword == "2") {
            //���˼�¼�ع�
        }elseif($keyword == "3") {
            //�ܷ����а�
        }else{
            $contentStr = "���ʹ�����Ϣ��������ѡ��";
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