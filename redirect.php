<?php
/**
 * Created by PhpStorm.
 * User: mertcan@0x2e88ce4
 * Date: 12.05.2016
 * Time: 00:01
 */

require('database.php');
require('function.php');

if (!empty($_GET['url'])) {
    $stmt = $db->prepare("SELECT url FROM urls WHERE url_short = :short LIMIT 1");
    $stmt->execute(array(':short' => $_GET['url']));
    $results = $stmt->fetch(PDO::FETCH_ASSOC);

    redirect(urldecode($results['url']));
} else {
    redirect('index.php');
}
