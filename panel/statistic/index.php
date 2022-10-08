<?php

session_start();
require('../../database.php');
require('../../function.php');
require('../../user_security.php');


if (!$giris_yapilmis) {
    print 'Bu sayfa üyelere özeldir! Lütfen giriş yapın!';
    exit;
}

//Tüm Linkler
$query = $db->prepare("select * from urls");
$query->execute();
$row = $query->fetch(PDO::FETCH_ASSOC);

//Anonim Linkler
$stmt = $db->prepare("select * from urls where username=''");
$stmt->execute();
$links = $stmt->fetch(PDO::FETCH_ASSOC);

//Toplam üye sayısı
$user = $db->prepare("select * from members");
$user->execute();
$links = $user->fetch(PDO::FETCH_ASSOC);

//Toplam Kayıtlı Link sayısı oranı
$avg = $query->rowCount() - $stmt->rowCount();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kontrol Paneli v0.1</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
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
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">İstatistikler</h1>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-link fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $query->rowCount(); ?></div>
                        </div>

                    </div>

                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left">Sistemdeki Toplam Kısaltılmış Link Sayısı</span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-link fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $stmt->rowCount(); ?></div>
                        </div>

                    </div>

                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left">Toplam Anonim Link Sayısı</span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-user fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $user->rowCount(); ?></div>
                        </div>

                    </div>

                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left">Toplam Üye Sayısı</span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Üye İstatistiği
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="flot-chart">
                            <div class="flot-chart-content" id="flot-pie-chart"></div>
                            <br>
                            *Anonim kullanıcılar hesaplanırken üye olmayan kullanıcılar tarafından kısaltılan her
                            benzersiz link farklı kullanıcılar tarafından kısaltılmış
                            kabul edilmektedir.
                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {

        var data = [{
            label: "Anonim Kullanıcı Sayısı*",
            data: '<?php echo $stmt->rowCount(); ?>'
        }, {
            label: "Kayıtlı Üye Sayısı",
            data: '<?php echo $user->rowCount(); ?>'
        }];

        var plotObj = $.plot($("#flot-pie-chart"), data, {
            series: {
                pie: {
                    show: true
                }
            },
            grid: {
                hoverable: true
            },
            tooltip: true,
            tooltipOpts: {
                content: "%p.0%, %s",
                shifts: {
                    x: 20,
                    y: 0
                },
                defaultTheme: true
            }
        });

    });
</script>
<script src="../../inc/sb-admin-2.js"></script>
<script src="../../inc/metisMenu.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/excanvas.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.pie.js"></script>
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.resize.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.time.js"></script>
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/flot.tooltip/0.8.7/jquery.flot.tooltip.min.js"></script>
</body>
</html>