<?php

ob_start();
require 'db.php';
require 'function.php';
if (isset($_POST['btnSubmit'])) {
    $eid = strtolower(trim($_POST['emp_no']));
    $dob = trim($_POST['dob']);
    $mobile = trim($_POST['mobile']);

    require_once 'db.php';
    $quiry = "select * from th_member_master where EMP_NO='$eid'";
//$quiry = "SELECT * FROM `email_master` INNER JOIN th_member_master ON email_master.EMP_NO = th_member_master.EMP_NO WHERE email_master.EMP_NO = $eid";
    $verify_employee = new Database;
    $verify_employee->query($quiry);
    $count = $verify_employee->count();
    if ($count > 0) {

        $db_emp_data = $verify_employee->resultset();
        foreach ($db_emp_data as $row) {
            $db_eid = $row["EMP_NO"];
            $db_dob = trim(date('dmy', strtotime($row['DOB'])));
            $db_mobile = trim($row['PH_NO_R']);
            if ($dob == $db_dob && $mobile == $db_mobile) {
                
                $quiry2 = "update pass_word set pswd = '$dob', first_user = 'Y' where EMP_NO=$eid ";
                $update_password = new Database;
                $update_password->query($quiry2);

                echo "<script>alert('Your Password has been updated please use your Date of Birth in ddmmyy formate to login');</script>";
                header("refresh:0;url=index.php");
            } else {
                //echo 'hi';
                echo "<script>alert('Data Entered is not matched with records Please contact Society office for reset password.' );</script>";
                header("refresh:0;url=forgot_pass.php");
            }
        }
    } else {
        //echo 'hi';
        echo "<script>alert('Data Entered is not matched with records Please contact Society office for reset password.' );</script>";
        header("refresh:0;url=forgot_pass.php");
    }
} else {
    header("location:index.php");
}
?>