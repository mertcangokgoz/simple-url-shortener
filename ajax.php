<?php
/**
 * Created by PhpStorm.
 * User: mertcan
 * Date: 10.05.2016
 * Time: 16:14
 */
require('database.php');
require('user_security.php');

//include database connection details
/*if (!$giris_yapilmis) {
    print 'Bu sayfa üyelere özeldir! Lütfen giriş yapın!';
    exit;
}*/

if (isset($_POST['url']) && preg_match_all('/(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/', $_POST['url'])) {
    //get random strong string for URL
    $stmt = $db->prepare("SELECT url_short FROM urls WHERE url_link = :link LIMIT 1");
    $stmt->execute(array(':link' => urlencode($_POST['url'])));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() == 1) {
        $site_url = "?s=" . $row["url_short"];
        echo json_encode(array("url" => $server_name . $row["url_short"], "site_url" => $server_name . $site_url));
    } else if (empty(trim($_POST["alias"]))) {
        $short = substr(bin2hex(openssl_random_pseudo_bytes(6, $short)), 3, 5);
        $url_data = $_POST["url"];
        $stmt = $db->prepare("INSERT INTO urls (url_link, url_short, url_date) VALUES(:url_link,:url_short,:url_data)");
        $stmt->execute(array(':url_link' => urlencode($url_data), ':url_short' => $short, ':url_data' => time()));
        $url = $server_name . $short;
        $site_url = $server_name . "?s=$short";
        echo json_encode(array("url" => $url, "site_url" => $site_url));
    } else {
        $url_data = $_POST['url'];
        $alias_data = $_POST["alias"];
        $stmt = $db->prepare("INSERT INTO urls (url_link, url_short, url_date) VALUES(:url_link,:url_short,:url_data)");
        $stmt->execute(array(':url_link' => urlencode($url_data), ':url_short' => $alias_data, ':url_data' => time()));
        $url = $server_name . $alias_data;
        $site_url = $server_name . "?s=$alias_data";
        echo json_encode(array("url" => $url, "site_url" => $site_url));
    }
}