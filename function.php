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