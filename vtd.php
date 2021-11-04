<?php
ob_start();
session_start();
if (!isset($_SESSION['suser'])) {
    header("location:index.php");
}
include 'header.php';

$error = '';
$info = '';
if (isset($_GET['st'])) {
    $error_code = $_GET['st'];

    if ($error_code == 1) {
        $error = 'Recovery Must be less thane or equal Rs.9900/-';
    }
    if ($error_code == 2) {
        $error = 'Recovery must be in multiples of 10s';
    }
}
$tool_msg = '';
//$datetime1 = date('Y-m-d');
//$datetime = date('Y-m-d H:i:s');
//$error = '';
//$info = '';
//if (isset($_POST['btn_change_vtd'])) {
//    $new_vtd = $_POST['new_vtd'];
//    $otp_code = $_POST['otp'];
//    if ($new_vtd > 9900) {
//        $error = 'Recovery Must be less thane Rs.9900/-';
//    } elseif ($new_vtd % 100 != 0) {
//        $error = 'Recovery must be in multiples of 100s';
//    } else {
//        $chk_otp = new Database;
//        $chk_otp->query("select * from otp_tbl where EMP_NO = $user and PURPOSE = 'VTD CHANGE' and status = 'UNUSED'");
//        $otp_count = $chk_otp->count();
//        if ($otp_count > 0) {
//            $otp = $chk_otp->resultset();
//            foreach ($otp as $otp) {
//                $otp_date = date('Y-m-d', strtotime($otp['created_time']));
//            }
//            if ($otp_code != $otp['OTP']) {
//                $error = 'Sorry Wrong OTP';
//            } else {
//                if ($datetime1 != $otp_date) {
//                    echo $error = 'OTP Expaired';
//                } else {
//                    $otp_time = date_create($otp['created_time']);
//                    $seconds_diff = ago_sec($otp_time);
////die();
//                    if ($seconds_diff <= 180) {
//                        $chk_record_query = "select * from rec_updates where EMP_NO = $user and status = 0";
//                        $chk_record = new Database;
//                        $chk_record->query($chk_record_query);
//                        $chk_record_count = $chk_record->count();
//                        if ($chk_record_count == 0) {
//                            $chk_existing_vtd = new Database;
//                            $chk_existing_vtd->query("select * from th_vtd_master where EMP_NO = $user");
//                            $vtd_count = $chk_existing_vtd->count();
//                            if ($vtd_count == 0) {
//                                $insert_record_query = "insert into rec_updates (`EMP_NO`, `new_td`, `new_vtd`, `new_loan`, `new_edl`) values ('$user', '0', '$new_vtd', '0', '0');"
//                                        . "INSERT INTO `th_vtd_master` (`EMP_NO`, `GL_NO`, `OPEN_BAL`, `CLOSE_BAL`, `INTEREST_AMOUNT`, `RECOVERY_RATE`, `PRG_RECOVERIES`, `PRG_PAYMENTS`, `MODIFIED_DATE`, `USER_ID`, `TRN_NO`, `TRAN_STATUS`, `START_DATE`, `LAST_YR_INT`, `RRATE_OLD`) "
//                                        . "VALUES ('$user', '$gl_no', 0, 0, NULL, '$new_vtd', NULL, NULL, NULL, NULL, NULL, NULL, '$datetime1', NULL, NULL)";
//                            } else {
//                                $insert_record_query = "insert into rec_updates (`EMP_NO`, `new_td`, `new_vtd`, `new_loan`, `new_edl`) values ('$user', '0', '$new_vtd', '0', '0');"
//                                        . "update th_vtd_master set RECOVERY_RATE = '$new_vtd' where EMP_NO = $user";
//                            }
//                            echo $insert_record_query;
//                            die();
//                            $insert_record = new Database;
//                            $insert_record->query($insert_record_query);
//                            $info = 'Recovery Updates Successfully';
//                            $subject = "Recovery  Update Alert";
//                            $message = "Dear " . $ename . " your Thrift Deposit Recovery has been updated to " . $new_vtd . " in case u have not updates please change your password and contact Society Office Immidiately";
//                            send_mail($email, $ename, $message, $subject);
//                            sms($message, $phone);
////header("location:vtd.php");
//                        } else {
//                            $chk_existing_vtd = new Database;
//                            $chk_existing_vtd->query("select * from th_vtd_master where EMP_NO = $user");
//                            $vtd_count = $chk_existing_vtd->count();
//                            if ($vtd_count == 0) {
//                                $update_record_query = "update rec_updates set `new_vtd` = '$new_vtd' where EMP_NO = $user ;"
//                                        . "INSERT INTO `th_vtd_master` (`EMP_NO`, `GL_NO`, `OPEN_BAL`, `CLOSE_BAL`, `INTEREST_AMOUNT`, `RECOVERY_RATE`, `PRG_RECOVERIES`, `PRG_PAYMENTS`, `MODIFIED_DATE`, `USER_ID`, `TRN_NO`, `TRAN_STATUS`, `START_DATE`, `LAST_YR_INT`, `RRATE_OLD`) "
//                                        . "VALUES ('$user', '$gl_no', 0, 0, NULL, '$new_vtd', NULL, NULL, NULL, NULL, NULL, NULL, '$datetime1', NULL, NULL)";
//                            } else {
//                                $update_record_query = "update rec_updates set `new_vtd` = '$new_vtd' where EMP_NO = $user ;"
//                                        . "update th_vtd_master set RECOVERY_RATE = '$new_vtd' where EMP_NO = $user";
//                            }
//
//                            $update_record = new Database;
//                            $update_record->query($update_record_query);
//                            $info = 'Recovery Updates Successfully';
//                            $subject = "Recovery  Update Alert";
//                            $message = "Dear " . $ename . " your Thrift Deposit Recovery has been updated to " . $new_vtd . " in case u have not updates please change your password and contact Society Office Immidiately";
//                            send_mail($email, $ename, $message, $subject);
//                            sms($message, $phone);
////header("location:vtd.php");
//                        }
//                        $update_otp_status = new Database;
//                        $update_otp_status->query("update otp_tbl set status = 'USED' where EMP_NO = $user and PURPOSE = 'VTD CHANGE' and status = 'UNUSED' ");
//                    } else {
//                        $error = 'OTP Expaired';
//                        $update_otp_status = new Database;
//                        $update_otp_status->query("update otp_tbl set status = 'EXPIRED' where EMP_NO = $user and PURPOSE = 'VTD CHANGE' and status = 'UNUSED'");
//                    }
//                }
//            }
//        } else {
//            $error = "Un Known Error";
//        }
//    }
//}
//if (isset($_POST['btn_withdraw_vtd'])) {
//    $withdraw_amount = $_POST['amt_required'];
//    $otp_code = $_POST['otp'];
//    $chk_otp = new Database;
//    $chk_otp->query("select * from otp_tbl where EMP_NO = $user and PURPOSE = 'VTD WITHDRAW' and status = 'UNUSED'");
//    $otp_count = $chk_otp->count();
//    if ($otp_count > 0) {
//        $otp = $chk_otp->resultset();
//        foreach ($otp as $otp) {
//            $otp_date = date('Y-m-d', strtotime($otp['created_time']));
//        }
//        if ($otp_code != $otp['OTP']) {
//            $error = 'Sorry Wrong OTP';
//        } else {
//            if ($datetime1 != $otp_date) {
//                echo $error = 'OTP Expaired';
//            } else {
//                $otp_time = date_create($otp['created_time']);
//                $seconds_diff = ago_sec($otp_time);
//                if ($seconds_diff <= 180) {
//                    $chk_record_query = "select * from vtd_withdraw where EMP_NO = $user and status = 0";
//                    $chk_record = new Database;
//                    $chk_record->query($chk_record_query);
//                    $chk_record_count = $chk_record->count();
//                    if ($chk_record_count == 0) {
//                        $insert_record_query = "insert into vtd_withdraw (`EMP_NO`, `amount`, `date_of_application`, `status`) values ('$user', '$withdraw_amount', '$datetime', '0')";
//                        $insert_record = new Database;
//                        $insert_record->query($insert_record_query);
//                        $info = 'Application Accepted Successfully';
//                        $subject = "Withdraw Application Alert";
//                        $message = "Dear " . $ename . " your VTD Withdraw application for Rs." . $withdraw_amount . " has been updated in case u have not applied please change your password and contact Society Office Immidiately";
//                        send_mail($email, $ename, $message, $subject);
//                        sms($message, $phone);
//                    }
//                    $update_otp_status = new Database;
//                    $update_otp_status->query("update otp_tbl set status = 'USED' where EMP_NO = $user and PURPOSE = 'VTD WITHDRAW' and status = 'UNUSED' ");
//                } else {
//                    $error = 'OTP Expaired';
//                    $update_otp_status = new Database;
//                    $update_otp_status->query("update otp_tbl set status = 'EXPIRED' where EMP_NO = $user and PURPOSE = 'VTD WITHDRAW' and status = 'UNUSED'");
//                }
//            }
//        }
//    } else {
//        $error = "Un Known Error";
//    }
//}

