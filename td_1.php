<?php
ob_start();
session_start();
include 'header.php';
if (!isset($_SESSION['suser'])) {
    echo('please login');
    header("location:index.php");
} else {
    $user = $_SESSION['suser'];
    $fname = $user . "_pht.jpg";
    $q = "select * from th_member_master where EMP_NO='$user'";
    $get_member_data = new Database;
    $get_member_data->query($q);
    $member_data = $get_member_data->resultset();
    foreach ($member_data as $row) {
        $ename = $row['EMP_NAME'];
        $gl_no = $row['GL_NO'];
        $DOJ = $row['DATE_OF_JOIN'];
        $bank_account_number = $row['BANK_AC_NO'];
        $bank_name = substr($row['BANK_NAME'], 12);
    }

//    $reg_data = new Database;
//    $reg_date_query = "SELECT * FROM `reg_user` where EMP_NO = '$user'";
//    $reg_data->query($reg_date_query);
//    $reg_user_data = $reg_data->resultset();
//    foreach ($reg_user_data as $user_data) {
//        $phone = $user_data['Mobile'];
//        $email = $user_data['Email'];
//    }
}

// = new DateTime();
$datetime1 = date('Y-m-d');
$datetime = date('Y-m-d H:i:s');
$error = '';
$info = '';
if (isset($_POST['btn_change_td'])) {
    $new_td = $_POST['new_td'];
    $otp_code = $_POST['otp'];
    if ($new_td < 500) {
        $error = 'Recovery Must be more thane Rs.500/-';
    } elseif ($new_td > 6000) {
        $error = 'Recovery Must be less thane Rs.6000/-';
    } elseif ($new_td % 100 != 0) {
        $error = 'Recovery must be in multiples of 100s';
    } else {
        $chk_otp = new Database;
        $chk_otp->query("select * from otp_tbl where EMP_NO = $user and PURPOSE = 'TD CHANGE' and status = 'UNUSED'");
        $otp_count = $chk_otp->count();
        if ($otp_count > 0) {
            $otp = $chk_otp->resultset();
            foreach ($otp as $otp) {
                $otp_date = date('Y-m-d', strtotime($otp['created_time']));
            }
            if ($otp_code != $otp['OTP']) {
                $error = 'Sorry Wrong OTP';
            } else {
                if ($datetime1 != $otp_date) {
                    echo $error = 'OTP Expaired';
                } else {
                    $otp_time = date_create($otp['created_time']);
                    $seconds_diff = ago_sec($otp_time);
                    //die();
                    if ($seconds_diff <= 180) {
                        $chk_record_query = "select * from rec_updates where EMP_NO = $user and status = 0";
                        $chk_record = new Database;
                        $chk_record->query($chk_record_query);
                        $chk_record_count = $chk_record->count();
                        if ($chk_record_count == 0) {
                            $insert_record_query = "insert into rec_updates (`EMP_NO`, `new_td`, `new_vtd`, `new_loan`, `new_edl`) values ('$user', '$new_td', '0', '0', '0');"
                                    . "update th_thrift_deposit_master set RECOVERY_RATE = '$new_td' where EMP_NO = $user";
                            $insert_record = new Database;
                            $insert_record->query($insert_record_query);
                            $info = 'Recovery Rate Updated Successfully';
                            $subject = "Recovery Update Alert";
                            $message = "Dear " . $ename . " your Thrift Deposit Recovery has been updated to " . $new_td . " in case u have not updates please change your password and contact Society Office Immidiately";
                            send_mail($email, $ename, $message, $subject);
                            sms($message, $phone);
                        } else {
                            $update_record_query = "update rec_updates set `new_td` = '$new_td' where EMP_NO = $user ;"
                                    . "update th_thrift_deposit_master set RECOVERY_RATE = '$new_td' where EMP_NO = $user";
                            $update_record = new Database;
                            $update_record->query($update_record_query);
                            $info = 'Recovery Rate Updated Successfully';
                            $subject = "Recovery  Update Alert";
                            $message = "Dear " . $ename . " your Thrift Deposit Recovery has been updated to " . $new_td . " in case u have not updates please change your password and contact Society Office Immidiately";
                            send_mail($email, $ename, $message, $subject);
                            sms($message, $phone);
                        }
                        $update_otp_status = new Database;
                        $update_otp_status->query("update otp_tbl set status = 'USED' where EMP_NO = $user and PURPOSE = 'TD CHANGE' and status = 'UNUSED' ");
                    } else {
                        $error = 'OTP Expaired';
                        $update_otp_status = new Database;
                        $update_otp_status->query("update otp_tbl set status = 'EXPIRED' where EMP_NO = $user and PURPOSE = 'TD CHANGE' and status = 'UNUSED'");
                    }
                }
            }
        } else {
            $error = "Un Known Error";
        }
    }
}

