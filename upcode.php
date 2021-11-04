<?php

ob_start();
session_start();
$user = $_SESSION['suser'];
require_once 'db.php';
$fname = $user . "_pht.jpg";
$name = $_FILES["file"]["name"];
$type = $_FILES["file"]['type'];
$size = $_FILES["file"]['size'];
$tempname = $_FILES["file"]['tmp_name'];
$error = $_FILES["file"]['error'];

if ($type == "image/jpeg" && $size <= 2000000) {
    move_uploaded_file($tempname, "user_img/" . $fname);

    header("location:admin.php");
} else {
    echo'file type not supported or size may be large';
    header("location:admin.php");
}