<?php
/**
 * Created by PhpStorm.
 * User: mertcan
 * Date: 09.05.2016
 * Time: 13:50
 */

function redirect($url)
{
    header('HTTP/1.1 301 Moved Permanently');
	header('Location: ' . $url);
	exit();
}

function cleandata($data)
{
    $data = trim($data);
    $data = htmlentities($data, ENT_QUOTES, 'utf-8' );
    $data = stripslashes($data);
    return $data;
}

function send_mail($email,$message,$subject)
{						
	require 'mailer/PHPMailerAutoload.php';
	$mail = new PHPMailer();
	$mail->IsSMTP();
    $mail->CharSet = 'UTF-8'; 
	$mail->SMTPDebug  = 0;                     
	$mail->SMTPAuth   = true;                  
	//$mail->SMTPSecure = 'tls';                 
	$mail->Host       = "smtp.live.com";      
	$mail->Port       = 25;             
	$mail->AddAddress($email);
	$mail->Username="mertcan.gokgoz@hotmail.com";  
	$mail->Password="";            
	$mail->SetFrom('mertcan.gokgoz@hotmail.com','Mertcan');
	$mail->AddReplyTo("mertcan.gokgoz@hotmail.com","Mertcan");
	$mail->Subject    = $subject;
	$mail->MsgHTML($message);
	$mail->send();
}	


function curt_kullan($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
    $curlData = curl_exec($curl);
    curl_close($curl);
    return $curlData;
}

/*function checkStatus($url) {
    $user_agent = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_exec($ch);
    $http_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($http_status_code >= 200 && $http_status_code < 300)
        return true;
    else
        return false;
}*/