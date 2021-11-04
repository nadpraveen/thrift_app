<?php
ob_start();
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION['id'])) {
    header("location:index.php");
}
require 'db.php';
require 'function.php';
include 'Hash.php';
include 'cookie.php';


if (isset($_POST['add_circuler'])) {
    $description = $_POST['cir_desc'];
    $name = $_FILES["circuler"]["name"];
    $type = $_FILES["circuler"]['type'];
    $size = $_FILES["circuler"]['size'];
    $tempname = $_FILES["circuler"]['tmp_name'];
    $error = $_FILES["circuler"]['error'];
    move_uploaded_file($tempname, "circulers/" . $name);
    $path = 'circulers/' . $name;
    $insert_circuler = new Database;
    $insert_circuler->query("insert into circulers (`description`, `link`,`date`) values('$description', '$path', now())");
    header("location:admin_panel.php?menu=circulers");
}

if (isset($_POST['add_scrol'])) {
    $description = $_POST['scrole_desc'];
    if (isset($_FILES['scrole'])) {
        $name = $_FILES["scrole"]["name"];
        $type = $_FILES["scrole"]['type'];
        $size = $_FILES["scrole"]['size'];
        $tempname = $_FILES["scrole"]['tmp_name'];
        $error = $_FILES["scrole"]['error'];
        move_uploaded_file($tempname, "scroles/" . $name);
        if ($name != '') {
            $path = 'scroles/' . $name;
        } else {
            $path = '';
        }
    }
    $insert_circuler = new Database;
    $insert_circuler->query("insert into scrole (`description`, `link`,`date`) values('$description', '$path', now())");
    //header("location:admin_panel.php?menu=scrole");
}

if (isset($_POST['add_appl'])) {
    $description = $_POST['appl_desc'];
    $name = $_FILES["application"]["name"];
    $type = $_FILES["application"]['type'];
    $size = $_FILES["application"]['size'];
    $tempname = $_FILES["application"]['tmp_name'];
    $error = $_FILES["application"]['error'];
    move_uploaded_file($tempname, "applications/" . $name);
    $path = 'applications/' . $name;
    $insert_circuler = new Database;
    $insert_circuler->query("insert into application (`description`, `link`,`date`) values('$description', '$path', now())");
    header("location:admin_panel.php?menu=upload_application");
}

if (isset($_POST['btn_address'])) {
    $emp_no = $_POST['emp_no'];
    header("location:admin_panel.php?menu=view_address&emp_no =" . $emp_no);
}

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'del_admin') {
        $del_admin = new Database;
        $del_admin->query("delete from admin_login where id = " . $_GET['id']);
        header("location:admin_panel.php?menu=admin");
    }
}
?>

