<?php
ob_start();
error_reporting(E_ALL);
//if (!isset($_SESSION['suser'])) {
//    header("location:index.php");
//}
$browser_supp = 'YES';
$u_agent = $_SERVER['HTTP_USER_AGENT'];
$ub = "";
if (preg_match('/Trident/i', $u_agent) || preg_match('/MSIE/i', $u_agent)) {
    $bname = 'Internet Explorer';
    $ub = "IE";
}
$string = preg_split("/[\s,();]+/", $u_agent);
if ($string['2'] == 'MSIE') {
    $version = $string['3'];
    if ($version < 9) {
        $browser_supp = 'YES';
    } else {
        $browser_supp = 'NO';
    }
}

include 'db.php';
include 'function.php';
include 'sanitize.php';
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
            <link href="css/style.css" rel="stylesheet">
            <?php
        } else if ($ub = "IE") {
            ?>
            <link href="css/old_browser.css" rel="stylesheet">
            <link href="css/style_old.css" rel="stylesheet" type="text/css"/>
            <style>
                .hide_div{
                    display: none;
                }
            </style>
            <?php
        }
        ?>

        <!--        <link href="css/style_1.css" rel="stylesheet" type="text/css"/>-->
        <!-- Libraries CSS Files -->
        <!--<link href="lib/nivo-slider/css/nivo-slider.css" rel="stylesheet">/-->
        <!--<link href="lib/owlcarousel/owl.carousel.css" rel="stylesheet">-->
        <!--<link href="lib/owlcarousel/owl.transitions.css" rel="stylesheet">-->

        <!--<link href="lib/animate/animate.min.css" rel="stylesheet">-->
        <!--<link href="lib/venobox/venobox.css" rel="stylesheet">-->
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
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">

                                <!-- Brand -->
                                <div class="col-md-8 col-sm-8 col-xs-8 heading">
                                    <div class="low_img" style="float: left">
                                        <a class="page-scroll sticky-logo" href="index.php">
                                            <img src="img/th.png" class="img-responsive" width="75">
                                        </a>
                                    </div>
                                    <div class="low_title" style="float: right; padding-left: 20px">
                                        <span class="heading_text">Visakhapatnam Steel Plant Employee's</span>
                                        <span class="heading_text_2"><br>Co-op Thrift & Credit Society LTD.,</span>
                                        <h6><span>Regd.No B-1918, Ukkunagaram, Visakhapatnam</span></h6>
                                    </div>
                                </div>
                                <div class="col-md-3 contact">
                                    <a href="tel:0891-2573333"><span class="c_info"><i class="fa fa-phone" aria-hidden="true"></i> 0891-2573333</span></a><br>
                                    <a href="mailto:vspthriftsociety@gmail.com"><span class="c_info"><i class="fa fa-envelope-o" aria-hidden="true"></i> vspthriftsociety@gmail.com</span></a>
                                    <br>
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12" style=" padding-top: 0px;">
                        <?php include 'top_scrol.php'; ?>
                    </div>
                </div>
            </div> 

            <div id="sticker" class="header-area hide_div">
                <div class="container">

                    <div class="row">
                        <div class="col-md-12 col-sm-12">

                            <!-- Navigation -->
                            <nav class="navbar navbar-default">
                                <!-- Brand and toggle get grouped for better mobile display -->
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".bs-example-navbar-collapse-1" aria-expanded="false">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                </div>
                                <!-- Collect the nav links, forms, and other content for toggling -->
                                <div class="collapse navbar-collapse main-menu bs-example-navbar-collapse-1" id="navbar-example">
                                    <?php
                                    if (!isset($_SESSION['ofc_usr'])) {
                                        ?>

                                        <ul class="nav navbar-nav navbar-right">
                                            <li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Back to Home</a></li>
                                            
                                        </ul>
                                        <?php
                                    } else {
                                        ?>
                                        <ul class="nav navbar-nav navbar-right">
                                            <li><a href="logout.php"><i class="fa fa-home" aria-hidden="true"></i>Logout</a></li>
                                        </ul>

                                        <?php
                                    }
                                    ?>
                                </div>
                                <!-- navbar-collapse -->
                            </nav>
                            <!-- END: Navigation -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- header-area end -->
        </header>

        <br>
        <br>
        <br>
        <!-- header end -->
