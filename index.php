<?php
/**
 * Created by PhpStorm.
 * User: mertcan
 * Date: 27.11.2015
 * Time: 23:14
 */

//include database connection details
include('database.php');
//hide error
ini_set('display_errors', 0);
//redirect to real link if URL is set
if (!empty($_GET['url'])) {
    $filter_url = filter_var($_GET['url'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $command1 = "SELECT url_link FROM urls WHERE url_short = '" . $filter_url . "'";
    $redirect = mysqli_fetch_assoc(mysqli_query($connect, $command1));
    $redirect = $redirect["url_link"];
    header('HTTP/1.1 301 Moved Permanently');
    header("Location: " . $redirect);
}
//insert new url
if (isset($_POST['url'])) {
    //get random strong string for URL
    $short = substr(bin2hex(openssl_random_pseudo_bytes(6, $short)), 3, 5);
    //$short = substr(str_shuffle(uniqid(sha1(md5(mt_rand((double)microtime()*1000000))))), 3, 5);
    $url_data = mysqli_real_escape_string($connect, $_POST['url']);
    $command2 = "INSERT INTO urls (url_link, url_short, url_date) VALUES('$url_data','$short','" . time() . "')";
    mysqli_query($connect, $command2);
    $redirect = "?s=$short";
    header('Location: ' . $redirect);
    die;
}
?>

<!DOCTYPE html>
<html lang="en" class="no-js" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>0w1 &mdash; URL Shortener Services</title>
    <!-- Google Main Meta -->
    <meta charset='utf-8'>
    <meta name="robots" content="noindex, nofollow">
    <meta name="google-site-verification" content="LPdSncuoqCucWsdFo_mdfpsmmjXdmUUFxm3x_2-5Bik"/>
    <meta name="description" content="Secure, fast and anonymous url Shortener Services for free">

    <!-- Meta -->
    <meta content="minimum-scale=1.0, width=device-width, maximum-scale=0.6667, user-scalable=no" name="viewport">
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Content-Language" content="en">
    <meta name="author" content="Mertcan GOKGOZ, admin@mertcangokgoz.com, https://mertcangokgoz.com/"/>

    <!-- Jquery -->
    <script src="inc/jquery-1.11.3.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="inc/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="inc/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="inc/bootstrap.min.js"></script>

    <!-- Costum Javascript code -->
    <link rel="stylesheet" href="costum.css">

    <!-- Costum Javascript code -->
    <script language="JavaScript">
        function checkurl() {
            var check = document.getElementById('longurl').value;
            var MatcUrl = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
            if (MatcUrl.test(check)) {
                console.log("OK");
                return true;
            } else {
                window.alert("URL Invalid");
                return false;
            }
        }
    </script>

    <!-- Content -->
    <link rel="author" href="//plus.google.com/103305118431759296457/posts"/>
    <link rel="publisher" href="//plus.google.com/103305118431759296457/posts"/>
</head>
<body style="font-family: Arial,sans-serif,Verdana !important;">
<!--[if lt IE 8]>
<p class="chromeframe">outdated</p>
<![endif]-->
<div class="container">
    <div class="well" style="margin-top: 10px;">
        <div class="row">
            <div class="col-md-6" style="border-right: 1px solid #c2c2c2;">
                <div class="form-group">
                    <form method="post" action="" id="shortener" onSubmit="return checkurl();">
                        <label for="longurl">URL to Shorten:</label> <input required="" type="text" name="url"
                                                                            id="longurl">
                        <button type="submit" class="btn btn-success">Shorten</button>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <?php if (!empty($_GET['s'])) { ?>
                        <label for="longurl">Short URL:</label> <a
                        href="<?php echo $server_name; ?><?php echo $_GET['s']; ?>"
                        target="_blank"><?php echo $server_name; ?><?php echo $_GET['s']; ?></a><?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="footer">
    <ul>
        <li><a href="mailto:admin@mertcangokgoz.com">Feedback</a></li>
    </ul>
</div>
</body>
</html>
