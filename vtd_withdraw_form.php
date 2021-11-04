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
    $bank_name = $row['BANKNAME_OLD'];
}

$q2 = "select * from th_vtd_master where EMP_NO='$user' ";
$get_td_data = new Database;
$get_td_data->prepare($q2);
$result2 = $get_td_data->resultset();
foreach ($result2 as $row) {
    $cb = round($row['CLOSE_BAL'], 0);
    $elg_amt = round($cb, 0);
    $rec_rate = round($row['RECOVERY_RATE'], 0);
    $curr_date = date("d-M-Y");
}
$query = "SELECT * FROM `th_vtd_trans` WHERE EMP_NO = $user AND TYPE_OF_TRANS = 'P' ORDER BY TRANS_DATE DESC limit 1 ";
$get_prev_withdraw_date = new Database;
$get_prev_withdraw_date->prepare($query);
$prev_withdraw_date = $get_prev_withdraw_date->resultset();
foreach ($prev_withdraw_date as $row) {
    $prev_with_date = date("d-M-Y", strtotime($row['TRANS_DATE']));
}


if (isset($_POST['btn_withdraw_vtd'])) {
    $amount_required = $_POST['amt_required'];
    if ($amount_required == NULL) {
        header("location:vtd_withdraw.php?st=1");
    }
    if ($amount_required > $elg_amt) {
        header("location:vtd_withdraw.php?st=0");
    }
    if ($amount_required % 100 == !0) {
        header("location:vtd_withdraw.php?st=2");
    }
}else{
    header("location:vtd.php");
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
                    <h1 style="border: 1px solid">VTD</h1>
                </td>
            </tr>
            <tr >
                <td colspan="4" align="center"><b>WITHDRAWAL APPLICATION FOR VOLUNTARY THRIFT DEPOSIT</b></td>
            </tr>
            <tr >
                <td colspan="4">
                    <p>To<br>
                        The Secretary<br>
                        VSPECT&CS Ltd<br>
                        Ukkunagaram - 530032<br>
                    </p>
                </td>
            </tr>
            <tr >
                <td colspan="4">
                    <p>Sir <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; I hereby apply for withdrawal of amount from my Thrift Deposit of the society. The particulers are furnished below</p></td>
            </tr>
        </table>

        <table  style="width: 650px; margin: auto; padding: 2px">
            <tr>
                <td style=" width: 1px">1</td><td width="25%">Gl No</td><td width="1">:</td><td width="70%" ><?php echo'' . $glno; ?></td>
            </tr>
            <tr>
                <td style=" width: 1px">2</td><td width="25%">Name</td><td width="1">:</td><td width="70%" ><?php echo'' . $ename; ?></td>
            </tr>
            <tr>
                <td style=" width: 1px">3</td><td width="25%">Emp No</td><td width="1">:</td><td width="70%" ><?php echo'' . $user; ?></td>
            </tr>

            <tr>
                <td style=" width: 1px">4</td><td width="25%">Department</td><td width="1">:</td><td width="70%" ><?php echo'' . $dep; ?></td>
            </tr>


            <tr>
                <td style=" width: 1px">5</td><td width="25%">Mobile No</td><td width="1">:</td><td width="70%" ><?php echo'' . $phone; ?></td>
            </tr>
            <tr>
                <td style=" width: 1px"></td><td width="25%">MAX No</td><td width="1">:</td><td width="70%" ><?php echo'' . $max; ?></td>
            </tr>
            <tr>
                <td style=" width: 1px">6</td><td width="25%">Date of joining in the Society</td><td width="1">:</td><td width="70%" ><?php echo'' . $DOJ; ?></td>
            </tr>
            <tr>
                <td style=" width: 1px">7</td><td width="25%">Monthly Contribution of Thrift Deposit</td><td width="1">:</td><td width="70%" ><?php echo'' . round($rec_rate, 0); ?>/-</td>
            </tr>
            <tr>
                <td style=" width: 1px">8</td><td width="20%">Amount of withdrawal</td><td width="1">:</td><td width="70%" ><?php
                    echo'<b>' . $amount_required . '/-</b>';
                    echo "&nbsp";
                    echo"(Rupees " . getStringOfAmount($amount_required) . " Only)";
                    ?></td>
            </tr>
            <tr>
<!--                <td style=" width: 1px">9</td><td width="25%">Date of previous withdrawal (if any)</td><td width="1">:</td><td width="70%" >
                    <?php
//                    if ($row['TRANS_DATE'] = '') {
//                        echo '---';
//                    } else {
//                        echo $prev_with_date;
//                    }
                    ?>
                </td>-->
            </tr>
            <tr>
                <td style=" width: 1px">10</td><td width="25%">Bank Details</td><td width="1">:</td><td width="70%" ><?php echo $bank_account_number . ',<small>' . $bank_name.'</small>' ?></td>
            </tr>
            <tr>
                <td colspan="4" align="left">
                    <p> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;I agree to abide by the rules and regulations of the society governing the withdrawals from thrift deposit to the members.</p>
                </td>
            </tr>
        </table>
        <br>
        <table  style="width: 650px; margin: auto; padding: 1px">
            <tr>
                <td>Place</td><td>:</td><td>Ukkunagaram</td><td width="25%">  </td><td>Signature</td><td>:</td><td>_________________________</td>
            </tr>
            <tr>
                <td>Date</td><td>:</td><td><?php echo "$curr_date" ?></td><td></td><td>Name</td><td>:</td><td><?php echo'' . $ename; ?></td>
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
        <table  style="width: 650px; margin: auto; padding: 2px">
            <tr>
                <td colspan="2"><hr></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><b> FOR OFFICE USE ONLY</b> </td>
            </tr>
            <tr>
                <td>1.</td><td>Total Thrift Deposit Amount  Rs. .....................................  as on .......................  </td>

            </tr>
            <tr>
                <td>2.</td><td>Eligible for Withdraw Rs..............................................................................  </td>
            </tr>
            <tr>
                <td>3.</td><td>Amount Sanctioned  Rs....................................................................................</td>
            </tr>
            <tr>
                <td colspan="2">&nbsp; </td>
            </tr>
            <tr>
                <td colspan="2" align="right"> SECRETARY</td>
            </tr>
        </table>
        <div id="click">
            <p align="right" style="margin-right: 30%;"><a id="printing" onclick="hideme()"   href="javascript:window.print();">Print</a></p>
            <p onclick=" closewin();">Close</p>
        </div>


    </body>
</html>