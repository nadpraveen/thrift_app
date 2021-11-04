<?php
ob_start();
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>VSPECT&CS LTD. Not Compatible</title>
        <style>
            .wrap_page{
                width: 500px;
                margin-left: auto;
                margin-right: auto;
                float: left;
            }
            .row{
                width: 100%;

            }
            .img_div{
                width: 33.3%;
                float: left;
            }
            .responsiv{
                max-width: 100%;
            }
            img{
                width: 100px;
            }
        </style>
    </head>
    <body>
        <div class="wrap_page">

            <div class="row">
                <div class="img_div">
                    <img class="responsiv" src="img/firefox.jpg" alt=""/>
                    <a href="documents/Firefox Setup 43.0.1.exe">Download</a>
                </div>
                <div class="img_div">
                    <img class="responsiv" src="img/chrome.png" alt=""/>
                    <a href="documents/69.0.3497.100_chrome_installer.exe">Download</a>
                </div>
                <a href="index.php">Back</a>
            </div>
        </div>
    </body>
</html>