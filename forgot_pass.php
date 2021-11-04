<!DOCTYPE html>
<?php
ob_start();
session_start();
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
include 'function.php';
include 'db.php';
include 'Hash.php';
include 'cookie.php';

if (isset($_POST['btn_signup'])) {
    $emp_no = $_POST['emp_no'];
    $otp = $_POST['otp'];
    $password = trim($_POST['pasword']);
    $re_password = trim($_POST['re_password']);
    $date_today = date('Y-m-d h:i:s');

    $fetch_otp_data = new Database;
    $fetch_otp_data->query("select * from otp_tbl where EMP_NO = $emp_no");
    $otp_data = $fetch_otp_data->resultset();
    foreach ($otp_data as $otp_data) {
        $otp_db = $otp_data['OTP'];
    }

    if ($otp == $otp_db) {
        if ($password === $re_password) {
            $password_to_store = Hash::make($password);
            $auth_code = Hash::unique();
            //$password_to_store = $password;
            $register_user = new Database;
            $register_user->prepare("update pass_master set `pswd` = :pswd, `auth_code` = :auth_code where EMP_NO = :emp_no");
            $register_user->bind(':emp_no', $emp_no);
            $register_user->bind(':pswd', $password_to_store);
            $register_user->bind(':auth_code', $auth_code);
            $register_user->execute();
            $_SESSION['pssword_update_success'] = true;
            header("location:index.php");
            exit();
        } else {
            ?>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="alert alert-danger">
                    Both Passwords should be matched
                </div>
            </div>
            <?php
        }
    } else {
        ?>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="alert alert-danger">
                Invalid OTP Please try again.
            </div>
        </div>
        <?php
    }
}
?>
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
        <!-- Bootstrap CSS File -->
        <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Responsive Stylesheet File -->
        <link href="css/responsive.css" rel="stylesheet">
        <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <style>
            .show_div{
                display: none;
            }
            .img-center{
                margin-left: auto;
                margin-right: auto;
            }
        </style>

        <link rel="stylesheet" type="text/css" href="css/folio-gallery.css" />
        <link rel="stylesheet" type="text/css" href="colorbox/colorbox.css" />

        <!-- Main Stylesheet File -->

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

            function isNumber(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
                return true;
            }
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
        <div class="container" style=" margin-top: 10%">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="login_logo">
                        <a href="index.php">
                            <img src="img/th.png" class="img-responsive img-center" width="75">
                        </a>
                    </div>
                </div>
                <br>
                <br>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="low_title" style="padding-left: 20px">
                        <h5 class="heading_text" style="text-align: center">
                            VSP Employee's Co-op Thrift & Credit Society LTD
                        </h5>
                        <h6 style="text-align: center"><span>Regd.No B-1918, Ukkunagaram, Visakhapatnam</span></h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <form action="" method="post" autocomplete="off">
                        <div class="form-group">
                            <label>Emp No</label>
                            <input class="form-control login_input" type="number" name="id" placeholder="Emp No" required maxlength="6" onkeypress="return isNumber(event)" 
                                   inputmode="numeric" pattern="[0-9]*" 
                                   value="<?php echo isset($_POST['id']) ? $_POST['id'] : '' ?>"
                                   <?php echo isset($_POST['id']) ? 'readonly' : '' ?>/>  
                        </div>
                        <?php
                        if (!isset($_POST['id'])) {
                            ?>
                            <div class="form-group">
                                <input type="submit" class="form-control btn-success" name="btn_fetch_data" value="NEXT" >
                            </div>
                            <?php
                        }
                        ?>

                    </form>
                </div>

                <?php
                if (isset($_POST['btn_fetch_data'])) {
                    $emp_no = $_POST['id'];
                    $check_user_reg_status = new Database;
                    $check_user_reg_status->query("select * from pass_master where EMP_NO = " . $emp_no);
                    $user_reg_count = $check_user_reg_status->count();
                    if ($user_reg_count > 0) {
                        $otp = randStrGen();
                        $get_otp_count = new Database;
                        $get_otp_count->query("select * from otp_tbl where EMP_NO = " . $emp_no);
                        $otp_count = $get_otp_count->count();
                        if ($otp_count == 0) {
                            $store_otp = new Database;
                            $store_otp->prepare("insert into otp_tbl (`EMP_NO`, `OTP`) values('$emp_no', '$otp')");
                            $store_otp->execute();
                        } else {
                            $store_otp = new Database;
                            $store_otp->prepare("update otp_tbl set `OTP` = '$otp' where EMP_NO = $emp_no");
                            $store_otp->execute();
                        }
                        //$message = "Dear Member, OTP for Reset of your Password is ##var## - Thrift Society";
                        $message = "Dear Member, OTP for Reset of your Password is " . $otp . " - Thrift Society";
                        $get_emp_data = new Database;
                        $get_emp_data->query("select * from th_member_master where EMP_NO = " . $emp_no);
                        $data_count = $get_emp_data->count();
                        if ($data_count > 0) {
                            $emp_data = $get_emp_data->resultset();
                            foreach ($emp_data as $emp_data) {
                                $phone = trim($emp_data['PH_NO_R']);
                                if (strlen($phone) == 10) {
                                    //echo $url = "http://login.smsindiahub.in/api/mt/SendSMS?user=vspthriftsociety&password=Thrift@1918&senderid=THRIFT&channel=trans&DCS=0&flashsms=0&number=$phone&text=$message&route=5&PEId=1001109379533529747";
                                    sms($message, $phone);
                                    $phone_to_show = 'xxxxxx' . substr($phone, 6);
                                    ?>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <form action="" method="post" autocomplete="off">
                                            <div class="form-group">                                            
                                                <input type="hidden" value="<?php echo $emp_no ?>" name="emp_no" />  
                                            </div>
                                            <div class="form-group">
                                                <label>Phone <small>(OTP Will be sent to this Mobile Number)</small></label>
                                                <input class="form-control login_input" value="<?php echo $phone_to_show ?>" readonly="" />  
                                            </div>
                                            <div class="form-group">
                                                <label>OTP</label>
                                                <input class="form-control login_input" type="number" name="otp" placeholder="OTP" inputmode="numeric" pattern="[0-9]*" />  
                                            </div>
                                            <div class="form-group">
                                                <a href="forgot_pass.php" class="btn btn-warning">Click hear to resent OTP</a>
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input class="form-control login_input" type="password" name="pasword" placeholder="Password" required />  
                                            </div>
                                            <div class="form-group">
                                                <label>Re Enter Password</label>
                                                <input class="form-control login_input" type="password" name="re_password" placeholder="Re Enter Password" required="" />  
                                            </div>
                                            <div class="form-group">
                                                <input type="submit" class="form-control btn-success" name="btn_signup" value="Continu to login" >
                                            </div>
                                        </form>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="alert alert-danger">
                                            Your Mobile Number is not Registered With Society. Please contact Thrift Society office.
                                            <a href="index.php" class="btn btn-success"><i class="fa fa-home" aria-hidden="true"></i>Home</a>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        } else {
                            ?>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="alert alert-danger">
                                    Please enter a valid Employee Number to proceed.
                                    <a href="index.php" class="btn btn-success"><i class="fa fa-home" aria-hidden="true"></i>Home</a>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="alert alert-danger">
                                Please enter a valid Employee Number to proceed. OR you may not be registered please register to continue.
                            </div>
                            <a href="index.php" class="btn btn-success"><i class="fa fa-home" aria-hidden="true"></i>Home</a>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
        <?php
        include 'footer.php';
        ?>