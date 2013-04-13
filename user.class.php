<?php
/**
 * 用户操作表
 */


class User{


    //操作的数据表
    private $db_table = "user";

    //查询当前用户状态
    function fn_userStatus($open_id){
        $sql = "select * from ".$this->db_table." where open_id = '".$open_id."'";
        $query = mysql_query($sql);
        return $query;
    }

    //更新当前用户状态
    function fn_updateUserStatus($open_id,$current_level){

        $sql = "UPDATE `".$this->db_table."` SET `current_level` = '".$current_level."' WHERE `open_id` = '".$open_id."'";
        $query = mysql_query($sql);
        return $query;
    }

    //若用户不存在数据库则插入操作
    function fn_insertUserStatus($open_id){
        $sql = "INSERT INTO `".$this->db_table."` (`open_id`, `current_level`, `moneynum`) VALUES ($open_id, 1,0)";
        $query = mysql_query($sql);
        return $query;
    }

}