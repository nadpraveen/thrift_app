<?php

session_start();
include 'cookie.php';
include 'db.php';

if (isset($_SESSION['suser'])) {
    $user_id = $_SESSION['suser'];
} elseif (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
}

$delete_hash = new Database;
$delete_hash->query("delete from user_session where emp_no = '$user_id'");
unset($_SESSION);
session_destroy();
cookie::delete('hash');
header("location:index.php");

?>