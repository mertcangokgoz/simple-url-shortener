<?php
/**
 * Created by PhpStorm.
 * User: mertcan
 * Date: 27.11.2015
 * Time: 23:14
 */

function Database_Connector()
{
    $server = "localhost";
    $username = "database_username";
    $password = "database_password";
    $database_name = "database_name";

    $connection = new mysqli($server, $username, $password, $database_name);
    return $connection;
}

$server_name = "http://" . $_SERVER['HTTP_HOST'] . "/";

$connect = Database_Connector();
$command = "CREATE TABLE IF NOT EXISTS `urls` (
  `url_id` int(11) NOT NULL AUTO_INCREMENT,
  `url_link` varchar(255) NOT NULL,
  `url_short` varchar(6) NOT NULL,
  `url_date` int(10) NOT NULL,
  PRIMARY KEY (`url_id`),
  UNIQUE KEY `url_id` (`url_id`,`url_short`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
// Perform queries
mysqli_query($connect, $command);