$query3 = "select * from th_vtd_register where emp_no='$user'";
$get_vtd_registration_data = new Database;
$get_vtd_registration_data->query($query3);
$count = $get_vtd_registration_data->count();
$app_status = '';
if ($count > 0) {
    $result3 = $get_vtd_registration_data->resultset();
    foreach ($result3 as $row2) {
        $app_amount = $row2['APPLIED_AMOUNT'];
        $reg_date = date('d-M-Y', strtotime($row2['REGISTRATION_DATE']));
        $app_status = 'applied';
    }
} else {
    $curr_month = date("m", time());
    if ($curr_month > 3) {
        $year1 = intval(date('Y'));
        $date1 = date('Y-m-d', strtotime('04/01/' . $year1));
        $year2 = intval(date('Y') + 1);
        $date2 = date('Y-m-d', strtotime('03/31/' . $year2));
    } elseif ($curr_month <= 3) {
        $year1 = intval(date('Y') - 1);
        $date1 = date('Y-m-d', strtotime('04/01/' . $year1));
        $year2 = intval(date('Y'));
        $date2 = date('Y-m-d', strtotime('03/31/' . $year2));
    }
    $cheak_eligibility = new Database;
    $query = "SELECT * FROM `th_vtd_trans` WHERE EMP_NO = $user AND TYPE_OF_TRANS = 'P' AND TRANS_DATE >= '$date1' AND TRANS_DATE <= '$date2'";
    $cheak_eligibility->query($query);
    $withdraw_count = $cheak_eligibility->count();
    if ($withdraw_count >= 2) {
        $app_status = "taken";
    } else {
        $app_status = 'eligible';
    }
}
?>
<div class="row">
    <div class="col-md-12">
        <?php
        if ($error != '' && $info == '') {
            ?>
            <div class="alert alert-danger">
                <strong>Warning!</strong> <?php echo $error; ?>
            </div>
            <?php
        } elseif ($info != '' && $error == '') {
            ?>
            <div class="alert alert-info">
                <strong>Info!</strong> <?php echo $info; ?>
            </div>   
            <?php
        }
        ?>
    </div>
