<?php 

session_start() 

?>

<!DOCTYPE html>
<html lang="TR" class="no-js" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>URL Kısaltma Servisi</title>

    <!-- Google Main Meta -->
    <meta charset='utf-8'>
    <meta name="robots" content="noindex, nofollow">
    <meta name="description" content="Secure, fast and anonymous url Shortener Services for free">

    <!-- Meta -->
    <meta content="minimum-scale=1.0, width=device-width, maximum-scale=0.6667, user-scalable=no" name="viewport">
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="tr">
    <meta name="author" content="Mertcan GOKGOZ, admin@mertcangokgoz.com, https://mertcangokgoz.com/"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="inc/costum.css">
    <script language="JavaScript">
        $(document).ready(function () {
            $("#send").click(function () {
                $('.alert').remove();
                var check = document.getElementById('longurl').value;
                var MatcUrl = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
                if (MatcUrl.test(check)) {
                    $.ajax({
                        type: "POST",
                        url: "ajax.php",
                        data: $("#shortener").serialize(),
                        success: function (data) {
                            var json = JSON.parse(data);
                                $('.result').html('');
                                $('.result').html('<input type="text" name="url" class="form-control" value="' + json.url + '">');
                        }
                    });
                } else {
                    $('.result').append('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>HATA!</strong> Tanımsız URL.</div>');
                    return false;
                }
            });
        });
    </script>
    <!-- Content -->
    <link rel="author" href="//plus.google.com/103305118431759296457/posts"/>
    <link rel="publisher" href="//plus.google.com/103305118431759296457/posts"/>
</head>
<body>
<!--[if lt IE 8]>
<p class="chromeframe">outdated</p>
<![endif]-->
<div class="container">
    <div class="row">
        <div class=" col-md-10 ">
            <h1 class='title text-center'>MER</h1>
            <p class='desc text-center'>URL Kısaltma Servisi</p>
        </div>
        <br>
        <?php if (isset($_SESSION['username']) && $_SESSION['username'] == true) { ?>
            <div class="col-md-2"><?php echo '<p >Hoşgeldin ' . htmlentities($_SESSION['username']) . ' <a href="/panel/">Hesap</a><span> | </span><a href="logout.php"> Çıkış Yap</a></p> '; ?></div>
        <?php }else{ ?>
            <div class="col-md-2"><?php echo '<p class="text-center"><a href="login.php"> Giriş Yap</a></p>' ?></div>
        <?php } ?>
    </div>
    <div class="well content">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <form method="post" action="" id="shortener" onsubmit="return false">
                        <div class="input-group input-group-lg">
                            <span class="input-group-addon" id="sizing-addon1">URL Kısalt:</span>
                            <input type="text" name="url" id="longurl" class="form-control" placeholder="URL"
                                   aria-describedby="sizing-addon1" required>
                            <input type="text" name="alias" id="alias" class="form-control" placeholder="Özel Takma Ad"
                                   aria-describedby="sizing-addon1" maxlength="6">
                            <span class="input-group-btn">
                                 <button type="submit" id="send" class="btn btn-success">Kısalt</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 center">
                <div class="result">
                    
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