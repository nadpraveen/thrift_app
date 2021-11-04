<?php
ob_start();
session_start();
if (!isset($_SESSION['suser'])) {
    header("location:logout.php");
}
include 'header.php';
?>

<div class="row">
    <div class="col-md-12" style="margin-top: 25px">
        <?php
        $get_fd_data = new Database;
        $get_fd_data->query("SELECT * FROM `th_fixed_deposit` where EMP_NO = $user and FD_STATUS = 'R' ORDER BY FD_DATE DESC");
        $fd_count = $get_fd_data->count();
        if ($fd_count > 0) {
            $fd_data = $get_fd_data->resultset();
            ?>
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#active_fd" aria-expanded="false" aria-controls="collapseExample">
                Active FD
            </button>
            <div class="collapse" id="active_fd" style="margin-top: 50px">
                <table class="table table-bordered">
                    <tr>
                        <th>FD No</th>
                        <?php
                        for ($i = 1; $i <= $fd_count; $i++) {
                            ?>
                            <th><?php echo $fd_data[$i - 1]['FD_AC_NO']; ?></th>
                            <?php
                        }
                        ?>
                    </tr>
                    <tr>
                        <th>Date of Deposit</th>
                        <?php
                        for ($i = 1; $i <= $fd_count; $i++) {
                            ?>
                            <td><?php echo date('d-m-Y', strtotime($fd_data[$i - 1]['FD_DATE'])); ?></td>
                            <?php
                        }
                        ?>
                    </tr>
                    <tr>
                        <th>Amount</th>
                        <?php
                        for ($i = 1; $i <= $fd_count; $i++) {
                            ?>
                            <td><?php echo round($fd_data[$i - 1]['FD_AMMOUNT']); ?></td>
                            <?php
                        }
                        ?>
                    </tr>
                    <tr>
                        <th>Period</th>
                        <?php
                        for ($i = 1; $i <= $fd_count; $i++) {
                            ?>
                            <td><?php echo $fd_data[$i - 1]['FD_PERIOD']; ?></td>
                            <?php
                        }
                        ?>
                    </tr>
                    <tr>
                        <th>Interest Rate</th>
                        <?php
                        for ($i = 1; $i <= $fd_count; $i++) {
                            ?>
                            <td><?php echo $fd_data[$i - 1]['INT_RATE']; ?></td>
                            <?php
                        }
                        ?>
                    </tr>
                    <tr>
                        <th>Due Date</th>
                        <?php
                        for ($i = 1; $i <= $fd_count; $i++) {
                            ?>
                            <td><?php echo date('d-m-Y', strtotime($fd_data[$i - 1]['DUE_DATE'])); ?></td>
                            <?php
                        }
                        ?>
                    </tr>
                    <tr>
                        <th>Maturity Amount</th>
                        <?php
                        for ($i = 1; $i <= $fd_count; $i++) {
                            ?>
                            <td><?php echo round($fd_data[$i - 1]['MATURITY_AMOUNT']); ?></td>
                            <?php
                        }
                        ?>
                    </tr>                            
                </table>
            </div>
            <?php
        } else {
            ?>
            <div class="alert alert-info">
                You don't have any FD.
            </div>
            <?php
        }

        $emp_no = $_POST['emp_no'];
        $get_fd_data = new Database;
        $get_fd_data->query("SELECT * FROM `th_fixed_deposit` where EMP_NO = $user and FD_STATUS = 'C' ORDER BY FD_DATE DESC");
        $fd_count = $get_fd_data->count();
        if ($fd_count > 0) {
            $fd_data = $get_fd_data->resultset();
            ?>
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#closed_fd" aria-expanded="false" aria-controls="collapseExample">
                Closed FD
            </button>
            <div class="collapse table-responsive" id="closed_fd" style="margin-top: 50px">
                <table class="table table-bordered">
                    <tr>
                        <th>FD No</th>
                        <?php
                        for ($i = 1; $i <= $fd_count; $i++) {
                            ?>
                            <th><?php echo $fd_data[$i - 1]['FD_AC_NO']; ?></th>
                            <?php
                        }
                        ?>
                    </tr>
                    <tr>
                        <th>Date of Deposit</th>
                        <?php
                        for ($i = 1; $i <= $fd_count; $i++) {
                            ?>
                            <td><?php echo date('d-m-Y', strtotime($fd_data[$i - 1]['FD_DATE'])); ?></td>
                            <?php
                        }
                        ?>
                    </tr>
                    <tr>
                        <th>Amount</th>
                        <?php
                        for ($i = 1; $i <= $fd_count; $i++) {
                            ?>
                            <td><?php echo round($fd_data[$i - 1]['FD_AMMOUNT']); ?></td>
                            <?php
                        }
                        ?>
                    </tr>
                    <tr>
                        <th>Period</th>
                        <?php
                        for ($i = 1; $i <= $fd_count; $i++) {
                            ?>
                            <td><?php echo $fd_data[$i - 1]['FD_PERIOD']; ?></td>
                            <?php
                        }
                        ?>
                    </tr>
                    <tr>
                        <th>Interest Rate</th>
                        <?php
                        for ($i = 1; $i <= $fd_count; $i++) {
                            ?>
                            <td><?php echo $fd_data[$i - 1]['INT_RATE']; ?></td>
                            <?php
                        }
                        ?>
                    </tr>
                    <tr>
                        <th>Due Date</th>
                        <?php
                        for ($i = 1; $i <= $fd_count; $i++) {
                            ?>
                            <td><?php echo date('d-m-Y', strtotime($fd_data[$i - 1]['DUE_DATE'])); ?></td>
                            <?php
                        }
                        ?>
                    </tr>
                    <tr>
                        <th>Maturity Amount</th>
                        <?php
                        for ($i = 1; $i <= $fd_count; $i++) {
                            ?>
                            <td><?php echo round($fd_data[$i - 1]['MATURITY_AMOUNT']); ?></td>
                            <?php
                        }
                        ?>
                    </tr>
                    <tr>
                        <th>Refunded on</th>
                        <?php
                        for ($i = 1; $i <= $fd_count; $i++) {
                            ?>
                            <td><?php echo date('d-m-Y', strtotime($fd_data[$i - 1]['REFUND_DATE'])); ?></td>
                            <?php
                        }
                        ?>
                    </tr>
                    <tr>
                        <th>Refunded Amount</th>
                        <?php
                        for ($i = 1; $i <= $fd_count; $i++) {
                            ?>
                            <td><?php echo round($fd_data[$i - 1]['REFUND_AMOUNT']); ?></td>
                            <?php
                        }
                        ?>
                    </tr>
                </table>
            </div>
            <?php
        } else {
            ?>
            <div class="alert alert-info">
                You Don't have any Closed FD
            </div>
            <?php
        }
        ?>

    </div>
</div>
</div>
</div>
</div>
</div>

<?php include 'footer.php'; ?>