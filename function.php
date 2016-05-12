<?php
/**
 * Created by PhpStorm.
 * User: mertcan
 * Date: 09.05.2016
 * Time: 13:50
 */

function generateToken($length)
{
    return bin2hex(random_bytes($length));
}

function redirect($url)
{
	header("Location: $url");
}

function cleandata($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function send_mail($email,$message,$subject)
{						
	require_once('mailer/class.phpmailer.php');
	$mail = new PHPMailer();
	$mail->isSMTP(); 
	$mail->SMTPDebug  = 0;                     
	$mail->SMTPAuth   = true;                  
	$mail->SMTPSecure = 'tls';                 
	$mail->Host       = "smtp.gmail.com";      
	$mail->Port       = 587;             
	$mail->AddAddress($email);
	$mail->Username="mertcan.gokgoz@gmail.com";  
	$mail->Password="sifre";            
	$mail->SetFrom('mertcan.gokgoz@gmail.com','Mertcan');
	$mail->AddReplyTo("mertcan.gokgoz@gmail.com","Mertcan");
	$mail->Subject    = $subject;
	$mail->MsgHTML($message);
	$mail->Send();
}

function checkStatus($url) {
    $user_agent = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36";
    $ch = curl_init();
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
}
