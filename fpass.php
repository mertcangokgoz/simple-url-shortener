<?php
session_start();
require('database.php');
require('function.php');

if (isset($_POST['btn-submit'])) {
    $email = trim($_POST['txtemail']);
    $stmt = $db->prepare("SELECT id FROM members WHERE mail=:email LIMIT 1");
    $stmt->execute(array(":email" => $email));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() == 1) {
        $id = base64_encode($row['id']);
        $code = md5(uniqid(rand()));
        $stmt = $db->prepare("UPDATE members SET token=:token WHERE mail=:email");
        $stmt->execute(array(":token" => $code, ":email" => $email));
        $message = "
				   Merhaba , $email
				   <br /><br />
				   İstediğiniz Üzere şifrenizi sıfırlamak için bir bağlantı oluşturduk aşağıdaki adımları izleyerek şifrenizi sıfırlayabilirisniz.
				   <br /><br />
				   <a href='$server_name/resetpassword.php?id=$id&code=$code'>Şifrenizi sıfırlamak için tıklayın</a>
				   <br /><br />
				   Teşekkürler :)
				   ";
        $subject = "Şifre Sıfırlama İsteği";

        try {
            send_mail($email, $message, $subject);
        } catch (phpmailerException $e) {
            echo $e->errorMessage();
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        $msg = "<div class='alert alert-success'>
					<button class='close' data-dismiss='alert'>&times;</button>
					Mail Adresine gereken bilgileri gönderdik $email.
                    Adımları takip ederek şifreni sıfırlayabilirsin. 
			  	</div>";
    } else {
        $msg = "<div class='alert alert-danger'>
					<button class='close' data-dismiss='alert'>&times;</button>
					<strong>Malesef!</strong>  Mail Adresi Bulunamadı
			    </div>";
    }
}
?>
<html lang="TR">
<head>
    <title>Şifremi Unuttum</title>
    <meta charset='utf-8'>
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
            <form class="form-signin" method="post">
                <h2 class="form-signin-heading">Şifreni mi Unuttun</h2>
                <hr/>

                <?php
                if (isset($msg)) {
                    echo $msg;
                } else {
                    ?>
                    <div class='alert alert-info'>
                        Lütfen şifresi sıfırlanacak hesabın mail adresini giriniz
                    </div>
                    <?php
                }
                ?>
                <label for="email" class="cols-sm-2 control-label">E-Posta Adresi</label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope fa"></i></span>
                        <label>
                            <input type="email" class="form-control" placeholder="Email address" name="txtemail"
                                   required/>
                        </label>
                    </div>
                </div>
                <hr/>
                <button class="btn btn-primary btn-lg btn-block login-button" type="submit" name="btn-submit">Yeni Şifre
                    İsteği
                </button>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script type="application/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.3/jquery.min.js"></script>
</body>
</html>