<?php
ob_start();
session_start();
if (!isset($_SESSION['suser'])) {
    header("location:index.php");
}
$user = $_SESSION['suser'];
include 'header.php';
?>

<div class="row" style="margin-top: 15px; padding: 10px;">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <form method="post" action="">
            <div class="form-group">
                <label for="emp_req">Requested Employee Number</label>
                <input type="number" name="emp_req" id="emp_req" class="form-control" placeholder="EMPLOYEE NUMBER"
                       inputmode="numeric" pattern="[0-9]*"
                       value="<?php echo isset($_POST['emp_req']) ? $_POST['emp_req'] : '' ?>"
                       >
            </div>
            <div class="form-group">
                <input type="submit" name="btn_emp_req" class="btn btn-primary">
            </div>
        </form>
    </div>
    <?php
    if (isset($_POST['btn_emp_req'])) {
        $emp_req = $_POST['emp_req'];
        ?>
        <div class="col-md-12 col-xs-12 col-sm-12">
            <h5>Loan Info</h5>
            <?php
            $get_loan_info = new Database;
            $get_loan_info->query("select * from th_loan_master where emp_no='$emp_req' and LOAN_STATUS = 'R'");
            $loan_count = $get_loan_info->count();
            if ($loan_count > 0) {
                $loan_info = $get_loan_info->resultset();
                foreach ($loan_info as $loan_info) {
                    $loanamount = $loan_info['SACTIONED_AMOUNT'];
                    $obi = $loan_info['OBI'];
                    $cbp = $loan_info['CBP'];
                    $rate = $loan_info['RATE_OF_INTREST'];
                    if (date('d') <= 15) {
                        $cbi = $loan_info['CBI'];
                    } else {
                        $interest = ((($cbp * $rate) / 12) / 100) / 2;
                        $cbi = round($loan_info['CBI'] + $interest);
                    }
                    $present_loan_balance = $cbp + $cbi;
                    $eligble_amount1_25 = ($loanamount * 0.25);
                    $eligble_amount2_25 = $loanamount - $eligble_amount1_25;
                    $eligble_amount3_25 = ($present_loan_balance - $eligble_amount2_25);
                    ?>
                    Loan Taken : <?php echo $loanamount; ?> <br>
                    Present Loan Balance : <?php echo $present_loan_balance ?><br>
                    <?php
                    if ($present_loan_balance < $eligble_amount2_25) {
                        echo 'Eligible for applying for new loan';
                    } else {
                        echo 'Eligible for next loan after repaying of ' . $eligble_amount3_25 . ' through salary';
                    }
                    ?>
                    <?php
                }
            } else {
                echo 'Dont have loan balance';
            }
            ?>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 25px;">
            <h5>Med. Term Loan Info</h5>
            <?php
            $get_edl_data = new Database;
            $get_edl_data->query("select * from th_ed_loan_master where emp_no='$emp_req' and LOAN_STATUS = 'R'");
            $edl_count = $get_edl_data->count();
            if ($edl_count > 0) {
                $edl_data = $get_edl_data->resultset();
                foreach ($edl_data as $edl_data) {
                    $loanamount = $edl_data['SACTIONED_AMOUNT'];
                    $rate = $edl_data['RATE_OF_INTREST'];
                    $obp = $edl_data['OBP'];
                    $obi = $edl_data['OBI'];
                    $cbp = $edl_data['CBP'];
                    if (date('d') <= 15) {
                        $cbi = $edl_data['CBI'];
                    } else {
                        $interest = ((($cbp * $rate) / 12) / 100) / 2;
                        $cbi = round($edl_data['CBI'] + $interest);
                    }
                    $present_loan_balence = $cbp + $cbi;
                    $eligble_amount1_25 = ($loanamount * 0.25);
                    $eligble_amount2_25 = $loanamount - $eligble_amount1_25;
                    $eligble_amount3_25 = ($present_loan_balence - $eligble_amount2_25);
                    ?>
                    Loan Taken : <?php echo $loanamount; ?> <br>
                    Present Loan Balance : <?php echo $present_loan_balence ?><br>
                    <?php
                    if ($present_loan_balence < $eligble_amount2_25) {
                        echo 'Eligible for applying for new loan';
                    } else {
                        echo 'Eligible for next loan after repaying of ' . $eligble_amount3_25 . ' through salary';
                    }
                }
            } else {
                echo 'Dont have Med. Term Loan';
            }
            ?>
        </div> 

        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 25px;">
            <h5>TD Info</h5>
            <?php
            $tool_msg = '';
            $eliggibilty_status = '';
            $query = "select EMP_NO, GL_NO, OPEN_BAL, CLOSE_BAL, INTEREST, RECOVERY_RATE, PRG_RECOVERIES, PRG_PAYMENTS, MODIFIED_DATE,
 MEMBERSHIP_DATE, LAST_WITHDRAWAL_DATE, IF(LAST_WITHDRAWAL_DATE IS NULL,0,LAST_WITHDRAWAL_DATE) as dt,  DATE_ADD(LAST_WITHDRAWAL_DATE, INTERVAL 12 MONTH) as NEWDATE, USER_ID, TRN_NO, TRAN_STATUS,
 LAST_YR_INT, RRATE, RRATE_OLD from th_thrift_deposit_master where emp_no='$emp_req'";
            $get_td_data = new Database;
            $get_td_data->query($query);

            $count = $get_td_data->count();
            if ($count > 0) {
                $result = $get_td_data->resultset();
                foreach ($result as $row) {
                    $ob = round($row['OPEN_BAL'], 0);
                    $cb = round($row['CLOSE_BAL'], 0);
                    if ($cb > 20000) {
                        $elg_amt = $cb / 2;
                    } else {
                        $elg_amt = $cb - 10000;
                    }
                    $rec_rate = round($row['RECOVERY_RATE'], 0);
                    $prev_with_date = $row['dt'];
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
                            $eliggibilty_status = 'eligible';
                            $mymsg = '';
                        } else {
                            if (strtotime($eligble_date) <= strtotime($curr_date)) {
                                $eliggibilty_status = 'eligible';
                                $mymsg = '';
                            } else {
                                $eliggibilty_status = 'not_eligible';
                                $_SESSION['td_app_status'] = FALSE;
                                $mymsg = 'Eligible for withdrawal after  ' . $eligble_date;
                            }
                        }
                    } else {
                        $eliggibilty_status = 'not_eligible';
                        $_SESSION['td_app_status'] = FALSE;
                        $mymsg = 'Eligible for withdrawal after  ' . $date_five;
                    }

                    $app_status = '';
                    $query3 = "select * from th_td_register where emp_no='$user'";
                    $get_registration_status = new Database;
                    $get_registration_status->query($query3);
                    $count = $get_registration_status->count();
                    if ($count > 0) {
                        $app_status = 'aplied';
                        $result3 = $get_registration_status->resultset();
                        foreach ($result3 as $row2) {
                            $_SESSION['td_app_status'] = FALSE;
                            $app_amount = $row2['APPLIED_AMOUNT'];
                            $reg_date = date('d-M-Y', strtotime($row2['REGISTRATION_DATE']));
                        }
                    } else {
                        $_SESSION['td_app_status'] = TRUE;
                        $app_status = 'not_applied';
                    }
                }
            }
            ?>
            TD Balance : <?php echo $cb ?> <br>
            TD Recovery : <?php echo $rec_rate ?><br>
            <?php
            if ($app_status == 'aplied') {
                ?>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="alert alert-info">
                            <h5 align="center">Applied for Withdrawal of Rs.<?php echo $app_amount ?>/-  on <?php echo $reg_date ?></h5>
                        </div>
                    </div>
                </div>
                <?php
            } else if ($eliggibilty_status = 'not_eligible' && $mymsg != '') {
                if (empty($default_msg)) {
                    ?>
                    <div class = "row">
                        <div class = "col-md-6 col-md-offset-3">
                            <div class = "alert alert-info">
                                <span align="center"><?php echo $mymsg ?></span>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class = "row">
                    <div class = "col-md-6 col-md-offset-3">
                        <div class = "alert alert-info">
                            <h5 align="center">Eligible for Withdrawal Rs.<?php echo round_to_hundred($elg_amt); ?></h5>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 25px;">
            <h5>VTD Info</h5>

            <?php
            $tool_msg = '';
            $query = "select * from th_vtd_master where emp_no='$emp_req'";
            $get_vtd_data = new Database;
            $get_vtd_data->query($query);
            $opt_count = $get_vtd_data->count();
            if ($opt_count > 0) {
                $result = $get_vtd_data->resultset();
                foreach ($result as $row) {
                    $ob = round($row['OPEN_BAL'], 0);
                    $total_Recov = round($row['PRG_RECOVERIES'], 0);
                    $total_payments = round($row['PRG_PAYMENTS'], 0);
                    $cb = round($row['CLOSE_BAL'], 0);
                    $rec_rate = round($row['RECOVERY_RATE'], 0);
                    $elg_amt = round($cb, 0);
                }
                ?>
                Total VTD : <?php echo $cb; ?> <br>
                Present recovery : <?php echo $rec_rate; ?>

                <?php
                $query3 = "select * from th_vtd_register where emp_no='$emp_req'";
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
                <?php
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
                } else {
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
                <?php
            } else {
                echo 'No VTD Deposit';
            }
            ?>
        </div>
        <?php
    }
    ?>
</div>

<?php include 'footer.php'; ?>