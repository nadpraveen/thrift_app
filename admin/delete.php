<?php
$get_id=$_GET['id'];
require_once '../db.php';
$query="delete from pages where id=$get_id";
$delete_page= new Database;
$delete_page->query($query);

header('location:index.php');