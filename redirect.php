<?php
/**
 * Created by PhpStorm.
 * User: mertcan@0x2e88ce4
 * Date: 12.05.2016
 * Time: 00:01
 */

//Gerekli dosyalar ekleniyor.
require('database.php');
require('function.php');

//Gerçek URL adresine yönlendirme işlemi
if (!empty($_GET['url'])) {
    $stmt = $db->prepare("SELECT url_link FROM urls WHERE url_short = :short LIMIT 1");
    $stmt->execute(array(':short' => $_GET['url']));
    $results = $stmt->fetch(PDO::FETCH_ASSOC);

    //Yönlendirme işlemi yapılıyor.
    redirect(urldecode($results['url_link']));
    
    if(!preg_match('|^[0-9a-zA-Z]{1,6}$|', $_GET['url']))
    {
	    die('Geçerli Değil');
    }
    
}
?>