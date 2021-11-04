<?php

ob_start();
session_start();

include 'header.php';
?>
<style>
    .icon_div{
        border: 1px solid;
        border-radius: 5px;
        padding: 10px;
        vertical-align: middle;
    }
    .helper {
        display: inline-block;
        height: 100%;
        vertical-align: middle;
    }
    img{
        vertical-align: middle;
    }
    .menu_title{       
        font-weight: bold;
        color: green;
        padding: 5px;
    }
    .title_div{
        text-align: center;
    }
    .loan-nav{
        font-size: large;
        display: block;
        background-color: #bcdfea;
        color: black;
        font-weight: bold;
        /* margin-bottom: 5%; */
        margin-top: 5%;
        padding: 5px 5px 5px 25px;
        border-bottom: 1px solid;
    }
</style>

<div class="container-fluid">

    <a href="lloan.php">
        <div class="col-md-12 col-xs-12 col-sm-12 loan-nav">
            Long Term Loan
        </div>
    </a>

    <a href="slone.php">
        <div class="col-md-12 col-xs-12 col-sm-12 loan-nav">
            Medium Term Loan
        </div>
    </a>

    <a href="sur_data.php">
        <div class="col-md-12 col-xs-12 col-sm-12 loan-nav">
            Surety Details
        </div>
    </a>

    <!--    <div class="row">
            <div class="col-xs-4 icon_div">
                <span class="helper"></span>
                <img src="web_icons/about_society.png" class="img-center img-responsive">
                <div class="title_div">
                    <span class="menu_title">About Us</span>
                </div>
            </div>
            <div class="col-xs-4 icon_div">
                <span class="helper"></span>
                <img src="web_icons/profile.png" class="img-center img-responsive">
                <div class="title_div">
                    <span class="menu_title">Profile</span>
                </div>
            </div>
            <div class="col-xs-4 icon_div">
                <span class="helper"></span>
                <img src="web_icons/loans.jpg" class="img-center img-responsive">
                <div class="title_div">
                    <span class="menu_title">Loans</span>
                </div>            
            </div>
        </div>-->
</div>
<?php

include 'footer.php';
?>