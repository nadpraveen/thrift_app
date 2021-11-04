<?php

ob_start();
session_start();
error_reporting(NULL);
require 'db.php';
if (!isset($_SESSION['suser'])) {
    echo('please login');
    header("location:index.php");
} else {
    $user = $_SESSION['suser'];
    ?>
    <style>
        .form-btn{
            width: 100%;
            padding: 10px;
            border: 1px solid #13f82d;
            border-radius: 6px;
            margin: 15px;
            background-color: aquamarine;
        }
        .form-email{
            width: 100%;
            padding: 10px;
            border: 1px solid #13f82d;
            border-radius: 6px;
            margin: 15px;

        }

        .form_wrap{
            width: 40%;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
    <div class="form_wrap">
        <h3>Please update your Email id for retrieve your password</h3>
        <form method="post" action="" autocomplete="off">
            <input class="form-email" type="email" name="email" placeholder="ENTER YOUR  EMAIL" required>
            <input class="form-btn" type="submit" name="update_email" value="Update">
        </form>
    </div>
    <?php

    if (isset($_POST['update_email'])) {

        $email = $_POST['email'];
        if ($email == '') {
            header("location:admin_update_email.php?error=true");
        } else {
            $insert_email_query = "insert into email_master (`EMP_NO`, `EMAIL_ID`) VALUES ($user, '$email')";
            $insert_email = new Database;
            $insert_email->query($insert_email_query);
            //print_r($insert_email);
            header('location: admin.php');
        }
    }
}