</div>
<div class="article">
    <div class="col-md-12 table-responsive">
        <?php
        $query = "select * from th_vtd_master where emp_no='$user'";
        $get_vtd_data = new Database;
        $get_vtd_data->query($query);
        $opt_count = $get_vtd_data->count();
        if ($opt_count > 0) {
            ?>
            <h5> Balance Information</h5>
            <?php // include 'table_slide.php'; ?>

            <?php
            $result = $get_vtd_data->resultset();
            foreach ($result as $row) {
                $ob = round($row['OPEN_BAL'], 0);
                $total_Recov = round($row['PRG_RECOVERIES'], 0);
                $total_payments = round($row['PRG_PAYMENTS'], 0);
                $cb = round($row['CLOSE_BAL'], 0);
                $rec_rate = round($row['RECOVERY_RATE'], 0);
                $elg_amt = round($cb, 0);
                ?>
                <table class="table table-bordered">
                    <tr>
                        <th>Opening Balance </th>
                        <td><?php echo $ob ?></td>
                    </tr>
                    <tr>
                        <th>Total Recoveries
                            <br>(Current Financial Year)</th>
                        <td><?php echo $total_Recov ?></td>
                    </tr>
                    <tr>
                        <th>Total Payments<br>(Current Financial Year)</th>
                        <td><?php echo $total_payments ?></td>
                    </tr>
                    <tr>
                        <th>Closing Balance</th>
                        <td><?php echo $cb; ?></td>
                    </tr>
                    <tr>
                        <th>Present Recovery Rate </th>
                        <td><?php echo $rec_rate ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <?php
        } else {
            ?>

            <h5>You have not opted for this Deposit.</h5>
            <!--<button type="button" class="btn btn-info" data-toggle="modal" data-target="#update_vtd_modal">Click Here to Start</button>-->

            <div id="update_vtd_modal" class="modal fade hide_div" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Update TD Recovery</h4>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="present_vtd" value="0" readonly>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="text" name="new_vtd">
                                </div>
                                <button class="btn btn-info form-control" name="otp_gen" id="otp_gen" onclick="gen_otp('VTD CHANGE', <?php echo $user ?>)">Process</button>

                                <div class="form-group" id="otp_info">
                                    <p>OTP has been sent to your Registered Mobile Number and Emial id .. incase not received 
                                        <a onclick="resend_otp('VTD CHANGE', <?php echo $user ?>, 'UNUSED')">Resend OTP</a>
                                    </p>
                                </div>
                                <div class="form-group" id="otp_div">
                                    <input class="form-control" type="text" name="otp" id="otp" placeholder="OTP">
                                </div>
                                <div class="form-group" id="btn_rec">
                                    <input class="form-control btn btn-success" type="submit" name="btn_change_vtd" value="Upate">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <?php
        }
        ?>

    </div>
</div>

<?php
if ($opt_count > 0) {
    if ($app_status != 'eligible') {
        ?>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="alert alert-info" align="center">
                    <?php
                    if ($app_status == 'applied') {
                        echo "<h5>you have applaied for Withdrawal of Rs.$app_amount/-  on $reg_date</h5>";
                    }
                    if ($app_status == 'taken') {
                        echo"<h5>You have alredy withdraw 2 times in this financial yaer </h5>";
                    }
                    ?>
                </div>
            </div>
        </div>

        <?php
    } else if ($tool_msg != '') {
        ?>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="alert alert-info" align="center">
                    <?php
                    echo "<h5>You are Eligible for Withdrawal</h5>";
                    ?>
                </div>
            </div>
        </div>

        <?php
    }
    ?>


    <div class="row">

        <div class="col-md-6">
            <h5>Deposits</h5>
            <table class=" table table-bordered" >
                <tr>
                    <th width="100px">Date</th>
                    <th width="100px">Amount</th>
                </tr>
            </table>
            <?php
            $query2 = "select * from th_vtd_trans where emp_no='$user' and TYPE_OF_TRANS='R' order by TRANS_DATE DESC";
            $get_td_trans = new Database;
            $get_td_trans->query($query2);
            $count = $get_td_trans->count();
            ?>
            <div class="scroll">
                <table class="table table-bordered">
                    <?php
                    if ($count > 0) {
                        $result2 = $get_td_trans->resultset();
                        foreach ($result2 as $row1) {
                            $date = date('d-M-Y', strtotime($row1['TRANS_DATE']));
                            $amount = round($row1['AMOUNT'], 0);
                            ?>
                            <tr>
                                <td width="100px"><?php echo $date ?></td>
                                <td width="100px"><?php echo $amount; ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>

                </table>
            </div>

        </div>

        <div class="col-md-6">
            <h5>Withdrawals</h5>
            <table class="table table-bordered">
                <tr>
                    <th width="100px">Date</th>
                    <th width="100px">Amount</th>

                </tr>
            </table>
            <?php
            $query2 = "select * from th_vtd_trans where emp_no='$user'and TYPE_OF_TRANS='P' order by TRANS_DATE DESC";
            $get_td_payment_data = new Database;
            $get_td_payment_data->query($query2);

            $count = $get_td_payment_data->count();
            ?>
            <div class="scroll">
                <table class="table table-bordered">
                    <?php
                    if ($count > 0) {
                        $result2 = $get_td_payment_data->resultset();
                        foreach ($result2 as $row1) {
                            $date = date('d-M-Y', strtotime($row1['TRANS_DATE']));
                            $amount = round($row1['AMOUNT'], 0);
                            ?>

                            <tr>
                                <td width="100px"><?php echo $date ?></td>
                                <td width="100px"><?php echo $amount; ?></td>

                            </tr>
                            <?php
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
    <?php
}
?>

<?php include 'footer.php'; ?>