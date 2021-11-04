<?php

ob_start();
session_start();

include 'header.php';
?>
<style>
    .icon_div{
        /*border: 1px solid;*/
        border-radius: 5px;
        padding: 10px;
        vertical-align: middle;
    }
    /*    icon_div img{
            vertical-align: middle;
            max-width: 59px;
        }*/
    .helper {
        display: inline-block;
        height: 100%;
        vertical-align: middle;
    }
    .menu_title{       
        font-weight: bold;
        color: green;
        /*padding: 5px;*/
        font-size: 12px;
    }
    .title_div {
        text-align: center;
        word-wrap: break-word;
    }
    .menu_wrap{
        width: 33%;
        float: left;
        padding: 15px;
    }
    
    .icon{
        width: 59px;
        margin-left: auto;
        margin-right: auto;
    }
</style>

<div class="container">

    <div class="row">
        <div class="menu_wrap">
            <a href="landing.php">
                <div class="icon_div">
                    <span class="helper"></span>
                    <img src="web_icons/about_society.png" class="img-center img-responsive icon">
                    <div class="title_div text-wrap">
                        <span class="menu_title">About Us</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="menu_wrap">
            <a href="admin.php">
                <div class="icon_div">
                    <span class="helper"></span>
                    <img src="web_icons/profile.png" class="img-center img-responsive icon">
                    <div class="title_div text-wrap">
                        <span class="menu_title">Profile</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="menu_wrap">
            <a href="loan_block.php">
                <div class="icon_div">
                    <span class="helper"></span>
                    <img src="web_icons/loans.jpg" class="img-center img-responsive icon">
                    <div class="title_div text-wrap">
                        <span class="menu_title">Loans</span>
                    </div>            
                </div>
            </a>  
        </div>
    </div>

    <div class="row">
        <div class="menu_wrap">
            <a href="dep_block.php">
                <div class="icon_div">
                    <span class="helper"></span>
                    <img src="web_icons/deposits.jpg" class="img-center img-responsive icon">
                    <div class="title_div text-wrap">
                        <span class="menu_title">Deposits</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="menu_wrap">
            <a href="miscellaneous.php">
                <div class="icon_div">
                    <span class="helper"></span>
                    <img src="web_icons/emi_calc.png" class="img-center img-responsive icon">
                    <div class="title_div text-wrap">
                        <span class="menu_title">Miscellaneous</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="menu_wrap">
            <a href="reports.php">
                <div class="icon_div">
                    <span class="helper"></span>
                    <img src="web_icons/report.jpg" class=" img-center img-responsive icon">
                    <div class="title_div text-wrap">
                        <span class="menu_title">Reports</span>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="menu_wrap">
            <a href="feedback.php">
                <div class="icon_div">
                    <span class="helper"></span>
                    <img src="web_icons/feedback.jpg" class=" img-center img-responsive icon">
                    <div class="title_div text-wrap">
                        <span class="menu_title">Feedback</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="menu_wrap">
            <a href="update_pass.php">
                <div class="icon_div">
                    <span class="helper"></span>
                    <img src="web_icons/update_password.png" class=" img-center img-responsive icon">
                    <div class="title_div text-wrap">
                        <span class="menu_title">Change Password</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="menu_wrap">
            <a href="logout.php">
                <div class="icon_div">
                    <span class="helper"></span>
                    <img src="web_icons/logout.png" class="img-center img-responsive icon">
                    <div class="title_div text-wrap">
                        <span class="menu_title">Logout</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
<?php

include 'footer.php';
?>