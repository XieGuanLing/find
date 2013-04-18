<?php
include_once("config.php");
include_once("user.php");
include_once("step.php");
include_once("score.php");

//define your token
define("TOKEN", "findnimeiconfig");
$wechatObj = new wechatCallbackapiTest();
$wechatObj->responseMsg();

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
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
				$type = trim($postObj->MsgType);

				switch ($type)
				{
					case "text":
						$this->receiveText($postObj);
						break;
					case "event":
						$this->receiveEvent($postObj);
						break;
					default:
						break;
				}
        }else {
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
	private function makeText($fromUsername, $toUsername, $contentStr)
	{
		$time = time();
		$textTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[text]]></MsgType>
					<Content><![CDATA[%s]]></Content>
					<FuncFlag>0<FuncFlag>
					</xml>"; 
		if (empty($contentStr)) $contentStr = "抱歉，当前网络繁忙，请稍后再试.";
		return sprintf($textTpl, $fromUsername, $toUsername, $time, $contentStr);
	}
   	private function checkUser($fromUsername){
		$userQuery  = queryUser($fromUsername);
		$userStatus  = mysql_fetch_array($userQuery);
		if(!$userStatus){
			 insertUser($fromUsername);
	     }
	}

	private function setStatus($fromUsername,$status){
		   $time = time();
	       $operate = '{"flag":"'.$status .'","index":"0","time":"'.$time .'"}';
           updateUserOperate($fromUsername,$operate);
	}

	private function getStatus($fromUsername){
		  $operateResult = queryUserOperate($fromUsername);
          $operateRow = mysql_fetch_array($operateResult);
          $operateJson =$operateRow['operate'];
		  $operate = json_decode($operateJson);
		  return $operate->flag;
	}
	private	function getGameStr($fromUsername){

		  $levelResult = queryUserLevel($fromUsername);
		  $level = mysql_fetch_array($levelResult);
		  $current_level = $level['current_level'];

		  $wordResult =queryWord($current_level);
		  $word = mysql_fetch_array($wordResult);
		  $present_num = $word['present_num'];

		  $stepNameResult = queryStepName($current_level);
		  $stepRow =  mysql_fetch_array($stepNameResult);
		  $step_name = $stepRow['step_name'];

		  $gameStr = "第".$current_level."关：".$step_name."。在下列方阵中找到其中一个\"".$word['key_word']."\"。例如输入27表示第2行第7列\n";

		  $array = array(
				'0'=> array("0"," 1"," 2"," 3"," 4"," 5"," 6"," 7"," 8"," 9"),
				 array(1,$word['main_word'],$word['main_word'],$word['main_word'],$word['main_word'],$word['main_word'],
							  $word['main_word'],$word['main_word'],$word['main_word'],$word['main_word']),
				 array(2,$word['main_word'],$word['main_word'],$word['main_word'],$word['main_word'],$word['main_word'],
							  $word['main_word'],$word['main_word'],$word['main_word'],$word['main_word']),
				 array(3,$word['main_word'],$word['main_word'],$word['main_word'],$word['main_word'],$word['main_word'],
							 $word['main_word'],$word['main_word'],$word['main_word'],$word['main_word']),
				 array(4,$word['main_word'],$word['main_word'],$word['main_word'],$word['main_word'],$word['main_word'],
							 $word['main_word'],$word['main_word'],$word['main_word'],$word['main_word']),
				 array(5,$word['main_word'],$word['main_word'],$word['main_word'],$word['main_word'],$word['main_word'],
							 $word['main_word'],$word['main_word'],$word['main_word'],$word['main_word']),
				array(6,$word['main_word'],$word['main_word'],$word['main_word'],$word['main_word'],$word['main_word'],
							 $word['main_word'],$word['main_word'],$word['main_word'],$word['main_word']),
				 array(7,$word['main_word'],$word['main_word'],$word['main_word'],$word['main_word'],$word['main_word'],
							 $word['main_word'],$word['main_word'],$word['main_word'],$word['main_word']),
				 array(8,$word['main_word'],$word['main_word'],$word['main_word'],$word['main_word'],$word['main_word'],
							 $word['main_word'],$word['main_word'],$word['main_word'],$word['main_word']),
				 array(9,$word['main_word'],$word['main_word'],$word['main_word'],$word['main_word'],$word['main_word'],
							$word['main_word'],$word['main_word'],$word['main_word'],$word['main_word']),
				 );

			 for($m=0; $m<$present_num; $m++){
				   $i = rand(1,9);
				   $j = rand(1,9);
				   $a = 0; //不能用a because the position of 'a' was the 0th (first) character.
				   $array[$i][$j] =$word['key_word'];
				   $game_result .="$i"."$j"."$a";
			  }
			   updateGameResult($fromUsername,$game_result);

			 for($i = 0; $i < 10; $i++){
				   for($j = 0; $j < 10; $j++){
						 $gameStr .=$array[$i][$j];
				   }
				$gameStr .="\n";
			}
			return $gameStr;
	}
	private	function play($fromUsername,$findme){
		 $userResult= queryUser($fromUsername);
		 $user = mysql_fetch_array($userResult);
		 $gameresultStr = $user['game_result'];

		$pos = strpos($gameresultStr, $findme);
		if ($pos === false) {
				$gameStr .="回答错误，请重新选择";
			    $gameStr .=$this->getGameStr($fromUsername);
				//重新生成这一关的游戏
		} else {
				$gamelevel= $user['current_level'];
				$current_level = $gamelevel+1;
				//在插入得分记录
				$stepResult = queryPlayment($gamelevel);
				$payRow =  mysql_fetch_array($stepResult);
				$money = $payRow['playment'];

				insertScore($fromUsername,$gamelevel,$money);

				//更新user等级
			   updateUserLevel($fromUsername,$current_level);

			  $gameStr ="恭喜你，找到妹子。现在进入";
			  $gameStr .=$this->getGameStr($fromUsername);
			}
		return $gameStr;
	}
	private function receiveEvent($postObj)
	{
		$fromUsername = $postObj->FromUserName;
		$toUsername = $postObj->ToUserName;
		$eventType = $postObj->Event;

        $this->checkUser($fromUsername);
	
		$contentStr = "";
		switch ($eventType)
		{
			case "subscribe":
				$contentStr ="为革命保护视力，眼保健操现在开始。在这里你需要集中注意力，在规定时间内找到特别的汉字。你就可以获得金币过关。挑战视力极限，就来找你妹。回复数字立即参选！\n\n1【开始游戏】\n\n2【个人记录回顾】\n\n3【总分排行榜】";

				break;
		}
		$resultStr = $this->makeText($fromUsername, $toUsername,   $contentStr);
		echo $resultStr;
	}
    private function receiveText($postObj)
    {
		$fromUsername = $postObj->FromUserName;
		$toUsername = $postObj->ToUserName;
		$keyword = trim($postObj->Content);
       if(!empty( $keyword ))
                {
		            $mainContentStr = "为革命保护视力，眼保健操现在开始。在这里你需要集中注意力，在规定时间内找到特别的汉字。你就可以获得金币过关。挑战视力极限，就来找你妹。回复数字立即参选！\n\n1【开始游戏】\n\n2【个人记录回顾】\n\n3【总分排行榜】";

				
				  
		            $status = $this->getStatus($fromUsername);

              		if($status == "main"){	
							if($keyword == "1"){
								//开始游戏
								$this->setStatus($fromUsername,"game");
								$contentStr =$this->getGameStr($fromUsername);
								$resultStr = $this->makeText($fromUsername, $toUsername,   $contentStr); 
							}elseif($keyword == "2"){
								//个人记录回顾					
								$this->setStatus($fromUsername,"record");
								$contentStr =$this->getMyHistoryScore($fromUsername);
								$resultStr = $this->makeText($fromUsername, $toUsername,   $contentStr); 
							}elseif($keyword == "3"){
								//总分排行					
								$this->setStatus($fromUsername,"score");
								$contentStr = "总分排行榜，返回主目录请输入#";
								$resultStr = $this->makeText($fromUsername, $toUsername,   $contentStr); 
							}else{										
								$contentStr = $mainContentStr;
								$resultStr = $this->makeText($fromUsername, $toUsername,   $contentStr); 
							}					
				    }elseif($status == "game"){					
							if($keyword == "#"){
								//返回主目录										
								$this->setStatus($fromUsername,"main");
								$contentStr = $mainContentStr;
								$resultStr = $this->makeText($fromUsername, $toUsername,   $contentStr); 
							}else{
								//验证输入的数字						
							
								$contentStr = $this->play($fromUsername,$keyword);
								$resultStr = $this->makeText($fromUsername, $toUsername,   $contentStr); 
							}					
				    }elseif($status == "record"){					
							if($keyword == "#"){
								//返回主目录
												
								$this->setStatus($fromUsername,"main");	
								$contentStr = $mainContentStr;
								$resultStr = $this->makeText($fromUsername, $toUsername,   $contentStr); 
							}					
				    }elseif($status == "score"){					
							if($keyword == "#"){
								//返回主目录
												
								$this->setStatus($fromUsername,"main");
								$contentStr = $mainContentStr;
								$resultStr = $this->makeText($fromUsername, $toUsername,   $contentStr); 
							}					
				    }
                	echo $resultStr;
                }else{
                	echo "Input something...";
                }
    }
	private function getMyHistoryScore($fromUsername){
      $myscoreResult= getMyScore($fromUsername);
      $score = mysql_fetch_array($myscoreResult);
      $scoreStr = $score['level'];
	  $moneyStr = $score['money'];
	  $num = mysqli_stmt_num_rows($myscoreResult);
      $tpl = "第%S关得分%s\n";
	  for($i=0; $i<$num;$i++){
		 $result .= sprintf(tpl,$scoreStr, $moneyStr);
	  }
	    $result .= "返回主目录请输入\"#\"";
	  echo $result;
	}


}

?>