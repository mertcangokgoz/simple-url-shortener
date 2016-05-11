<?php
/**
 * Created by PhpStorm.
 * User: mertcan
 * Date: 09.05.2016
 * Time: 10:19
 */
session_start();
require('database.php');

//Zaten giriş yapmış kullanıcıyı geri yönlendiriyoruz.
if (isset($_SESSION['username'])) {
    $warning = "Zaten Giriş yapmışsınız Sayın " . $_SESSION['username'] . " Yönlendiriliyorsunuz.";
    header("Refresh:2; url=index.php");
}

if (isset($_POST["submit"])) {
    $kadi = $_POST["username"];
    $sifre = $_POST["password"];
    $stmt = $db->prepare("select * from members where username = :kadi");
    $stmt->execute(array(":kadi" => $kadi));
    $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() == 1 and password_verify($sifre, $userRow['password'])) {
        //Giriş yapacak olan kullanıcının oturum bilgilerini kayıt ediyoruz.
        $_SESSION["giris"] = md5("kullanic_oturum_" . md5($userRow['password']) . "_ds785667f5e67w423yjgty");
        $_SESSION["username"] = $_POST["username"];
        //Kullanıcıya çerez tanımlaması yapıyoruz.
        setcookie("username", $kadi, time() + 3600);
        setcookie("password", md5($sifre), time() + 3600);
        $success = "Başarılı bir şekilde giriş yaptınız Yönlendiriliyorsunuz...";
        header("Refresh:3; url=index.php");
    } else {
        $error = "Giriş Yapılamadı Kullanıcı Adı veya şifre yanlış";
    }
}
?>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="inc/bootstrap.min.css">

    <!-- Website CSS style -->
    <link rel="stylesheet" type="text/css" href="inc/main.css">

    <!-- Website Font style -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">

    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Passion+One' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>

    <title>Kullanıcı Girişi</title>
</head>
<body>
<div class="container">
    <div class="row main">
        <div class="panel-heading">
            <div class="panel-title text-center">
                <h1 class="title">Kullanıcı Giris</h1>
                <hr/>
            </div>
        </div>
        <div class="main-login main-center">
            <form class="form-horizontal" method="post" action="">
                <?php
                if (isset($error)) {
                    ?>
                    <div class="alert alert-danger">
                        <i class="glyphicon glyphicon-remove"></i> &nbsp; <?php echo $error; ?> !
                    </div>
                    <?php
                }
                ?>
                <?php
                if (isset($success)) {
                    ?>
                    <div class="alert alert-success">
                        <i class="glyphicon glyphicon-ok"></i> &nbsp; <?php echo $success; ?> !
                    </div>
                    <?php
                }
                ?>
                <?php
                if (isset($warning)) {
                    ?>
                    <div class="alert alert-warning">
                        <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $warning; ?> !
                    </div>
                    <?php
                }
                ?>
                <div class="form-group">
                    <label for="username" class="cols-sm-2 control-label">Kullanıcı Adı</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-users fa" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" name="username" id="username"
                                   placeholder="Kullanıcı Adınız" required/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="cols-sm-2 control-label">Şifre</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                            <input type="password" class="form-control" name="password" id="password"
                                   placeholder="Şifreniz" required/>
                        </div>
                    </div>
                </div>

                <div class="form-group ">
                    <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block login-button">Giriş
                        Yap
                    </button>
                </div>
                <div class="login-register">
                    <a href="register.php">Kayıt OL</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="inc/bootstrap.min.js"></script>
<script type="application/javascript" src="inc/jquery-1.12.3.min.js"></script>
</body>
</html>