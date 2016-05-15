<?php
/**
 * Created by PhpStorm.
 * User: mertcan
 * Date: 10.05.2016
 * Time: 16:14
 */
require('database.php');
session_start();

# uye oturum degiskenleri
$giris_yapilmis = false;
$uye = false;

//Giriş yapmamış kullanıcıyı giriş yapması için yönlendiriyoruz.
if(!isset($_SESSION['username']))
{
    header("Refresh:2; url=../../login.php");
}

# kontrol ederek bilgileri dogrulayalim
if (!empty($_SESSION["giris"]) && !empty($_SESSION["username"])) {

    # kulanici bilgisini alalim
    $stmt = $db->prepare("select * from members where username=:user LIMIT 1");
    $stmt->execute(array(':user' => $_SESSION["username"]));
    $uye = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() == 1) {
        # anahtar kontrol
        if ($_SESSION["giris"] == md5("kullanic_oturum_" . md5($uye['password']) . "_ds785667f5e67w423yjgty")) {
            session_regenerate_id();
            $giris_yapilmis = true;
        } else {
            # giris yanlis. $uye'yi silelim
            $uye = false;
        }
    }
}
?>