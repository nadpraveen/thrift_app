<!DOCTYPE html>
<?php
ob_start();
session_start();

include 'function.php';
include 'db.php';
include 'Hash.php';
include 'cookie.php';
create_image();

if (cookie::exists('hash')) {
    $hash = cookie::get('hash');
    $get_sessio_user_id = new Database;
    $get_sessio_user_id->query("select * from user_session where hash = '$hash'");
    $session_user_id_count = $get_sessio_user_id->count();
    $session_user_id = $get_sessio_user_id->resultset();
    foreach ($session_user_id as $sid) {
        $user_id = $sid['emp_no'];
    }
    if ($session_user_id_count > 0) {
        cookie::put('hash', $hash, 950400);
        if (substr($user_id, 0, 1) == 1) {
            $_SESSION['suser'] = $user_id;
            header("location:landing_block.php");
        } else if (substr($user_id, 0, 1) == 3) {
            $_SESSION['id'] = $user_id;
            header("location:admin_panel.php");
        }
    } else {
        $delete_hash = new Database;
        $delete_hash->query("delete from user_session where hash = '$hash'");
        session_destroy();
        cookie::delete('hash');
        header("location:index.php");
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
        
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>

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
            <?php
            if (isset($_SESSION['reg_success'])) {
                ?>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="alert alert-success alert-dismissable">
                        You are Successfully Registered. Please login to continue.
                    </div>
                </div>
                <?php
                unset($_SESSION['reg_success']);
            }
            if (isset($_GET['msg'])) {
                if ($_GET['msg'] == 'invalid_captch') {
                    ?>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="alert alert-danger alert-dismissable">
                            Captcha is invalid. Please try again
                        </div>
                    </div>
                    <?php
                }
            }
            ?>

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
                    <form action="login.php" method="post" autocomplete="off">
                        <div class="form-group">
                            <label>Emp No</label>
                            <input class="form-control login_input" type="number" name="id" placeholder="Emp No" required maxlength="6" onkeypress="return isNumber(event)" 
                                   inputmode="numeric" pattern="[0-9]*" />  
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control login_input" placeholder="Password" required  />
                        </div>
                        <div class="form-group">
                            <!--<div class="g-recaptcha" data-sitekey="6LceTSUcAAAAAKgvDGCB2CLANOrO6O08wc-D_Jbw"></div>-->
                            <?php
                            display();
                            ?>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="form-control btn-success" name="btnSubmit" value="Login" >
                        </div>
                    </form>

                    <a  href="signup.php" class="btn btn-primary form-control">
                        <span> Sign Up (1st Time User Registration)</span>
                    </a>

                    <br>
                    <br>
                    <a  href="forgot_pass.php" class="btn btn-info form-control">
                        <span  style="color: red;"> Forgot Password</span>
                    </a>
                </div> 
            </div>
        </div>
        <?php
        include 'footer.php';
        ?>