<?php
ob_start();
session_start();
if (!isset($_SESSION['suser'])) {
    header("location:index.php");
}
include 'header.php';
?>


<div class="row">
    <div class="col-md-12">
        <table class="table">
            <tr>
                <td>Annual Report</td><td><a href="state_input.php">view</a></td>
            </tr>
<!--            <tr>
                <td>Provisional Interest Statement</td><td><a href="prov_int_pdf.php">view</a></td>
            </tr>-->
            <?php
            if (date('m') > 3) {
                $year2 = date('Y') + 1;
                $fin_year = date('Y') . '-' . $year2;
            } else if (date('m') <= 3) {
                $year2 = date('Y') - 1;
                $fin_year = $year2 . '-' . date('Y');
            }
            $chk_provi_int_query = "SELECT * FROM th_int_paid WHERE EMP_NO = $user AND FIN_YEAR = '$fin_year'";
            $chk_provi_int = new Database;
            $chk_provi_int->query($chk_provi_int_query);
            $res_count = $chk_provi_int->count();
            if ($res_count > 0) {
                ?>
            <tr>
                <td>Provisional Interest Statement</td><td><a href="prov_int_pdf.php">view</a></td>
            </tr>
                <?php
            }
            ?>
            <tr>
                <td>Interest Statement</td><td><a href="int_input.php">view</a></td>
            </tr>
            <tr>
                <td>Surety Loan - Running/Closed loans list</td><td><a href="#" data-toggle="modal" data-target="#myModal1" target="_blank">view</a></td>
            </tr>
            <tr>
                <td>Medium Term Loan - Running/Closed loans list</td><td><a href="#" data-toggle="modal" data-target="#myModal2" target="_blank">view</a></td>
            </tr>
        </table>

        <div id="myModal1" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Loans List</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Loan Number</th>
                                <th>Loan Amount</th>
                                <th>Loan Date</th>
                                <th>Loan Balance</th>
                                <th>Closed Date</th>
                            </tr>

                            <?php
                            $loan_list_query = "SELECT * FROM `th_loan_master` WHERE EMP_NO = $user ORDER BY `SACTION_DATE` DESC";
                            $get_all_loan_data = new Database;
                            $get_all_loan_data->prepare($loan_list_query);
                            $all_loan_data = $get_all_loan_data->resultset();
                            foreach ($all_loan_data as $data) {
                                $sanction_date = date('d-m-Y', strtotime($data['SACTION_DATE']))
                                ?>
                                <tr>
                                    <td><a href="loan_cert_pdf.php?loan_no=<?php echo $data['LOAN_NO'] ?>"><?php echo $data['LOAN_NO'] ?></a></td>
                                    <td><?php echo $data['SACTIONED_AMOUNT'] ?></td>
                                    <td><?php echo $sanction_date ?></td>
                                    <td><?php echo $data['CBP'] + $data['CBI'] ?></td>
                                    <?php
                                    if ($data['LOAN_STATUS'] == 'C') {
                                        ?>
                                        <td><?php echo date('d-m-Y', strtotime($data['CLOSE_DATE'])) ?></td>
                                        <?php
                                    } else {
                                        ?>
                                        <td>Active</td>
                                        <?php
                                    }
                                    ?>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>

        <div id="myModal2" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Loans List</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Loan Number</th>
                                <th>Loan Amount</th>
                                <th>Loan Date</th>
                                <th>Loan Balance</th>
                                <th>Closed Date</th>
                            </tr>

                            <?php
                            $loan_list_query = "SELECT * FROM `th_ed_loan_master` WHERE EMP_NO = $user ORDER BY `SACTION_DATE` DESC";
                            $get_all_loan_data = new Database;
                            $get_all_loan_data->prepare($loan_list_query);
                            $all_loan_data = $get_all_loan_data->resultset();
                            foreach ($all_loan_data as $data) {
                                $sanction_date = date('d-m-Y', strtotime($data['SACTION_DATE']))
                                ?>
                                <tr>
                                    <td><a href="short_loan_certi_pdf.php?loan_no=<?php echo $data['LOAN_NO'] ?>" target="_blank"><?php echo $data['LOAN_NO'] ?></a></td>
                                    <td><?php echo $data['SACTIONED_AMOUNT'] ?></td>
                                    <td><?php echo $sanction_date ?></td>
                                    <td><?php echo $data['CBP'] + $data['CBI'] ?></td>
                                    <?php
                                    if ($data['LOAN_STATUS'] == 'C') {
                                        ?>
                                        <td><?php echo date('d-m-Y', strtotime($data['CLOSE_DATE'])) ?></td>
                                        <?php
                                    } else {
                                        ?>
                                        <td>Active</td>
                                        <?php
                                    }
                                    ?>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
</div>
<?php include 'footer.php'; ?>