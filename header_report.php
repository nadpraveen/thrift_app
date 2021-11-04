<?php
ob_start();
session_start();
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

        <!-- Bootstrap CSS File -->
        <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Responsive Stylesheet File -->
        <link href="css/responsive.css" rel="stylesheet">
        <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="css/folio-gallery.css" />
        <link rel="stylesheet" type="text/css" href="colorbox/colorbox.css" />

        <!-- Main Stylesheet File -->
        <link href="css/style.css" rel="stylesheet">

        <script src="js/jquery-3.3.1.min.js" type="text/javascript"></script>

        <!--<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>-->
        <script src="js/jquery.cycle.all.js" type="text/javascript"></script>
        <script src="js/scripts.js" type="text/javascript"></script>
        
                <style>
            @media print{
                #click{
                    display: none;
                }
            }
            body{
                font-size: x-small;
                padding: 15px;
            }
            h6{
                margin-bottom: 0px;
            }
        </style>
    </head>

    <body>
        

