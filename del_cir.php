<?php
ob_start();
session_start();
require 'db.php';

$delete_circuler = new Database;
$delete_circuler->query("delete from circulers where id = ".$_GET['id']);

header("location:admin_panel.php?menu=circulers&result=success");