<!doctype html>
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

        <!-- Bootstrap CSS File -->
        <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/style_1.css" rel="stylesheet" type="text/css"/>
        <!-- Libraries CSS Files -->
        <link href="lib/nivo-slider/css/nivo-slider.css" rel="stylesheet">
        <link href="lib/owlcarousel/owl.carousel.css" rel="stylesheet">
        <link href="lib/owlcarousel/owl.transitions.css" rel="stylesheet">
        <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="lib/animate/animate.min.css" rel="stylesheet">
        <link href="lib/venobox/venobox.css" rel="stylesheet">

        <!-- Nivo Slider Theme -->
        <link href="css/nivo-slider-theme.css" rel="stylesheet">

        <!-- Main Stylesheet File -->
        <link href="css/style.css" rel="stylesheet">

        <!-- Responsive Stylesheet File -->
        <link href="css/responsive.css" rel="stylesheet">
        <style>
            .side_menu{
                display: block;
                padding: 5px;
                background-color: #e2e2e2;
                margin: 2px;
            }
            .side_menu:hover{
                background-color: gray;
                color: black;
                font-weight: bold;
            }
        </style>
    </head>

    <body data-spy="scroll" data-target="#navbar-example">

        <header>
            <!-- header-area start -->
            <div id="sticker" class="header-area">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12" style="padding:0">

                            <!-- Navigation -->
                            <nav class="navbar navbar-default">
                                <!-- Brand and toggle get grouped for better mobile display -->
                                <div class="navbar-header">  
                                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                    <!-- Brand -->
                                    <a class="navbar-brand page-scroll sticky-logo" href="admin_panel.php">
                                        <h1><span>Admin</span>Panel.</h1>
                                        <!-- Uncomment below if you prefer to use an image logo -->
                                        <!-- <img src="img/logo.png" alt="" title=""> -->
                                    </a>
                                </div>
                                <!-- Collect the nav links, forms, and other content for toggling -->
                                <div class="collapse navbar-collapse navbar-inverse" id="bs-example-navbar-collapse-1">
                                    <ul class="nav navbar-nav">
                                        <li><a href="admin_panel.php?menu=circulers">Circulars</a></li>
                                        <li><a href="admin_panel.php?menu=scrole">Scroll</a></li>
                                        <!--                                        <li><a href="admin_panel.php?menu=rec_table">Download Recovery Rates Changes</a></li>-->
                                        <!--                                        <li><a href="admin_panel.php?menu=user_reg">Web Services Approved / Rejected </a></li>-->
                                        <li><a href="admin_panel.php?menu=reset_pass">Reset Password </a></li>
                                        <li><a href="admin_panel.php?menu=feed_back">Feed backs </a></li>
                                        <!--                                        <li><a href="admin_panel.php?menu=upload_application">Upload Applications</a></li>-->
                                        <li><a href="admin_panel.php?menu=view_address">View Address & phone</a></li>
                                        <!--<li><a href="admin_panel.php?menu=reports">Reports/ Prints</a></li>-->
                                        <!--                                        <li><a href="admin_panel.php?menu=iom">Missing IOM</a></li>-->
                                        <li><a href="admin_panel.php?menu=admin">User ID Maintenance </a></li>
                                        <!--                                        <li><a href="admin_panel.php?menu=ledg_trans">Ledger Trans Data Genarator</a></li>-->
                                        <li><a href="admin_panel.php?menu=queries">Queries</a></li>
                                        <li><a href="logout.php">Logout </a></li>

                                    </ul>
                                </div><!-- /.navbar-collapse -->
                            </nav>
                            <!-- END: Navigation -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- header-area end -->
        </header>
        <div class="container-fluid">
            <div class="row" style=" margin-top: 80px;">
                <div class="col-md-9">
                    <?php
                    if (isset($_GET['result'])) {
                        if ($_GET['result'] == 'success') {
                            ?>
                            <div class=" alert alert-info">
                                record deleted Successfully
                            </div>
                            <?php
                        } elseif ($_GET['result'] == 'faild') {
                            ?>
                            <div class=" alert alert-danger">
                                Failed to delete record
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <?php
                    if (!isset($_GET['menu'])) {
                        ?>
                        <div class=" alert alert-info">
                            Please Select A Menu to Start
                        </div>
                        <?php
                    } elseif ($_GET['menu'] == 'circulers') {
                        ?>
                        <h5>Add Circular</h5>
                        <?php
                        $get_circulers_list = new Database;
                        $get_circulers_list->query("select * from circulers order by date DESC");
                        $circuler_count = $get_circulers_list->count();
                        if ($circuler_count == 0) {
                            ?>
                            <div class=" alert alert-info">
                                No Circulars Yet
                            </div>
                            <?php
                        } else {
                            ?>
                            <table class="table">
                                <tr>
                                    <th>Description</th>
                                    <th>Link</th>
                                    <th>Action</th>
                                </tr>
                                <?php
                                $circulers = $get_circulers_list->resultset();
                                foreach ($circulers as $circuler) {
                                    ?>
                                    <tr>
                                        <td><?php echo $circuler['description'] ?></td>
                                        <td><a href="<?php echo $circuler['link'] ?>" target="_blank">View</a></td>
                                        <td><a href="del_cir.php?id=<?php echo $circuler['id'] ?>">Delete</a></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                            <?php
                        }
                        ?>
                        <div class="row">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#cir_modal">Add Circular</button>

                            <!-- Modal -->
                            <div class="modal fade" id="cir_modal" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Add Circular</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form action='' method='post' enctype='multipart/form-data'>
                                                <div class="form-group">
                                                    <textarea name="cir_desc" rows="3" class="form-control"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <input type='file' name='circuler' class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <input type='submit' name='add_circuler' value='Add' class="form-control">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php
                    } elseif ($_GET['menu'] == 'scrole') {
                        ?>
                        <h5>Add Scrolling Text</h5>
                        <?php
                        $get_scrol_list = new Database;
                        $get_scrol_list->query("select * from scrole order by date DESC");
                        $scrol_count = $get_scrol_list->count();
                        if ($scrol_count == 0) {
                            ?>
                            <div class=" alert alert-info">
                                No Scrolling Text  Yet
                            </div>
                            <?php
                        } else {
                            ?>
                            <table class="table">
                                <tr>
                                    <th>Description</th>
                                    <th colspan="2">Action</th>
                                </tr>
                                <?php
                                $scroles = $get_scrol_list->resultset();
                                foreach ($scroles as $scroles) {
                                    ?>
                                    <tr>

                                        <td><a href="<?php echo $scroles['link'] ?>" target="_blank"><?php echo $scroles['description'] ?></a></td>
                                        <td><a href="del_scrol.php?id=<?php echo $scroles['id'] ?>">Delete</a></td>
                                        <td><a href="edit_scrol.php?id=<?php echo $scroles['id'] ?>">Edit</a></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                            <?php
                        }
                        ?>
                        <div class="row">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#scrole_modal">Add Scroll  Text</button>

                            <!-- Modal -->
                            <div class="modal fade" id="scrole_modal" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Add Scrole</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form action='' method='post' enctype='multipart/form-data'>
                                                <div class="form-group">
                                                    <textarea name="scrole_desc" rows="3" class="form-control"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <input type='file' name='scrole' class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <input type='submit' name='add_scrol' value='Add' class="form-control">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php
                    } elseif ($_GET['menu'] == 'rec_table') {
                        $get_prev_downlod_date = new Database;
                        $get_prev_downlod_date->query("SELECT MAX(status_update_date) as date FROM rec_updates limit 1");
                        $prev_download_date = $get_prev_downlod_date->resultset();
                        foreach ($prev_download_date as $download_date) {
                            ?>
                            <div class=" alert alert-info">
                                Last Download Date is <?php echo date('d-M-Y , h:i a', strtotime($download_date['date'])); ?>
                            </div>
                            <?php
                        }

                        $fetch_rec_table_qiry = "select * from rec_updates where status = 0";
                        $fetch_rec_table = new Database;
                        $fetch_rec_table->query($fetch_rec_table_qiry);
                        $rec_table_count = $fetch_rec_table->count();
                        if ($rec_table_count == 0) {
                            echo 'No Changes in Recovery Rates yet';
                        } else {
                            ?>
                            <table class=" table table-bordered">
                                <tr>
                                    <th>Emp No</th>
                                    <th>TD</th>
                                    <th>VTD</th>
                                    <th>LOAN</th>
                                    <th>ED LOAN</th>
                                </tr>

                                <?php
                                $rec_table_data = $fetch_rec_table->resultset();
                                foreach ($rec_table_data as $data) {
                                    ?>
                                    <tr>
                                        <td><?php echo $data['EMP_NO'] ?></td>
                                        <td><?php echo $data['new_td'] ?></td>
                                        <td><?php echo $data['new_vtd'] ?></td>
                                        <td><?php echo $data['new_loan'] ?></td>
                                        <td><?php echo $data['new_edl'] ?></td>
                                    </tr>

                                    <?php
                                }
                                ?>
                            </table>
                            <a class="btn btn-info" href="download_rec_table.php">Download Table</a>
                            <br>
                            <?php
                        }
                    } else if ($_GET['menu'] == 'user_reg') {
                        if (isset($_GET['msg'])) {
                            if ($_GET['msg'] == 'success') {
                                ?>
                                <div class="alert alert-success" id="accept_msg">
                                    User Accepted Successfully 
                                </div>
                                <?php
                            } else if ($_GET['msg'] == 'fail') {
                                ?>
                                <div class="alert alert-danger" id="alert_div">
                                    Incorrect data... please cheack and try again
                                </div>
                                <?php
                            }
                        }
                        $select_users_list = new Database;
                        $select_users_list->query("select * from reg_user where status = 'N'");
                        $user_count = $select_users_list->count();
                        if ($user_count > 0) {
                            ?>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Reg. No</th>
                                    <th>Emp. No</th>
                                    <th>Name</th>
                                    <th>Reg. Date</th>
                                    <th colspan="2" align="center">Action</th>
                                </tr>
                                <?php
                                $users_data = $select_users_list->resultset();
                                foreach ($users_data as $users) {
                                    ?>
                                    <tr>
                                        <td><?php echo $users['Reg_no'] ?></td>
                                        <td><?php echo $users['EMP_NO'] ?></td>
                                        <td>
                                            <?php
                                            $get_user_name = new Database;
                                            $get_user_name->query("select * from th_member_master where EMP_NO =" . $users['EMP_NO']);
                                            $name_count = $get_user_name->count();
                                            if ($user_count > 0) {
                                                $user_name = $get_user_name->resultset();
                                                foreach ($user_name as $name) {
                                                    echo $name['EMP_NAME'];
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $users['Date_of_registration'] ?></td>
                                        <td><a href="accept_user.php?emp_no=<?php echo $users['EMP_NO'] ?>&rg_no=<?php echo $users['Reg_no'] ?>"><i class="fa fa-check" aria-hidden="true"></i></a></td>
                                        <td><a href="reject_user.php?emp_no=<?php echo $users['EMP_NO'] ?>&rg_no=<?php echo $users['Reg_no'] ?>"><i class="fa fa-ban" aria-hidden="true"></i></a></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                            <?php
                        }
                    } else if ($_GET['menu'] == 'reset_pass') {

                        if (isset($_POST['btn_reset_pass'])) {
                            $user = $_POST['emp_no'];
                            $check_emp_dob = new Database;
                            $check_emp_dob_query = "select * from `th_member_master` where EMP_NO = $user";
                            $check_emp_dob->query($check_emp_dob_query);
                            $emp_dob_count = $check_emp_dob->count();
                            if ($emp_dob_count > 0) {
                                $check_user_reg_count = new Database;
                                $check_user_reg_count->query("select * from pass_master where EMP_NO = $user");
                                $user_reg_count = $check_user_reg_count->count();
                                if ($user_reg_count > 0) {
                                    $emp_dob_data = $check_emp_dob->resultset();
                                    foreach ($emp_dob_data as $emp_data) {
                                        $dob = date('dmy', strtotime($emp_data['DOB']));
                                        $pass_to_store = Hash::make($dob);
                                        $auth_code = Hash::unique();
                                        $email = $emp_data['EMAIL_ID'];
                                        $insert_pass = new Database;
                                        $insert_pass_query = "update `pass_master` set `pswd` = '$pass_to_store', auth_code = '$auth_code' where EMP_NO = '$user'";
                                        //$insert_pass_query = "INSERT INTO `pass_word` (`EMP_NO`, `pswd`) VALUES ('$user', '$dob')";
                                        $insert_pass->query($insert_pass_query);
                                        header("location:admin_panel.php?menu=reset_pass&msg=success");
                                    }
                                } else {
                                    header("location:admin_panel.php?menu=reset_pass&msg=not_reg");
                                }
                            } else {
                                header("location:admin_panel.php?menu=reset_pass&msg=not_member");
                            }
                        }


                        if (isset($_GET['msg'])) {
                            if ($_GET['msg'] == 'success') {
                                ?>
                                <div class="alert alert-success" id="accept_msg">
                                    Password Updated Successfully
                                </div>
                                <?php
                            } else if ($_GET['msg'] == 'not_reg') {
                                ?>
                                <div class="alert alert-danger" id="alert_div">
                                    User Not Registered
                                </div>
                                <?php
                            } else if ($_GET['msg'] == 'not_member') {
                                ?>
                                <div class="alert alert-danger" id="alert_div">
                                    User is not a Member
                                </div>
                                <?php
                            }
                        }
                        ?>

                        <div class="col-md-12">
                            <h5>Reset User Password</h5>
                            <form method="post" action="">
                                <div class="form-group">
                                    <label for="emp_no">Emp No</label>
                                    <input type="text" class=" form-control" name="emp_no" id="emp_no" maxlength="6">
                                </div>
                                <div class="form-group">
                                    <input type="submit" class=" form-control btn btn-info" name="btn_reset_pass" id="btn_reset_pass" value="Reset">
                                </div>
                            </form>
                        </div>
                        <?php
                    } else if ($_GET['menu'] == 'feed_back') {
                        ?>
                        <?php
                        if (isset($_GET['sent'])) {
                            ?>
                            <div class="col-md-12">
                                <?php
                                if ($_GET['sent'] == 'success') {
                                    ?>
                                    <div class="alert alert-success">
                                        Reply has been sent Successfully
                                    </div>
                                    <?php
                                } else if ($_GET['sent'] == 'fail') {
                                    ?>
                                    <div class="alert alert-danger">
                                        Sorry! unable to send email.
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                        <div class = "col-md-12">
                            <h5>User Feedbacks</h5>
                            <?php
                            $fetch_feed_back_query = "select * from feed_back where read_status = 'N'";
                            $fetch_feed_back = new Database;
                            $fetch_feed_back->query($fetch_feed_back_query);
                            $feed_back_count = $fetch_feed_back->count();
                            if ($feed_back_count == 0) {
                                ?>
                                <div class=" alert alert-info">
                                    No Feedbacks
                                </div>
                                <?php
                            } else {
                                ?>
                                <table class=" table">
                                    <tr>
                                        <th>ID</th>
                                        <th>EMP NO</th>
                                        <th>MESSAGE</th>
                                        <th colspan="2">ACTION</th>
                                    </tr>
                                    <?php
                                    $feed_backs = $fetch_feed_back->resultset();
                                    foreach ($feed_backs as $feed_back) {
                                        $msg_legth = strlen($feed_back['message']);
                                        if ($msg_legth <= 100) {
                                            $msg = $feed_back['message'];
                                        } else {
                                            $msg = substr($feed_back['message'], 0, 100) . '.....';
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo $feed_back['id'] ?></td>
                                            <td><?php echo $feed_back['emp_no'] ?></td>
                                            <td><?php echo $msg ?></td>

                                            <td>
                                                <a type="button" data-toggle="modal" data-target="#message_modal_<?php echo $feed_back['id'] ?>">
                                                    Reply
                                                </a>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="message_modal_<?php echo $feed_back['id'] ?>" role="dialog">
                                            <div class="modal-dialog">

                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Print Message</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12">

                                                                <div class="col-md-6">
                                                                    Message ID : <?php echo $feed_back['id'] ?>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    Employee ID : <?php echo $feed_back['emp_no'] ?>
                                                                </div>

                                                            </div>

                                                            <div class="col-md-12">
                                                                <hr>
                                                                Nature of Feed Back / Suggestion:
                                                                <br>
                                                                <br>
                                                                <?php echo $feed_back['message'] ?>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <hr>
                                                                <form method="post" action="send_feed_back_reply.php">
                                                                    <input type="hidden" name="feed_back_id" value="<?php echo $feed_back['id'] ?>">
                                                                    <input type="hidden" name="feed_back_emp_id" value="<?php echo $feed_back['emp_no'] ?>">
                                                                    <div class="form-group">
                                                                        <label for="reply">Reply</label>
                                                                        <textarea class="form-control" name="feed_back_reply" id="reply" rows="5"></textarea>
                                                                    </div>
                                                                    <div class="form-group">                                                                        
                                                                        <input type="submit" name="btn_feed_back_reply" class="form-control btn btn-info" value="Send Reply">
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>                               
                                </table>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    } elseif ($_GET['menu'] == 'upload_application') {
                        $get_applications = new Database;
                        $get_applications->query("select * from application order by date DESC");
                        $application_count = $get_applications->count();
                        if ($application_count == 0) {
                            ?>
                            <div class=" alert alert-info">
                                No Applications Yet
                            </div>
                            <?php
                        } else {
                            ?>
                            <table class="table">
                                <tr>
                                    <th>Description</th>
                                    <th>Link</th>
                                    <th>Action</th>
                                </tr>
                                <?php
                                $applications = $get_applications->resultset();
                                foreach ($applications as $application) {
                                    ?>
                                    <tr>
                                        <td><?php echo $application['description'] ?></td>
                                        <td><a href="<?php echo $application['link'] ?>" target="_blank">View</a></td>
                                        <td><a href="del_appl.php?id=<?php echo $application['id'] ?>">Delete</a></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                            <?php
                        }
                        ?>
                        <div class="row">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#appl_modal">Add Application</button>

                            <!-- Modal -->
                            <div class="modal fade" id="appl_modal" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Add Application</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form action='' method='post' enctype='multipart/form-data'>
                                                <div class="form-group">
                                                    <textarea name="appl_desc" rows="3" class="form-control"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <input type='file' name='application' class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <input type='submit' name='add_appl' value='Add' class="form-control">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php
                    } elseif ($_GET['menu'] == 'view_address') {
                        if (isset($_POST['btn_addres'])) {
                            $user = $_POST['emp_no'];
                            header("location:admin_panel.php?menu=view_address&emp=$user");
                        }
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <h5>View User Data</h5>
                                <div class="col-md-6 col-md-offset-3">
                                    <form method="post" action="">
                                        <div class="form-group">
                                            <label for="emp_no">Enter Employee Number</label>
                                            <input type="text" name="emp_no" id="emp_no" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" name="btn_addres" class="form-control btn btn-info" value="Submit">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <?php
                                if (isset($_GET['emp'])) {
                                    if ($_GET['emp'] != '') {
                                        $get_email_id = new Database;
                                        $get_email_id->prepare("select * from email_master where EMP_NO = " . $_GET['emp']);
                                        $email_id = $get_email_id->resultset();
                                        foreach ($email_id as $email_id) {
                                            if ($email_id['EMAIL_ID'] != '') {
                                                ?>
                                                Email Id : <?php echo $email_id['EMAIL_ID'] ?><br>
                                                <?php
                                            } else {
                                                echo 'No Email Found <br>';
                                            }
                                        }

                                        $get_address = new Database;
                                        $get_address->query("select * from address_data where EMP_NO = " . $_GET['emp']);

                                        $add_count = $get_address->count();
                                        if ($add_count > 0) {
                                            ?>
                                            <table class=" table table-bordered">
                                                <tr>
                                                    <th>Present Address</th>
                                                    <th>Permanent Address</th>
                                                </tr>
                                                <?php
                                                $address = $get_address->resultset();
                                                foreach ($address as $address) {
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo strtoupper($address['d_no']) ?>,<br>
                                                            <?php echo strtoupper($address['street']) ?>,<br>
                                                            <?php echo strtoupper($address['area']) ?>,<br>
                                                            <?php echo strtoupper($address['city']) ?>,<br>
                                                            <?php echo strtoupper($address['district']) ?>,<br>
                                                            <?php echo strtoupper($address['state']) ?>,<br>
                                                            <?php echo strtoupper($address['pin']) ?>
                                                        </td>
                                                        <td>
                                                            <?php echo strtoupper($address['p_d_no']) ?>,<br>
                                                            <?php echo strtoupper($address['p_street']) ?>,<br>
                                                            <?php echo strtoupper($address['p_area']) ?>,<br>
                                                            <?php echo strtoupper($address['p_city']) ?>,<br>
                                                            <?php echo strtoupper($address['p_district']) ?>,<br>
                                                            <?php echo strtoupper($address['p_state']) ?>,<br>
                                                            <?php echo strtoupper($address['p_pin']) ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </table>
                                            <?php
                                        } else {
                                            echo 'No Address Found';
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                    } elseif ($_GET['menu'] == 'reports') {
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6 col-md-offset-3">
                                    <form method="post" action="">
                                        <div class="form-group">
                                            <label for="emp_no">Enter Employee Number</label>
                                            <input type="number" name="emp_no" id="emp_no" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" name="btn_report" class="form-control btn btn-info" value="Submit">
                                        </div>
                                    </form>
                                </div>
                                <?php
                                if (isset($_POST['btn_report'])) {
                                    $emp_req = $_POST['emp_no'];
                                    $get_usr_req_data = new Database;
                                    $get_usr_req_data->prepare("select * from th_member_master where EMP_NO = $emp_req");
                                    $user_req_data = $get_usr_req_data->resultset();
                                    foreach ($user_req_data as $req_data) {
                                        ?>
                                        <div class="col-md-12">
                                            <table class=" table table-bordered">
                                                <tr>
                                                    <td><strong>Name</strong></td><td colspan="3"><?php echo $req_data['EMP_NAME'] ?></td>
                                                    <td><strong>EMP NO</strong></td><td><?php echo $req_data['EMP_NO'] ?></td>
                                                </tr>

                                                <tr>
                                                    <td><strong>GL NO</strong></td><td><?php echo $req_data['GL_NO'] ?></td>
                                                    <td><strong>DEPT</strong></td><td><?php echo $req_data['DEPT'] ?></td>
                                                    <td><strong>DESIGN</strong></td><td><?php echo $req_data['DESIG'] ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="col-md-12">
                                        <a href="state_input_user.php?emp=<?php echo $emp_req ?>" target="_blank"><button class="btn btn-primary">Ann Report</button></a>
                                    </div>
                                    <?php
                                }
                                ?>

                            </div>
                        </div>
                        <?php
                    } elseif ($_GET['menu'] == 'iom') {
                        ?>
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <tr>
                                    <th>S.no</th>
                                    <th>Emp No</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Dept</th>
                                    <th>ENQ on</th>
                                    <th>Action</th>
                                </tr>
                                <?php
                                $i = 1;
                                $get_missing_noc_list = new Database;
                                $get_missing_noc_list->query("select * from noc_doc order by searchd_on desc");
                                $noc_count = $get_missing_noc_list->count();
                                if ($noc_count > 0) {
                                    $noc_list = $get_missing_noc_list->resultset();
                                    foreach ($noc_list as $noc) {
                                        $emp_no = $noc['emp_no']
                                        ?>
                                        <tr>
                                            <td><?php echo $i++ ?></td>
                                            <td><?php echo $emp_no; ?></td>
                                            <?php
                                            $get_emp_data = new Database;
                                            $get_emp_data->query("select * from th_member_master where EMP_NO = $emp_no");
                                            $emp_data_count = $get_emp_data->count();
                                            if ($emp_data_count > 0) {
                                                $emp_data = $get_emp_data->resultset();
                                                foreach ($emp_data as $data) {
                                                    $emp_name = $data['EMP_NAME'];
                                                    $emp_desg = $data['DESIG'];
                                                    $emp_dept = $data['DEPT'];
                                                }
                                            } else {
                                                $emp_name = 'Not a Mmeber';
                                                $emp_desg = 'Not a Mmeber';
                                                $emp_dept = 'Not a Mmeber';
                                            }
                                            ?>
                                            <td><?php echo $emp_name; ?></td>
                                            <td><?php echo $emp_desg; ?></td>
                                            <td><?php echo $emp_dept; ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($noc['searchd_on'])) ?></td>
                                            <td><a href="admin_panel.php?menu=iom&action=del&id=<?php echo $noc['id'] ?>">Receveid</a></td>
                                        </tr>
                                        <?php
                                    }

                                    if (isset($_GET['action'])) {
                                        if ($_GET['action'] === 'del') {
                                            $id = $_GET['id'];
                                            $remove_missing_noc_rec = new Database;
                                            $remove_missing_noc_rec->query("delete from noc_doc where id = $id");
                                            header("location:admin_panel.php?menu=iom");
                                        }
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="6">No Missing IOM Data found</td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                        </div>
                        <?php
                    } elseif ($_GET['menu'] == 'ledg_trans') {

                        //TRANS DATA GENERATION

                        $curr_month = date('M');
                        $curr_year = date('Y');

                        if (isset($_POST['btncheck'])) {
                            //print_r($_POST);
                            $month = $_POST['month'];
                            $year = $_POST['year'];
                            //$month_formate = '20-' . $month . '-' . $year;
                            $check_excisted_data = new Database;
                            $check_excisted_data->query("select * from th_members_trans_data "
                                    . "where month(TRANS_DATE) = $month and year(TRANS_DATE) = $year");
                            $excisted_data_count = $check_excisted_data->count();
                            if ($excisted_data_count > 0) {
                                $_SESSION['run'] = TRUE;
                            } else {
                                // TD TRANS DATA
                                $insert_td_trans_data = new Database;
                                $insert_td_trans_data->prepare("insert into th_trans_temp (`TRANS_DATE`, `EMP_NO`, `TD_RCPT`) "
                                        . "SELECT TRANS_DATE, EMP_NO, AMOUNT FROM th_thrift_deposit_trans "
                                        . "where month(TRANS_DATE) = $month and year(TRANS_DATE) = $year and TYPE_OF_TRANS = 'R'");
                                //print_r($insert_td_trans_data);
                                $insert_td_trans_data->execute();

                                // TD PAYMENT
                                $get_td_payment_data = new Database;
                                $get_td_payment_data->query("select * from th_thrift_deposit_trans where month(TRANS_DATE) = $month and year(TRANS_DATE) = $year and TYPE_OF_TRANS = 'P'");
                                $td_payment_count = $get_td_payment_data->count();
                                if ($td_payment_count > 0) {
                                    $td_payment_data = $get_td_payment_data->resultset();
                                    foreach ($td_payment_data as $td_payment_data) {
                                        $td_payment_emp = $td_payment_data['EMP_NO'];
                                        $td_payment = $td_payment_data['AMOUNT'];
                                        $td_payment_date = $td_payment_data['TRANS_DATE'];
                                        //INSERT TD PAYMENT DATA
                                        $chk_rows = new Database;
                                        $chk_rows->query("select * from th_trans_temp where TRANS_DATE = '$td_payment_date' and EMP_NO = $td_payment_emp");
                                        $rows_count = $chk_rows->count();
                                        if ($rows_count > 0) {
                                            $insert_td_payment_data = new Database;
                                            $insert_td_payment_data->prepare("update th_trans_temp set TD_PYMT = $td_payment where EMP_NO = $td_payment_emp and TRANS_DATE = '$td_payment_date'");
                                            $insert_td_payment_data->execute();
                                        } else {
                                            $insert_td_payment_data = new Database;
                                            $insert_td_payment_data->prepare("insert into th_trans_temp (`TRANS_DATE`, `EMP_NO`, `TD_PYMT`) "
                                                    . "values('$td_payment_date','$td_payment_emp','$td_payment')");
                                            $insert_td_payment_data->execute();
                                        }
                                    }
                                }

                                //VTD REC DATA
                                //GET VTD REC DATA
                                $get_vtd_rec_data = new Database;
                                $get_vtd_rec_data->query("select * from th_vtd_trans where month(TRANS_DATE) = $month and year(TRANS_DATE) = $year and TYPE_OF_TRANS = 'R'");
                                $vtd_rec_data_count = $get_vtd_rec_data->count();
                                if ($vtd_rec_data_count > 0) {
                                    $vtd_rec_data = $get_vtd_rec_data->resultset();
                                    foreach ($vtd_rec_data as $vtd_rec_data) {
                                        $vtd_rec_emp = $vtd_rec_data['EMP_NO'];
                                        $vtd_rec = $vtd_rec_data['AMOUNT'];
                                        $vtd_rec_date = $vtd_rec_data['TRANS_DATE'];

                                        $chk_rows = new Database;
                                        $chk_rows->query("select * from th_trans_temp where TRANS_DATE = '$vtd_rec_date' and EMP_NO = $vtd_rec_emp");
                                        $rows_count = $chk_rows->count();
                                        //INSERT VTD REC DATA
                                        if ($rows_count > 0) {
                                            $insert_vtd_rec_data = new Database;
                                            $insert_vtd_rec_data->prepare("update th_trans_temp set VTD_RCPT = $vtd_rec where EMP_NO = $vtd_rec_emp and TRANS_DATE = '$vtd_rec_date'");
                                            $insert_vtd_rec_data->execute();
                                        } else {
                                            $insert_vtd_rec_data = new Database;
                                            $insert_vtd_rec_data->prepare("insert into th_trans_temp (`TRANS_DATE`, `EMP_NO`, `VTD_RCPT`) "
                                                    . "values('$vtd_rec_date','$vtd_rec_emp','$vtd_rec')");
                                            $insert_vtd_rec_data->execute();
                                        }
                                    }
                                }
                                //VTD PAYMENT DATA
                                $get_vtd_payment_data = new Database;
                                $get_vtd_payment_data->query("select * from th_vtd_trans "
                                        . "where month(TRANS_DATE) = $month and year(TRANS_DATE) = $year and TYPE_OF_TRANS = 'P'");
                                $vtd_payment_count = $get_vtd_payment_data->count();
                                if ($vtd_payment_count > 0) {
                                    $vtd_payment_data = $get_vtd_payment_data->resultset();
                                    foreach ($vtd_payment_data as $vtd_payment_data) {
                                        $vtd_payment_eno = $vtd_payment_data['EMP_NO'];
                                        $vtd_payment = $vtd_payment_data['AMOUNT'];
                                        $vtd_payment_date = $vtd_payment_data['TRANS_DATE'];

                                        $chk_rows = new Database;
                                        $chk_rows->query("select * from th_trans_temp where TRANS_DATE = '$vtd_payment_date' and EMP_NO = $vtd_payment_eno");
                                        $rows_count = $chk_rows->count();
//                    if ($vtd_payment_date == $trans_date)
                                        if ($rows_count > 0) {
                                            $insert_vtd_payment_data = new Database;
                                            $insert_vtd_payment_data->prepare("update th_trans_temp set VTD_PYMT = $vtd_payment "
                                                    . "where EMP_NO = $vtd_payment_eno and TRANS_DATE = '$vtd_payment_date'");
                                            $insert_vtd_payment_data->execute();
                                        } else {
                                            $insert_vtd_payment_data = new Database;
                                            $insert_vtd_payment_data->prepare("insert into th_trans_temp (`TRANS_DATE`, `EMP_NO`, `VTD_PYMT`) "
                                                    . "values('$vtd_payment_date','$vtd_payment_eno','$vtd_payment')");
                                            $insert_vtd_payment_data->execute();
                                        }
                                    }
                                }


                                //SHARE CAPITAL RECPT
                                $get_share_recpt_data = new Database;
                                $get_share_recpt_data->query("SELECT * FROM th_share_trans where "
                                        . "month(TRANS_DATE) = $month and year(TRANS_DATE) = $year and TRAN_TYPE = 'R'");
                                $share_recpt_count = $get_share_recpt_data->count();
                                if ($share_recpt_count > 0) {
                                    $share_recpt_data = $get_share_recpt_data->resultset();
                                    foreach ($share_recpt_data as $share_recpt_data) {
                                        $share_recpt_eno = $share_recpt_data['EMP_NO'];
                                        $share_rept_amount = $share_recpt_data['AMOUNT'];
                                        $share_recpt_date = $share_recpt_data['TRANS_DATE'];

                                        $chk_rows = new Database;
                                        $chk_rows->query("select * from th_trans_temp where TRANS_DATE = '$share_recpt_date' and EMP_NO = $share_recpt_eno");
                                        $rows_count = $chk_rows->count();
//                    if ($share_recpt_date == $trans_date)
                                        if ($rows_count > 0) {
                                            $insert_share_recpt_data = new Database;
                                            $insert_share_recpt_data->prepare("update th_trans_temp set SC_RCPT = $share_rept_amount where "
                                                    . "EMP_NO = $share_recpt_eno and TRANS_DATE = '$share_recpt_date'");
                                            $insert_share_recpt_data->execute();
                                        } else {
                                            $insert_share_recpt_data = new Database;
                                            $insert_share_recpt_data->prepare("insert into th_trans_temp (`TRANS_DATE`, `EMP_NO`, `SC_RCPT`) "
                                                    . "values ('$share_recpt_date', '$share_recpt_eno', '$share_rept_amount')");
                                            $insert_share_recpt_data->execute();
                                        }
                                    }
                                }


                                //SHARE CAPITAL PAYMENTS
                                $get_share_payment_data = new Database;
                                $get_share_payment_data->query("SELECT * FROM th_share_trans where "
                                        . "month(TRANS_DATE) = $month and year(TRANS_DATE) = $year and TRAN_TYPE = 'P'");
                                $share_payment_count = $get_share_payment_data->count();
                                if ($share_payment_count > 0) {
                                    $share_payment_data = $get_share_payment_data->resultset();
                                    foreach ($share_payment_data as $share_payment_data) {
                                        $share_payment_eno = $share_payment_data['EMP_NO'];
                                        $share_payment_amount = $share_payment_data['AMOUNT'];
                                        $share_payment_date = $share_payment_data['TRANS_DATE'];

                                        $chk_rows = new Database;
                                        $chk_rows->query("select * from th_trans_temp where TRANS_DATE = '$share_payment_date' and EMP_NO = $share_payment_eno");
                                        $rows_count = $chk_rows->count();
//                    if ($share_payment_date == $trans_date)
                                        if ($rows_count > 0) {
                                            $insert_share_payment_data = new Database;
                                            $insert_share_payment_data->prepare("update th_trans_temp set SC_PYMT = $share_payment_amount where "
                                                    . "EMP_NO = $share_payment_eno and TRANS_DATE = '$share_payment_date'");
                                            $insert_share_payment_data->execute();
                                        } else {
                                            $insert_share_payment_data = new Database;
                                            $insert_share_payment_data->prepare("insert into th_trans_temp (`TRANS_DATE`, `EMP_NO`, `SC_PYMT`) "
                                                    . "values ('$share_payment_date', '$share_payment_eno', '$share_payment_amount')");
                                            $insert_share_payment_data->execute();
                                        }
                                    }
                                }

                                //RB RECPT
                                $get_rb_recpt_data = new Database;
                                $get_rb_recpt_data->query("select * from th_ret_ben_trans where "
                                        . "month(TRANS_DATE) = $month and year(TRANS_DATE) = $year and TYPE_OF_TRANS = 'R'");
                                $rb_recpt_count = $get_rb_recpt_data->count();
                                if ($rb_recpt_count > 0) {
                                    $rb_recpt_data = $get_rb_recpt_data->resultset();
                                    foreach ($rb_recpt_data as $rb_recpt_data) {
                                        $rb_recpt_eno = $rb_recpt_data['EMP_NO'];
                                        $rb_recpt_amount = $rb_recpt_data['AMOUNT'];
                                        $rb_recpt_date = $rb_recpt_data['TRANS_DATE'];

                                        $chk_rows = new Database;
                                        $chk_rows->query("select * from th_trans_temp where TRANS_DATE = '$rb_recpt_date' and EMP_NO = $rb_recpt_eno");
                                        $rows_count = $chk_rows->count();
                                        //if ($rb_recpt_date == $trans_date)
                                        if ($rows_count > 0) {
                                            $insert_rb_recpt_data = new Database;
                                            $insert_rb_recpt_data->prepare("update th_trans_temp set RB_RCPT = $rb_recpt_amount "
                                                    . "where EMP_NO = $rb_recpt_eno and TRANS_DATE = '$rb_recpt_date'");
                                            $insert_rb_recpt_data->execute();
                                        } else {
                                            $insert_rb_recpt_data = new Database;
                                            $insert_rb_recpt_data->prepare("insert into th_trans_temp (`TRANS_DATE`, `EMP_NO`, `RB_RCPT`) "
                                                    . "values ('$rb_recpt_date', '$rb_recpt_eno', '$rb_recpt_amount')");
                                            $insert_rb_recpt_data->execute();
                                        }
                                    }
                                }


                                //RB PAYMENT
                                $get_rb_payment_data = new Database;
                                $get_rb_payment_data->query("select * from th_ret_ben_trans where "
                                        . "month(TRANS_DATE) = $month and year(TRANS_DATE) = $year and TYPE_OF_TRANS = 'P'");
                                $rb_payment_count = $get_rb_payment_data->count();
                                if ($rb_payment_count > 0) {
                                    $rb_payment_data = $get_rb_payment_data->resultset();
                                    foreach ($rb_payment_data as $rb_payment_data) {
                                        $rb_payment_eno = $rb_payment_data['EMP_NO'];
                                        $rb_payment_amount = $rb_payment_data['AMOUNT'];
                                        $rb_payment_date = $rb_payment_data['TRANS_DATE'];

                                        $chk_rows = new Database;
                                        $chk_rows->query("select * from th_trans_temp where TRANS_DATE = '$rb_payment_date' and EMP_NO = $rb_payment_eno");
                                        $rows_count = $chk_rows->count();
                                        //if ($rb_payment_date == $trans_date)
                                        if ($rows_count > 0) {
                                            $insert_rb_payment_data = new Database;
                                            $insert_rb_payment_data->prepare("update th_trans_temp set RB_PPYMT = $rb_payment_amount "
                                                    . "where EMP_NO = $rb_payment_eno and TRANS_DATE = '$rb_payment_date'");
                                            $insert_rb_payment_data->execute();
                                        } else {
                                            $insert_rb_payment_data = new Database;
                                            $insert_rb_payment_data->prepare("insert into th_trans_temp (`TRANS_DATE`, `EMP_NO`, `RB_PPYMT`) "
                                                    . "values ('$rb_payment_date', '$rb_payment_eno', '$rb_payment_amount')");
                                            $insert_rb_payment_data->execute();
                                        }
                                    }
                                }


                                // LOAN AMOUNT
                                $get_loan_amout_data = new Database;
                                $get_loan_amout_data->query("select * from th_loan_trans where month(TRANS_DATE) = $month "
                                        . "and year(TRANS_DATE) = $year");
                                $loan_amount_count = $get_loan_amout_data->count();
                                if ($loan_amount_count > 0) {
                                    $loan_amount_data = $get_loan_amout_data->resultset();
                                    foreach ($loan_amount_data as $loan_amount_data) {
                                        $loan_eno = $loan_amount_data['EMP_NO'];
                                        $loan_pri_amount = $loan_amount_data['AMOUNTP'];
                                        $loan_int_amount = $loan_amount_data['AMOUNTI'];
                                        $loan_trans_date = $loan_amount_data['TRANS_DATE'];

                                        $chk_rows = new Database;
                                        $chk_rows->query("select * from th_trans_temp where TRANS_DATE = '$loan_trans_date' and EMP_NO = $loan_eno");
                                        $rows_count = $chk_rows->count();
//                    if ($loan_trans_date == $trans_date)
                                        if ($rows_count > 0) {
                                            $insert_loan_data = new Database;
                                            $insert_loan_data->prepare("update th_trans_temp set LO_PRL_REC = $loan_pri_amount, LO_INT_REC = $loan_int_amount "
                                                    . "where EMP_NO = $loan_eno and TRANS_DATE = '$loan_trans_date'");
                                            $insert_loan_data->execute();
                                        } else {
                                            $insert_loan_data = new Database;
                                            $insert_loan_data->prepare("insert into th_trans_temp (`TRANS_DATE`, `EMP_NO`, `LO_PRL_REC`, `LO_INT_REC`) "
                                                    . "values ('$loan_trans_date', '$loan_eno', '$loan_pri_amount', '$loan_int_amount')");
                                            $insert_loan_data->execute();
                                        }
                                    }
                                }


                                // ED LOAN AMOUNT  
                                $get_ed_loan_amout_data = new Database;
                                $get_ed_loan_amout_data->query("select * from th_edl_trans where month(TRANS_DATE) = $month "
                                        . "and year(TRANS_DATE) = $year");
                                $ed_loan_amount_count = $get_ed_loan_amout_data->count();
                                if ($ed_loan_amount_count > 0) {
                                    $ed_loan_amount_data = $get_ed_loan_amout_data->resultset();
                                    foreach ($ed_loan_amount_data as $ed_loan_amount_data) {
                                        $edl_eno = $ed_loan_amount_data['EMP_NO'];
                                        $ed_loan_pri_amount = $ed_loan_amount_data['AMOUNTP'];
                                        $ed_loan_int_amount = $ed_loan_amount_data['AMOUNTI'];
                                        $ed_loan_trans_date = $ed_loan_amount_data['TRANS_DATE'];

                                        $chk_rows = new Database;
                                        $chk_rows->query("select * from th_trans_temp where TRANS_DATE = '$ed_loan_trans_date' and EMP_NO = $edl_eno");
                                        $rows_count = $chk_rows->count();
//                    if ($ed_loan_trans_date == $trans_date)
                                        if ($rows_count > 0) {
                                            $insert_ed_loan_data = new Database;
                                            $insert_ed_loan_data->prepare("update th_trans_temp set ELO_PRL_REC = $ed_loan_pri_amount, ELO_INT_REC = $ed_loan_int_amount "
                                                    . "where EMP_NO = $edl_eno and TRANS_DATE = '$ed_loan_trans_date'");
                                            $insert_ed_loan_data->execute();
                                        } else {
                                            $insert_ed_loan_data = new Database;
                                            $insert_ed_loan_data->prepare("insert into th_trans_temp (`TRANS_DATE`, `EMP_NO`, `ELO_PRL_REC`, `ELO_INT_REC`) "
                                                    . "values ('$ed_loan_trans_date', '$edl_eno', '$ed_loan_pri_amount', '$ed_loan_int_amount')");
                                            $insert_ed_loan_data->execute();
                                        }
                                    }
                                }


                                //NEW LOAN DATA
                                $get_new_loan_data = new Database;
                                $get_new_loan_data->query("SELECT * FROM th_loan_master "
                                        . "where month(SACTION_DATE) = $month and year(SACTION_DATE) = $year");
                                $new_loan_count = $get_new_loan_data->count();
                                if ($new_loan_count > 0) {
                                    $new_loan_data = $get_new_loan_data->resultset();
                                    foreach ($new_loan_data as $new_loan_data) {
                                        $new_loan_eno = $new_loan_data['EMP_NO'];
                                        $new_loan_amount = $new_loan_data['SACTIONED_AMOUNT'];
                                        $new_loan_date = $new_loan_data['SACTION_DATE'];

                                        $chk_rows = new Database;
                                        $chk_rows->query("select * from th_trans_temp where TRANS_DATE = '$new_loan_date' and EMP_NO = $new_loan_eno");
                                        $rows_count = $chk_rows->count();
                                        //if ($new_loan_date == $trans_date)
                                        if ($rows_count > 0) {
                                            $insert_new_loan_data = new Database;
                                            $insert_new_loan_data->prepare("update th_trans_temp set NEW_LOAN_PYMT = $new_loan_amount "
                                                    . "where EMP_NO = $new_loan_eno and TRANS_DATE = '$new_loan_date'");
                                            $insert_new_loan_data->execute();
                                        } else {
                                            $insert_new_loan_data = new Database;
                                            $insert_new_loan_data->prepare("insert into th_trans_temp (`TRANS_DATE`, `EMP_NO`, `NEW_LOAN_PYMT`) "
                                                    . "values ('$new_loan_date', '$new_loan_eno', '$new_loan_amount')");
                                            $insert_new_loan_data->execute();
                                        }
                                    }
                                }


                                //NEW ED LOAN DATA 
                                $get_new_ed_loan_data = new Database;
                                $get_new_ed_loan_data->query("SELECT * FROM th_ed_loan_master "
                                        . "where month(SACTION_DATE) = $month and year(SACTION_DATE) = $year ");
                                $new_ed_loan_count = $get_new_ed_loan_data->count();
                                if ($new_ed_loan_count > 0) {
                                    $new_ed_loan_data = $get_new_ed_loan_data->resultset();
                                    foreach ($new_ed_loan_data as $new_ed_loan_data) {
                                        $new_edl_eno = $new_ed_loan_data['EMP_NO'];
                                        $new_ed_loan_amount = $new_ed_loan_data['SACTIONED_AMOUNT'];
                                        $new_ed_loan_date = $new_ed_loan_data['SACTION_DATE'];

                                        $chk_rows = new Database;
                                        $chk_rows->query("select * from th_trans_temp where TRANS_DATE = '$new_ed_loan_date' and EMP_NO = $new_edl_eno");
                                        $rows_count = $chk_rows->count();
                                        //if ($new_ed_loan_date == $trans_date)
                                        if ($rows_count > 0) {
                                            $insert_new_loan_data = new Database;
                                            $insert_new_loan_data->prepare("update th_trans_temp set NEW_EDL_PYMT = $new_ed_loan_amount "
                                                    . "where EMP_NO = $new_edl_eno and TRANS_DATE = '$new_ed_loan_date'");
                                            $insert_new_loan_data->execute();
                                        } else {
                                            $insert_new_ed_loan_data = new Database;
                                            $insert_new_ed_loan_data->prepare("insert into th_trans_temp (`TRANS_DATE`, `EMP_NO`, `NEW_EDL_PYMT`) "
                                                    . "values ('$new_ed_loan_date', '$new_edl_eno', '$new_ed_loan_amount')");
                                            $insert_new_ed_loan_data->execute();
                                        }
                                    }
                                }

                                //DUMPING DATA
                                $dump_data = new Database;
                                $dump_data->prepare("insert into th_members_trans_data (select * from th_trans_temp)");
                                $dump_data->execute();

                                //TRUNCATING TEMP TABLE
                                $trunc_temp_table = new Database;
                                $trunc_temp_table->prepare("truncate table th_trans_temp");
                                $trunc_temp_table->execute();

                                $_SESSION['process'] = TRUE;
                                $_SESSION['msg'] = $month . ',' . $year;
                            }
                        }
                        ?>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <h4 class="main_head">Run Member Trans Data</h4>

                                <form method="post" action="" autocomplete="off" class="form-inline">
                                    <div class="form-group">
                                        <label for="month">Select Month</label>
                                        <select name="month" id="month" required>
                                            <option value="">-- Select Month --</option>
                                            <?php
                                            for ($i = 1; $i <= 12; $i++) {
                                                ?>
                                                <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <select name="year" id="year" required>
                                            <option value="">-- Select Year --</option>
                                            <?php
                                            for ($i = 2020; $i <= $curr_year; $i++) {
                                                ?>
                                                <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">                
                                        <input type="submit" name="btncheck" value="Process" class="btn btn-primary" onclick="displayProcess();">
                                    </div>
                                </form>
                            </div>
                            <script>
                                function displayProcess() {
                                    document.getElementById('msg_div').style.display = 'none';
                                    document.getElementById('process_div').style.display = 'block';
                                }
                            </script>

                            <div class="col-md-4 col-md-offset-4" id="process_div" style=" margin-top: 5% ; display: none">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                                         role="progressbar" aria-valuenow="100" style=" width: 100%">
                                        Processing
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12" id="msg_div">
                                <?php
                                if (isset($_SESSION['run'])) {
                                    ?>
                                    <div class="alert alert-danger alert-dismissable">
                                        <?php
                                        $get_last_pross_month = new Database;
                                        $get_last_pross_month->prepare("select * from th_members_trans_data order by TRANS_DATE desc LIMIT 1");
                                        $last_pross_month = $get_last_pross_month->resultset();
                                        foreach ($last_pross_month as $last_pross_month) {
                                            $last_month = $last_pross_month['TRANS_DATE'];
                                        }
                                        ?>
                                        Data Alredy proccessed upto <?php echo date('M-Y', strtotime($last_month)) ?>, Please select next month                
                                    </div>
                                    <?php
                                    unset($_SESSION['run']);
                                }

                                if (isset($_SESSION['process'])) {
                                    ?>
                                    <div class="col-md-12">
                                        <div class="alert alert-success alert-dismissable">
                                            Process Completed Successfully for the month <?php echo $_SESSION['msg'] ?>               
                                        </div>
                                        <?php
                                        unset($_SESSION['process']);
                                        unset($_SESSION['msg']);
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                        <?php
                    } else if ($_GET['menu'] == 'admin') {
                        if (isset($_POST['btn_add_admin'])) {
                            $admin_no = $_POST['admin_emp_no'];

                            $add_admin = new Database;
                            $add_admin->prepare("insert into admin_login (admin_id) values(:admin_id)");
                            $add_admin->bind(':admin_id', $admin_no);
                            $add_admin->execute();
                        }
                        ?>
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <h5>User Maintenance</h5>
                            <form method="post" action="">
                                <div class="form-group">
                                    <input type="text" name="admin_emp_no" class="form-control" placeholder="Enter Admin Number" required>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="btn_add_admin" class="btn btn-primary" value="Add User">
                                </div>
                            </form>
                        </div>

                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <table class="table table-bordered">
                                <tr>
                                    <th>S.No</th>
                                    <th>Admin Name</th>
                                    <th>Admin Emp No</th>
                                    <th>Action</th>
                                </tr>
                                <?php
                                $i = 1;
                                $fetch_admin = new Database;
                                $fetch_admin->query("select * from admin_login");
                                $admin_count = $fetch_admin->count();
                                if ($admin_count > 0) {
                                    $admin = $fetch_admin->resultset();
                                    foreach ($admin as $admin) {
                                        ?>
                                        <tr>
                                            <td><?php echo $i++ ?></td>                                            
                                            <td>
                                                <?php
                                                $get_admin_name = new Database;
                                                $get_admin_name->query("select EMP_NAME from th_member_master where EMP_NO = " . $admin['admin_id']);
                                                $admin_name = $get_admin_name->resultset();
                                                foreach ($admin_name as $admin_name) {
                                                    echo $admin_name['EMP_NAME'];
                                                }
                                                ?>                                            
                                            </td>
                                            <td><?php echo $admin['admin_id'] ?></td>
                                            <td><a href="admin_panel.php?action=del_admin&id=<?php echo $admin['id'] ?>">Delete</a></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </table>
                        </div>
                        <?php
                    } else if ($_GET['menu'] == 'queries') {
                        ?>
                        <div class="row" style="margin-top: 15px; padding: 10px;">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <form method="post" action="">
                                    <div class="form-group">
                                        <label for="emp_req">Requested Employee Number</label>
                                        <input type="number" name="emp_req" id="emp_req" class="form-control" placeholder="EMPLOYEE NUMBER"
                                               inputmode="numeric" pattern="[0-9]*"
                                               value="<?php echo isset($_POST['emp_req']) ? $_POST['emp_req'] : '' ?>"
                                               >
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="btn_emp_req" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                            <?php
                            if (isset($_POST['btn_emp_req'])) {
                                $emp_req = $_POST['emp_req'];
                                ?>
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <?php
                                    $get_emp_data = new Database;
                                    $get_emp_data->prepare("select * from th_member_master where EMP_NO = $emp_req");
                                    $emp_data = $get_emp_data->resultset();
                                    foreach ($emp_data as $emp_data) {
                                        ?>
                                        <table class="table table-bordered" >
                                            <tr>
                                                <td><?php echo $emp_data['EMP_NAME'] ?></td>
                                                <td><?php echo $emp_data['DESIG'] ?></td>
                                                <td><?php echo $emp_data['DEPT'] ?></td>
                                            </tr>
                                        </table>
                                        <?php
                                    }
                                    ?>
                                </div>

                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <h5><strong>Loan Info</strong></h5>
                                    <?php
                                    $get_loan_info = new Database;
                                    $get_loan_info->query("select * from th_loan_master where emp_no='$emp_req' and LOAN_STATUS = 'R'");
                                    $loan_count = $get_loan_info->count();
                                    if ($loan_count > 0) {
                                        $loan_info = $get_loan_info->resultset();
                                        foreach ($loan_info as $loan_info) {
                                            $loanamount = $loan_info['SACTIONED_AMOUNT'];
                                            $obi = $loan_info['OBI'];
                                            $cbp = $loan_info['CBP'];
                                            $rate = $loan_info['RATE_OF_INTREST'];
                                            if (date('d') <= 15) {
                                                $cbi = $loan_info['CBI'];
                                            } else {
                                                $interest = ((($cbp * $rate) / 12) / 100) / 2;
                                                $cbi = round($loan_info['CBI'] + $interest);
                                            }
                                            $present_loan_balance = $cbp + $cbi;
                                            $eligble_amount1_25 = ($loanamount * 0.25);
                                            $eligble_amount2_25 = $loanamount - $eligble_amount1_25;
                                            $eligble_amount3_25 = ($present_loan_balance - $eligble_amount2_25);

                                            $surities = [$loan_info['SURITY1'], $loan_info['SURITY2'], $loan_info['SURITY3']];
                                            ?>
                                            Loan Taken : <?php echo $loanamount; ?> <br>
                                            Present Loan Balance : <?php echo $present_loan_balance ?><br>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th colspan="2" >Surity Taken From</th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                foreach ($surities as $surity) {
                                                    $get_surity_info = new Database;
                                                    $get_surity_info->query("select * from th_member_master where EMP_NO = $surity");
                                                    $surity_info = $get_surity_info->resultset();
                                                    foreach ($surity_info as $info) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $info['EMP_NO'] ?></td>
                                                            <td><?php echo $info['EMP_NAME'] ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </table>                                            
                                            <?php
                                            if ($present_loan_balance < $eligble_amount2_25) {
                                                ?>
                                                <div class="alert alert-info">
                                                    Eligible for applying for new loan
                                                </div>
                                                <?php
                                            } else {
                                                ?>
                                                <div class="alert alert-info">
                                                    Eligible for next loan after repaying of <?php echo $eligble_amount3_25 ?> through salary
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <div class="alert alert-info">
                                            Don't Have Loan Balance
                                        </div>
                                        <?php
                                    }
                                    ?>

                                    <div class="col-md-12 table-responsive">    
                                        <table class="table table-bordered">
                                            <tr>
                                                <th colspan="7">Surity Given</th>
                                            </tr>
                                            <tr>
                                                <th>E.no </th>
                                                <th>Name </th>
                                                <th>Loan Amount </th>
                                                <th>Date </th>
                                                <th>Present Balance </th>
                                                <th>Previous Month Recovery</th>
                                                <th>Photo</th>
                                            </tr>
                                            <?php
                                            $query = "SELECT * FROM `th_loan_master` WHERE (SURITY1 = $emp_req OR SURITY2 = $emp_req OR SURITY3 = $emp_req) and LOAN_STATUS = 'R' ORDER BY `LOAN_NO` ASC";
                                            //echo $query;
                                            $get_edl_data = new Database;
                                            $get_edl_data->query($query);
                                            $count = $get_edl_data->count();
                                            if ($count > 0) {
                                                $result = $get_edl_data->resultset();
                                                foreach ($result as $row) {
                                                    ?>
                                                    <tr>
                                                        <td> <?php echo $row['EMP_NO'] ?></td>
                                                        <?php
                                                        $get_name = new Database;
                                                        $get_name->prepare("select EMP_NAME from th_member_master where EMP_NO = " . $row['EMP_NO']);
                                                        $name = $get_name->resultset();
                                                        foreach ($name as $name) {
                                                            
                                                        }
                                                        ?>
                                                        <td> <?php echo $name['EMP_NAME'] ?></td>
                                                        <td> <?php echo $row['SACTIONED_AMOUNT'] ?></td>
                                                        <?php
                                                        $loan_data = date('d-m-Y', strtotime($row['SACTION_DATE']));
                                                        ?>
                                                        <td> <?php echo $loan_data ?></td>
                                                        <td> <?php echo $row['CBP'] + $row['CBI'] ?></td>
                                                        <td>
                                                            <?php
                                                            $day = date('d');
                                                            $month = date('m');
                                                            $year = date('Y');
                                                            if ($month == 1) {
                                                                $year_to_chk = $year - 1;
                                                                $month = 12;
                                                                $date_chk = $year_to_chk . '-' . $month . '-28';
                                                                $date_to_chk = date('Y-m-d', strtotime($date_chk));
                                                            } else {
                                                                $month = $month - 1;
                                                                $date_chk = $year . '-' . $month . '-28';
                                                                $date_to_chk = date('Y-m-d', strtotime($date_chk));
                                                            }
                                                            $get_prev_rec = new Database;
                                                            $get_prev_rec->query("SELECT * FROM th_loan_trans where EMP_NO = $row[EMP_NO] AND MODE_OF_PAYMENT = 'S' AND TRANS_DATE = '$date_to_chk'");
                                                            $prev_rec_count = $get_prev_rec->count();
                                                            if ($prev_rec_count > 0) {
                                                                ?>
                                                                <span style="color: green">YES</span>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <span style="color: red">NO</span>
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><img class="img-responsive" src="user_img/<?php echo $row['EMP_NO'] ?>_pht.jpg" width="50"></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }

                                            $get_pending_loan_sur_query = "SELECT * FROM `th_loan_register` WHERE SURITY1 = $emp_req OR SURITY2 = $emp_req OR SURITY3 = $emp_req ";
                                            //echo $query;
                                            $get_pending_loan_sur = new Database;
                                            $get_pending_loan_sur->query($get_pending_loan_sur_query);
                                            $pending_suritie_count = $get_pending_loan_sur->count();
                                            if ($pending_suritie_count > 0) {
                                                $pending_suritie = $get_pending_loan_sur->resultset();
                                                foreach ($pending_suritie as $pending_suritie) {
                                                    ?>
                                                    <tr>
                                                        <td> <?php echo $pending_suritie['EMP_NO'] ?></td>
                                                        <?php
                                                        $get_name = new Database;
                                                        $get_name->prepare("select EMP_NAME from th_member_master where EMP_NO = " . $pending_suritie['EMP_NO']);
                                                        $name = $get_name->resultset();
                                                        foreach ($name as $name) {
                                                            
                                                        }
                                                        ?>
                                                        <td> <?php echo $name['EMP_NAME'] ?></td>
                                                        <td> <?php echo $pending_suritie['APPLIED_AMOUNT'] ?></td>
                                                        <td>
                                                            <?php
                                                            echo $loan_data = date('d-m-Y', strtotime($pending_suritie['REGISTER_DATE']));
                                                            ?>
                                                        </td>
                                                        <td>Under Process</td>
                                                        <td><img class="img-responsive" src="user_img/<?php echo $pending_suritie['EMP_NO'] ?>_pht.jpg" width="50"></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            $total_sur_count = $count + $pending_suritie_count;
                                            $rem_sur_count = 3 - $total_sur_count;
                                            if ($rem_sur_count > 0) {
                                                if ($rem_sur_count == 1) {
                                                    $text = 'surety';
                                                } else {
                                                    $text = 'sureties';
                                                }
                                                ?>
                                                <tr>
                                                    <td colspan="6" align="center"><h6>You can give <?php echo $rem_sur_count; ?> More <?php echo $text ?> for Loan</h6></td>
                                                </tr>
                                                <?php
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="6" align="center"><h6>you are not eligible to give any sureties</h6></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </table>                    
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 25px;">
                                    <h5>Med. Term Loan Info</h5>
                                    <?php
                                    $get_edl_data = new Database;
                                    $get_edl_data->query("select * from th_ed_loan_master where emp_no='$emp_req' and LOAN_STATUS = 'R'");
                                    $edl_count = $get_edl_data->count();
                                    if ($edl_count > 0) {
                                        $edl_data = $get_edl_data->resultset();
                                        foreach ($edl_data as $edl_data) {
                                            $loanamount = $edl_data['SACTIONED_AMOUNT'];
                                            $rate = $edl_data['RATE_OF_INTREST'];
                                            $obp = $edl_data['OBP'];
                                            $obi = $edl_data['OBI'];
                                            $cbp = $edl_data['CBP'];
                                            $surities = [$edl_data['SURITY1'], $edl_data['SURITY2']];
                                            if (date('d') <= 15) {
                                                $cbi = $edl_data['CBI'];
                                            } else {
                                                $interest = ((($cbp * $rate) / 12) / 100) / 2;
                                                $cbi = round($edl_data['CBI'] + $interest);
                                            }
                                            $present_loan_balence = $cbp + $cbi;
                                            $eligble_amount1_25 = ($loanamount * 0.25);
                                            $eligble_amount2_25 = $loanamount - $eligble_amount1_25;
                                            $eligble_amount3_25 = ($present_loan_balence - $eligble_amount2_25);
                                            ?>
                                            Loan Taken : <?php echo $loanamount; ?> <br>
                                            Present Loan Balance : <?php echo $present_loan_balence ?><br>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>Surity Taken From</th>
                                                </tr>

                                                <?php
                                                foreach ($surities as $surity) {
                                                    $get_surity_info = new Database;
                                                    $get_surity_info->query("select * from th_member_master where EMP_NO = $surity");
                                                    $surity_info = $get_surity_info->resultset();
                                                    foreach ($surity_info as $info) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $info['EMP_NO'] ?></td>
                                                            <td><?php echo $info['EMP_NAME'] ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                            </table>
                                            <?php
                                            if ($present_loan_balence < $eligble_amount2_25) {
                                                ?>
                                                <div class="alert alert-info">
                                                    Eligible for applying for new loan
                                                </div>                                                
                                                <?php
                                            } else {
                                                ?>
                                                <div class="alert alert-info">
                                                    Eligible for next loan after repaying of <?php echo $eligble_amount3_25 ?> through salary
                                                </div>

                                                <?php
                                            }
                                        }
                                    } else {
                                        ?>
                                        <div class="alert alert-info">
                                            Don't have Med. Term Loan
                                        </div>
                                        <?php
                                    }
                                    ?>

                                    <div class="col-md-12 table-responsive">
                                        <h5> Surity Given  :</h5>    
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>E.no </th>
                                                <th>Name </th>
                                                <th>Loan Amount </th>
                                                <th>Present Balance </th>
                                                <th>Date </th>
                                                <th>Previous Month Recovery</th>
                                                <th>Photo</th>
                                            </tr>
                                            <?php
                                            $query = "SELECT * FROM `th_ed_loan_master` WHERE (SURITY1 = $emp_req OR SURITY2 = $emp_req) AND LOAN_STATUS = 'R' ORDER BY `LOAN_NO` ASC";
                                            //echo $query;
                                            $get_edl_data = new Database;
                                            $get_edl_data->query($query);
                                            $count = $get_edl_data->count();
                                            if ($count > 0) {
                                                $result = $get_edl_data->resultset();
                                                foreach ($result as $row) {
                                                    ?>
                                                    <tr>
                                                        <td> <?php echo $row['EMP_NO'] ?></td>
                                                        <?php
                                                        $get_name = new Database;
                                                        $get_name->prepare("select EMP_NAME from th_member_master where EMP_NO = " . $row['EMP_NO']);
                                                        $name = $get_name->resultset();
                                                        foreach ($name as $name) {
                                                            
                                                        }
                                                        ?>
                                                        <td> <?php echo $name['EMP_NAME'] ?></td>
                                                        <td> <?php echo $row['SACTIONED_AMOUNT'] ?></td>

                                                        <td> <?php echo $row['CBP'] + $row['CBI'] ?></td>
                                                        <?php
                                                        $loan_data = date('d-m-Y', strtotime($row['SACTION_DATE']));
                                                        ?>
                                                        <td> <?php echo $loan_data ?></td>
                                                        <td>
                                                            <?php
                                                            $day = date('d');
                                                            $month = date('m');
                                                            $year = date('Y');
                                                            if ($month == 1) {
                                                                $year_to_chk = $year - 1;
                                                                $month = 12;
                                                                $date_chk = $year_to_chk . '-' . $month . '-28';
                                                                $date_to_chk = date('Y-m-d', strtotime($date_chk));
                                                            } else {
                                                                $month = $month - 1;
                                                                $date_chk = $year . '-' . $month . '-28';
                                                                $date_to_chk = date('Y-m-d', strtotime($date_chk));
                                                            }
                                                            $get_prev_rec = new Database;
                                                            $get_prev_rec->query("SELECT * FROM th_edl_trans where EMP_NO = $row[EMP_NO] AND MODE_OF_PAYMENT = 'S' AND TRANS_DATE = '$date_to_chk'");
                                                            $prev_rec_count = $get_prev_rec->count();
                                                            if ($prev_rec_count > 0) {
                                                                ?>
                                                                <span style="color: green">YES</span>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <span style="color: red">NO</span>
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><img class="img-responsive" src="user_img/<?php echo $row['EMP_NO'] ?>_pht.jpg" width="50"></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <?php
                                            $get_pending_loan_sur_query = "SELECT * FROM `th_edl_register` WHERE SURITY1 = $emp_req OR SURITY2 = $emp_req";
                                            //echo $query;
                                            $get_pending_loan_sur = new Database;
                                            $get_pending_loan_sur->query($get_pending_loan_sur_query);
                                            $pending_suritie_count = $get_pending_loan_sur->count();
                                            if ($pending_suritie_count > 0) {
                                                $pending_suritie = $get_pending_loan_sur->resultset();
                                                foreach ($pending_suritie as $pending_suritie) {
                                                    ?>
                                                    <tr>
                                                        <td> <?php echo $pending_suritie['EMP_NO'] ?></td>
                                                        <?php
                                                        $get_name = new Database;
                                                        $get_name->prepare("select EMP_NAME from th_member_master where EMP_NO = " . $pending_suritie['EMP_NO']);
                                                        $name = $get_name->resultset();
                                                        foreach ($name as $name) {
                                                            
                                                        }
                                                        ?>
                                                        <td> <?php echo $name['EMP_NAME'] ?></td>
                                                        <td> <?php echo $pending_suritie['APPLIED_AMOUNT'] ?></td>
                                                        <td>Under Process</td>
                                                        <td>
                                                            <?php
                                                            echo $loan_data = date('d-m-Y', strtotime($pending_suritie['REGISTER_DATE']));
                                                            ?>
                                                        </td>

                                                        <td>
                                                            <img class="img-responsive" src="user_img/<?php echo $pending_suritie['EMP_NO'] ?>_pht.jpg" width="50">
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            $total_sur_count = $count + $pending_suritie_count;
                                            $rem_sur_count = 2 - $total_sur_count;
                                            if ($rem_sur_count > 0) {
                                                if ($rem_sur_count == 1) {
                                                    $text = 'surety';
                                                } else {
                                                    $text = 'sureties';
                                                }
                                                ?>
                                                <tr>
                                                    <td colspan="6" align="center"><h6>You can give <?php echo $rem_sur_count; ?> More <?php echo $text ?> for Medium Term Loan</h6></td>
                                                </tr>
                                                <?php
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="6" align="center"><h6>you are not eligible to give any sureties</h6></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </table>  
                                    </div>

                                </div> 

                                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 25px;">
                                    <h5>TD Info</h5>
                                    <?php
                                    $tool_msg = '';
                                    $eliggibilty_status = '';
                                    $query = "select EMP_NO, GL_NO, OPEN_BAL, CLOSE_BAL, INTEREST, RECOVERY_RATE, PRG_RECOVERIES, PRG_PAYMENTS, MODIFIED_DATE,
 MEMBERSHIP_DATE, LAST_WITHDRAWAL_DATE, IF(LAST_WITHDRAWAL_DATE IS NULL,0,LAST_WITHDRAWAL_DATE) as dt,  DATE_ADD(LAST_WITHDRAWAL_DATE, INTERVAL 12 MONTH) as NEWDATE, USER_ID, TRN_NO, TRAN_STATUS,
 LAST_YR_INT, RRATE, RRATE_OLD from th_thrift_deposit_master where emp_no='$emp_req'";
                                    $get_td_data = new Database;
                                    $get_td_data->query($query);

                                    $count = $get_td_data->count();
                                    if ($count > 0) {
                                        $result = $get_td_data->resultset();
                                        foreach ($result as $row) {
                                            $ob = round($row['OPEN_BAL'], 0);
                                            $cb = round($row['CLOSE_BAL'], 0);
                                            if ($cb > 20000) {
                                                $elg_amt = $cb / 2;
                                            } else {
                                                $elg_amt = $cb - 10000;
                                            }
                                            $rec_rate = round($row['RECOVERY_RATE'], 0);
                                            $prev_with_date = $row['dt'];
                                            $eligble_date = date("M-Y", strtotime($row['NEWDATE']));
                                            $total_Recov = round($row['PRG_RECOVERIES'], 0);
                                            $total_payments = round($row['PRG_PAYMENTS'], 0);
                                            $curr_date = date("M-Y");

                                            $q = "select DATE_OF_JOIN,DATE_ADD(DATE_OF_JOIN, INTERVAL 60 MONTH) as date1 from th_member_master where emp_no='$user'";
                                            $chk_eligibility = new Database();
                                            $chk_eligibility->query($q);
                                            $r = $chk_eligibility->resultset();
                                            foreach ($r as $row3) {
                                                $doj = $row3['DATE_OF_JOIN'];
                                                $date_five = date("M-Y", strtotime($row3['date1']));
                                                $curr_date = date("M-Y");
                                            }
                                            if (strtotime($date_five) <= strtotime($curr_date)) {
                                                if ($prev_with_date == 0) {
                                                    $eliggibilty_status = 'eligible';
                                                    $mymsg = '';
                                                } else {
                                                    if (strtotime($eligble_date) <= strtotime($curr_date)) {
                                                        $eliggibilty_status = 'eligible';
                                                        $mymsg = '';
                                                    } else {
                                                        $eliggibilty_status = 'not_eligible';
                                                        $_SESSION['td_app_status'] = FALSE;
                                                        $mymsg = 'Eligible for withdrawal after  ' . $eligble_date;
                                                    }
                                                }
                                            } else {
                                                $eliggibilty_status = 'not_eligible';
                                                $_SESSION['td_app_status'] = FALSE;
                                                $mymsg = 'Eligible for withdrawal after  ' . $date_five;
                                            }

                                            $app_status = '';
                                            $query3 = "select * from th_td_register where emp_no='$user'";
                                            $get_registration_status = new Database;
                                            $get_registration_status->query($query3);
                                            $count = $get_registration_status->count();
                                            if ($count > 0) {
                                                $app_status = 'aplied';
                                                $result3 = $get_registration_status->resultset();
                                                foreach ($result3 as $row2) {
                                                    $_SESSION['td_app_status'] = FALSE;
                                                    $app_amount = $row2['APPLIED_AMOUNT'];
                                                    $reg_date = date('d-M-Y', strtotime($row2['REGISTRATION_DATE']));
                                                }
                                            } else {
                                                $_SESSION['td_app_status'] = TRUE;
                                                $app_status = 'not_applied';
                                            }
                                        }
                                    }
                                    ?>
                                    TD Balance : <?php echo $cb ?> <br>
                                    TD Recovery : <?php echo $rec_rate ?><br>
                                    <?php
                                    if ($app_status == 'aplied') {
                                        ?>
                                        <div class="row">
                                            <div class="col-md-6 col-md-offset-3">
                                                <div class="alert alert-info">
                                                    Applied for Withdrawal of Rs.<?php echo $app_amount ?>/-  on <?php echo $reg_date ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    } else if ($eliggibilty_status = 'not_eligible' && $mymsg != '') {
                                        if (empty($default_msg)) {
                                            ?>
                                            <div class = "row">
                                                <div class = "col-md-6 col-md-offset-3">
                                                    <div class = "alert alert-info">
                                                        <span align="center"><?php echo $mymsg ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <div class = "row">
                                            <div class = "col-md-6 col-md-offset-3">
                                                <div class = "alert alert-info">
                                                    Eligible for Withdrawal Rs.<?php echo round_to_hundred($elg_amt); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 25px;">
                                    <h5>VTD Info</h5>

                                    <?php
                                    $tool_msg = '';
                                    $query = "select * from th_vtd_master where emp_no='$emp_req'";
                                    $get_vtd_data = new Database;
                                    $get_vtd_data->query($query);
                                    $opt_count = $get_vtd_data->count();
                                    if ($opt_count > 0) {
                                        $result = $get_vtd_data->resultset();
                                        foreach ($result as $row) {
                                            $ob = round($row['OPEN_BAL'], 0);
                                            $total_Recov = round($row['PRG_RECOVERIES'], 0);
                                            $total_payments = round($row['PRG_PAYMENTS'], 0);
                                            $cb = round($row['CLOSE_BAL'], 0);
                                            $rec_rate = round($row['RECOVERY_RATE'], 0);
                                            $elg_amt = round($cb, 0);
                                        }
                                        ?>
                                        Total VTD : <?php echo $cb; ?> <br>
                                        Present recovery : <?php echo $rec_rate; ?>

                                        <?php
                                        $query3 = "select * from th_vtd_register where emp_no='$emp_req'";
                                        $get_vtd_registration_data = new Database;
                                        $get_vtd_registration_data->query($query3);
                                        $count = $get_vtd_registration_data->count();
                                        $app_status = '';
                                        if ($count > 0) {
                                            $result3 = $get_vtd_registration_data->resultset();
                                            foreach ($result3 as $row2) {
                                                $app_amount = $row2['APPLIED_AMOUNT'];
                                                $reg_date = date('d-M-Y', strtotime($row2['REGISTRATION_DATE']));
                                                $app_status = 'applied';
                                            }
                                        } else {
                                            $curr_month = date("m", time());
                                            if ($curr_month > 3) {
                                                $year1 = intval(date('Y'));
                                                $date1 = date('Y-m-d', strtotime('04/01/' . $year1));
                                                $year2 = intval(date('Y') + 1);
                                                $date2 = date('Y-m-d', strtotime('03/31/' . $year2));
                                            } elseif ($curr_month <= 3) {
                                                $year1 = intval(date('Y') - 1);
                                                $date1 = date('Y-m-d', strtotime('04/01/' . $year1));
                                                $year2 = intval(date('Y'));
                                                $date2 = date('Y-m-d', strtotime('03/31/' . $year2));
                                            }
                                            $cheak_eligibility = new Database;
                                            $query = "SELECT * FROM `th_vtd_trans` WHERE EMP_NO = $user AND TYPE_OF_TRANS = 'P' AND TRANS_DATE >= '$date1' AND TRANS_DATE <= '$date2'";
                                            $cheak_eligibility->query($query);
                                            $withdraw_count = $cheak_eligibility->count();
                                            if ($withdraw_count >= 2) {
                                                $app_status = "taken";
                                            } else {
                                                $app_status = 'eligible';
                                            }
                                        }
                                        ?>
                                        <?php
                                        if ($app_status != 'eligible') {
                                            ?>
                                            <div class="row">
                                                <div class="col-md-6 col-md-offset-3">
                                                    <div class="alert alert-info" align="center">
                                                        <?php
                                                        if ($app_status == 'applied') {
                                                            echo "you have applaied for Withdrawal of Rs.$app_amount/-  on $reg_date";
                                                        }
                                                        if ($app_status == 'taken') {
                                                            echo"You have alredy withdraw 2 times in this financial yaer";
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                        } else {
                                            ?>
                                            <div class="row">
                                                <div class="col-md-6 col-md-offset-3">
                                                    <div class="alert alert-info" align="center">
                                                        You are Eligible for Withdrawal
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                        }
                                        ?>
                                        <?php
                                    } else {
                                        ?>
                                        <div class="row">
                                            <div class="col-md-6 col-md-offset-3">
                                                <div class="alert alert-info" align="center">
                                                    No VTD Deposit
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>

                </div>
            </div>
        </div>
        <footer>
            <div class="footer-area-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="copyright text-center">
                                <p>
                                    &copy; Copyright <strong></strong>. All Rights Reserved
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

        <!-- JavaScript Libraries -->
        <script src="lib/jquery/jquery.min.js"></script>
        <script src="lib/bootstrap/js/bootstrap.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="lib/venobox/venobox.min.js"></script>
        <script src="lib/knob/jquery.knob.js"></script>
        <script src="lib/wow/wow.min.js"></script>
        <script src="lib/parallax/parallax.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/nivo-slider/js/jquery.nivo.slider.js" type="text/javascript"></script>
        <script src="lib/appear/jquery.appear.js"></script>
        <script src="lib/isotope/isotope.pkgd.min.js"></script>
        <script src="js/scripts.js" type="text/javascript"></script>
        <!-- Contact Form JavaScript File -->
        <script src="contactform/contactform.js"></script>

        <script src="js/main.js"></script>
    </body>

</html>