<?php
ob_start();
session_start();

include 'header_loan.php';
$user = $_GET['emp_no'];

$q = "select * from th_member_master where EMP_NO='$user'";
$get_member_data = new Database;
$get_member_data->query($q);
$member_data = $get_member_data->resultset();
foreach ($member_data as $row) {
    
}
$ename = $row['EMP_NAME'];
$fname = $user . "_pht.jpg";

$logo_absalute_path = file_get_contents('img/thlogo.jpg');
$logo = base64_encode($logo_absalute_path);

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

if (isset($_GET['file'])) {
    $file_name = "reports/" . trim($_GET['file'], "'");
}
?>
<style>
    .table-condensed>tbody>tr>td, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>td, .table-condensed>tfoot>tr>th, .table-condensed>thead>tr>td, .table-condensed>thead>tr>th
    {
        padding: 0;
    }
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
        padding: 0;
        border-top: none;
    }
    .sno{
        padding: 0px;
    }
/*    .wrap{
        margin-top: 60px;
    }*/

    .report td, th {
        border: 1px solid black;
    }

    .report {
        width: 100%;
        margin-bottom: 20px;
        border-collapse: collapse;
        font-size: 10px;
    }

    .repay_tbl{
        font-size: 10px;
    }
    @media print{
        .report{
            font-size: x-small;
        }
        .wrap{
            margin-top: 0;
        }
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="wrap">
                <table class="table" style="border: none">
                    <tr>
                        <td><img class="img-responsive" src="data:image/png;base64, <?php echo $logo ?>" width="50" height="65" alt="logo"></td>
                        <td  align="center" colspan="3"><span style="font-size: x-large; font-weight: bold">Visakhapatnam Steel Plant Employees Co-op Thrift and Credit Society Ltd.</span>

                            <p align="center">(REGD.NO.B-1918)<br>
                                <b align="center">Ukkunagaram - 530032</b></p>
                        </td>
                    </tr>
                </table>
                <table class="report">
                    <tr>
                        <td colspan="6" align="center"><span style="font-size: large"> Loan Statement</span></td>
                    </tr>
                    <?php
                    $q = "select * from th_member_master where EMP_NO='$user'";
                    $get_member_data = new Database;
                    $get_member_data->query($q);
                    $member_data = $get_member_data->resultset();
                    foreach ($member_data as $row) {
                        
                    }
                    ?>
                    <tr>
                        <th>Name of the Member</th><td><?php echo $ename ?></td>
                        <th>GL No</th><td><?php echo $row['GL_NO'] ?></td>
                        <th>Emp No</th><td><?php echo $row['EMP_NO'] ?></td>
                    </tr>
                    <tr>
                        <th>Designation</th><td><?php echo $row['DESIG'] ?></td>
                        <th>Department</th><td><?php echo $row['DEPT'] ?></td>
                    </tr>
                </table>
                <?php
                $loan_number = $_GET['loan_no'];
                $fetch_loan_data = new Database;
                $fetch_loan_data->prepare("SELECT * FROM `th_loan_master` where EMP_NO = $user AND LOAN_NO = $loan_number ORDER BY `SACTION_DATE` DESC");
                $loan_data = $fetch_loan_data->resultset();
                foreach ($loan_data as $loan_data) {
                    ?>
                    <table class="report">
                        <tr>
                            <td colspan="8" align="center"><span style="font-size: medium; padding: 0; margin: 0">Loan Sanction Details</span></td>
                        </tr>
                        <tr>
                            <th>Loan Amount</th><td> <?php echo round($loan_data['SACTIONED_AMOUNT'], 0) ?></td>
                            <th>Sanctioned Date</th><td> <?php echo date('d-m-Y', strtotime($loan_data['SACTION_DATE'])) ?></td>
                            <th>Interest Rate</th><td> <?php echo $loan_data['RATE_OF_INTREST'] ?></td>
                            <th>No. Installments</th><td> <?php echo $loan_data['INSTALLMENTS'] ?></td>

                        </tr>
                        <tr>
                            <th>Loan No</th><td><?php echo $loan_data['LOAN_NO'] ?></td>
                            <th>Old Loan Adjusted</th><td><?php echo round($loan_data['ADJ_LOAN_P'] + $loan_data['ADJ_LOAN_I'] + $loan_data['ADJ_SHR'], 0) ?></td>
                            <th>Net Amount</th><td><?php echo round($loan_data['SACTIONED_AMOUNT'] - ($loan_data['ADJ_LOAN_P'] + $loan_data['ADJ_LOAN_I'] + $loan_data['ADJ_SHR']), 0) ?> </td>
                            <th>Recovery Rate</th><td><?php echo $loan_data['REC_RATE_CUR'] ?></td>
                        </tr>
                    </table>
                    <?php
                }
                ?>
                <table class="report">
                    <tr>
                        <td colspan="3" align="center" >
                            <span style="font-size: medium">Balance as on <?php echo date('d-m-Y') ?> </span>  
                        </td>
                    </tr>
                    <tr>
                        <?php
                        if ($loan_data['LOAN_STATUS'] == 'R') {
                            ?>
                            <td>Principle Balance : <?php echo round($loan_data['CBP'], 0) ?></td>
                            <td>Interest Balance : <?php echo round($loan_data['CBI'], 0) ?></td>
                            <td>Total Balance : <?php echo round($loan_data['CBP'] + $loan_data['CBI'], 0) ?></td>
                            <?php
                        } else {
                            ?>
                            <td colspan="3"> <span style=" font-size: medium; font-weight: bold">Loan is closed on <?php echo date('d-m-Y', strtotime($loan_data['CLOSE_DATE'])) ?> </span> </td>
                            <?php
                        }
                        ?>
                    </tr>

                    </tr>
                </table>

                <table class="report repay_tbl">
                    <tr>
                        <th colspan="12">Loan Repayment Details</th>
                    </tr>
                    <tr>
                        <td>S.no</td>
                        <td>Date</td>
                        <td>Principle</td>
                        <td>Interest</td>
                        <td>S.no</td>
                        <td>Date</td>
                        <td>Principle</td>
                        <td>Interest</td>
                        <td>S.no</td>
                        <td>Date</td>
                        <td>Principle</td>
                        <td>Interest</td>
                    </tr>

                    <?php
                    $query = "SELECT * FROM `th_loan_trans` where LOAN_NO = $loan_number";
                    //echo $query;
                    $fetch_loan_trans = new Database;
                    $fetch_loan_trans->query($query);
                    $trans_count = $fetch_loan_trans->count();
                    //echo $trans_count;
                    $loan_trans = $fetch_loan_trans->resultset();
                    $row_count = count($loan_trans);
                    $itration_count = ceil($row_count / 3);
//                   $itration_count = floor($row_count / 3);
                    $k = 0;
                    for ($i = 0; $i < $itration_count; $i++) {
                        ?>
                        <tr>
                            <?php
                            for ($j = 0; $j <= 2; $j++) {
                                ?>
                                <th><?php echo $k + 1; ?></th>
                                <td><?php echo date('d-m-Y', strtotime($loan_trans[$k]['TRANS_DATE'])); ?></td>
                                <td><?php echo round($loan_trans[$k]['AMOUNTP']); ?></td>
                                <td><?php echo round($loan_trans[$k]['AMOUNTI']); ?></td>
                                <?php
                                $k++;
                                if ($k + 1 > $row_count) {
                                    break;
                                }
                            }
                            ?>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
            <div class="btn-div">
                <table class="table ">
                    <tr>
                        <td style="padding: 10px;">
                            <span class="pull-left">
                                <a href="reports.php" id="printing" class="btn btn-default">close</a>
                            </span>
                        </td>
                        <td>
                            <span class="pull-right">
                                <a href="<?php echo $file_name ?>" class="btn btn-warning">Download</a>
                            </span>
                        </td>
                    </tr>
                </table>
            </div> 
        </div>
    </div>
</div>

