<?php
ob_start();
session_start();
if (!isset($_SESSION['suser'])) {
    header("location:index.php");
}
include 'header.php';
?>

<div class="col-md-6">
    <h5> Balance Information</h5>
    <table class="table table-bordered" >
        <?php
        $query = "select * from th_share_master where emp_no='$user'";
        $get_share_data = new Database;
        $get_share_data->query($query);
        $result = $get_share_data->resultset();
        foreach ($result as $row) {
            $ob = round($row['OPEN_BAL'], 0);
            $recp = round($row['PRG_RECEIPTS'], 0);
            $payment = round($row['PRG_PAYMENTS'], 0);
            $cb = round($row['CLOSE_BAL'], 0);
            ?>
            <tr>
                <td><strong>Opening Balance</strong></td><td><?php echo $ob; ?></td></tr>
            <tr>
                <td><strong>Closing Balance</strong></td><td><?php echo $cb; ?></td>
            </tr>
            <tr>
                <td><strong>Receipts</strong></td><td><?php echo $recp; ?></td>
            </tr>
            <tr>
                <td><strong>Payments</strong></td><td><?php echo $payment; ?></td> 
            </tr> 
            <?php
        }
        ?>
    </table >
</div>

<div class="col-md-6">
    <h5> Transaction</h5>
    <div id="trans_div">
        <table class="table table-bordered">
            <tr>
                <th>Date</th>
                <th>Amount</th>
            </tr>
            <?php
            $query2 = "select * from th_share_trans where emp_no='$user' order by TRANS_DATE DESC";
            $get_share_trans = new Database;
            $get_share_trans->query($query2);
            $count = $get_share_trans->count();


            if ($count > 0) {
                $result2 = $get_share_trans->resultset();
                foreach ($result2 as $row) {
                    $date = date('d-M-Y', strtotime($row['TRANS_DATE']));
                    $amount = round($row['AMOUNT'], 0);
                    ?>
                    <tr>
                        <td><?php echo $date ?></td>
                        <td><?php echo $amount; ?></td>
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
</div>
</div>
</div>
</div>



</div>

<?php include 'footer.php'; ?>