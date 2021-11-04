<?php
ob_start();
session_start();
if (!isset($_SESSION['suser'])) {
    header("location:logout.php");
}
include 'header.php';
?>

<div class="col-md-6">

    <?php
    $query = "select * from th_ret_ben where emp_no='$user'";
    $get_rb_data = new Database;
    $get_rb_data->query($query);
    $count = $get_rb_data->count();
    if ($count > 0) {
        ?>
        <h5> Balance Information</h5>
        <table class="table table-bordered">
            <tr>
                <th>Opening Balance  </th>
                <th>Closing Balance</th>
            </tr>
            <?php
            $result = $get_rb_data->resultset();
            foreach ($result as $row) {
                $ob = round($row['OPEN_BAL'], 0);
                $cb = round($row['CLOSE_BAL'], 0);
                ?>
                <tr>
                    <td><?php echo $ob ?></td>
                    <td><?php echo $cb ?></td>
                </tr>
                <?php
            }
            ?>
        </table >
        <?php
    } else {
        echo '<h5 align="center">You Have not opted for this scheme</h5>';
    }
    ?>
</div>

<div class="col-md-6">
    <h5>Transaction</h5>
    <table class="table table-bordered">
        <tr>
            <th width="100px">Date</th>
            <th width="100px">Amount</th>
        </tr>
    </table>
    <?php
    $query2 = "select * from th_ret_ben_trans where emp_no='$user' order by TRANS_DATE DESC";
    $get_rb_trans = new Database;
    $get_rb_trans->query($query2);
    $count = $get_rb_trans->count();
    ?>
    <div class="scroll">
        <table class="table table-bordered">
            <?php
            if ($count > 0) {
                $result2 = $get_rb_trans->resultset();
                foreach ($result2 as $row) {
                    $date = date("d-M-Y", strtotime($row['TRANS_DATE']));
                    $amount = round($row['AMOUNT'], 0);
                    ?>

                    <tr>
                        <td width="100px"><?php echo $date ?></td>
                        <td width="100px"><?php echo $amount; ?></td>

                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='2'>No Record Found</td></tr>";
            }
            ?>
        </table>
    </div>
</div>

<?php include 'footer.php'; ?>