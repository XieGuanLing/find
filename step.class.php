<?php

class Step {
         private $db_table = "step";

      //查询当前用户状态
    function fn_word($step_id){
        $sql = "select 'main_word','key_word'  from ".$this->db_table." where step_id = '".$step_id."'";
        $query = mysql_query($sql);
        return $query;
    }


    //根据$step_id=$current_level+1生成游戏文本
    function makegame($step_id){
    	 $sql = "select 'main_word','key_word' ,'present_num' from ".$this->db_table." where step_id = '".$step_id."'";
        $query = mysql_query($sql);
        $row = mysql_fetch_array($query);
         $array = array(
		        0=> array(0,1,2,3,4,5,6,7,8,9),
		         array(1,$row['main_word'],$row['main_word'],$row['main_word'],$row['main_word'],$row['main_word'],
		                      $row['main_word'],$row['main_word'],$row['main_word'],$row['main_word']),
		         array(2,$row['main_word'],$row['main_word'],$row['main_word'],$row['main_word'],$row['main_word'],
		                      $row['main_word'],$row['main_word'],$row['main_word'],$row['main_word']),
		         array(3,$row['main_word'],$row['main_word'],$row['main_word'],$row['main_word'],$row['main_word'],
		                     $row['main_word'],$row['main_word'],$row['main_word'],$row['main_word']),
		         array(4,$row['main_word'],$row['main_word'],$row['main_word'],$row['main_word'],$row['main_word'],
		                     $row['main_word'],$row['main_word'],$row['main_word'],$row['main_word']),
		         array(5,$row['main_word'],$row['main_word'],$row['main_word'],$row['main_word'],$row['main_word'],
		                     $row['main_word'],$row['main_word'],$row['main_word'],$row['main_word']),
		        array(6,$row['main_word'],$row['main_word'],$row['main_word'],$row['main_word'],$row['main_word'],
		                     $row['main_word'],$row['main_word'],$row['main_word'],$row['main_word']),
		         array(7,$row['main_word'],$row['main_word'],$row['main_word'],$row['main_word'],$row['main_word'],
		                     $row['main_word'],$row['main_word'],$row['main_word'],$row['main_word']),
		         array(8,$row['main_word'],$row['main_word'],$row['main_word'],$row['main_word'],$row['main_word'],
		                     $row['main_word'],$row['main_word'],$row['main_word'],$row['main_word']),
		         array(9,$row['main_word'],$row['main_word'],$row['main_word'],$row['main_word'],$row['main_word'],
		                    $row['main_word'],$row['main_word'],$row['main_word'],$row['main_word']),
         );
        $present_num = $row['present_num'];
        for($m=0; $m<$present_num; $m++){
		       $i = rand(1,9);
		       $j = rand(1,9);
		       $array[$i][$j] = $row['key_word'];
	    }
	    return $array;
    }

}
?>