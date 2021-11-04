
<?php
$no_menu_array = ['index.php', 'forgot_pass.php', 'signup.php', 'landing_block.php'];
if (!in_array(basename($_SERVER['PHP_SELF']), $no_menu_array)) {
    ?>
    <br>
    <style>
        .float{
            position:fixed;
            width:60px;
            height:60px;
            bottom:40px;
            right:40px;
            background-color:#008000;
            color:#FFF;
            border-radius:15%;
            text-align:center;
            box-shadow: 2px 2px 3px #999;
            font-size: 4rem;
        }

        .my-float{
            margin-top:10px;
        }
    </style>

    <a href="landing_block.php" class="float">         
        <i class="fa fa-home my-float" aria-hidden="true"></i>
    </a>


    <?php
}
?>

<a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

<!-- JavaScript Libraries -->
<!--<script src="lib/jquery/jquery.min.js"></script>-->
<!--<script src="lib/bootstrap/js/bootstrap.min.js"></script>-->
<script src="lib/bootstrap/js/bootstrap.js" type="text/javascript"></script>

<script src="js/scripts.js" type="text/javascript"></script>

<!-- Contact Form JavaScript File -->
<script type="text/javascript" src="colorbox/jquery.colorbox-min.js"></script>
<!--<script src="js/main.js"></script>-->
</body>

</html>
