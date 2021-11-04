<?php
ob_start();
session_start();
if (!isset($_SESSION['suser'])) {
    header("location:index.php");
}
include 'header.php';
?>

<?php include 'table_slide.php'; ?>
<div class="col-md-12 table-responsive">    
    <h5> Long Term Loan :</h5>
    <table class="table table-bordered">
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
        $query = "SELECT * FROM `th_loan_master` WHERE (SURITY1 = $user OR SURITY2 = $user OR SURITY3 = $user) and LOAN_STATUS = 'R' ORDER BY `LOAN_NO` ASC";
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
        ?>

        <?php
        $get_pending_loan_sur_query = "SELECT * FROM `th_loan_register` WHERE SURITY1 = $user OR SURITY2 = $user OR SURITY3 = $user ";
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
<br>
<hr>
<?php include 'table_slide.php'; ?>
<div class="col-md-12 table-responsive">
    <h5> Medium Term Loan :</h5>    
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
        $query = "SELECT * FROM `th_ed_loan_master` WHERE (SURITY1 = $user OR SURITY2 = $user) AND LOAN_STATUS = 'R' ORDER BY `LOAN_NO` ASC";
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
        $get_pending_loan_sur_query = "SELECT * FROM `th_edl_register` WHERE SURITY1 = $user OR SURITY2 = $user";
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
</div>
</div>
</div>

<?php include 'footer.php'; ?>