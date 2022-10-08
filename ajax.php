<?php
/**
 * Created by PhpStorm.
 * User: mertcan
 * Date: 10.05.2016
 * Time: 16:14
 */
session_start();
require('database.php');


if (isset($_POST['url'])) {
    $stmt = $db->prepare("SELECT url_short FROM urls WHERE url = :link LIMIT 1");
    $stmt->execute(array(':link' => urlencode(htmlspecialchars(trim($_POST['url'])))));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() == 1) {
        echo json_encode(array("url" => $server_name . $row["url_short"]));
    } else if (empty(trim($_POST["alias"]))) {
        //kısaltma algoritması
        $short = substr(md5(rand()), 0, 6);
        $stmt = $db->prepare("INSERT INTO urls (url, url_short, date, username) VALUES(:url_link,:url_short,:url_data,:username)");
        $stmt->execute(array(':url_link' => urlencode(htmlspecialchars(trim($_POST["url"]))), ':url_short' => $short, ':url_data' => date('d.m.Y H:i:s'), ':username' => htmlspecialchars(trim($_SESSION['username']))));
        echo json_encode(array("url" => $server_name . $short));
    } else {
        $stmt = $db->prepare("INSERT INTO urls (url, url_short, date, username) VALUES(:url_link,:url_short,:url_data,:username)");
        $stmt->execute(array(':url_link' => urlencode(htmlspecialchars(trim($_POST['url']))), ':url_short' => htmlspecialchars(trim($_POST["alias"])), ':url_data' => date('d.m.Y H:i:s'), ':username' => htmlspecialchars(trim($_SESSION['username']))));
        echo json_encode(array("url" => $server_name . $alias_data));
    }
}