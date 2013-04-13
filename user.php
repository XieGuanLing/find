<?php
/**
 * 用户操作表
 */


class User{


    //操作的数据表
    private $db_table = "toguess";

    //查询当前用户状态
    function fn_userStatus($FakeID){
        $sql = "select * from toguess where FakeID = '".$FakeID."'";
        $query = mysql_query($sql);
        return $query;
    }

    //更新当前用户状态
    function fn_updateUserStatus($fakeID,$operate){
	
        $sql = "UPDATE `toguess` SET `Operate` = '".$operate."' WHERE `FakeID` = '".$fakeID."'";
        $query = mysql_query($sql);
        return $query;
    }

    //若用户不存在数据库则插入操作
    function fn_insertUserStatus($FakeID,$operate){
        $sql = "INSERT INTO `".$this->db_table."` (`UserID`, `FakeID`, `Operate`) VALUES (NULL, '".$FakeID."', '".$operate."')";
        $query = mysql_query($sql);
        return $query;
    }

}