<?php
ob_start();
session_start();
if (!isset($_SESSION['suser'])) {
    header("location:logout.php");
}
include 'header.php';

$loan_query = "select * from th_loan_master where emp_no='$user' and LOAN_STATUS = 'R'";
$get_loan = new Database;
$get_loan->query($loan_query);
$loan = $get_loan->resultset();
foreach ($loan as $loan) {
    
}
//$datetime1 = date('Y-m-d');
//$rec_type = 'Loan Recovery';
$error = '';
$info = '';
if (isset($_GET['st'])) {
    $error_code = $_GET['st'];

    if ($error_code == 1) {
        $error = 'Recovery not to be less thane yout first recovery ( ' . $loan['REC_RATE_DEF'] . '/- )';
    }
    if ($error_code == 2) {
        $error = 'Recovery Must be less thane Rs.20000/-';
    }
    if ($error_code == 3) {
        $error = 'Recovery must be in multiples of 10s';
    }
}





//if (isset($_POST['btn_change_loan'])) {
//    $error = '';
//    $info = '';
//    $new_loan = $_POST['new_loan'];
//    $otp_code = $_POST['otp'];
//    if ($new_loan < $loan['REC_RATE_DEF']) {
//        $error = 'Recovery not to be less thane yout first recovery ( ' . $loan['REC_RATE_DEF'] . '/- )';
//    } elseif ($new_loan > 20000) {
//        $error = 'Recovery Must be less thane Rs.20000/-';
//    } elseif ($new_loan % 100 != 0) {
//        $error = 'Recovery must be in multiples of 100s';
//    } else {
//        $chk_otp = new Database;
//        $chk_otp->query("select * from otp_tbl where EMP_NO = $user and PURPOSE = 'LOAN REC CHANGE' and status = 'UNUSED'");
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
//                    $update_otp_status->query("update otp_tbl set status = 'EXPIRED' where EMP_NO = $user and PURPOSE = 'LOAN REC CHANGE' and status = 'UNUSED'");
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
//                            $insert_record_query = "insert into rec_updates (`EMP_NO`, `new_td`, `new_vtd`, `new_loan`, `new_edl`) values ('$user', '0', '0', '$new_loan', '0');"
//                                    . "update th_loan_master set REC_RATE_CUR = '$new_loan' where EMP_NO = $user";
//                            $insert_record = new Database;
//                            $insert_record->query($insert_record_query);
//                            $info = 'Recovery Updates Successfully';
//                            $subject = "Recovery Update Alert";
//                            $message = "Dear " . $ename . " your" . $rec_type . " has been updated to " . $new_td . " in case u have not updates please change your password and contact Society Office Immidiately";
//                            send_mail($email, $ename, $message, $subject);
//                            sms($message, $phone);
//                            //header("location:lloan.php");
//                        } else {
//                            $update_record_query = "update rec_updates set `new_loan` = '$new_loan' where EMP_NO = $user ;"
//                                    . "update th_loan_master set REC_RATE_CUR = '$new_loan' where EMP_NO = $user";
//                            $update_record = new Database;
//                            $update_record->query($update_record_query);
//                            $info = 'Recovery Updates Successfully';
//                            $subject = "Recovery Update Alert";
//                            $message = "Dear " . $ename . " your " . $rec_type . " has been updated to " . $new_loan . " in case u have not updates please change your password and contact Society Office Immidiately";
//                            send_mail($email, $ename, $message, $subject);
//                            sms($message, $phone);
//                            //header("location:lloan.php");
//                        }
//                        $update_otp_status = new Database;
//                        $update_otp_status->query("update otp_tbl set status = 'USED' where EMP_NO = $user and PURPOSE = 'LOAN REC CHANGE' and status = 'UNUSED' ");
//                    } else {
//                        $error = 'OTP Expaired';
//                        $update_otp_status = new Database;
//                        $update_otp_status->query("update otp_tbl set status = 'EXPIRED' where EMP_NO = $user and PURPOSE = 'LOAN REC CHANGE' and status = 'UNUSED'");
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
    } elseif ($error == '' && $info != '') {
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
        $query = "select * from th_loan_master where emp_no='$user' and LOAN_STATUS = 'R'";
        $get_loan_data = new Database;
        $get_loan_data->query($query);
        $present_loan_balence = '';
        global $obp, $eligble_amount2;
        $loan_count = $get_loan_data->count();

        if ($loan_count > 0) {
            $loan_data = $get_loan_data->resultset();
            foreach ($loan_data as $row) {
                $loanamount = $row['SACTIONED_AMOUNT'];
                $rate = $row['RATE_OF_INTREST'];
                $sac_date = date('d-M-Y', strtotime($row['SACTION_DATE']));
//                                $curr_date = new DateTime("now");
//                                $sanction_date = date_create($row['SACTION_DATE']);

                $sanction_year = date("Y", strtotime($row['SACTION_DATE']));

                $current_year = date('Y');

                $sanction_month = date('m', strtotime($row['SACTION_DATE']));
                $current_month = date('m');

                $diff = (($current_year - $sanction_year) * 12) + ($current_month - $sanction_month);

//                                $interval = $sanction_date->diff($curr_date);
//                                $date_diff_in_moths = $interval->format('%y years and %m months');

                $surity1 = $row['SURITY1'];
                $surity2 = $row['SURITY2'];
                $surity3 = $row['SURITY3'];
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
                // FOR 50% CALUCLATION
                $eligble_amount1 = ($loanamount * 0.50);
                $eligble_amount2 = $loanamount - $eligble_amount1;
                $eligble_amount3 = ($present_loan_balence - $eligble_amount2);

                //FOR 25% CALUCUALTION
                $eligble_amount1_25 = ($loanamount * 0.25);
                $eligble_amount2_25 = $loanamount - $eligble_amount1_25;
                $eligble_amount3_25 = ($present_loan_balence - $eligble_amount2_25);
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
                    <td>Recovery Rate</td><td>
                        <?php echo round($row['REC_RATE_CUR'], 0) ?>
                        <!--<button type="button" class="btn btn-info" data-toggle="modal" data-target="#update_loan_modal">Request for Recovery Rate change</button>--> 
                    </td>

                    <!-- Modal -->
                <div id="update_loan_modal" class="modal fade hide_div" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Update loan Recovery</h4>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="loan_rec_change_form.php" autocomplete="off">
                                    <div class="form-group">
                                        <label for="present_rec">Present Recovery Rate</label>
                                        <input class="form-control" type="text" id="present_rec" name="present_loan" value="<?php echo round($row['REC_RATE_CUR'], 0) ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="required_rec">Required Recovery Rate Change</label>
                                        <input class="form-control" id="required_rec" type="text" name="new_loan" required>
                                        <small style="color: red" >Note : This is not an online submission. Member has to take print out of the application and submit the same at Society office,failing which the application can't be processed for Change of Recovery.</small>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control btn btn-success" type="submit" name="btn_change_loan" value="Print">
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
                    <td>No.Installments</td><td><?php echo $row ['INSTALLMENTS'] ?></td>
                </tr>

                <tr>
                    <td>Present loan Balance</td>
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
                if ($surity3 != 0) {
                    $get_suritie3_date = new Database;
                    $get_suritie3_date->prepare("SELECT * FROM `th_member_master` where EMP_NO = $surity3 ");
                    $suritie3_data = $get_suritie3_date->resultset();
                    foreach ($suritie3_data as $suritie3_data) {
                        
                    }
                    ?>
                    <tr>
                        <td>Surety 3</td>
                        <td>
                            <div class="row">
                                <div class="col-md-6">
                                    <?php echo $surity3 ?>, &nbsp; <?php echo $suritie3_data['EMP_NAME'] ?>
                                    <br>
                                    <?php echo $suritie3_data['DEPT'] ?>
                                </div>
                                <div class="col-md-6">
                                    <img class="img-responsive" src="user_img/<?php echo $surity3 ?>_pht.jpg" width="50">
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
    $query2 = "select * from th_loan_trans where emp_no='$user' and LOAN_NO = (select LOAN_NO from th_loan_master where emp_no='$user' and LOAN_STATUS = 'R') order by TRANS_DATE DESC ";
    //echo $query2;
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
        if ($_SESSION['loan_default'] == 'YES') {
            echo "<h5>Your Loan is overdue by Rs." . $_SESSION['loan_diff_amount'] . "/- </h5>";
        }
        ?>
    </div>

    <div class="col-md-12">
        <?php
        $query2 = "select * from th_loan_register where emp_no='$user'";
        $get_loan_registration_status = new Database;
        $get_loan_registration_status->query($query2);
        $count = $get_loan_registration_status->count();
        if ($count > 0) {
            $result2 = $get_loan_registration_status->resultset();
            foreach ($result2 as $row2) {
                $app_amount = $row2['APPLIED_AMOUNT'];
                $reg_date = date('d-M-Y', strtotime($row2['REGISTER_DATE']));
                echo"<br>";
                ?>
                <div class="alert alert-info">        
                    You have applied for loan of Rs.<?php echo $app_amount ?>/-  on <?php echo $reg_date ?>
                </div>
                <?php
            }
        } else {

            if (empty($default_msg)) {
                if ($present_loan_balence == '' || $present_loan_balence == NULL) {
                    ?>
                    <div class="alert alert-success">
                        You are eligible for next loan 
                    </div>
                    <?php
                } elseif ($present_loan_balence > $eligble_amount2_25) {
                    ?>

                    You are eligible for next loan after repaying of Rs. <?php echo $eligble_amount3_25 ?>/- Through Salary
                    <br>

                    <?php
                } else if ($present_loan_balence > $eligble_amount2_25) {
                    if ($present_loan_balence > $eligble_amount2) {
                        ?>
                        <div class="alert alert-warning">
                            You are eligible for next loan after repaying of Rs. <?php echo $eligble_amount3 ?>/-

                        </div>
                        <?php
                    }
                } else {
                    if ($_SESSION['loan_default'] != 'YES') {
                        ?>
                        <div class="alert alert-success">
                            You are eligible for next loan 
                        </div>
                        <?php
                    }
                }
            }
        }
        ?>
    </div>
    <hr>
    <div class="col-md-12 show_div">
        <div class="alert alert-warning">for Geting Loan Statement Please update to latest browser</div>
    </div>
    <div class="col-md-12 hide_div">
        Click here for 
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal1">Long Term Loan Statement</button>

        <!-- Loan Statement Modal Starting -->
        <div id="myModal1" class="modal fade" role="dialog">
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
                            $loan_list_query = "SELECT * FROM `th_loan_master` WHERE EMP_NO = $user ORDER BY `SACTION_DATE` DESC";
                            $get_all_loan_data = new Database;
                            $get_all_loan_data->prepare($loan_list_query);
                            $all_loan_data = $get_all_loan_data->resultset();
                            foreach ($all_loan_data as $data) {
                                $sanction_date = date('d-m-Y', strtotime($data['SACTION_DATE']))
                                ?>
                                <tr>
                                    <td><a href="loan_cert_pdf.php?loan_no=<?php echo $data['LOAN_NO'] ?>"><?php echo $data['LOAN_NO'] ?></a></td>
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
        <!-- Loan Statement Modal Ending -->

    </div>
</div>

<?php include 'footer.php'; ?>