<?php

error_reporting(E_ALL);
ob_start();
include 'db.php';
include 'function.php';
include 'sanitize.php';


if (isset($_POST['emp_no']) && isset($_POST['mobile']) && isset($_POST['email']) && isset($_POST['aadhar'])) {
    $date_now = date('Y-m-d h:i:s');

    $d_no = escape($_POST['d_no']);
    $street = escape($_POST['street']);
    $area = escape($_POST['area']);
    $city = escape($_POST['city']);
    $dictrict = escape($_POST['district']);
    $state = escape($_POST['state']);
    $pin = escape($_POST['pin']);
    $p_d_no = escape($_POST['p_d_no']);
    $p_street = escape($_POST['p_street']);
    $p_area = escape($_POST['p_area']);
    $p_city = escape($_POST['p_city']);
    $p_district = escape($_POST['p_district']);
    $p_state = escape($_POST['p_state']);
    $p_pin = escape($_POST['p_pin']);
    $phone = $_POST['mobile'];
    $email = $_POST['email'];
    $name = 'Member';

    $chk_existing_reg = new Database;
    $chk_existing_reg->query("select * from reg_user where EMP_NO =" . $_POST['emp_no']);
    $existing_count = $chk_existing_reg->count();
    if ($existing_count == 0) {
        $insert_reg_data = new Database;
        $insert_reg_data->query("INSERT INTO `reg_user` (`EMP_NO`, `Mobile`, `Email`, `Aadhar`, `d_no`, `street`, `area`, `city`, "
                . "`district`, `state`, `pin`, `p_d_no`, `p_street`, `p_area`, `p_city`, `p_district`, `p_state`, `p_pin`, "
                . "`Date_of_registration`, `Date_of_approval`, `Status`) "
                . "VALUES ('$_POST[emp_no]', '$phone', '$email', '$_POST[aadhar]', "
                . "'$d_no', '$street', '$area', '$city', '$dictrict', '$state', '$pin', "
                . "'$p_d_no', '$p_street', '$p_area', '$p_city', '$p_district', '$p_state', '$p_pin', "
                . "'$date_now', NULL, 'N')");
        $reg_no = $insert_reg_data->lastInsertId();
        $message = "Dear Member your website Registration Number  is $reg_no . Vsp Thrift Society";
        //echo $message;

        $subject = 'Confirmation of Registration';

        send_mail($email, $name, $message, $subject);
        sms($message, $phone);
    } else {
        $update_reg_data = new Database;
        $update_reg_data->query("update reg_user set Mobile = $_POST[mobile], Email = '$_POST[email]', Aadhar = '$_POST[aadhar]', "
                . "d_no = '$d_no', "
                . "street = '$street', "
                . "area = '$area', "
                . "city = '$city', "
                . "district = '$dictrict', "
                . "state = '$state', "
                . "pin = '$pin', "
                . "p_d_no = '$p_d_no', "
                . "p_street = '$p_street', "
                . "p_area = '$p_area', "
                . "p_city = '$p_city', "
                . "p_district = '$p_district', "
                . "p_state = '$p_state', "
                . "p_pin = '$p_pin'");
    }

//    print_r($insert_reg_data);
//    $insert_reg_data->bind(':emp_no', $_POST['emp_no']);
//    $insert_reg_data->bind(':mobile', $_POST['mobile']);
//    $insert_reg_data->bind(':email', $_POST['email']);
//    $insert_reg_data->bind(':aadhar', $_POST['aadhar']);
//    $insert_reg_data->bind(':d_no', escape($_POST['d_no']));
//    $insert_reg_data->bind(':street', escape($_POST['street']));
//    $insert_reg_data->bind(':area', escape($_POST['area']));
//    $insert_reg_data->bind(':city', escape($_POST['city']));
//    $insert_reg_data->bind(':district', escape($_POST['district']));
//    $insert_reg_data->bind(':state', escape($_POST['state']));
//    $insert_reg_data->bind(':pin', $_POST['pin']);
//    $insert_reg_data->bind(':p_d_no', escape($_POST['p_d_no']));
//    $insert_reg_data->bind(':p_street', escape($_POST['p_street']));
//    $insert_reg_data->bind(':p_area', escape($_POST['p_area']));
//    $insert_reg_data->bind(':p_city', escape($_POST['p_city']));
//    $insert_reg_data->bind(':p_district', escape($_POST['p_district']));
//    $insert_reg_data->bind(':p_state', escape($_POST['p_state']));
//    $insert_reg_data->bind(':p_pin', $_POST['p_pin']);
//    $insert_reg_data->bind(':reg_date', $date_now);
//    $insert_reg_data->bind(':aproved_date', NULL);
//    $insert_reg_data->bind(':status', 'N');
//
//    $insert_reg_data->dump();
//    $insert_reg_data->execute();
//    header("location:reg.php?success");
}


