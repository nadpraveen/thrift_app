<?php
ob_start();
session_start();
if (!isset($_SESSION['suser'])) {
    echo('please login');
    header("location:index.php");
} else {
    $user = $_SESSION['suser'];
    require_once 'db.php';
    $q = "select * from th_member_master where EMP_NO='$user'";
    $get_member_data = new Database;
    $get_member_data->query($q);
    $member_data = $get_member_data->resultset();
    foreach ($member_data as $row) {
        
    }
    $ename = $row['EMP_NAME'];
    $fname = $user . "_pht.jpg";

    include 'header.php';
    ?>


    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div style="margin-top: 10%">
                    <table class="table" style="border: none">
                        <tr >
                            <td><img class="img-responsive" src="img/th.png" width="80" height="100"/></td>
                            <td  align="center" colspan="3"><h4>Visakhapatnam Steel Plant Employees Co-op Thrift and Credit Society Ltd.</h4>

                                <p align="center">(REGD.NO.B-1918)<br>
                                    <b align="center">Ukkunagaram - 530032</b></p>
                            </td>
                        </tr>
                    </table>
                    <table class="table table-bordered">
                        <tr>
                            <td colspan="6" align="center"><h5> Loan Statement</h5></td>
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
                            <td>Name of Member</td><td><?php echo $ename ?></td>
                            <td>GL No</td><td><?php echo $row['GL_NO'] ?></td>
                            <td>Emp No</td><td><?php echo $row['EMP_NO'] ?></td>
                        </tr>
                        <tr>
                            <td>Designation</td><td><?php echo $row['DESIG'] ?></td>
                            <td>Designation</td><td><?php echo $row['DEPT'] ?></td>
                        </tr>
                    </table>
                    <?php
                    $loan_number = $_GET['loan_no'];
                    $fetch_loan_data = new Database;
                    $fetch_loan_data->prepare("SELECT * FROM `th_ed_loan_master` where EMP_NO = $user AND LOAN_NO = $loan_number ORDER BY `SACTION_DATE` DESC");
                    $loan_data = $fetch_loan_data->resultset();
                    foreach ($loan_data as $loan_data) {
                        ?>
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="8" align="center"> <h5>Loan Sanction Details</h5></td>
                            </tr>
                            <tr>
                                <td>Loan Amount</td><td> <?php echo $loan_data['SACTIONED_AMOUNT'] ?></td>
                                <td>Sanctioned Date</td><td> <?php echo date('d-m-Y', strtotime($loan_data['SACTION_DATE'])) ?></td>
                                <td>Interest</td><td> <?php echo $loan_data['RATE_OF_INTREST'] ?></td>
                                <td>Installments</td><td> <?php echo $loan_data['INSTALLMENTS'] ?></td>

                            </tr>
                            <tr>
                                <td>Loan No</td><td><?php echo $loan_data['LOAN_NO'] ?></td>
                                <td>Old Loan Adjusted</td><td><?php echo $loan_data['LOAN_NO'] ?></td>
                                <td>Net Amount</td><td><?php echo $loan_data['ADJ_LOAN_P'] + $loan_data['ADJ_LOAN_I'] + $loan_data['ADJ_SHR'] ?></td>
                                <td>Recovery</td><td><?php echo $loan_data['REC_RATE'] ?></td>
                            </tr>
                        </table>

                        <?php
                    }
                    ?>


                    <table class="table table-bordered">
                        <tr>
                            <td colspan="3" align="center" >
                                <h5>Balance as on <?php echo date('d-m-Y') ?> </h5>  
                            </td>
                        <tr>
                            <?php
                            if ($loan_data['LOAN_STATUS'] == 'R') {
                                ?>
                                <td>Principle Balance : <?php echo $loan_data['CBP'] ?></td>
                                <td>Interest Balance : <?php echo $loan_data['CBI'] ?></td>
                                <td>Interest Balance : <?php echo $loan_data['CBP'] + $loan_data['CBI'] ?></td>
                                <?php
                            } else {
                                ?>
                                <td colspan="3"> <h6>Loan is closed on <?php echo date('d-m-Y', strtotime($loan_data['CLOSE_DATE'])) ?> </h6> </td>
                                <?php
                            }
                            ?>
                        </tr>

                        </tr>
                    </table>



                    <div class="col-md-12" align="center"> 
                        <h4>Loan Repayment Details</h4>
                    </div>
                    <div class="col-md-4 col-print-4" >
                        <div class="col-md-1 col-print-1" style="border: 1px solid"><strong>S.NO</strong></div>
                        <div class="col-md-4 col-print-4" style="border: 1px solid"><strong>Date</strong></div>
                        <div class="col-md-3 col-print-3" style="border: 1px solid"><strong>Princple</strong></div>
                        <div class="col-md-3 col-print-3" style="border: 1px solid"><strong>Interest</strong></div>
                    </div>
                    <div class="col-md-4 col-print-4" >
                        <div class="col-md-1 col-print-1" style="border: 1px solid"><strong>S.NO</strong></div>
                        <div class="col-md-4 col-print-4" style="border: 1px solid"><strong>Date</strong></div>
                        <div class="col-md-3 col-print-3" style="border: 1px solid"><strong>Princple</strong></div>
                        <div class="col-md-3 col-print-3" style="border: 1px solid"><strong>Interest</strong></div>
                    </div>
                    <div class="col-md-4 col-print-4" >
                        <div class="col-md-1 col-print-1" style="border: 1px solid"><strong>S.NO</strong></div>
                        <div class="col-md-4 col-print-4" style="border: 1px solid"><strong>Date</strong></div>
                        <div class="col-md-3 col-print-3" style="border: 1px solid"><strong>Princple</strong></div>
                        <div class="col-md-3 col-print-3" style="border: 1px solid"><strong>Interest</strong></div>
                    </div>

                    <?php
                    $query = "SELECT * FROM `th_edl_trans` where LOAN_NO = $loan_number";
                    //echo $query;
                    $fetch_loan_trans = new Database;
                    $fetch_loan_trans->query($query);
                    $trans_count = $fetch_loan_trans->count();
                    //echo $trans_count;
                    $loan_trans = $fetch_loan_trans->resultset();
                    $i = 0;
                    foreach ($loan_trans as $loan_trans) {
                        $i = $i + 1;
                        ?>
                        <div class="col-md-4 col-print-4" >
                            <div class="col-md-1 col-print-1" style="border: 1px solid"><?php echo $i ?></div>
                            <div class="col-md-4 col-print-4" style="border: 1px solid"><?php echo date('d-m-Y', strtotime($loan_trans['TRANS_DATE'])) ?></div>
                            <div class="col-md-3 col-print-3" style="border: 1px solid"><?php echo $loan_trans['AMOUNTP'] ?></div>
                            <div class="col-md-3 col-print-3" style="border: 1px solid"><?php echo $loan_trans['AMOUNTI'] ?></div>
                        </div>

                        <?php
                    }
                    ?>

                    <div class="col-md-12" style="margin-top: 15px">
                        <div class="col-md-6">
                            Date : <?php echo date('d-m-Y') ?>
                        </div>
                        <div class="col-md-6" align="right">
                            <p>
                                For VSP Employees Coop- Thrift & Credit
                                <br>
                                Society Ltd.
                            </p>
                            <br>
                            <br>
                            <br>
                            <br>
                            <script type="text/javascript">
                                function hideme() {
                                    document.getElementById('printing').style.visibility = 'hidden';
                                }

                                function hideme_div() {
                                    document.getElementById('click').style.visibility = 'hidden';
                                }
                            </script>
                            <div id="click">
                                <p align="right" style="margin-right: 30%;"><a id="printing" onclick="hideme(), closewin();"   href="javascript:window.print();">Print</a></p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}