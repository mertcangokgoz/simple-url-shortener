<?php
/**
 * Created by PhpStorm.
 * User: mertcan
 * Date: 27.11.2015
 * Time: 23:14
 */

//include database connection details
include('database.php');
$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
//redirect to real link if URL is set
if (!empty($_GET['url'])) {
    $filter_url = filter_var($_GET['url'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $command1 = "SELECT url_link FROM urls WHERE url_short = '" . $filter_url . "'";
    $redirect = mysqli_fetch_assoc(mysqli_query($connect, $command1));
    $redirect = urldecode($redirect["url_link"]);

	echo "<script>function go() {window.frames[0].document.body.innerHTML = '<form target=\"_parent\" method=\"get\" action=\"".$redirect."\"></form>';window.frames[0].document.forms[0].submit()}</script><iframe onload=\"window.setTimeout('go()', 10)\" src=\"about:blank\" style=\"visibility:hidden\"></iframe>";
    
    //header('HTTP/1.1 301 Moved Permanently');
    //header("Location: " . $redirect);
}
?>
<!DOCTYPE html>
<html lang="en" class="no-js" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>0w1 &mdash; URL Shortener Services</title>
    <!-- Google Main Meta -->
    <meta charset='utf-8'>
    <meta name="robots" content="noindex, nofollow">
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
        $(document).ready(function () {
            $("#send").click(function () {
                $('.alert').remove();
                var check = document.getElementById('longurl').value;
                var MatcUrl = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
                if (MatcUrl.test(check)) {
                    $.ajax({
                        type: "post",
                        url: "ajax.php",
                        data: $("#shortener").serialize(),
                        success: function (data) {
                            var json = JSON.parse(data);
                            $('.result').append('<div class="alert alert-success" role="alert">Short Url:<a target="_blank" href="' + json.url + '">' + json.url + '</a> <br> \
                            Site Url <a target="_blank" href="' + json.site_url + '">' + json.site_url + '</a> \
                            </div>');
                        }
                    });
                } else {
                    $('.result').append('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Invalid url.</div>');
                    return false;
                }
            });
        });
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
    <div class="header col-md-6 center">
        <h1 class='title'>0w1</h1>

        <p class='desc'>URL Shortener Service</p>
    </div>
    <div class="well content">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <form method="post" action="" id="shortener" onsubmit="return false">
                        <div class="input-group input-group-lg">
                            <span class="input-group-addon" id="sizing-addon1">URL to Shorten:</span>
                            <input type="text" name="url" id="longurl" class="form-control" placeholder="URL"
                                   aria-describedby="sizing-addon1">
                            <input type="text" name="alias" id="alias" class="form-control" placeholder="Custom Alias"
                                   aria-describedby="sizing-addon1" maxlength="6">
                            <span class="input-group-btn">
                                 <button type="submit" id="send" class="btn btn-success">Shorten</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 center">
                <div class="result">
                    <?php 
						/*
		                	http://0w1.xyz/?s="http gibi ilginç querylerin http ya da https ile başlama durumunun kontrolü
		                	eğer çalışıyorsa bunu kullanabilirsiniz.
		                	if koşulu çok uzun sürdüğü için or kontrolünden sonrasında alt kısma geçtim.
                    	*/
						if (!empty($_GET['s'])): ?>
						<?php if(ctype_alnum($_GET['s'])): ?>
						<?php 	
								$command3 = "SELECT * FROM urls WHERE url_short= '" . urlencode($_GET['s']) . "';"; 
								$control_database = mysqli_query($connect, $command3);
								if(mysqli_num_rows($control_database) > 0):
						?>
                        <div class="alert alert-success" role="alert">Short Url:<a
                                href="<?php echo $server_name; ?><?php echo $_GET['s']; ?>"
                                target="_blank"><?php echo $server_name; ?><?php echo $_GET['s']; ?></a><br>
                            Site Url:<a href="<?php echo $server_name; ?>?s=<?php echo $_GET['s']; ?>"
                                        target="_blank"><?php echo $server_name; ?>?s=<?php echo $_GET['s']; ?></a><br>
                        </div>
					<?php else: ?>
						<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Invalid url.</div>
                    <?php endif ?>
                    <?php else: ?>
                    	<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Invalid url.</div>
                    <?php endif ?>
                    <?php endif ?>


                </div>
            </div>
        </div>
    </div>
</div>
<div id="footer">
    <ul>
        <li><a href="mailto:admin@mertcangokgoz.com">Feedback</a></li>
        <li><a href="https://github.com/MertcanGokgoz/simple-url-shortener">Github</a></li>
    </ul>
</div>
</body>
</html>
