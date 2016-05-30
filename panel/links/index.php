<?php

session_start();
require('../../database.php');
require('../../function.php');
require('../../user_security.php');


if (!$giris_yapilmis) {
    print 'Bu sayfa üyelere özeldir! Lütfen giriş yapın!';
    exit;
}


$query = $db->prepare("SELECT * FROM urls WHERE username=:session ORDER BY url_id ASC");
$query->execute(array(':session' => $_SESSION['username']));
$row = $query->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET["sil"])){
    $query = $db->prepare("DELETE FROM urls WHERE url_id=:delete AND username=:username");
    $query->execute(array(':delete' => $_GET["sil"], ':username'=> $_SESSION['username']));
    $row = $query->fetchAll(PDO::FETCH_ASSOC);
    header('Location: /panel/links/');
}

?>

<!DOCTYPE html>
<html lang="TR">
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
                <h1 class="page-header">Linkler</h1>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-external-link fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo count($row) ?></div>
                        </div>
                        
                    </div>
                    
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Toplam Kısaltılmış Link Sayınız</span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                </div>
            </div>
        </div>
        <table class="table table-striped" id="dataTables-example">
            <thead>
            <tr>
                <th>ID</th>
                <th>Link</th>
                <th>Kısa Link</th>
                <th>Tarih</th>
                <th> </th>
            </tr>
            </thead>
            <tbody>
            <?php for( $i = 0; $i < count($row); $i++ ) : ?>
                <tr>
                    <td scope="row"><?php echo $i+1; ?></td>
                    <td><a href="<?php echo urldecode($row[$i]['url_link']); ?>" target="_blank"><?php echo urldecode($row[$i]['url_link']); ?></a></td>
                    <td><a href="<?php echo $server_name . $row[$i]['url_short']; ?>" target="_blank"><?php echo $row[$i]['url_short']; ?></a></td>
                    <td><?php echo $row[$i]['url_date']; ?></td>
                    <td><a href = "index.php?sil=<?php echo $row[$i]['url_id'] ?>" class="btn btn-danger" role = "button">Sil</a></td>
                </tr>
            <?php endfor; ?>
            </tbody>
        </table>
    </div>
    <div class="row">
    </div>
</div>
</div>
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
    });
    </script>
<script src="../../inc/sb-admin-2.js"></script>
<script src="../../inc/metisMenu.min.js"></script>
</body>
</html>