if (isset($_POST['btn_withdraw_td'])) {
    $withdraw_amount = $_POST['amt_required'];
    $otp_code = $_POST['otp'];
    $chk_otp = new Database;
    $chk_otp->query("select * from otp_tbl where EMP_NO = $user and PURPOSE = 'TD WITHDRAW' and status = 'UNUSED'");
    $otp_count = $chk_otp->count();
    if ($otp_count > 0) {
        $otp = $chk_otp->resultset();
        foreach ($otp as $otp) {
            $otp_date = date('Y-m-d', strtotime($otp['created_time']));
        }
        if ($otp_code != $otp['OTP']) {
            $error = 'Sorry Wrong OTP';
        } else {
            if ($datetime1 != $otp_date) {
                echo $error = 'OTP Expaired';
            } else {
                $otp_time = date_create($otp['created_time']);
                $seconds_diff = ago_sec($otp_time);
                if ($seconds_diff <= 180) {
                    $chk_record_query = "select * from td_withdraw where EMP_NO = $user and status = 0";
                    $chk_record = new Database;
                    $chk_record->query($chk_record_query);
                    $chk_record_count = $chk_record->count();
                    if ($chk_record_count == 0) {
                        $insert_record_query = "insert into td_withdraw (`emp_no`, `amount`, `date_of_application`, `status`) values ('$user', '$withdraw_amount', '$datetime', '0')";
                        $insert_record = new Database;
                        $insert_record->query($insert_record_query);
                        $info = 'Application Accepted Successfully';
                        $subject = "Withdraw Application Alert";
                        $message = "Dear " . $ename . " your TD Withdraw application for Rs." . $withdraw_amount . " has been updated in case u have not applied please change your password and contact Society Office Immidiately";
                        send_mail($email, $ename, $message, $subject);
                        sms($message, $phone);
                    }
                    $update_otp_status = new Database;
                    $update_otp_status->query("update otp_tbl set status = 'USED' where EMP_NO = $user and PURPOSE = 'TD WITHDRAW' and status = 'UNUSED' ");
                } else {
                    $error = 'OTP Expaired';
                    $update_otp_status = new Database;
                    $update_otp_status->query("update otp_tbl set status = 'EXPIRED' where EMP_NO = $user and PURPOSE = 'TD WITHDRAW' and status = 'UNUSED'");
                }
            }
        }
    } else {
        $error = "Un Known Error";
    }
}
?>

<script language="javascript" type="text/javascript">
<!--
    function popitup(url) {
        newwindow = window.open(url, 'name', 'height=300,width=500,scrollbars=1').style.overflow = 'auto';
        if (window.focus) {
            newwindow.focus()
        }
        return false;
    }

