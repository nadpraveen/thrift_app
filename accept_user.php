<?php

error_reporting(E_ALL);
ob_start();
include 'db.php';
include 'function.php';
$date_now = date('Y-m-d h:i:s');
$fetch_user_data = new Database;
$fetch_user_data->query("select * from reg_user where EMP_NO =" . $_GET['emp_no'] . " and Reg_no =" . $_GET['rg_no'] . " and status = 'N'");
$user_count = $fetch_user_data->count();
if ($user_count > 0) {
    $user_data = $fetch_user_data->resultset();
    foreach ($user_data as $user_data) {
        $email = $user_data['Email'];
        $phone = $user_data['Mobile'];
        $name = 'Member';
    }
    $accept_user = new Database;
    $accept_user->query("update reg_user set Date_of_approval = '$date_now' , status = 'Y'");

    $password = randStrGen();
    $randstr = md5($password);
    $cheak_exsisting_pass = new Database;
    $cheak_exsisting_pass->query("select * from pass_word where EMP_NO =" . $_GET['emp_no']);
    $pass_count = $cheak_exsisting_pass->count();
    if ($pass_count == 0) {
        $insert_password = new Database;
        $query = "insert into pass_word values(" . $_GET['emp_no'] . ",'$randstr',0)";
        $insert_password->query($query);
        $message = "Dear Member your website login password is $password . Vsp Thrift Society";
        $subject= "Your Password for login";
        send_mail($email, 'Memeber', $message, $subject);
        sms($message, $phone);
        
        header("location:admin_panel.php?menu=user_reg&&msg=success");
    }
} else {

    header("location:admin_panel.php?menu=user_reg&&msg=fail");
}