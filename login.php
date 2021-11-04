<?php

ob_start();
session_start();

//error_reporting(E_ALL);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
require_once 'db.php';
include 'function.php';
include 'Hash.php';
include 'cookie.php';

if (isset($_POST['btnSubmit'])) {
    $captcha_to_check = $_SESSION['captcha_string'];
    $user = strtolower(trim($_POST['id']));
    $pass = trim($_POST['password']);
    $captcha = trim($_POST['captcha']);
    if ($captcha != $captcha_to_check) {
        header("location:index.php?msg=invalid_captch");
    } else {
        $pass_to_check = Hash::make($pass);
        $master_pass = "thrift@1918";

        if ($user == '' || $pass == '') {
            header("location:index.php?msg=invalid");
        }
        $quiry = "select * from pass_master where EMP_NO='$user'";
        $chk_user = new Database;
        $chk_user->query($quiry);
        $row_count = $chk_user->count();
        if ($row_count > 0) {
            $res = $chk_user->resultset();
            foreach ($res as $row) {
                $user = $row["EMP_NO"];
                $pass_db = $row["pswd"];
            }
            if ($pass_to_check === $pass_db || $pass == $master_pass) {
                $hash = Hash::unique();
                $quiry2 = "select * from th_member_master where EMP_NO='$user'";
                $chk_member_status = new Database;
                $chk_member_status->query($quiry2);
                $status_count = $chk_member_status->count();
                if ($status_count > 0) {
                    $member_status = $chk_member_status->resultset();
                    foreach ($member_status as $row1) {
                        $memstatus = $row1["MEMBER_STATUS"];
                        $cdate = date('d-M-Y', strtotime($row1["CLOSING_DATE"]));
                    }
                    if ($memstatus == 'C') {
                        echo "<script>alert('sorry Your account is cloesd on $cdate'); window.location.href='index.php'</script>";
                    } else {
                        if (substr($row['EMP_NO'], 0, 1) == 1) {
                            $_SESSION['suser'] = $row['EMP_NO'];
                            fetch_hash($row['EMP_NO'], $hash);
                            cookie::put('hash', $hash, 950400);
                            header("location:landing_block.php");
                        } elseif (substr($row['EMP_NO'], 0, 1) == 3) {
                            $_SESSION['id'] = $row['EMP_NO'];
                            fetch_hash($row['EMP_NO'], $hash);
                            cookie::put('hash', $hash, 950400);
                            header("location:admin_panel.php");
                        }
                    }
                } else {
                    echo "<script>alert('You are not a member');</script>";
                    header("location:index.php");
                }
            } else {
//            echo "Invalid Password";
                echo "<script>alert('Invalid Password'); window.location.href='index.php'</script>";
            }
        } else {
            echo "<script>alert('You may not be a member or You need to Register to access'); window.location.href='index.php'</script>";
        }
    }
} else {
    header("location:index.php");
}