// -->
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div style="margin-top: 6%">
                <div class="panel-heading">
                    <h3 class="panel-title"> <?php echo"Welcome  " . $ename . ", " . $user . " - - Thrift Deposit"; ?></h3>
                </div>
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
                        <div class="alert alert-info" >
                            <strong>Info!</strong> <?php echo $info; ?>
                        </div>   
                        <?php
                    }
                    ?>
                </div>
                <div class="col-md-12 table-responsive">
                    <h5> Balance Information</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>Opening Balance </th>
                            <th>Total Recoveries <br>(Current Financial Year)</th>
                            <th>Total Payments <br>(Current Financial Year)</th>
                            <th>Closing Balance</th>
                            <th>Present Recovery Rate </th>
                        </tr>
                        <?php
                        $eliggibilty_status = '';
                        $query = "select EMP_NO, GL_NO, OPEN_BAL, CLOSE_BAL, INTEREST, RECOVERY_RATE, PRG_RECOVERIES, PRG_PAYMENTS, MODIFIED_DATE,
 MEMBERSHIP_DATE, LAST_WITHDRAWAL_DATE, IF(LAST_WITHDRAWAL_DATE IS NULL,0,LAST_WITHDRAWAL_DATE) as dt,  DATE_ADD(LAST_WITHDRAWAL_DATE, INTERVAL 12 MONTH) as NEWDATE, USER_ID, TRN_NO, TRAN_STATUS,
 LAST_YR_INT, RRATE, RRATE_OLD from th_thrift_deposit_master where emp_no='$user'";
                        $get_td_data = new Database;
                        $get_td_data->query($query);

                        $count = $get_td_data->count();
                        if ($count > 0) {
                            $result = $get_td_data->resultset();
                            foreach ($result as $row) {
                                $ob = round($row['OPEN_BAL'], 0);
//                        $obi=$row['OBI'];
//                        $cbp=$row['CBP'];
                                $cb = round($row['CLOSE_BAL'], 0);
                                $elg_amt = $cb / 2;
                                $rec_rate = round($row['RECOVERY_RATE'], 0);
//                                $prev_with_date = date("M-Y", strtotime($row['dt']));
                                $prev_with_date = $row['dt'];
//                                echo "ppp= ".$prev_with_date;
                                $eligble_date = date("M-Y", strtotime($row['NEWDATE']));
                                $total_Recov = round($row['PRG_RECOVERIES'], 0);
                                $total_payments = round($row['PRG_PAYMENTS'], 0);
                                $curr_date = date("M-Y");

                                $q = "select DATE_OF_JOIN,DATE_ADD(DATE_OF_JOIN, INTERVAL 60 MONTH) as date1 from th_member_master where emp_no='$user'";
                                $chk_eligibility = new Database();
                                $chk_eligibility->query($q);
                                $r = $chk_eligibility->resultset();
                                foreach ($r as $row3) {
                                    $doj = $row3['DATE_OF_JOIN'];
                                    $date_five = date("M-Y", strtotime($row3['date1']));
                                    $curr_date = date("M-Y");
                                }
                                if (strtotime($date_five) <= strtotime($curr_date)) {
                                    if ($prev_with_date == 0) {
                                        $eliggibilty_status = '1';
                                        $mymsg = 'You are eligible for withdrawal ';
                                        $mymsg = $mymsg . '&nbsp &nbsp';
                                        $mymsg = $mymsg . '<a href="td_withdraw.php" target="_blank" >Click here </a> to genarate the withdraw form';
                                    } else {
                                        if (strtotime($eligble_date) <= strtotime($curr_date)) {
                                            $eliggibilty_status = '1';
                                            $mymsg = 'You are eligible for withdrawal ';
                                            $mymsg = $mymsg . '&nbsp &nbsp';
                                            $mymsg = $mymsg . '<a href="td_withdraw.php" target="_blank">Click here </a> to genarate the withdraw form';
                                        } else {
                                            $_SESSION['td_app_status'] = FALSE;
                                            $mymsg = 'You are eligible for withdrawal after  ' . $eligble_date;
                                        }
                                    }
                                } else {
                                    $_SESSION['td_app_status'] = FALSE;
                                    $mymsg = 'You are eligible for withdrawal after  ' . $date_five;
                                }

                                $app_status = '';
                                $query3 = "select * from th_td_register where emp_no='$user'";
                                $get_registration_status = new Database;
                                $get_registration_status->query($query3);
                                $count = $get_registration_status->count();
                                if ($count > 0) {
                                    $app_status = '0';
                                    $result3 = $get_registration_status->resultset();
                                    foreach ($result3 as $row2) {
                                        $_SESSION['td_app_status'] = FALSE;
                                        $app_amount = $row2['APPLIED_AMOUNT'];
                                        $reg_date = date('d-M-Y', strtotime($row2['REGISTRATION_DATE']));
                                    }
                                } else {
                                    $app_status = '1';
                                }
                                ?>

                                <tr>
                                    <td><?php echo $ob ?></td>
                                    <td><?php echo $total_Recov ?></td>
                                    <td><?php echo $total_payments ?></td>
                                    <td><?php echo $cb; ?>
                                        <?php
                                        if ($eliggibilty_status == 1 && $app_status == 1) {
                                            $chk_record_query = "select * from td_withdraw where emp_no = $user and status = 0";
                                            $chk_record = new Database;
                                            $chk_record->query($chk_record_query);
                                            $chk_record_count = $chk_record->count();
                                            if ($chk_record_count == 0) {
                                                ?>
                                                <!--<button type="button" class="btn btn-info" data-toggle="modal" data-target="#withdraw_vtd">Withdraw</button>-->

                                                <div id="withdraw_vtd" class="modal fade" role="dialog">
                                                    <div class="modal-dialog">

                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title">Withdraw TD</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="" method="post">
                                                                    <div class="form-group">

                                                                        <input type="hidden" class="form-control" id="e_name" value="<?php echo $ename ?>" >    
                                                                    </div>
                                                                    <div class="form-group">

                                                                        <input type="hidden" class="form-control" id="e_no" value="<?php echo $user ?>" >    
                                                                    </div>  
                                                                    <div class="form-group">
                                                                        <label for="total_amount">Total Amount</label>
                                                                        <input type="text" class="form-control" id="total_amount" value="<?php echo $cb ?>" readonly>    
                                                                    </div>  
                                                                    <div class="form-group">
                                                                        <label for="eligible_amt">Eligible Amount</label>
                                                                        <input type="text" class="form-control" id="eligible_amt" value="<?php echo round($elg_amt) ?>" readonly>    
                                                                    </div>  
                                                                    <div class="form-group">
                                                                        <label for="ac_no">Account Number</label>
                                                                        <input type="text" class="form-control" id="ac_no" value="<?php echo $bank_account_number ?>" readonly>    
                                                                    </div>  
                                                                    <div class="form-group">
                                                                        <label for="bank">Bank Name</label>
                                                                        <input type="text" class="form-control" id="bank" value="<?php echo $bank_name ?>" readonly>    
                                                                        <small style="color: red"> (Note: Amount will be credit to this bank account after processing)</small>
                                                                    </div>  
                                                                    <div class="form-group alert alert-danger" id="alert_info" style="display: none">

                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="amt_required">Amount Required</label>
                                                                        <input class="form-control" type="text" name="amt_required" value="" id="amt_required" onkeypress="return isNumber(event)"
                                                                               onblur="return is_eligible(<?php echo round($elg_amt) ?>);"/>    
                                                                    </div>
                                                                    <button class="btn btn-info form-control" name="otp_gen" id="otp_gen_withdraw" onclick="gen_otp('TD WITHDRAW', <?php echo $user ?>)">Process</button>

                                                                    <div class="form-group" id="otp_info_withdraw">
                                                                        <p>OTP has been sent to your Registered Mobile Number and Emial id .. incase not received 
                                                                            <a onclick="resend_otp('TD WITHDRAW', <?php echo $user ?>, 'UNUSED')">Resend OTP</a>
                                                                        </p>
                                                                    </div>
                                                                    <div class="form-group" id="otp_div_withdraw">
                                                                        <input class="form-control" type="text" name="otp" id="otp" placeholder="OTP">
                                                                    </div>
                                                                    <div class="form-group" id="btn_withdraw">
                                                                        <input class="form-control btn btn-success" type="submit" name="btn_withdraw_td" value="Withdraw">
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
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $rec_rate ?> 
                                        <!--<button type="button" class="btn btn-info" data-toggle="modal" data-target="#update_td_modal">Change</button>-->
                                    </td>

                                </tr>
                                <!-- Modal -->
                                <div id="update_td_modal" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Update TD Recovery</h4>
                                            </div>
                                            <div class="modal-body" id="change_div">
                                                <form method="post" action="">
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" name="present_td" value="<?php echo $rec_rate ?>" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" name="new_td"  placeholder="New TD">
                                                    </div>

                                                    <button class="btn btn-info form-control" name="otp_gen" id="otp_gen" onclick="gen_otp('TD CHANGE', <?php echo $user ?>)">Process</button>

                                                    <div class="form-group" id="otp_info">
                                                        <p>OTP has been sent to your Registered Mobile Number and Emial id .. incase not received 
                                                            <a onclick="resend_otp('TD CHANGE', <?php echo $user ?>, 'UNUSED')">Resend OTP</a>
                                                        </p>

                                                    </div>

                                                    <div class="form-group" id="otp_div">
                                                        <input class="form-control" type="text" name="otp" id="otp" placeholder="OTP">
                                                    </div>
                                                    <div class="form-group" id="btn_rec">
                                                        <input class="form-control btn btn-success" type="submit" name="btn_change_td" value="Update">
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
                        }
                        ?>
                    </table>

                </div>
                <span class="pull-left hidden-lg hidden-md hidden-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i></span>
                <span class="pull-right hidden-lg hidden-md hidden-sm"><i class="fa fa-arrow-right" aria-hidden="true"></i></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h5>Recoveries</h5>
            <table class=" table table-bordered" >
                <tr>
                    <th width="100px">Date</th>
                    <th width="100px">Amount</th>
                </tr>
            </table>
            <?php
            $curr_month = date("m", time());
            //echo $curr_month;
            if ($curr_month > 3) {
                $year1 = intval(date('Y'));
                $date1 = date('Y-m-d', strtotime('04/01/' . $year1));
                //echo $date1 . ',' . $date2;
            } elseif ($curr_month <= 3) {
                $year1 = intval(date('Y') - 1);
                $date1 = date('Y-m-d', strtotime('01/04/' . $year1));
                //echo $date1 . ',' . $date2;
            }

            $query2 = "select * from th_td_trans_web where emp_no='$user'and TYPE_OF_TRANS='R' and TRANS_DATE >= '$date1' order by TRANS_DATE DESC";
            //echo $query2;
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
            <h5>Payments</h5>
            <table class="table table-bordered">
                <tr>
                    <th width="100px">Date</th>
                    <th width="100px">Amount</th>
                </tr>
            </table>
            <?php
            $query2 = "select * from th_td_trans_web where emp_no='$user'and TYPE_OF_TRANS='P' order by TRANS_DATE DESC";
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
    <div class="row">
        <div class="col-md-12">

            <?php
            $query3 = "select * from th_td_register where emp_no='$user'";
            $get_registration_status = new Database;
            $get_registration_status->query($query3);
            $count = $get_registration_status->count();
            if ($count > 0) {
                $_SESSION['td_app_status'] = FALSE;
                $result3 = $get_registration_status->resultset();
                foreach ($result3 as $row2) {
                    $app_amount = $row2['APPLIED_AMOUNT'];
                    $reg_date = date('d-M-Y', strtotime($row2['REGISTRATION_DATE']));
                    echo"<br>";
                    echo "<h5 style='margin-left: 5%'>you have applaied for Withdrawal of Rs.$app_amount/-  on $reg_date</h5>";
                }
            } else {
                echo "<h5> $mymsg;</h5>";
            }
            ?>
        </div>  
    </div>
</div>

<?php include 'footer.php'; ?>