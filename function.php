<?php
/**
 * Created by PhpStorm.
 * User: mertcan
 * Date: 09.05.2016
 * Time: 13:50
 */

function cleandata($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}