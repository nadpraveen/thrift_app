<?php
ob_start();
session_start();
if (!isset($_SESSION['suser'])) {
    header("location:index.php");
}
include 'header.php';

$loan_query = "select * from th_ed_loan_master where emp_no='$user' and LOAN_STATUS = 'R'";
$get_loan = new Database;
$get_loan->query($loan_query);
$loan = $get_loan->resultset();
foreach ($loan as $loan) {
    
}

$get_def_rec_rate = new Database;
$get_def_rec_rate->prepare("SELECT (AMOUNTP+AMOUNTI) AS total_recovery FROM `th_edl_trans` WHERE EMP_NO = 122562 AND LOAN_NO =(select LOAN_NO from th_ed_loan_master where emp_no='122562' and LOAN_STATUS = 'R') ORDER BY TRANS_DATE ASC LIMIT 1");
$def_rec = $get_def_rec_rate->resultset();
foreach ($def_rec as $def_rec) {
    
}

$error = '';
$info = '';
if (isset($_GET['st'])) {
    $error_code = $_GET['st'];

    if ($error_code == 1) {
        $error = 'Recovery not to be less thane yout first recovery ( ' . $def_rec['total_recovery'] . '/- )';
    }
    if ($error_code == 2) {
        $error = 'Recovery Must be less thane Rs.9900/-';
    }
    if ($error_code == 3) {
        $error = 'Recovery must be in multiples of 10s';
    }
}
//$datetime1 = date('Y-m-d');
//$rec_type = 'Medium Term Loan Recovery';
//$error = '';
//$info = '';
//if (isset($_POST['btn_change_ed_loan'])) {
//    $new_ed_loan = $_POST['new_ed_loan'];
//    $otp_code = $_POST['otp'];
//    $get_def_rec_rate = new Database;
//    $get_def_rec_rate->prepare("SELECT (AMOUNTP+AMOUNTI) AS total_recovery FROM `th_edl_trans` WHERE EMP_NO = 122562 AND LOAN_NO =(select LOAN_NO from th_ed_loan_master where emp_no='122562' and LOAN_STATUS = 'R') ORDER BY TRANS_DATE ASC LIMIT 1");
//    $def_rec = $get_def_rec_rate->resultset();
//    foreach ($def_rec as $def_rec) {
//        
//    }
//    if ($new_ed_loan < $def_rec['total_recovery']) {
//        $error = 'Recovery not to be less thane yout first recovery ( ' . $def_rec['total_recovery'] . '/- )';
//    } elseif ($new_ed_loan > 9900) {
//        $error = 'Recovery Must be less thane Rs.9900/-';
//    } elseif ($new_ed_loan % 100 != 0) {
//        $error = 'Recovery must be in multiples of 100s';
//    } else {
//        $chk_otp = new Database;
//        $chk_otp->query("select * from otp_tbl where EMP_NO = $user and PURPOSE = 'MEDIUM TERM LOAN REC CHANGE' and status = 'UNUSED'");
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
//                    $error = 'OTP Expaired';
//                    $update_otp_status = new Database;
//                    $update_otp_status->query("update otp_tbl set status = 'EXPIRED' where EMP_NO = $user and PURPOSE = 'MEDIUM TERM LOAN REC CHANGE' and status = 'UNUSED'");
//                } else {
//                    $otp_time = date_create($otp['created_time']);
//                    $seconds_diff = ago_sec($otp_time);
//                    //die();
//                    if ($seconds_diff <= 180) {
//                        $chk_record_query = "select * from rec_updates where EMP_NO = $user and status = 0";
//                        $chk_record = new Database;
//                        $chk_record->query($chk_record_query);
//                        $chk_record_count = $chk_record->count();
//                        if ($chk_record_count == 0) {
//                            $insert_record_query = "insert into rec_updates (`EMP_NO`, `new_td`, `new_vtd`, `new_loan`, `new_edl`) values ('$user', '0', '0', '0', '$new_ed_loan');"
//                                    . "update th_ed_loan_master set REC_RATE = '$new_ed_loan' where EMP_NO = $user";
//                            $insert_record = new Database;
//                            $insert_record->query($insert_record_query);
//                            $info = 'Recovery Updates Successfully';
//                            $subject = "Recovery Update Alert";
//                            $message = "Dear " . $ename . " your" . $rec_type . " has been updated to " . $new_ed_loan . " in case u have not updates please change your password and contact Society Office Immidiately";
//                            send_mail($email, $ename, $message, $subject);
//                            sms($message, $phone);
//                            //header("location:slone.php");
//                        } else {
//                            $update_record_query = "update rec_updates set `new_edl` = '$new_ed_loan' where EMP_NO = $user ;"
//                                    . "update th_ed_loan_master set REC_RATE = '$new_ed_loan' where EMP_NO = $user";
//                            $update_record = new Database;
//                            $update_record->query($update_record_query);
//                            $info = 'Recovery Updates Successfully';
//                            $subject = "Recovery Update Alert";
//                            $message = "Dear " . $ename . " your" . $rec_type . " has been updated to " . $new_td . " in case u have not updates please change your password and contact Society Office Immidiately";
//                            send_mail($email, $ename, $message, $subject);
//                            sms($message, $phone);
//                            //header("location:slone.php");
//                        }
//                        $update_otp_status = new Database;
//                        $update_otp_status->query("update otp_tbl set status = 'USED' where EMP_NO = $user and PURPOSE = 'MEDIUM TERM LOAN REC CHANGE' and status = 'UNUSED' ");
//                    } else {
//                        $error = 'OTP Expaired';
//                        $update_otp_status = new Database;
//                        $update_otp_status->query("update otp_tbl set status = 'EXPIRED' where EMP_NO = $user and PURPOSE = 'MEDIUM TERM LOAN REC CHANGE' and status = 'UNUSED'");
//                    }
//                }
//            }
//        } else {
//            $error = "Un Known Error";
//        }
//    }
//}
?>

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
<div class="col-md-6">
    <h5> Loan Information</h5>
    <table class="table table-bordered">
        <?php
        $query = "select * from th_ed_loan_master where emp_no='$user' and LOAN_STATUS = 'R'";
        //echo $query;
        $get_edl_data = new Database;
        $get_edl_data->query($query);
        $count = $get_edl_data->count();
        if ($count > 0) {
            $result = $get_edl_data->resultset();
            foreach ($result as $row) {
                $loan_num = $row['LOAN_NO'];
                $loanamount = $row['SACTIONED_AMOUNT'];
                $rate = $row['RATE_OF_INTREST'];
                $sac_date = date('d-M-Y', strtotime($row['SACTION_DATE']));
                $surity1 = $row['SURITY1'];
                $surity2 = $row['SURITY2'];
                $obp = $row['OBP'];
                $obi = $row['OBI'];
                $cbp = $row['CBP'];
                if (date('d') <= 15) {
                    $cbi = $row['CBI'];
                } else {
                    $interest = ((($cbp * $rate) / 12) / 100) / 2;
                    $cbi = round($row['CBI'] + $interest);
                }
                $present_loan_balence = $cbp + $cbi;
                $status = $row['LOAN_STATUS'];
                $rec_rate = $row['REC_RATE'];
                global $rec_rate;
                ?>
                <tr>
                    <td>Loan Sanctioned</td><td><?php echo round($loanamount, 0) ?></td>
                </tr>
                <tr>
                    <td>Rate of Interest</td><td><?php echo $rate; ?></td>
                </tr>
                <tr>
                    <td>Sanctioned Date</td><td><?php echo $sac_date ?></td>
                </tr>
                <tr>
                    <td>Recovery Rate</td>
                    <td>
                        <?php echo round($row['REC_RATE'], 0) ?>
                        <!--<button type="button" class="btn btn-info" data-toggle="modal" data-target="#update_ed_loan_modal">Request for Recovery Rate change</button>-->
                    </td>

                    <!-- Modal -->
                <div id="update_ed_loan_modal" class="modal fade hide_div" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Update Medium Term loan Recovery</h4>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="edloan_rec_change.php" autocomplete="off">
                                    <div class="form-group">
                                        <label for="present_rec">Present Recovery Rate</label>
                                        <input class="form-control" type="text" id="present_rec" name="present_ed_loan" value="<?php echo round($row['REC_RATE'], 0) ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="required_rec">Required Recovery Rate Change</label>
                                        <input class="form-control" id="required_rec" type="text" name="new_ed_loan">
                                        <small style="color: red" >Note : This is not an online submission. Member has to take print out of the application and submit the same at Society office,failing which the application can't be processed for Change of Recovery.</small>
                                    </div>

                                    <div class="form-group">
                                        <input class="form-control btn btn-success" type="submit" name="btn_change_ed_loan" value="Print">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>
                </tr>
                <tr>
                    <td>No. Installments</td><td><?php echo $row ['INSTALLMENTS'] ?></td>
                </tr>

                <tr>
                    <td>Present Balance</td>
                    <td>
                        Principal : <?php echo round($cbp, 0) ?> <br>
                        Interest  : <?php echo round($cbi, 0) ?> <br>  
                        <strong>Total Balance : <?php echo round($present_loan_balence, 0) ?></strong>
                    </td>
                </tr>

                <?php
                $get_suritie1_date = new Database;
                $get_suritie1_date->prepare("SELECT * FROM `th_member_master` where EMP_NO = $surity1 ");
                $suritie1_data = $get_suritie1_date->resultset();
                foreach ($suritie1_data as $suritie1_data) {
                    
                }
                ?>
                <tr>
                    <td>Surety 1 </td>
                    <td>
                        <div class="row">
                            <div class="col-md-6">
                                <?php echo $surity1 ?>, &nbsp; <?php echo $suritie1_data['EMP_NAME'] ?>
                                <br>
                                <?php echo $suritie1_data['DEPT'] ?>
                            </div>
                            <div class="col-md-6">
                                <img class="img-responsive" src="user_img/<?php echo $surity1 ?>_pht.jpg" width="50">
                            </div>
                        </div>
                    </td>
                </tr>

                <?php
                if ($surity2 != 0) {
                    $get_suritie2_date = new Database;
                    $get_suritie2_date->prepare("SELECT * FROM `th_member_master` where EMP_NO = $surity2 ");
                    $suritie2_data = $get_suritie2_date->resultset();
                    foreach ($suritie2_data as $suritie2_data) {
                        
                    }
                    ?>
                    <tr>
                        <td>Surety 2</td>
                        <td>
                            <div class="row">
                                <div class="col-md-6">
                                    <?php echo $surity2 ?>, &nbsp; <?php echo $suritie2_data['EMP_NAME'] ?>
                                    <br>
                                    <?php echo $suritie2_data['DEPT'] ?>
                                </div>
                                <div class="col-md-6">
                                    <img class="img-responsive" src="user_img/<?php echo $surity2 ?>_pht.jpg" width="50">
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
            }
        } else {
            echo "<tr><td colspan='10'>You don't have any loan";
        }
        ?>
    </table>
</div>

<div class="col-md-6">
    <h5> Transaction (in Rupees)</h5>
    <table class="table table-bordered" >
        <tr>
            <th width="100px">Date</th>
            <th width="100px">Principal</th>
            <th width="100px">Interest</th>
        </tr>
    </table>
    <?php
    $query2 = "select * from th_edl_trans where emp_no='$user' and LOAN_NO = (select LOAN_NO from th_ed_loan_master where emp_no='$user' and LOAN_STATUS = 'R') order by TRANS_DATE DESC";
    $get_loan_trans = new Database;
    $get_loan_trans->query($query2);
    $count = $get_loan_trans->count();
    ?>
    <div class="scroll">
        <table class="trans table table-bordered">
            <?php
            if ($count > 0) {
                $result2 = $get_loan_trans->resultset();
                foreach ($result2 as $row1) {
                    $date = date('d-M-Y', strtotime($row1['TRANS_DATE']));
                    $Princple = $row1['AMOUNTP'];
                    $interest = $row1['AMOUNTI'];
                    ?>
                    <tr>
                        <td width="100px"><?php echo $date ?></td>
                        <td width="100px"><?php echo round($Princple, 0); ?></td>
                        <td width="100px"><?php echo round($interest, 0); ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>
    </div>
</div>
</div>
</div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <?php
        if ($_SESSION['ed_loan_default'] == 'YES') {
            echo "<h5>Your Loan is overdue by Rs." . $_SESSION['edl_diff_amount'] . "/- </h5>";
        }
        ?>
    </div>
    <div class="col-md-12">
        <?php
        $query2 = "select * from th_edl_register where emp_no='$user'";
        $get_edl_registration_data = new Database;
        $get_edl_registration_data->query($query2);
        $count = $get_edl_registration_data->count();
        if ($count > 0) {
            $result2 = $get_edl_registration_data->resultset();
            foreach ($result2 as $row) {
                $app_amount = $row['APPLIED_AMOUNT'];
                $reg_date = date('d-M-Y', strtotime($row['REGISTER_DATE']));
                echo"<br>";
                echo "<h3 style='margin-left: 10%'>you have applaied for loan of Rs.$app_amount/-  on $reg_date</h3>";
            }
        }
        ?>
    </div>

    <!-- NEW LOAN ELIGIBLE CHECK -->
    <div class="col-md-12">
        <?php
        $nex_loan_query = "SELECT * FROM th_ed_loan_master WHERE EMP_NO = $user AND LOAN_STATUS = 'R'";
        $next_loan = new Database;
        $next_loan->query($nex_loan_query);
        $curr_loan_count = $next_loan->count();
        if ($curr_loan_count > 0) {
            $next_loan_data = $next_loan->resultset();
            foreach ($next_loan_data as $next_loan_data) {
                $curr_loan_num = $next_loan_data['LOAN_NO'];
                $curr_sancon_amount = $next_loan_data['SACTIONED_AMOUNT'];
                $amount_for_elig = $curr_sancon_amount / 4;

                $get_pri_amount_thru_sal = "SELECT SUM(AMOUNTP) as total_prl FROM th_edl_trans where EMP_NO = $user and LOAN_NO = $curr_loan_num and MODE_OF_PAYMENT = 'S'";
                $get_total_prl = new Database;
                $get_total_prl->prepare($get_pri_amount_thru_sal);
                $total_prl = $get_total_prl->resultset();
                foreach ($total_prl as $total_prl) {
                    $total_prl = $total_prl['total_prl'];
                }
                if ($total_prl >= $amount_for_elig) {
                    ?>
                    <div class="alert alert-info">
                        You are eligible for next Loan.
                    </div>
                    <?php
                } else {
                    $amount_to_clear = $amount_for_elig - $total_prl;
                    ?>
                    <div class="alert alert-info">
                        you have to clear an amount of <?php echo $amount_to_clear ?>/- through salary to avile next loan.
                    </div>
                    <?php
                }
            }
        } else {
            $select_recent_closed_loan_query = "SELECT * FROM th_ed_loan_master where EMP_NO = $user order by CLOSE_DATE DESC limit 1";
            $get_recent_closed_loan = new Database;
            $get_recent_closed_loan->query($select_recent_closed_loan_query);
            $recent_closed_loan_count = $get_recent_closed_loan->count();
            if ($recent_closed_loan_count > 0) {
                $closed_loan_data = $get_recent_closed_loan->resultset();
                foreach ($closed_loan_data as $closed_loan_data) {
                    $loan_num = $closed_loan_data['LOAN_NO'];
                    $sancon_amount = $closed_loan_data['SACTIONED_AMOUNT'];
                    $amount_for_elig = $sancon_amount / 2;
                    $cloased_date = $closed_loan_data['CLOSE_DATE'];
                }

                $get_pri_amount_thru_sal = "SELECT SUM(AMOUNTP) as total_prl FROM th_edl_trans where EMP_NO = $user and LOAN_NO = $loan_num and MODE_OF_PAYMENT = 'S'";
                $get_total_prl = new Database;
                $get_total_prl->prepare($get_pri_amount_thru_sal);
                $total_prl = $get_total_prl->resultset();
                foreach ($total_prl as $total_prl) {
                    $total_prl = $total_prl['total_prl'];
                }
                if ($total_prl >= $amount_for_elig) {
                    ?>
                    <div class="alert alert-info">
                        You are eligible for next Loan.
                    </div>
                    <?php
                } else {
                    $eligible_date = date('Y-m-d', strtotime("+1 months", strtotime($cloased_date)));
                    $today = date('Y-m-d');
                    if ($today > $eligible_date) {
                        ?>
                        <div class="alert alert-info">
                            You are eligible for next Loan.
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="alert alert-info">
                            you are eligible for next loan on/after <?php echo date('M-Y', strtotime($eligible_date)); ?>
                        </div>
                        <?php
                    }
                }
            }
        }
        ?>
    </div>
    <!-- NEW LOAN ELIGIBLE CHECK END -->
    
    <div class="col-md-12 show_div">
         <div class="alert alert-warning">for Geting Loan Statement Please update to latest browser</div>
    </div>

    <div class="col-md-12 hide_div">
        Click here for 
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal2">Medium term loan statement</button>
        <!-- Modal -->

        <div id="myModal2" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Loans List</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Loan Number</th>
                                <th>Loan Amount</th>
                                <th>Loan Date</th>
                                <th>Loan Balance</th>
                                <th>Closed Date</th>
                            </tr>

                            <?php
                            $loan_list_query = "SELECT * FROM `th_ed_loan_master` WHERE EMP_NO = $user ORDER BY `SACTION_DATE` DESC";
                            $get_all_loan_data = new Database;
                            $get_all_loan_data->prepare($loan_list_query);
                            $all_loan_data = $get_all_loan_data->resultset();
                            foreach ($all_loan_data as $data) {
                                $sanction_date = date('d-m-Y', strtotime($data['SACTION_DATE']))
                                ?>
                                <tr>
                                    <td><a href="short_loan_certi.php?loan_no=<?php echo $data['LOAN_NO'] ?>" target="_blank"><?php echo $data['LOAN_NO'] ?></a></td>
                                    <td><?php echo $data['SACTIONED_AMOUNT'] ?></td>
                                    <td><?php echo $sanction_date ?></td>
                                    <td><?php echo $data['CBP'] + $data['CBI'] ?></td>
                                    <?php
                                    if ($data['LOAN_STATUS'] == 'C') {
                                        ?>
                                        <td><?php echo date('d-m-Y', strtotime($data['CLOSE_DATE'])) ?></td>
                                        <?php
                                    } else {
                                        ?>
                                        <td>Active</td>
                                        <?php
                                    }
                                    ?>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php include 'footer.php'; ?>