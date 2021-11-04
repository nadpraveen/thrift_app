<?php
ob_start();
require 'db.php';
$update_reply_status_query = "update feed_back_reply set read_status = 'Y' where id =".$_GET['id'];
$update_reply_status = new Database;
$update_reply_status->query($update_reply_status_query);
header("location:feedback.php");