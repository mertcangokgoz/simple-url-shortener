<?php
//include database connection details
include('database.php');

$_POST = filter_input_array(FILTER_SANITIZE_STRING);

if (isset($_POST['url']) && !empty($_POST['url']) && preg_match_all('/(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/', $_POST['url'])) {
    //get random strong string for URL
    $command3 = "SELECT * FROM urls WHERE url_link= '" . urlencode($_POST['url']) . "';";
    $control_database = mysqli_query($connect, $command3);
    //check database
    if ($control_database == FALSE) {
        return FALSE;
    }
    if (mysqli_num_rows($control_database) > 0) {
        $row = mysqli_fetch_assoc($control_database);
        $site_url = "?s=" . $row["url_short"];
        echo json_encode(array("url" => $server_name . $row["url_short"], "site_url" => $server_name . $site_url));
    } else if (empty(trim($_POST["alias"]))) {
        $short = substr(bin2hex(openssl_random_pseudo_bytes(6, $short)), 3, 5);
        //$short = substr(str_shuffle(uniqid(sha1(md5(mt_rand((double)microtime()*1000000))))), 3, 5);
        $url_data = mysqli_real_escape_string($connect, $_POST["url"]);
        $command2 = "INSERT INTO urls (url_link, url_short, url_date) VALUES('" . urlencode($url_data) . "','$short','" . time() . "')";
        mysqli_query($connect, $command2);
        $url = $server_name . $short;
        $site_url = $server_name . "?s=$short";
        echo json_encode(array("url" => $url, "site_url" => $site_url));
    } else {
        $url_data = mysqli_real_escape_string($connect, $_POST['url']);
        $alias_data = mysqli_real_escape_string($connect, htmlspecialchars($_POST["alias"], ENT_QUOTES));
        $command4 = "INSERT INTO urls (url_link, url_short, url_date) VALUES('" . urlencode($url_data) . "','$alias_data','" . time() . "')";
        mysqli_query($connect, $command4);
        $url = $server_name . $alias_data;
        $site_url = $server_name . "?s=$alias_data";
        echo json_encode(array("url" => $url, "site_url" => $site_url));
    }
}

//URL Status Check Function but not activated
function checkStatus($url) {
    $user_agent = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36";
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_exec($ch);
    $http_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($http_status_code >= 200 && $http_status_code < 300)
        return true;
    else
        return false;
}