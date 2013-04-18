<?php
     //插入每一次得分记录
    function insertScore($open_id,$gamelevel,$money){
        $sql ="insert into historyscore(historyscore_id,open_id,level,use_time,money) values(NULL,'".$open_id."','".$gamelevel."',NULL,'".$money."')";
 //echo "sql语句：$sql<br>";
        mysql_query($sql);
    }

	function getMyScore($open_id){
         $sql = "select level,money from historyscore where open_id ='".$open_id."'";
		 $result =mysql_query($sql);
		 return $result;
	}

	function getAllScore(){
       $sql = "SELECT SUM( money ) totalmoney, open_id FROM historyscore GROUP BY open_id ORDER BY mymoney DESC LIMIT 3";
       $result =mysql_query($sql);
	   return $result; 
	}
?>
