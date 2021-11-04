<?php
ob_start();
session_start();
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
$ub = '';
include 'db.php';
include 'function.php';
include 'sanitize.php';
include 'Hash.php';
include 'cookie.php';

if (cookie::exists('hash')) {
    $hash = cookie::get('hash');
    $get_sessio_user_id = new Database;
    $get_sessio_user_id->query("select * from user_session where hash = '$hash'");
    $session_user_id_count = $get_sessio_user_id->count();
    $session_user_id = $get_sessio_user_id->resultset();
    foreach ($session_user_id as $sid) {
        $user_id = $sid['emp_no'];
    }
    if ($session_user_id_count != 0) {
        cookie::put('hash', $hash, 950400);
        if (!isset($_SESSION['suser'])) {
            $_SESSION['suser'] = $user_id;
            header("location:landing.php");
        }
    }
} else {
    if (!isset($_SESSION['suser'])) {
        header("location:index.php");
    } else {
        $user = $_SESSION['suser'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>VSPECT & CS LTD</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Favicons -->
        <link href="img/favicon.png" rel="icon">
        <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

        <!-- Google Fonts 
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700|Raleway:300,400,400i,500,500i,700,800,900" rel="stylesheet">
        -->
        <?php
        if ($ub != "IE") {
            ?>
            <!-- Bootstrap CSS File -->
            <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
            <!-- Responsive Stylesheet File -->
            <link href="css/responsive.css" rel="stylesheet">
            <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
            <style>
                .show_div{
                    display: none;
                }
            </style>
            <?php
        } else if ($ub = "IE") {
            ?>
            <link href="css/old_browser.css" rel="stylesheet">
            <link href="css/style_old.css" rel="stylesheet" type="text/css"/>
            <style>
                .hide_div{
                    display: none;
                }
                .show_div{
                    display: block;
                }
            </style>
            <?php
        }
        ?>

        <link rel="stylesheet" type="text/css" href="css/folio-gallery.css" />
        <link rel="stylesheet" type="text/css" href="colorbox/colorbox.css" />

        <!-- Main Stylesheet File -->
        <link href="css/style.css" rel="stylesheet">

        <script src="js/jquery-3.3.1.min.js" type="text/javascript"></script>

        <!--<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>-->
        <script src="js/jquery.cycle.all.js" type="text/javascript"></script>
        <script src="js/scripts.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('marquee').on('mouseover', function () {
                    $(this).attr("direction");
                })
            });
        </script>
        <?php
        if (isset($_SESSION)) {
            ?>
            <style>
                table tr th{
                    color: green;
                }

                h5{
                    color: #8e3228;
                }
            </style>
            <?php
        }
        ?>
    </head>

    <body>

        <header class="hidden-print" >
            <!-- header-area start -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                        <img src="img/header_baner.png" alt="Header Baner" class="img-responsive">
                    </div>
                </div>
            </div>

            <div class="container-fluid scrol-wrap">
                <div class="row scrol-div">
                    <?php include 'top_scrol.php'; ?>
                </div>            
            </div>

