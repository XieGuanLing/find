<?php

	include_once("db.class.php");

	$services_json = json_decode(getenv("VCAP_SERVICES"),true);
	$mysql_config = $services_json["mysql-5.1"][0]["credentials"];

	$dbuser = $mysql_config["username"];
	$dbpass = $mysql_config["password"];
	$dbname = $mysql_config["name"];
	$hostname = $mysql_config["hostname"];
	$port = $mysql_config["port"];
	$dbhost = "$hostname:$port";

	$db = new DB($dbname, $dbhost, $dbuser, $dbpass);
	$db->execute("set names 'UTF8';");
	//$db->execute("set character_set_results=GBK;");


?>