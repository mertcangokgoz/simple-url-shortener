<?php
//include database connection details
include('database.php');


//insert new url
if (isset($_POST['url'])) {
    //get random strong string for URL
+   $short = substr(bin2hex(openssl_random_pseudo_bytes(6, $short)), 3, 5);
+   //$short = substr(str_shuffle(uniqid(sha1(md5(mt_rand((double)microtime()*1000000))))), 3, 5);
    $url_data = mysqli_real_escape_string($connect, $_POST['url']);
    $command2 = "INSERT INTO urls (url_link, url_short, url_date) VALUES('$url_data','$short','" . time() . "')";
    mysqli_query($connect, $command2);
    $url = $server_name.$short;
    $site_url = $server_name."?s=$short";
    echo json_encode(array("url" => $url, "site_url" => $site_url));

}
