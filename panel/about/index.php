<?php

session_start();
require('../../database.php');
require('../../function.php');
require('../../user_security.php');


if (!$giris_yapilmis) {
    print 'Bu sayfa üyelere özeldir! Lütfen giriş yapın!';
    exit;
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
            <div class="col-lg-12">
                <h1 class="page-header">Hakkımızda</h1>
            </div>
             <div class="col-lg-12">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eu bibendum nunc. Aenean sed diam a sapien tincidunt porta eget suscipit lorem. Quisque quis ipsum nulla. Pellentesque ornare sem vitae velit euismod, in eleifend arcu pretium. Praesent ac diam in est porta vehicula a eu sapien. Suspendisse eget mi sit amet elit cursus egestas. Suspendisse nisl metus, varius quis scelerisque vitae, ultrices condimentum lorem. Nam non eros volutpat, blandit ipsum et, sollicitudin massa. Donec massa sem, imperdiet at viverra a, faucibus ultrices lectus. Maecenas sed nulla nulla. Integer porta, mi in viverra pellentesque, dolor neque venenatis dolor, at placerat ipsum justo sed est. Nunc tempus diam fringilla, sodales odio eu, aliquet nisi. Nullam vestibulum ac nisi vel ornare. Etiam ac urna eros. Sed rutrum ante in turpis pulvinar consequat. Cras quis aliquam mauris.

Praesent libero augue, tristique vehicula dapibus in, pulvinar eget dolor. Donec rhoncus nunc finibus cursus hendrerit. Quisque arcu diam, ullamcorper sit amet vestibulum rutrum, ultricies nec tortor. Donec lectus elit, volutpat nec metus vitae, varius vehicula erat. Mauris lorem quam, bibendum eget lobortis id, hendrerit eget leo. Donec viverra ex eget urna porttitor, et convallis dolor laoreet. Vivamus nunc purus, viverra in erat in, placerat semper urna. Praesent cursus massa quis nunc dapibus, non aliquet eros lacinia. Donec vitae malesuada dui, et pulvinar ex. Proin ornare ultricies feugiat.

Suspendisse in viverra metus, sed cursus mi. Vestibulum a pretium elit. Sed felis libero, varius ac nisi id, dictum accumsan mauris. Maecenas commodo elementum metus ut porttitor. Duis ac tempus velit, nec aliquet ligula. Suspendisse velit eros, volutpat a dapibus eget, dictum id lacus. Etiam semper elit sed dui scelerisque, nec volutpat eros varius. Vivamus eget tortor turpis. Vivamus porttitor dolor libero, eu efficitur nibh commodo sed. Sed in lacinia augue. Nam facilisis scelerisque diam, vitae pulvinar metus tincidunt id.
                </p>
            </div>
        </div>
    </div>
</div>
</div>
<script src="../../inc/sb-admin-2.js"></script>
<script src="../../inc/metisMenu.min.js"></script>
</body>
</html>