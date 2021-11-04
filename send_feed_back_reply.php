<?php

ob_start();
session_start();

require 'db.php';
require 'function.php';
include 'sanitize.php';
//if (isset($_POST['btn_feed_back_reply'])) {
//    $message = $_POST['feed_back_reply'];
//    $subject = "Reply for Feedback / Sggestion";
//    $feed_back_emp = $_POST['feed_back_emp_id'];
//    $feed_back_id = $_POST['feed_back_id'];
//    $name = "Members";
//    $get_emial_id_query = "select * from email_master where EMP_NO = " . $feed_back_emp;
//    $get_email_id = new Database;
//    $get_email_id->query($get_emial_id_query);
//    $email_count = $get_email_id->count();
//    if ($email_count > 0) {
//        $email_id = $get_email_id->resultset();
//        foreach ($email_id as $email_id) {
//            $to_email = $email_id['EMAIL_ID'];
//        }
//        send_mail($to_email, $name, $message, $subject);
//        $update_feed_back_status_query = "update feed_back set read_status = 'Y' where id =" . $feed_back_id;
//        $update_feed_back_status = new Database;
//        $update_feed_back_status->query($update_feed_back_status_query);
//        header("location:admin_panel.php?menu=feed_back&sent=success");
//    } else {
//        header("location:admin_panel.php?menu=feed_back&sent=fail");
//    }
//}

if (isset($_POST['btn_feed_back_reply'])) {
    $message = escape(trim($_POST['feed_back_reply']));
    $feed_back_emp = $_POST['feed_back_emp_id'];
    $feed_back_id = $_POST['feed_back_id'];
    $admin_id = $_SESSION['id'];
    $insert_feed_back_reply_query = "INSERT INTO `feed_back_reply` (`feed_back_id`, `reply`, `reply_to`, `reply_by`, `reply_on`, `read_status`) "
            . "VALUES ('$feed_back_id', '$message', '$feed_back_emp', '$admin_id', now(), 'N') ";
    $insert_feed_back_reply = new Database;
    $insert_feed_back_reply->query($insert_feed_back_reply_query);

    $update_feed_back_status_query = "update feed_back set read_status = 'Y' where id =" . $feed_back_id;
    $update_feed_back_status = new Database;
    $update_feed_back_status->query($update_feed_back_status_query);
    header("location:admin_panel.php?menu=feed_back&sent=success");
} else {
    header("location:admin_panel.php?menu=feed_back&sent=fail");
}
?>