<?php
ob_start();
session_start();
include 'header_report.php';

$user = $_GET['emp_no'];
$auth_code = $_GET['auth'];
if (date('m') > 3) {
    $year2 = date('Y') + 1;
    $fin_year = date('Y') . '-' . $year2;
} else if (date('m') <= 3) {
    $year2 = date('Y') - 1;
    $fin_year = $year2 . '-' . date('Y');
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

if (isset($_GET['file'])) {
    $file_name = "reports/" . trim($_GET['file'], "'");
}

$logo_absalute_path = file_get_contents('img/th.png');
$logo = base64_encode($logo_absalute_path);

$verify_auth_code = new Database;
$verify_auth_code->query("select * from pass_master where EMP_NO = $user and auth_code = '$auth_code'");
$auth_count = $verify_auth_code->count();
if ($auth_count == 0) {
    die('Not Authrised to access');
}

if (isset($_GET['type'])) {
    if ($_GET['type'] == 'pdf') {
        ?>
        <style>
            .btn-div{
                display: none;
            }
        </style>
        <?php
    }
}
?>
<style>
    .btn{
        margin: 20px;
    }

    @media print{
        .btn{
            display: none;
        }
    }
</style>
<table style="width: 100%; margin: auto; padding: 2px">
    <tr>
        <td width="15%"><img class=" img-responsiv" src="data:image/png;base64, <?php echo $logo ?>" width="50" height="70" alt="logo"/></td>
        <td  align="center" colspan="3">
            <span style="font-size: 20px;line-height: 35px;font-weight: bold;">Visakhapatnam Steel Plant Employees Co-op Thrift and Credit Society Ltd.</span>
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

<table style="width: 100%; margin: auto; padding: 2px">
    <tr>
        <td>
            Dear Member,<br>
            As Per the income tax Act 1961, the interest paid/accrued on deposit is a taxable income and may be declared by you as other income. The details of projected interest paid/ to be paid to you
            by the society for the Financial Year <?php echo $fin_year ?> is as follows.
        </td> 
    </tr>
</table>
<br>
<table style="width: 100%; margin: auto; padding: 2px">
    <tr >
        <th style=" border-top: 1px solid; border-bottom: 1px solid; text-align: center;">T.D</th>
        <th style=" border-top: 1px solid; border-bottom: 1px solid; text-align: center;">V.T.D</th>
        <th style=" border-top: 1px solid; border-bottom: 1px solid; text-align: center;">F.D</th>
        <th style=" border-top: 1px solid; border-bottom: 1px solid; text-align: center;">R.B Fund</th>
        <th style=" border-top: 1px solid; border-bottom: 1px solid; text-align: center;">Dividend</th>
        <th style=" border-top: 1px solid; border-bottom: 1px solid; text-align: center;">TOTAL</th>
    </tr>
    <?php
    $interest_data_query = "SELECT * FROM th_int_paid WHERE EMP_NO = $user AND FIN_YEAR = '$fin_year'";
    $get_interest_data = new Database;
    $get_interest_data->query($interest_data_query);
    $data_count = $get_interest_data->count();
    if ($data_count > 0) {
        $interest_data = $get_interest_data->resultset();
        foreach ($interest_data as $data) {
            $total = $data['TD_INT'] + $data['VTD_INT'] + $data['FD_INT'] + $data['RB_INT'] + $data['DIVIDEND_AMOUNT'];
            ?>
            <tr>
                <td style="text-align: center;"><?php echo $data['TD_INT'] ?></td>

                <td style="text-align: center;"><?php echo $data['VTD_INT'] ?></td>

                <td style="text-align: center;"><?php echo $data['FD_INT'] ?></td>

                <td style="text-align: center;"><?php echo $data['RB_INT'] ?></td>

                <td style="text-align: center;"><?php echo $data['DIVIDEND_AMOUNT'] ?></td>

                <td style="text-align: center;"><strong><?php echo $total; ?></strong></td>
            </tr>
            <tr>
                <td colspan="6">

                </td>
            </tr>
            <tr>
                <td colspan="6">
                    Rs. <?php echo getStringOfAmount($total) ?> only
                </td>
            </tr>
            <?php
        }
    }
    ?>

</table>

<br>
<table  style="width: 100%; margin: auto; padding: 1px">
    <tr>
        <td>
            Note: The above interests are calculated on the basis of actual recoveries and withdrawals of your TD, VTD considered upto 18/10/2021 
            and for remaining it is assumes that same recoveries will continue and no more withdrawals will be made in remaining period.
        </td>
    </tr>
</table>
<div class="btn-div" style="margin-left: auto; margin-right: auto; width: auto">
    <button class="btn"><a href="reports.php" id="printing">close</a></button>
    <br>
    <button class="btn"><a href="<?php echo $file_name ?>">Download</a></button>
</div>
</body>
</html>