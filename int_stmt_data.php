<?php
ob_start();
session_start();
if (!isset($_SESSION['suser'])) {
    echo('please login');
    header("location:../index.php");
}
$user = $_SESSION['suser'];
require_once 'db.php';
include 'function.php';
if (isset($_POST['btnSubmit'])) {
    $fin_year = $_POST['fin_year'];
}

$q = "select * from th_member_master where EMP_NO='$user'";
$member_data = new Database;
$member_data->query($q);
$result1 = $member_data->resultset();
foreach ($result1 as $row) {
    $ename = $row['EMP_NAME'];
    $glno = $row['GL_NO'];
    $DOJ = $row['DATE_OF_JOIN'];
    $desg = $row['DESIG'];
    $dep = $row['DEPT'];
    $phone = $row['PH_NO_R'];
    $max = $row['PH_NO_O'];
}
?>

<html>
    <head>
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
                #click{
                    display: none;
                }
            }
        </style>
    </head>
    <body>
        <table style="width: 650px; margin: auto; padding: 2px">
            <tr >
                <td width="7%"><img src="img/th.png" width="80" height="100"/></td>
                <td  align="center" colspan="3"><h2>Visakhapatnam Steel Plant Employees Co-op Thrift and Credit Society Ltd.</h2>

                    <p align="center">(REGD.NO.B-1918)<br>
                        <b align="center">Ukkunagaram - 530032</b></p>
                </td>
            </tr>

            <tr >
                <td colspan="4">
                    <p align="right">Date : <?php echo date('d-M-Y'); ?></p>
                </td>
            </tr>
        </table>

        <table style="width: 650px; margin: auto; padding: 2px">
            <tr>
                <td colspan="4"><h4 align="center">Statement of amount accrued & interest paid to the following Member by the Society</h4></td>
            </tr>
            <tr>
                <td colspan="2" width="50%">Name : <?php echo'' . $ename; ?></td>

                <td colspan="2" width="45%">Emp No/B.No : <?php echo'' . $user; ?></td>

            </tr>

            <tr>
                <td colspan="2" width="50%">Designation : <?php echo'' . $desg; ?></td>
                <td colspan="2" width="45%">Department : <?php echo'' . $dep; ?></td>

            </tr>
            <tr>
                <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4"> The below mentioned amounts have been paid by the Society during the financial  year  <?php echo $fin_year ?></td>
            </tr>
        </table>
        <br>
        <table style="width: 650px; margin: auto; padding: 2px">
            <tr >
                <th style=" border-top: 1px solid; border-bottom: 1px solid; text-align: center;">Particulars</th>
                <th style=" border-top: 1px solid; border-bottom: 1px solid; text-align: center;">Amount (Rs.)</th>
            </tr>
            <?php
            $interest_data_query = "SELECT * FROM th_int_paid WHERE EMP_NO = $user AND FIN_YEAR = '$fin_year'";
            $get_interest_data = new Database;
            $get_interest_data->prepare($interest_data_query);
            $interest_data = $get_interest_data->resultset();
            foreach ($interest_data as $data) {
                $total = $data['TD_INT'] + $data['VTD_INT'] + $data['FD_INT'] + $data['RB_INT'] + $data['DIVIDEND_AMOUNT'] + $data['SB_AMOUNT'];
                ?>
                <tr>
                    <td>Interest on Thrift Deposit</td><td style="text-align: right;"><?php echo $data['TD_INT'] ?></td>
                </tr>
                <tr>
                    <td>Interest on Voluntary Thrift Deposit</td><td style="text-align: right;"><?php echo $data['VTD_INT'] ?></td>
                </tr>
                <tr>
                    <td>Interest on Fixed Deposit</td><td style="text-align: right;"><?php echo $data['FD_INT'] ?></td>
                </tr>
                <tr>
                    <td>Interest on Retirement Benefit Fund</td><td style="text-align: right;"><?php echo $data['RB_INT'] ?></td>
                </tr>
                <tr>
                    <td>Dividend</td><td style="text-align: right;"><?php echo $data['DIVIDEND_AMOUNT'] ?></td>
                </tr>
    <!--                <tr>
                    <td>Superanuation Benifit Fund</td><td style="text-align: right;"><?php echo $data['SB_AMOUNT'] ?></td>
                </tr>-->
                <tr>
                    <td align="center" style="border-bottom: 1px solid"><strong>Total</strong></td>
                    <td style="border-top: 1px solid; border-bottom: 1px solid;text-align: right;"><strong><?php echo $total; ?></strong></td>
                </tr>
                <tr>
                    <td>
                        <br>
                        Rs. <?php echo getStringOfAmount($total) ?> only
                    </td>
                </tr>
                <?php
            }
            ?>

        </table>

        <br>
        <table  style="width: 650px; margin: auto; padding: 1px">


        </table>

        <div id="click">
            <span align="right" style="margin-left: 30%;
                  margin-right: 30%;"><a id="printing" onclick="hideme()"   href="javascript:window.print();">Print</a></span>
            <span align="left"><a href="#" id="printing" onclick="closewin();">close</a></span>
        </div>


    </body>
</html>