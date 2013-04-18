<?php
    //根据等级查询word 和出现次数
   function queryWord($step_id){
        $sql = "select  main_word,key_word,present_num from step where step_id= '".$step_id."'";
// echo "sql语句：$sql<br>";
        $query = mysql_query($sql);
        return $query;
    }

    //根据等级查询过关得分
   function queryPlayment($step_id){
        $sql = "select  playment from step where step_id= '".$step_id."'";
// echo "sql语句：$sql<br>";
        $query = mysql_query($sql);
        return $query;
    }

        //根据等级查询名称
   function queryStepName($step_id){
        $sql = "select step_name  from step where step_id= '".$step_id."'";
// echo "sql语句：$sql<br>";
        $query = mysql_query($sql);
        return $query;
    }
?>
