<?php

session_start();
require('../../database.php');
require('../../function.php');
require('../../user_security.php');


if (!$giris_yapilmis) {
    print 'Bu sayfa üyelere özeldir! Lütfen giriş yapın!';
    exit;
}

//form güvenlik tokeni
$form_token = md5(uniqid('auth', true));
$_SESSION['form_token'] = $form_token;

if (isset($_POST["submit"]) && $_POST['form_token'] != $_SESSION['form_token']) {
    $user = cleandata($_POST["name"]);
    $email = cleandata($_POST["email"]);
    $message = cleandata($_POST["message"]);
    $token = cleandata($_POST['form_token']);
    if (empty($user) || empty($email) || empty($message) || empty($token)) {
        $error = 'Lütfen eksik alanları doldurunuz.';
    } else {
        $save = $db->prepare("INSERT INTO about(name, mail, message) VALUES (:name, :mail, :message)");
        $save->execute(array(
            ":name" => $user,
            ":mail" => $email,
            ":message" => $message
        ));
        if ($save) {
            $success = "Mesajınız gönderildi.";
        } else {
            $error = "Mesaj Gönderilemedi.";
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
    <title>İletişim</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <link href="../../inc/timeline.css" rel="stylesheet">
    <link href="../../inc/panel.css" rel="stylesheet">
    <link href="../../inc/metisMenu.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
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
            <div class="col-lg-6">
                <h1 class="page-header">İletişim</h1>
                <form class="form-horizontal" role="form" method="post" action="">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Adınız</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Adınız" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Mail Adresiniz</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" name="email" placeholder="example@domain.com" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message" class="col-sm-2 control-label">Mesajınız</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="4" name="message"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="6Led9B8TAAAAANHFQz_qSAGQdpj56epsZk-iTufN"></div>
                        <div class="col-sm-10 col-sm-offset-2">
                            <input id="submit" name="submit" type="submit" value="Gönder" class="btn btn-primary">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
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
                    <input type="hidden" name="form_token" value="<?php echo $form_token; ?>"/>
                </form>
            </div>
        </div>
        <div class="col-lg-6">
        </div>
    </div>
</div>
<script src="../../inc/sb-admin-2.js"></script>
<script src="../../inc/metisMenu.min.js"></script>
</body>
</html>