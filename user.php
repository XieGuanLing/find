 <?php
    //查询用户是否存在
     function isExistUser($open_id){
        $sql = "select count(*) from user where open_id='".$open_id."'";
 //echo "sql语句：$sql<br>";
        $query = mysql_query($sql);
        return $query;
    }
     //若插入用户，且会自动设置current_level,operate默认值
    function insertUser($open_id){
        $sql = "INSERT INTO user (open_id) VALUES ('".$open_id."')";
 //echo "sql语句：$sql<br>";
        mysql_query($sql);
    }
    //查询用户全部信息
      function queryUser($open_id){
        $sql = "select  * from user where open_id='".$open_id."'";
        $query = mysql_query($sql);
 echo "sql语句：$sql<br>";
        return $query;
    }




   //更新当前用户等级
    function updateUserLevel($open_id,$current_level){
        $sql = "UPDATE user SET current_level = '".$current_level."' WHERE open_id ='".$open_id."'";
        $query = mysql_query($sql);
 //echo "sql语句：$sql<br>";
        return $query;
    }
   //查询当前用户等级
   function queryUserLevel($open_id){
        $sql = "select  current_level from user where open_id= '".$open_id."'";
        $query = mysql_query($sql);
 //echo "sql语句：$sql<br>";
        return $query;
    }




    //更新用户操作
     function updateUserOperate($open_id,$operate){
        $sql = "UPDATE user SET operate = '".$operate."'  WHERE open_id ='".$open_id."'";
        $query = mysql_query($sql);
 //echo "sql语句：$sql<br>";
        return $query;
    }
    //查询当前用户操作目录
      function queryUserOperate($open_id){
        $sql = "select  operate  from user where open_id= '".$open_id."'";
        $query = mysql_query($sql);
 //echo "sql语句：$sql<br>";
        return $query;
    }






     //更新游戏结果
     function updateGameResult($open_id,$game_result){
        $sql = "UPDATE user SET game_result = '".$game_result."'  WHERE open_id = '".$open_id."'";
 //echo "sql语句：$sql<br>";
        $query = mysql_query($sql);
    }
       //查询当前游戏结果
      function queryGameResult($open_id){
        $sql = "select  game_result  from user where open_id= '".$open_id."'";
 //echo "sql语句：$sql<br>";
        $query = mysql_query($sql);
        return $query;
    }


?>