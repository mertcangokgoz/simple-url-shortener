<?php

require('database.php');

if (isset($_GET['id']) && isset($_GET['code'])) {
    $id = base64_encode($_GET['id']);
    $code = $_GET['code'];

    $stmt = $db->prepare("SELECT * FROM members WHERE id=:uid AND token=:token");
    $stmt->execute(array(":uid" => $id, ":token" => $code));
    $rows = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() == 1) {
        if (isset($_POST['btn-reset-pass'])) {
            $pass = $_POST['pass'];
            $cpass = $_POST['confirm-pass'];

            if ($cpass !== $pass) {
                $msg = "<div class='alert alert-warning'>
						<button class='close' data-dismiss='alert'>&times;</button>
						<strong>HATA!</strong>  Şifreler Uyuşmuyor. 
						</div>";
            } else {
                $password = password_hash($cpass, PASSWORD_DEFAULT);
                $stmt = $db->prepare("UPDATE members SET password=:upass WHERE id=:uid");
                $stmt->execute(array(":upass" => $password, ":uid" => $rows['id']));

                $msg = "<div class='alert alert-success'>
						<button class='close' data-dismiss='alert'>&times;</button>
						Şifre Değiştirildi.Yönlendiriliyorsunuz
						</div>";
                header("refresh:5; url=login.php");
            }
        }
    } else {
        $msg = "<div class='alert alert-alert-danger'>
				<button class='close' data-dismiss='alert'>&times;</button>
				Böyle bir hesap bulunamadı
				</div>";

    }


}

?>
<!DOCTYPE html>
<html lang="TR">
<head>
    <meta charset='utf-8'>
    <title>Şifreni Sıfırla</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="inc/main.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Passion+One' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>
</head>
<body>
<div class="container">
    <div class="row main">
        <div class="main-login main-center">
            <strong>Merhaba !</strong> <?php echo htmlentities($rows['username']) ?> Sanırım Şifreni unuttun :)
            <form class="form-signin" method="post">
                <hr/>
                <?php
                if (isset($msg)) {
                    echo $msg;
                }
                ?>
                <label for="pass" class="cols-sm-2 control-label">Şifre</label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock fa-lg"></i></span>
                        <input type="password" class="form-control" placeholder="Yeni Şifreniz" name="pass" required/>
                    </div>
                </div> <br/>
                <label for="confirm-pass" class="cols-sm-2 control-label">Şifre Tekrar</label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock fa-lg"></i></span>
                        <input type="password" class="form-control" placeholder="Yeni Şifre Tekrarı" name="confirm-pass" required/>
                    </div>
                </div>
                <hr/>
                <button class="btn btn-primary btn-lg btn-block login-button" type="submit" name="btn-reset-pass">Şifreyi Sıfırla
                </button>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script type="application/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.3/jquery.min.js"></script>
</body>
</html>