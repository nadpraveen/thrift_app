<?php

ob_start();
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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

//$fin_year = '2020-2021';

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

$interest_data_query = "SELECT * FROM th_int_paid WHERE EMP_NO = $user AND FIN_YEAR = '$fin_year'";
$get_interest_data = new Database;
$get_interest_data->prepare($interest_data_query);
$interest_data = $get_interest_data->resultset();
foreach ($interest_data as $data) {
    $total = $data['TD_INT'] + $data['VTD_INT'] + $data['FD_INT'] + $data['RB_INT'] + $data['DIVIDEND_AMOUNT'] + $data['SB_AMOUNT'];
    $total_string = getStringOfAmount($total);
}
$date = date('d-M-Y');

$logo_absalute_path = file_get_contents('img/th.png');
$logo = base64_encode($logo_absalute_path);
?>

<?php

require 'vendor/autoload.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();


$output = <<<content

        <table style="width: 650px; margin: auto; padding: 2px">
            <tr >

        <td width="7%"><img src="data:image/png;base64, $logo" width="80" height="100" alt="logo" /></td>
                <td  align="center" colspan="3"><h2>Visakhapatnam Steel Plant Employees Co-op Thrift and Credit Society Ltd.</h2>

                    <p align="center">(REGD.NO.B-1918)<br>
                        <b align="center">Ukkunagaram - 530032</b></p>
                </td>
            </tr>

            <tr >
                <td colspan="4">
                    <p align="right">Date : $date </p>
                </td>
            </tr>
        </table>
        <table style="width: 650px; margin: auto; padding: 2px">
            <tr>
                <td colspan="4"><h4 align="center">Statement of amount accrued & interest paid to the following Member by the Society</h4></td>
            </tr>
            <tr>
                <td colspan="2" width="50%">Name :  $ename </td>

                <td colspan="2" width="45%">Emp No/B.No : $user </td>
            </tr>
            <tr>
                <td colspan="2" width="50%">Designation : $desg </td>
                <td colspan="2" width="45%">Department :  $dep </td>
            </tr>
            <tr>
                <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4"> The below mentioned amounts have been paid by the Society during the financial  year $fin_year </td>
            </tr>
        </table>
        <br>
        <table style="width: 650px; margin: auto; padding: 2px">
            <tr >
                <th style=" border-top: 1px solid; border-bottom: 1px solid; text-align: center;">Particulars</th>
                <th style=" border-top: 1px solid; border-bottom: 1px solid; text-align: center;">Amount (Rs.)</th>
            </tr>
                <tr>
                    <td>Interest on Thrift Deposit</td><td style="text-align: right;"> {$data['TD_INT']} </td>
                </tr>
                <tr>
                    <td>Interest on Voluntary Thrift Deposit</td><td style="text-align: right;"> {$data['VTD_INT']} </td>
                </tr>
                <tr>
                    <td>Interest on Fixed Deposit</td><td style="text-align: right;"> {$data['FD_INT']} </td>
                </tr>
                <tr>
                    <td>Interest on Retirement Benefit Fund</td><td style="text-align: right;"> {$data['RB_INT']} </td>
                </tr>
                <tr>
                    <td>Dividend</td><td style="text-align: right;"> {$data['DIVIDEND_AMOUNT']} </td>
                </tr>

                <tr>
                    <td align="center" style="border-bottom: 1px solid"><strong>Total</strong></td>
                    <td style="border-top: 1px solid; border-bottom: 1px solid;text-align: right;"><strong> $total</strong></td>
                </tr>
                <tr>
                    <td>
                        <br>
                        Rs. $total_string   only
                    </td>
                </tr>
        </table>
content;

$dompdf->loadHtml($output);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', '');

// Render the HTML as PDF
$dompdf->render();

$output = $dompdf->output();

// Output the generated PDF to Browser
$file_name = $user . '_int_stmt';
file_put_contents($file_name.'.pdf', $output);
//$dompdf->stream($file_name, array("Attachment" => 1));
?>