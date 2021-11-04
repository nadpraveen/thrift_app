<?php

ob_start();
session_start();
include 'assets/includes/db.php';
include 'assets/includes/function.php';
$emp = $_SESSION['suser'];
//$key = rtrim($_GET['key'], '.');

$fetch_emp_info = new Database;
$fetch_emp_info->prepare("select * from th_member_master where EMP_NO = " . $emp);
$emp_info = $fetch_emp_info->resultset();
foreach ($emp_info as $emp_info) {
    $emp_no = $emp_info['EMP_NO'];
    $emp_name = $emp_info['EMP_NAME'];
    $mobile = $emp_info['PH_NO_R'];

    //Rec Responce
    //Agreed
    if ($_GET['resp'] == 'agree') {
        $rec_resp = new Database;
        $rec_resp->prepare("insert into tbl_resp (`emp_no`, `name`, `mobile`, `response`, `reasion`, `time_of_responce`) "
                . "values (:emp_no, :emp_name, :mobile, :responce, :reasion, :time)");

        $rec_resp->bind(':emp_no', $emp_no);
        $rec_resp->bind(':emp_name', $emp_name);
        $rec_resp->bind(':mobile', $mobile);
        $rec_resp->bind(':responce', 'YES');
        $rec_resp->bind(':reasion', 'Agreed All Agenda Items');
        $rec_resp->bind(':time', date('Y-m-d h:i:s'));

        $rec_resp->execute();

        header("location:index.php");
        
    } elseif ($_GET['resp'] == 'dis_agree') {
        if (isset($_POST['reasonbtn'])) {

            $reason = escape($_POST['reasontxt']);

            $rec_resp = new Database;
            $rec_resp->prepare("insert into tbl_resp (`emp_no`, `name`, `mobile`, `response`, `reasion`, `time_of_responce`) "
                    . "values (:emp_no, :emp_name, :mobile, :responce, :reasion, :time)");

            $rec_resp->bind(':emp_no', $emp_no);
            $rec_resp->bind(':emp_name', $emp_name);
            $rec_resp->bind(':mobile', $mobile);
            $rec_resp->bind(':responce', 'NO');
            $rec_resp->bind(':reasion', $reason);
            $rec_resp->bind(':time', date('Y-m-d h:i:s'));

            $rec_resp->execute();

            header("location:index.php");
        }
    } elseif ($_GET['resp'] == 'suggestion') {
        if (isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token']) {
            $token_age = time() - $_SESSION['token_time'];

            if ($token_age <= 300) {
                if (isset($_POST['suggesionbtn'])) {

                    $suggestion = escape($_POST['suggestiontxt']);

                    $rec_resp = new Database;
                    $rec_resp->prepare("insert into tbl_suggestions (`emp_no`, `name`, `mobile`, `suggestion`, `time_of_suggestion`) "
                            . "values (:emp_no, :emp_name, :mobile, :suggestion, :time)");

                    $rec_resp->bind(':emp_no', $emp_no);
                    $rec_resp->bind(':emp_name', $emp_name);
                    $rec_resp->bind(':mobile', $mobile);
                    $rec_resp->bind(':suggestion', $suggestion);
                    $rec_resp->bind(':time', date('Y-m-d h:i:s'));

                    $rec_resp->execute();

                    header("location:index.php");
                }
            } else {
                die('Something Went wrong');
            }
        } else {
            die('something suspesios please try again');
        }
    }
}