if (isset($_POST['re_emp_no']) && isset($_POST['reg_no'])) {
    $get_user_reg_data = new Database;
    $get_user_reg_data->query("select * from reg_user where EMP_NO = " . $_POST['re_emp_no'] . " and Reg_no = " . $_POST['reg_no']);
    $reg_count = $get_user_reg_data->count();
    if ($reg_count > 0) {
        return TRUE;
    } else {
        echo"<script> alert('Data entered Not matched with Records ')</script>";
    }
}


if (isset($_POST['emp_no']) && $_POST['pourpose']) {
    $emp_no = trim($_POST['emp_no']);
    $purpose = trim($_POST['pourpose']);
    $get_emp_name = new Database;
    $get_emp_name->query("select * from th_member_master where EMP_NO = $emp_no");

    $emp_name = $get_emp_name->resultset();
    foreach ($emp_name as $emp_name) {
        $name = $emp_name['EMP_NAME'];
        $email = $emp_name['EMAIL_ID'];
        $phone = $emp_name['PH_NO_R'];
    }

    $otp = randStrGen();
    $time_now = date('Y-m-d H:i:s');
    $message = " Dear Member your OTP for Changing your " . $purpose . "  is " . $otp . " .Vsp Thrift Society";
    $subject = 'OTP for Recover change';
    $chk_existing_otp = new Database;
    $chk_existing_otp->query("select * from otp_tbl where EMP_NO = $emp_no and PURPOSE = '$purpose'");
    $otp_count = $chk_existing_otp->count();
    if ($otp_count == 0) {
        $insert_otp = new Database;
        $insert_otp->query("insert into otp_tbl (`EMP_NO`, `OTP`,`PURPOSE`, `to_mobile`, `to_email`, `created_time`, `status`) "
                . "values('$emp_no', '$otp', '$purpose', '$phone', '$email', '$time_now', 'UNUSED')");
        send_mail($email, $name, $message, $subject);
        sms($message, $phone);
    } else {
        $otp_chk = $chk_existing_otp->resultset();
        foreach ($otp_chk as $chk) {
            $status = $chk['status'];
        }
        if ($status == 'USED' || $status == 'EXPIRED') {
            $insert_otp = new Database;
            $insert_otp->query("insert into otp_tbl (`EMP_NO`, `OTP`,`PURPOSE`, `to_mobile`, `to_email`, `created_time`, `status`) "
                    . "values('$emp_no', '$otp', '$purpose', '$phone', '$email', '$time_now', 'UNUSED')");
            send_mail($email, $name, $message, $subject);
            sms($message, $phone);
        }
    }
}

if (isset($_POST['type']) && isset($_POST['re_emp_no']) && isset($_POST['re_pourpose'])) {
    //if(isset($_POST['btnReOtp'])){  

    $emp_no = $_POST['re_emp_no'];
    $purpose = $_POST['re_pourpose'];
    $status = $_POST['type'];
    $get_otp_query = "select * from otp_tbl where EMP_NO = $emp_no and PURPOSE = '$purpose' and status = '$status'";
    $get_otp = new Database;
    $get_otp->query($get_otp_query);
    $otp_count = $get_otp->count();
    if ($otp_count > 0) {
        $otp = $get_otp->resultset();
        foreach ($otp as $otp) {
            $otp_code = $otp['OTP'];
        }
        $get_emp_name = new Database;
        $get_emp_name->query("select * from th_member_master where EMP_NO = $emp_no");
        $emp_name = $get_emp_name->resultset();
        foreach ($emp_name as $emp_name) {
            $name = $emp_name['EMP_NAME'];
            $email = $emp_name['EMAIL_ID'];
            $phone = $emp_name['PH_NO_R'];
        }
        $message = " Dear Member your OTP for Changing your " . $purpose . "  is " . $otp_code . " Vsp Thrift Society";
        $subject = 'OTP for Recover change';
        send_mail($email, $name, $message, $subject);
        sms($message, $phSone);
    }
}

if (isset($_POST['update_addr'])) {
    $date_now = date('Y-m-d h:i:s');
    $d_no = escape($_POST['d_no']);
    $street = escape($_POST['street']);
    $area = escape($_POST['area']);
    $city = escape($_POST['city']);
    $dictrict = escape($_POST['district']);
    $state = escape($_POST['state']);
    $pin = escape($_POST['pin']);
    $p_d_no = escape($_POST['p_d_no']);
    $p_street = escape($_POST['p_street']);
    $p_area = escape($_POST['p_area']);
    $p_city = escape($_POST['p_city']);
    $p_district = escape($_POST['p_district']);
    $p_state = escape($_POST['p_state']);
    $p_pin = escape($_POST['p_pin']);
    $insert_reg_data = new Database;
    $insert_reg_data->query("INSERT INTO `address_data` (`EMP_NO`, `d_no`, `street`, `area`, `city`, `district`, `state`, `pin`, `p_d_no`, `p_street`, `p_area`, `p_city`, `p_district`, `p_state`, `p_pin`) VALUES ('$_POST[user]', '$d_no', '$street', '$area', '$city', '$dictrict', '$state', '$pin','$p_d_no', '$p_street', '$p_area', '$p_city', '$p_district', '$p_state', '$p_pin')");
    header("location:admin.php?add_msg=success");
}