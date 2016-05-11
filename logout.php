<?php
/**
 * Created by PhpStorm.
 * User: mertcan
 * Date: 09.05.2016
 * Time: 10:19
 */
$past = time() - 3600;
session_start();
unset($_SESSION['username']);
session_destroy();
//this makes the time in the past to destroy the cookie
setcookie("username", $kadi, $past);
setcookie("password", md5($sifre), $past);
$success = "Başarılı bir şekilde çıkış yaptınız."
?>
    <html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="inc/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="inc/main.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
        <link href='https://fonts.googleapis.com/css?family=Passion+One' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>
    </head>
    <body>
    <div class="container">
        <div class="row main">
            <div class="main-login main-center">
                    <?php
                    if (isset($success)) {
                        ?>
                        <div class="alert alert-success">
                            <i class="glyphicon glyphicon-ok"></i> &nbsp; <?php echo $success; ?> !
                        </div>
                        <?php
                    }
                    ?>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="inc/bootstrap.min.js"></script>
    <script type="application/javascript" src="inc/jquery-1.12.3.min.js"></script>
    </body>
    </html>
<?php
header("Refresh:3; url=login.php");
exit;
?>