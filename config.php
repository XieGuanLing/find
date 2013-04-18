<?php

	$services_json = json_decode(getenv("VCAP_SERVICES"),true);
	$mysql_config = $services_json["mysql-5.1"][0]["credentials"];

	$dbuser = $mysql_config["username"];
	$dbpass = $mysql_config["password"];
	$dbname = $mysql_config["name"];
	$hostname = $mysql_config["hostname"];
	$port = $mysql_config["port"];
	$dbhost = "$hostname:$port";
	 

  $link = mysql_connect($dbhost, $dbuser, $dbpass);
  $db_selected = mysql_select_db($dbname, $link);
  mysql_query("SET NAMES utf8");


?>