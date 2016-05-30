<?php
/**
 * Created by PhpStorm.
 * User: mertcan
 * Date: 09.05.2016
 * Time: 12:03
 */
session_start();
require('database.php');
require('function.php');

//form güvenlik tokeni
$form_token = md5(uniqid('auth', true));
$_SESSION['form_token'] = $form_token;

if (isset($_POST["submit"]) && $_POST['form_token'] != $_SESSION['form_token']) {
    $user = cleandata($_POST["kullanici_adi"]);
    $password = cleandata($_POST["sifre"]);
    $password2 = cleandata($_POST["sifre_tekrar"]);
    $email = cleandata($_POST["mail"]);
    $token = cleandata($_POST['form_token']);
    //Google Captcha Api Response
    $recaptcha = $_POST['g-recaptcha-response'];
    $google_url = "https://www.google.com/recaptcha/api/siteverify";
    $secret = "6Led9B8TAAAAALJQVgo5G8cNTkq9mwkXL_yD3j0o";
    $ip = $_SERVER['REMOTE_ADDR'];
    $url = $google_url . "?secret=" . $secret . "&response=" . $recaptcha . "&remoteip=" . $ip;
    $res = curt_kullan($url);
    $res = json_decode($res, true);
    $code = md5(uniqid(rand()));
    //Captcha Sonrası güvenlik kontrolleri
    if ($res['success']) {
        if (empty($email) || empty($user) || empty($password) || empty($password2) || empty($token)) {
            $error = 'Lütfen eksik alanları doldurunuz.';
        } else {
            $password_md = password_hash($password, PASSWORD_DEFAULT);
            //üyelik kontrol yapısı
            $stmt = $db->prepare("SELECT username, mail FROM members WHERE username=:uname OR mail=:umail");
            $stmt->execute(array(
                ':uname' => $user,
                ':umail' => $email
            ));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row['username'] == $user) {
                $error = "Kullanıcı Adı Kullanılıyor !";
            } elseif ($row['mail'] == $email) {
                $error = "Mail Adresi Kullanılıyor. !";
            } else {
                if (strlen($user) > 20 || strlen($user) < 6) {
                    $error = 'Kullanıcı Adı maximum 20 minimum 6 karakterden oluşmalıdır.';
                } elseif (strlen($password) < 6) {
                    $error = 'Şifre minimum 6 haneli olmalıdır.';
                } elseif (ctype_alnum($user) != true) {
                    $error = "Kullanıcı adı alfanümerik olmalı";
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error = "Lütfen geçerli bir email adresi giriniz";
                } elseif ($password != $password2) {
                    $error = "Şifre uyuşmuyor.";
                } else {
                    $save = $db->prepare("INSERT INTO members(username, password, mail,token) VALUES (:user,:password,:email,:token)");
                    $save->execute(array(
                        ":user" => $user,
                        ":password" => $password_md,
                        ":email" => $email,
                        ":token" => $code
                    ));
                    if ($save) {
                        $success = "Başarılı bir şekilde üye oldunuz yönlendiriliyorsunuz.";
                        header("Refresh:3; url=login.php");
                    } else {
                        $error = "Kayıt başarısız Yönlendiriliyorsunuz.";
                        header("Location: register.php");
                    }
                }
            }
        }
    }else{
        $error = "Lütfen bot olmadığınızı doğrulayın.";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script type="application/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="inc/main.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Passion+One' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>
    <title>Kayıt ol</title>
</head>
<body>
<div class="container">
    <div class="row main">
        <div class="panel-heading">
            <div class="panel-title text-center">
                <h1 class="title">Üyelik Paneli</h1>
                <hr/>
            </div>
        </div>
        <div class="main-login main-center">
            <form class="form-horizontal" method="post" action="">
                <div class="form-group">
                    <?php
                    if (isset($error)) {
                        ?>
                        <div class="alert alert-danger">
                            <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo htmlentities($error); ?>
                            !
                        </div>
                        <?php
                    }
                    ?>
                    
                    <?php
                    if (isset($success)) {
                        ?>
                        <div class="alert alert-success">
                            <i class="glyphicon glyphicon-ok"></i> &nbsp; <?php echo htmlentities($success); ?> !
                        </div>
                        <?php
                    }
                    ?>
                    <label for="email" class="cols-sm-2 control-label">E-Posta Adresi</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope fa"></i></span>
                            <input type="text" class="form-control" name="mail" id="mail"
                                   placeholder="Mail Adresi Giriniz" required/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="username" class="cols-sm-2 control-label">Kullanıcı Adı</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-users fa"></i></span>
                            <input type="text" class="form-control" name="kullanici_adi" id="kullanici_adi"
                                   placeholder="Kullanıcı Adı Giriniz" required/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="cols-sm-2 control-label">Şifre</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock fa-lg"></i></span>
                            <input type="password" class="form-control" name="sifre" id="sifre"
                                   placeholder="Şifrenizi Giriniz" required/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm" class="cols-sm-2 control-label">Şifre Tekrar</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock fa-lg"></i></span>
                            <input type="password" class="form-control" name="sifre_tekrar" id="sifre_tekrar"
                                   placeholder="Şifrenizi Tekrar Giriniz" required/>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="form_token" value="<?php echo $form_token; ?>"/>
                <div class="form-group">
                    <div class="g-recaptcha" data-sitekey="6Led9B8TAAAAANHFQz_qSAGQdpj56epsZk-iTufN"></div>
                    <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block login-button">Kayıt Ol
                    </button>
                </div>
                <div class="login-register">
                    <a href="login.php">Giriş Yap</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>