<?php
ob_start();
session_start();
if (!isset($_SESSION['suser'])) {
    header("location:logout.php");
}
include 'header.php';
?>

<div class="col-md-12 table-responsive">

    <?php
    $query = "select * from th_fixed_deposit where emp_no='$user'and FD_STATUS='R'";
    $get_fd_data = new Database;
    $get_fd_data->query($query);
    $count = $get_fd_data->count();
    if ($count > 0) {
        ?>
        <h5> Deposit Information</h5>
        <?php include 'table_slide.php'; ?>
        <table class="table table-bordered">
            <tr>
                <th>FD Account</th>
                <th>Date of Deposit</th>
                <th>Amount</th>  
                <th>Period</th>
                <th>Maturity Date </th>     
                <th>Maturity Amount </th>     
                <th>Interest Rate </th>  
            </tr>
            <?php
            $fd_data = $get_fd_data->resultset();
            foreach ($fd_data as $row) {
                $fd_ac_no = $row['FD_AC_NO'];
                $fd_date = DATE('d-M-Y', strtotime($row['FD_DATE']));
                $fd_amount = round($row['FD_AMMOUNT'], 0);
                $fd_period = $row['FD_PERIOD'];
                $fd_close_date = date('d-M-Y', strtotime($row['DUE_DATE']));
                $fd_met_amiunt = round($row['MATURITY_AMOUNT'], 0);
                $fd_int_rate = $row['INT_RATE'] . '%';
                ?>

                <tr>
                    <td><?php echo $fd_ac_no ?></td>
                    <td><?php echo $fd_date ?></td>
                    <td><?php echo $fd_amount ?></td>
                    <td><?php echo $fd_period; ?></td>
                    <td><?php echo $fd_close_date ?></td>
                    <td><?php echo $fd_met_amiunt ?></td>
                    <td><?php echo $fd_int_rate ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
    } else {
        echo '<h5 align="center">You don\'t have any Deposits in this Scheme</h5>';
    }
    ?>
</div>
</div>
</div>
</div>
</div>

<?php include 'footer.php'; ?>