<?php
ob_start();
session_start();
if (!isset($_SESSION['suser'])) {
    header("location:logout.php");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'assets/includes/db.php';
include 'assets/includes/function.php';

$emp = $_SESSION['suser'];
$chk_responce = new Database;
$chk_responce->query("select * from tbl_resp where emp_no = " . $emp);
$resp_count = $chk_responce->count();
if ($resp_count > 0) {
    $responce = TRUE;
} else {
    $responce = FALSE;
}

$chk_suggestion = new Database;
$chk_suggestion->query("select * from tbl_suggestions where emp_no = " . $emp);
$sugg_count = $chk_suggestion->count();
if ($sugg_count > 0) {
    $suggestion = TRUE;
} else {
    $suggestion = FALSE;
}

$token = md5(uniqid(rand(), TRUE));
$_SESSION['token'] = $token;
$_SESSION['token_time'] = time();
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>VPS EMPLOYEES CO OP THRIFT AND CREDIT SOCIETY</title>

        <!-- Bootstrap -->
        <link href="assets/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
    <body>

        <div class="container">
            <div class="row">
                <!-- Brand -->
                <div class="col-xs-12 banner">
                    <div class="row">
                        <div class="col-xs-4">
                            <a class="page-scroll sticky-logo" href="index.php">
                                <img src="assets/img/th.png" class="img-responsive img-center" width="50">
                            </a>
                        </div>
                        <div class="col-xs-8 title-div" style="padding-left: 0;">
                            <span class="heading_text">VSP Employee's Co-op Thrift & Credit Society LTD.,</span><br>
                            <span class="tagline-text">Regd.No B-1918, Ukkunagaram, Visakhapatnam</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <?php
                    if ($responce == TRUE) {
                        ?>

                        <?php
                    }
                    ?>

                </div>
            </div>

            <div class="row" style="margin-top: 25px;">
                <div class="col-xs-12">
                    <!--                      <object width="900" height="900" data="assets/documents/meeting_book.pdf"></object> 
                                         <embed src="assets/documents/meeting_book.pdf" width="900" height="900"> -->
                    <!--<iframe class="iframe" src="assets/documents/55 AGM UP DATE.pdf"></iframe>-->                    

                    <div class="img-container">
                        <img src="assets/documents/55 AGM UP DATE_pages-to-jpg-0001.jpg" class="img-responsive" alt="55 AGM"/>
                        <hr>
                        <img src="assets/documents/55 AGM UP DATE_pages-to-jpg-0002.jpg" class="img-responsive" alt="55 AGM"/>
                        <hr>
                        <img src="assets/documents/55 AGM UP DATE_pages-to-jpg-0003.jpg" class="img-responsive" alt="55 AGM"/>
                        <hr>
                        <img src="assets/documents/55 AGM UP DATE_pages-to-jpg-0004.jpg" class="img-responsive" alt="55 AGM"/>
                        <hr>
                        <img src="assets/documents/55 AGM UP DATE_pages-to-jpg-0005.jpg" class="img-responsive" alt="55 AGM"/>
                        <hr>
                        <img src="assets/documents/55 AGM UP DATE_pages-to-jpg-0006.jpg" class="img-responsive" alt="55 AGM"/>
                        <hr>
                        <img src="assets/documents/55 AGM UP DATE_pages-to-jpg-0007.jpg" class="img-responsive" alt="55 AGM"/>
                        <hr>
                        <img src="assets/documents/55 AGM UP DATE_pages-to-jpg-0008.jpg" class="img-responsive" alt="55 AGM"/>
                        <hr>
                        <img src="assets/documents/55 AGM UP DATE_pages-to-jpg-0009.jpg" class="img-responsive" alt="55 AGM"/>
                        <hr>
                        <img src="assets/documents/55 AGM UP DATE_pages-to-jpg-0010.jpg" class="img-responsive" alt="55 AGM"/>
                        <hr>
                        <img src="assets/documents/55 AGM UP DATE_pages-to-jpg-0011.jpg" class="img-responsive" alt="55 AGM"/>
                        <hr>
                        <img src="assets/documents/55 AGM UP DATE_pages-to-jpg-0012.jpg" class="img-responsive" alt="55 AGM"/>
                        <hr>
                        <img src="assets/documents/55 AGM UP DATE_pages-to-jpg-0013.jpg" class="img-responsive" alt="55 AGM"/>
                        <hr>
                        <img src="assets/documents/55 AGM UP DATE_pages-to-jpg-0014.jpg" class="img-responsive" alt="55 AGM"/>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row" id="btn-dive">
                <div class="col-xs-12">
                    <?php
                    if ($responce == TRUE) {
                        ?>
                        <div class="alert alert-danger">
                            <h5 class="h5"> You have already given the response 
                                <a class="btn btn-danger" href="../landing_block.php">
                                    Exit
                                </a>
                            </h5>
                        </div>

                        <?php
                    } else {
                        ?>
<!--                        <div class="form-group">
                            <a class="btn btn-success form-control" id="btnAgree" 
                               href="resp_rec.php?resp=agree">Agreed All Agenda Items</a> 
                        </div> -->
                        <!--                        <div class="form-group">
                                                    <a class="btn btn-danger form-control" id="btnDisAgree" onclick="giveReason();">Disagreed (Give your Reasons)</a> 
                                                </div>-->
                        <?php
                    }
                    ?>
                    <?php
                    if ($suggestion == TRUE) {
                        ?>
                        <div class="alert alert-danger">
                            <h5 class="h5"> You have already given the Suggestion </h5>
                        </div>
                        <?php
                    } else {
                        ?>
<!--                        <div class="form-group">
                            <a class="btn btn-primary form-control" id="btnSuggestion" onclick="giveSuggestion();">Suggestions / Feedback</a> 
                        </div>                         -->
                        <?php
                    }
                    ?>
                    <div class="form-group">
                        <a class="btn btn-warning form-control" href="assets/documents/55 AGM UP DATE.pdf" >Dowland as PDF</a> 
                    </div>   
                </div>
            </div>
            <hr>
            <div class = "row" id = "reason-div">
                <div class = "col-xs-12">
                    <form method = "post" action = "resp_rec.php?resp=dis_agree&mobile=<?php echo $mobile ?>&key=<?php echo $key ?>"">
                        <div class = "form-group">
                            <textarea class = "form-control" name = "reasontxt" id = "reasontxt" placeholder = "Give your reasons for Disagree Here" required></textarea>
                        </div>
                        <div class = "form-group">
                            <input type = "submit" name = "reasonbtn" class = "btn btn-primary" value = "Submit">
                        </div>
                    </form>
                </div>
            </div>

            <div class = "row" id = "suggestion-div">
                <div class = "col-xs-12">
                    <form method = "post" action = "resp_rec.php?resp=suggestion">
                        <input type="hidden" name="token" value="<?php echo $token; ?>" />
                        <div class = "form-group">
                            <textarea class = "form-control" name = "suggestiontxt" id = "reasontxt" placeholder = "Give your Suggestion / Feedback Here" required></textarea>
                        </div>
                        <div class = "form-group">
                            <input type = "submit" name = "suggesionbtn" class = "btn btn-primary" value = "Submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="assets/bootstrap/js/bootstrap.js" type="text/javascript"></script>
        <script src="assets/scripts/scripts.js" type="text/javascript"></script>
    </body>
</html>