<!--            <nav class="navbar" style="background-color: aliceblue">
                <div class="container-fluid">
                     Brand and toggle get grouped for better mobile display 
                    <div class="navbar-header" >
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav" aria-expanded="false" style=" border-color: #337ab7">
                            <span class="sr-only">Toggle navigation</span>
                            <span style="font-weight: bolder; font-size: larger; color: #337ab7"><i class="fa fa-arrow-alt-circle-down"></i> &nbsp; Menu</span>
                        </button>
                    </div>
                     Collect the nav links, forms, and other content for toggling 
                    <div class="collapse navbar-collapse" id="main-nav">
                        <ul class="nav navbar-nav">
                            <li class=""><a href="admin.php">Member Info</a></li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#"> Loans
                                    <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="lloan.php">Long Term Loan</a></li>
                                    <li><a href="slone.php">Medium Term Loan</a></li>
                                    <li><a href="sur_data.php">Surety Data </a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#"> Deposits
                                    <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="td.php">Thrift Deposit</a></li>
                                    <li><a href="vtd.php">Voluntary Thrift Deposit </a></li>
                                    <li><a href="fd.php">Fixed Deposit</a></li>
                                    <li><a href="rb.php">Retirement Benefit Scheme</a></li>
                                    <li><a href="share.php">Shares</a></li>
                                </ul>
                            </li>
                            <li class=""><a href="miscellaneous.php">Miscellaneous</a></li>
                            <li class=""><a href="reports.php">Reports</a></li>
                            <li class=""><a href="feedback.php">Feed Back / Suggestions</a></li>
                            <li class=""><a href="download_appl.php">Downloads</a></li>
                            <li><a href="update_pass.php">Change Password</a></li>
                            <li><a href="logout.php"><span style="color: red" >Logout</span></a></li>
                        </ul>
                    </div> /.navbar-collapse 
                </div> /.container-fluid 
            </nav>-->
            <!-- header-area end -->
        </header>
        <!-- header end -->
        <?php
        if (isset($_SESSION)) {
            $user = $_SESSION['suser'];
            $chk_loan_exist_quiry = "select * from th_loan_master where emp_no='$user' and LOAN_STATUS = 'R'";
            $chk_loan_exist = new Database;
            $chk_loan_exist->query($chk_loan_exist_quiry);
            $loan_exist = $chk_loan_exist->count();
            if ($loan_exist != 0) {
                $loan_exist_data = $chk_loan_exist->resultset();
                foreach ($loan_exist_data as $loan_exist_data) {
                    $loan_currunt_date = date('d-m-Y');
                    $loan_currunt_date = date_create($loan_currunt_date);
                    echo '<br>';
                    $loan_sanction_date = date('d-m-Y', strtotime($loan_exist_data['SACTION_DATE']));
                    $loan_sanction_date = date_create($loan_sanction_date);
                    //echo date_diff
                    $sanctiond_date = date_create($loan_exist_data['SACTION_DATE']);
                    $loan_diff_months = month_diff($sanctiond_date);
                    $loan_diff_days = day_diff($sanctiond_date);
                    $sanction_year = date("Y", strtotime($loan_exist_data['SACTION_DATE']));
                    $current_year = date('Y');
                    $sanction_month = date('m', strtotime($loan_exist_data['SACTION_DATE']));
                    $month_to_left1 = $sanction_month + 1;
                    $month_to_left2 = $sanction_month + 2;
                    $current_month = date('m');
                    $sanction_day = date('d', strtotime($loan_exist_data['SACTION_DATE']));
                    $diff = (($current_year - $sanction_year) * 12) + ($current_month - $sanction_month);
                    $loan_exist_data['REC_RATE_DEF'];
                }
                //echo $get_total_recovary_query = "SELECT SUM(`AMOUNTP`) as total_prinicple, SUM(`AMOUNTI`) as total_interest FROM th_loan_trans WHERE EMP_NO = $user AND LOAN_NO = (select LOAN_NO from th_loan_master where emp_no= $user and LOAN_STATUS = 'R')";
                if ($sanction_day < 15 && $loan_diff_days > 46) {
                    if ($loan_sanction_date < $loan_currunt_date) {
                        $get_total_recovary_query = "SELECT SUM(`AMOUNTP`) as total_prinicple, SUM(`AMOUNTI`) as total_interest FROM th_loan_trans WHERE EMP_NO = $user AND LOAN_NO = (select LOAN_NO from th_loan_master where emp_no= $user and LOAN_STATUS = 'R')";
                        $get_total_recovary = new Database;
                        $get_total_recovary->prepare($get_total_recovary_query);
                        $total_recovery = $get_total_recovary->resultset();
                        foreach ($total_recovery as $total_recovery) {
                            $total_recovery_amount = $total_recovery['total_prinicple'] + $total_recovery['total_interest'];
                            $total_amont_to_be_recoverd = $diff * $loan_exist_data['REC_RATE_DEF'];
                            $diff_amont = $total_amont_to_be_recoverd - $total_recovery_amount;
                        }
                        if ($total_recovery_amount < $total_amont_to_be_recoverd) {
                            $_SESSION['loan_default'] = 'YES';
                            $_SESSION['loan_diff_amount'] = $diff_amont;
                            $default_msg[] = "Your Loan is overdue by Rs." . $_SESSION['loan_diff_amount'] . "/-";
                        } else {
                            $_SESSION['loan_default'] = 'NO';
                        }
                    } else {
                        $_SESSION['loan_default'] = 'NO';
                    }
                } else {
                    $_SESSION['loan_default'] = 'NO';
                }
            } else {
                $_SESSION['loan_default'] = 'NO';
            }

            $chk_edl_loan_exist_quiry = "select * from th_ed_loan_master where emp_no='$user' and LOAN_STATUS = 'R'";
            $chk_edl_loan_exist = new Database;
            $chk_edl_loan_exist->query($chk_edl_loan_exist_quiry);
            $edl_exist = $chk_edl_loan_exist->count();
            if ($edl_exist > 0) {
                $exist_edl_data = $chk_edl_loan_exist->resultset();
                foreach ($exist_edl_data as $exist_edl_data) {
                    $loan_num = $exist_edl_data['LOAN_NO'];
                    $edl_sanction_date = date('m-Y', strtotime($exist_edl_data['SACTION_DATE']));
                    $edl_sanction_month = date('m', strtotime($exist_edl_data['SACTION_DATE']));
                    $edl_sanction_day = date('d', strtotime($exist_edl_data['SACTION_DATE']));
                    $edl_currunt_date = date('m-Y');
                    $edl_sanctiond_date = date_create($exist_edl_data['SACTION_DATE']);
                    $sanction_day = date('d', strtotime($exist_edl_data['SACTION_DATE']));
                    $edl_day_diff = day_diff(date_create($exist_edl_data['SACTION_DATE']));
                    $edl_diff_months = month_diff($edl_sanctiond_date);
                    $edl_current_month = date('m');
                    $edl_month_to_left1 = $edl_sanction_month + 1;
                    $edl_month_to_left2 = $edl_sanction_month + 2;
                }

                if ($edl_sanction_date < $edl_currunt_date) {
                    $get_total_recovary_query = "SELECT SUM(`AMOUNTP`) as total_prinicple, SUM(`AMOUNTI`) as total_interest FROM th_edl_trans WHERE EMP_NO = $user AND LOAN_NO = $loan_num ";
                    $get_total_recovary = new Database;
                    $get_total_recovary->prepare($get_total_recovary_query);
                    $total_recovery = $get_total_recovary->resultset();
                    foreach ($total_recovery as $total_recovery) {
                        $total_recovery_amount = $total_recovery['total_prinicple'] + $total_recovery['total_interest'];
                    }

                    $get_first_rec_query = "SELECT * FROM `th_edl_trans` WHERE LOAN_NO = $loan_num ORDER BY `th_edl_trans`.`TRANS_DATE` ASC LIMIT 1 ";
                    $get_first_rec = new Database;
                    $get_first_rec->prepare($get_first_rec_query);
                    $first_rec = $get_first_rec->resultset();
                    foreach ($first_rec as $first_rec) {
                        $princple_amount = $first_rec['AMOUNTP'];
                        $interest_amount = $first_rec['AMOUNTI'];
                        $total_emi = $princple_amount + $interest_amount;
                        $first_trans_date = date_create($first_rec['TRANS_DATE']);
                        //changed on 28/12/18 for checking
                        $month_diff = month_diff($first_trans_date);
                        $total_amont_to_be_recoverd = $month_diff * $total_emi;
                    }

                    if ($sanction_day > 15 && $edl_day_diff < 46) {
                        $_SESSION['ed_loan_default'] = 'NO';
                    } elseif ($sanction_day <= 15) {
                        $diff_amont = $total_amont_to_be_recoverd - $total_recovery_amount;
                        if ($total_recovery_amount < $total_amont_to_be_recoverd) {
                            $_SESSION['ed_loan_default'] = 'YES';
                            $_SESSION['edl_diff_amount'] = $diff_amont;
                            $default_msg[] = "Your Medium Term Loan is overdue by Rs." . $_SESSION['edl_diff_amount'] . "/-";
                        } else {
                            $_SESSION['ed_loan_default'] = 'NO';
                        }
                    } else {
                        $_SESSION['ed_loan_default'] = 'NO';
                    }
                } else {
                    $_SESSION['ed_loan_default'] = 'NO';
                }
            } else {
                $_SESSION['ed_loan_default'] = 'NO';
            }

            $chk_surity_rec_query = "select * from th_surity_rec_master where PRI_EMP_NO = $user and REC_AMOUNT != 0";
            $chk_surity_rec = new Database;
            $chk_surity_rec->query($chk_surity_rec_query);
            $sur_rec_count = $chk_surity_rec->count();
            if ($sur_rec_count > 0) {
                $_SESSION['sur_rec'] = 'YES';
                $default_msg[] = "Your Loan is Rec from Surities Please pay the dues";
            } else {
                $_SESSION['sur_rec'] = 'NO';
            }

            $this_day = date('d');
            $this_month = date('m');
            if ($this_day <= 31) {
                $month = date('m');
                //echo $month = date('m', strtotime('-3 month'));
                $month = $month - 3;
            } else {
                $month = date('m', strtotime('-2 month'));
            }

            if ($this_month == 01 || $this_month == 02 || $this_month == 03) {
                $year = date('Y', strtotime('-1 year'));
            } else {
                $year = date('Y');
            }
            $date_gen = '28-' . $month . '-' . $year;
            $date_to_chk = date('Y-m-d', strtotime($date_gen));

            if ($loan_exist != 0) {

                if ($sanction_day > 15 && $loan_diff_days > 90) {
                    if ($loan_sanction_date < $loan_currunt_date) {
                        $check_loan_emi_regular_query = "SELECT * FROM `th_loan_trans` WHERE EMP_NO = $user AND LOAN_NO = (SELECT LOAN_NO FROM th_loan_master WHERE EMP_NO = $user AND LOAN_STATUS = 'R') AND TRANS_DATE >= '$date_to_chk' AND MODE_OF_PAYMENT = 'S'";
                        $check_loan_emi_regular = new Database;
                        $check_loan_emi_regular->query($check_loan_emi_regular_query);
                        $loan_emi_count = $check_loan_emi_regular->count();
                        if ($loan_diff_months == 1) {
                            if ($loan_diff_months == 1 && $loan_emi_count == 1) {
                                $_SESSION['loan_not_reguler'] = 'NO';
                            } else {

                                $_SESSION['loan_not_reguler'] = 'YES';
                                $default_msg[] = "You are not Reguler in paying loan installment";
                            }
                        } else if ($loan_diff_months == 2) {
                            //modfied on 08/02/2019 - showing loan recas defaulter
                            if ($loan_diff_months == 2 && $loan_emi_count >= 2) {
                                $_SESSION['loan_not_reguler'] = 'NO';
                            } else {

                                $_SESSION['loan_not_reguler'] = 'YES';
                                $default_msg[] = "You are not Reguler in paying loan installment";
                            }
                        } else if ($loan_diff_months >= 3) {
                            if ($loan_emi_count < 3) {
                                $_SESSION['loan_not_reguler'] = 'YES';
                                $default_msg[] = "You are not Reguler in paying loan installment";
                            } else {
                                $_SESSION['loan_not_reguler'] = 'NO';
                            }
                        } else {
                            $_SESSION['loan_not_reguler'] = 'NO';
                        }
                    } else {
                        $_SESSION['loan_not_reguler'] = 'NO';
                    }
                }
            } else {
                $_SESSION['loan_not_reguler'] = 'NO';
            }

            if ($edl_exist > 0) {

                if ($edl_sanction_day > 15 && ($edl_current_month == $edl_month_to_left1 || $edl_current_month == $edl_month_to_left2)) {
                    $_SESSION['ed_loan_default'] = 'NO';
                } elseif ($edl_sanction_date < $edl_currunt_date) {
                    $chk_edl_emi_reguler_query = "SELECT * FROM `th_edl_trans` WHERE EMP_NO = $user AND LOAN_NO = (SELECT LOAN_NO FROM th_ed_loan_master WHERE EMP_NO = $user AND LOAN_STATUS = 'R') AND TRANS_DATE >= '$date_to_chk' AND MODE_OF_PAYMENT = 'S'";
                    $chk_edl_emi_reguler = new Database;
                    $chk_edl_emi_reguler->query($chk_edl_emi_reguler_query);
                    $edl_emi_count = $chk_edl_emi_reguler->count();
                    if ($edl_diff_months == 1) {
                        if ($edl_diff_months == 1 && $edl_emi_count >= 1) {
                            $_SESSION['edl_not_reguler'] = 'NO';
                        } else {
                            $_SESSION['edl_not_reguler'] = 'YES';
                            $default_msg[] = "You are not Reguler in paying Medium Term Loan installment";
                        }
                    } else if ($edl_diff_months == 2) {
                        if ($edl_diff_months == 2 && $edl_emi_count >= 2) {
                            $_SESSION['edl_not_reguler'] = 'NO';
                        } else {
                            $_SESSION['edl_not_reguler'] = 'YES';
                            $default_msg[] = "You are not Reguler in paying Medium Term Loan installment";
                        }
                    } else if ($edl_diff_months >= 3) {
                        if ($edl_emi_count < 3 && $edl_sanction_day < 15) {
                            $_SESSION['edl_not_reguler'] = 'YES';
                            $default_msg[] = "You are not Reguler in paying Medium Term Loan installment";
                        } else {
                            $_SESSION['edl_not_reguler'] = 'NO';
                        }
                    } else {
                        $_SESSION['edl_not_reguler'] = 'NO';
                    }
                } else {
                    $_SESSION['edl_not_reguler'] = 'NO';
                }
            } else {
                $_SESSION['edl_not_reguler'] = 'NO';
            }

            $check_td_rec_reguler_query = "SELECT * FROM `th_thrift_deposit_trans` WHERE EMP_NO = $user AND TRANS_DATE >= '$date_to_chk' AND TYPE_OF_TRANS = 'R'";
            $check_td_rec_reguler = new Database;
            $check_td_rec_reguler->query($check_td_rec_reguler_query);
            $td_rec_count = $check_td_rec_reguler->count();
            if ($td_rec_count < 3) {
                $_SESSION['td_not_reguler'] = 'YES';
                $default_msg[] = "You are not Reguler in paying Thrift Deposit installment";
            } else {
                $_SESSION['td_not_reguler'] = 'NO';
            }
            //$rec_date1 = date('Y-m-d', strtotime($day.'-'.$month.''.));

            $chk_loan_regularity_query = "";

            if (!isset($_SESSION['suser'])) {
                echo('please login');
                header("location:index.php");
            } else {
                //$user = $_SESSION['suser'];

                $q = "select * from th_member_master where EMP_NO='$user'";
                $get_member_data = new Database;
                $get_member_data->query($q);
                $member_data = $get_member_data->resultset();
                foreach ($member_data as $row) {
                    $bank_account_number = $row['BANK_AC_NO'];
                    $bank_name = $row['BANKNAME_OLD'];
                }
                $ename = $row['EMP_NAME'];
                $fname = $user . "_pht.jpg";
                $reg_data = new Database;
                $reg_date_query = "select * from email_master where EMP_NO =" . $user;
                $reg_data->query($reg_date_query);
                $email_count = $reg_data->count();
                if ($email_count > 0) {
                    $reg_user_data = $reg_data->resultset();
                    foreach ($reg_user_data as $user_data) {
                        //$phone = $user_data['Mobile'];
                        $email = $user_data['EMAIL_ID'];
                    }
                } else {
                    $email = '';
                }
            }
            $panel_name = '';
            if (basename($_SERVER['PHP_SELF']) == 'admin.php') {
                $panel_name = 'Member information';
            }
            if (basename($_SERVER['PHP_SELF']) == 'lloan.php') {
                $panel_name = 'Long Term Loan';
            }
            if (basename($_SERVER['PHP_SELF']) == 'slone.php') {
                $panel_name = 'Medium Term Loan';
            }
            if (basename($_SERVER['PHP_SELF']) == 'sur_data.php') {
                $panel_name = 'Surity Given Information';
            }
            if (basename($_SERVER['PHP_SELF']) == 'td.php') {
                $panel_name = 'Thrift Deposit';
            }
            if (basename($_SERVER['PHP_SELF']) == 'vtd.php') {
                $panel_name = 'Voluntary Thrift Deposit';
            }
            if (basename($_SERVER['PHP_SELF']) == 'rb.php') {
                $panel_name = 'Retirement Benfit Fund';
            }
            if (basename($_SERVER['PHP_SELF']) == 'fd.php') {
                $panel_name = 'Fixed Deposit';
            }
            if (basename($_SERVER['PHP_SELF']) == 'share.php') {
                $panel_name = 'Share Capital';
            }
            if (basename($_SERVER['PHP_SELF']) == 'miscellaneous.php') {
                $panel_name = 'Miscellaneous information';
            }
            if (basename($_SERVER['PHP_SELF']) == 'feedback.php') {
                $panel_name = 'Feedback/ Suggestion';
            }
            if (basename($_SERVER['PHP_SELF']) == 'update_pass.php') {
                $panel_name = 'Update Password';
            }
            if (basename($_SERVER['PHP_SELF']) == 'add_update.php') {
                $panel_name = 'Update Address';
            }
            ?>
            <div class="container">
                <div class="row">
                    <div class="col-md-12" style="padding:0">
                        <div class="article" >
                            <div class="panel-heading">
                                <h3 class="panel-title"> <?php echo"welcome  " . $ename . ", " . $user . " - - " . $panel_name; ?></h3>
                            </div>

                            <?php
                            $defaulter_bar_array = ['landing.php', 'about_us.php', 'activites.php', 'commette.php'];
                            if (!in_array(basename($_SERVER['PHP_SELF']), $defaulter_bar_array)) {

                                if (!empty($default_msg)) {
                                    ?>
                                    <div class="alert alert-danger">

                                        <?php
                                        foreach ($default_msg as $default_msg) {
                                            ?>
                                            <span><?php echo $default_msg; ?></span>
                                            <br>
                                            <?php
                                        }
                                        ?>

                                    </div>
                                    <?php
                                }
                            }
                        }
                        ?>

