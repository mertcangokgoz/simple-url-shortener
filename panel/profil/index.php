<?php

session_start();
require('../../database.php');
require('../../function.php');
require('../../user_security.php');


if (!$giris_yapilmis) {
    print 'Bu sayfa üyelere özeldir! Lütfen giriş yapın!';
    exit;
}
//update members set password = :password where username = :username

//form güvenlik tokeni
$form_token = md5(uniqid('auth', true));
$_SESSION['form_token'] = $form_token;

if (isset($_POST["submit"]) && $_POST['form_token'] != $_SESSION['form_token']) {
    $password1 = cleandata($_POST["password1"]);
    $password2 = cleandata($_POST["password2"]);
    $token = cleandata($_POST['form_token']);
    $password1_md = password_hash($password2, PASSWORD_DEFAULT);
    if (empty($password1) || empty($password2) || empty($token)) {
        $error = 'Lütfen eksik alanları doldurunuz.';
    } else {
        $save = $db->prepare("UPDATE members SET password = :password WHERE username = :username");
        $save->execute(array(
            ":password" => $password1_md,
            ":username" => $_SESSION['username']
        ));
        if ($save) {
            $success = "Şifreniz Başarılı bir şekilde değişti";
        } else {
            $error = "Şifreniz Değiştirilemedi.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kontrol Paneli v0.1</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <link href="../../inc/timeline.css" rel="stylesheet">
    <link href="../../inc/panel.css" rel="stylesheet">
    <link href="../../inc/metisMenu.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/t/bs/dt-1.10.11/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/t/bs/dt-1.10.11/datatables.min.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
        $( document ).ready(function() {
            $("input[type=password]").keyup(function(){
                var ucase = new RegExp("[A-Z]+");
                var lcase = new RegExp("[a-z]+");
                var num = new RegExp("[0-9]+");

                if($("#password1").val().length >= 6){
                    $("#8char").removeClass("glyphicon-remove");
                    $("#8char").addClass("glyphicon-ok");
                    $("#8char").css("color","#00A41E");
                }else{
                    $("#8char").removeClass("glyphicon-ok");
                    $("#8char").addClass("glyphicon-remove");
                    $("#8char").css("color","#FF0004");
                }

                if(ucase.test($("#password1").val())){
                    $("#ucase").removeClass("glyphicon-remove");
                    $("#ucase").addClass("glyphicon-ok");
                    $("#ucase").css("color","#00A41E");
                }else{
                    $("#ucase").removeClass("glyphicon-ok");
                    $("#ucase").addClass("glyphicon-remove");
                    $("#ucase").css("color","#FF0004");
                }

                if(lcase.test($("#password1").val())){
                    $("#lcase").removeClass("glyphicon-remove");
                    $("#lcase").addClass("glyphicon-ok");
                    $("#lcase").css("color","#00A41E");
                }else{
                    $("#lcase").removeClass("glyphicon-ok");
                    $("#lcase").addClass("glyphicon-remove");
                    $("#lcase").css("color","#FF0004");
                }

                if(num.test($("#password1").val())){
                    $("#num").removeClass("glyphicon-remove");
                    $("#num").addClass("glyphicon-ok");
                    $("#num").css("color","#00A41E");
                }else{
                    $("#num").removeClass("glyphicon-ok");
                    $("#num").addClass("glyphicon-remove");
                    $("#num").css("color","#FF0004");
                }

                if($("#password1").val() == $("#password2").val() && $("#password1").val() != "" && $("#password2").val() != "" ){
                    $("#pwmatch").removeClass("glyphicon-remove");
                    $("#pwmatch").addClass("glyphicon-ok");
                    $("#pwmatch").css("color","#00A41E");
                }else{
                    $("#pwmatch").removeClass("glyphicon-ok");
                    $("#pwmatch").addClass("glyphicon-remove");
                    $("#pwmatch").css("color","#FF0004");
                }

            });
        });
    </script>
</head>

<body>

<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/panel/">Kullanıcı Paneli</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a href="/"><i class="fa fa-home fa-fw"></i></a>
            </li>
            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="/panel/profil/"><i class="fa fa-gear fa-fw"></i>Profil</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="../../logout.php"><i class="fa fa-sign-out fa-fw"></i> Çıkış Yap</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="/panel/links"><i class="fa fa-link fa-fw"></i> Linkler</a>
                    </li>
                    <li>
                        <a href="/panel/statistic/"><i class="fa fa-bar-chart fa-fw"></i> İstatistikler</a>
                    </li>
                    <li>
                        <a href="/panel/about/"><i class="fa fa-info fa-fw"></i> Hakkımızda</a>
                    </li>
                    <li>
                        <a href="/panel/contact/"><i class="fa fa-phone fa-fw"></i> İletişim</a>
                    </li>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">

        <div class="row">
        </div>
        <div class="col-lg-6">
            <h1 class="page-header">Şifre Değiştir</h1>
            <form method="post" id="passwordForm" name="form" action="">
                <input type="password" class="input-lg form-control" name="password1" id="password1" placeholder="Yeni Şifre" autocomplete="off">
                <div class="row">
                    <div class="col-sm-6">
                        <span id="8char" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> En az 6 Karakter Olmalı<br>
                        <span id="ucase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Bir büyük harf içermeli
                    </div>
                    <div class="col-sm-6">
                        <span id="lcase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Bir küçük harf içermeli<br>
                        <span id="num" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Bir sayı içermeli
                    </div>
                </div>
                <input type="password" class="input-lg form-control" name="password2" id="password2" placeholder="Şifre Tekrar" autocomplete="off">
                <div class="row">
                    <div class="col-sm-12">
                        <span id="pwmatch" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Şifre Uyuştu
                    </div>
                </div>
                <input type="submit" class="col-xs-12 btn btn-primary btn-load btn-lg" name="submit" data-loading-text="Changing Password..." value="Change Password">
                <input type="hidden" name="form_token" value="<?php echo $form_token; ?>"/>
            </form>
            <br>
            <br>
            <br>
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
        </div>
    </div>
</div>
</div>

<div class="row">
</div>
</div>
</div>
<script src="../../inc/sb-admin-2.js"></script>
<script src="../../inc/metisMenu.min.js"></script>
</body>
</html>