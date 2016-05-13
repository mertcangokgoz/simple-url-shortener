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

$result = "%^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu";
if (isset($_POST['url']) && preg_match_all($result, $_POST['url'])) {
    //get random strong string for URL
    $stmt = $db->prepare("SELECT url_short FROM urls WHERE url_link = :link LIMIT 1");
    $stmt->execute(array(':link' => urlencode(htmlspecialchars(trim($_POST['url'])))));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() == 1) {
        echo json_encode(array("url" => $server_name . $row["url_short"]));
    } else if (empty(trim($_POST["alias"]))) {
        $short = substr(bin2hex(openssl_random_pseudo_bytes(6, $short)), 3, 5);
        $stmt = $db->prepare("INSERT INTO urls (url_link, url_short, url_date) VALUES(:url_link,:url_short,:url_data)");
        $stmt->execute(array(':url_link' => urlencode(htmlspecialchars(trim($_POST["url"]))), ':url_short' => $short, ':url_data' => time()));
        echo json_encode(array("url" => $server_name . $short));
    } else {
        $stmt = $db->prepare("INSERT INTO urls (url_link, url_short, url_date) VALUES(:url_link,:url_short,:url_data)");
        $stmt->execute(array(':url_link' => urlencode(htmlspecialchars(trim($_POST['url']))), ':url_short' => $_POST["alias"], ':url_data' => time()));
        echo json_encode(array("url" => $server_name . $alias_data));
    }
}
