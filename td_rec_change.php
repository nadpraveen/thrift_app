<?php
ob_start();
session_start();
if (!isset($_SESSION['suser'])) {
    header("location:index.php");
}
//if ($_SESSION['vtd_app_status'] == FALSE) {
//    echo 'Not Eligible';
//    header("location:vtd.php");
//}
$user = $_SESSION['suser'];
date_default_timezone_set('asia/kolkata');
require_once 'db.php';
require_once 'function.php';

$q = "select * from th_member_master where EMP_NO='$user'";
$get_emp_data = new Database;
$get_emp_data->prepare($q);
$result1 = $get_emp_data->resultset();
foreach ($result1 as $row) {
    $ename = $row['EMP_NAME'];
    $glno = $row['GL_NO'];
    $DOJ = date("d-M-Y", strtotime($row['DATE_OF_JOIN']));
    $desg = $row['DESIG'];
    $dep = $row['DEPT'];
    $phone = $row['PH_NO_R'];
    $max = $row['PH_NO_O'];
    $bank_account_number = $row['BANK_AC_NO'];
    $bank_name = $row['BANK_NAME'];
}


if (isset($_POST['btn_change_td'])) {
    $new_td = $_POST['new_td'];
    $present_td = $_POST['present_td'];
    $curr_date = date("d-M-Y");
    //$otp_code = $_POST['otp'];
    if ($new_td < 500) {
         header("location:td.php?st=1");
        //$error = 'Recovery Must be more thane Rs.500/-';
    } elseif ($new_td > 6000) {
         header("location:td.php?st=2");
        //$error = 'Recovery Must be less thane Rs.6000/-';
    } elseif ($new_td % 10 != 0) {
         header("location:td.php?st=3");
        //$error = 'Recovery must be in multiples of 10s';
    }
}
?>
<html>
    <head>
        <script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
        <link rel="STYLESHEET" type="text/css" href="codebase/dhtmlx.css">
        <script src="codebase/dhtmlx.js"></script>
        <script type="text/javascript">
            function hideme() {
                document.getElementById('printing').style.visibility = 'hidden';
            }

            function hideme_div() {
                document.getElementById('click').style.visibility = 'hidden';
            }
            function closewin() {
                window.close();
            }
        </script>
        <style>
            @media print{
                #close_win{
                    display: none;
                }
            }
        </style>
    </head>
    <body>
        <table style="width: 650px; margin: auto; padding: 2px">
            <tr >
                <td width="7%"><img src="img/th.png" width="80" height="100"/></td>
                <td  align="center" colspan="2"><h2>Visakhapatnam Steel Plant Employees Co-op Thrift and Credit Society Ltd.</h2>

                    <p align="center">(REGD.NO.B-1918)<br>
                        <b align="center">Ukkunagaram - 530032</b></p>
                </td>
                <td >
                    <h1 style="border: 1px solid">TD</h1>
                </td>
            </tr>
            
            <tr >
                <td colspan="2">
                    <p>To<br>
                        The Secretary<br>
                        VSPECT&CS Ltd<br>
                        Ukkunagaram - 530032<br>
                    </p>
                </td>
                <td colspan="2" align="right">
                   
                Ukkunagaram<br>
                Date:<?php echo "$curr_date" ?>
            </tr>
                </td>
            </tr>
            <tr >
                <td colspan="4">
                    <p>Sir </p>
                    <p style="text-indent: 5em"><strong>Sub:- Application for Enhancement/Reduction of Thrift Deposit Recovery</strong></p>
                </td>
            </tr>
        </table>

        <table  style="width: 650px; margin: auto; padding: 2px">
            <tr>
                <td>
                    <p style="text-indent: 3em">
                        Kindly enhance / reduce my monthly Thrift Deposit Recovery rate from <strong>Rs.<?php echo round($present_td,0) ?>/-</strong> to <strong>Rs. <?php echo $new_td ?>/-</strong> from my salary w.e.f .............. <?php echo date('Y'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <td style="text-indent: 14em">
                    Thanking You
                </td>
            </tr>
        </table>
        <br>
        <table  style="width: 650px; margin: auto; padding: 1px">
            <tr>
                <td></td><td></td><td></td><td width="50%">  </td><td>Signature</td><td>:</td><td>_________________________</td>
            </tr>
            <tr>
                <td></td><td></td><td></td><td></td><td>Name</td><td>:</td><td><?php echo'' . $ename; ?></td>
            </tr>
            <tr>
                <td></td><td></td><td></td><td></td><td>E.No</td><td>:</td><td><?php echo'' . $user; ?></td>
            </tr>
            <tr>
                <td></td><td></td><td></td><td></td><td>Designation</td><td>:</td><td><?php echo'' . $desg; ?></td>
            </tr>
            <tr>
                <td></td><td></td><td></td><td></td><td>Department</td><td>:</td><td><?php echo'' . $dep; ?></td>
            </tr>

        </table>
        <div id="click" style=" width: 60%; margin-left: auto; margin-right: auto;">
            <p align="right" style="margin-right: 30%;"><a id="printing" onclick="hideme()"   href="javascript:window.print();">Print</a></p>
            <!--<p id="close_win" style="margin-right: 30%;" onclick=" closewin();">Close</p>-->
            <p id="close_win" style="margin-right: 30%;"><a href="td.php">Back</a></p>            
        </div>


    </body>
</html>