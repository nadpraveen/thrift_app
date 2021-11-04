<?php
ob_start();
session_start();
include 'header.php';
if (!isset($_SESSION['suser'])) {
    echo('please login');
    header("location:index.php");
} else {
    $user = $_SESSION['suser'];

    $q = "select * from th_member_master where EMP_NO='$user'";
    $get_member_data = new Database;
    $get_member_data->query($q);
    $member_data = $get_member_data->resultset();
    foreach ($member_data as $row) {
        
    }
    $ename = $row['EMP_NAME'];
    $fname = $user . "_pht.jpg";
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="article" style="margin-top: 6%">
                <div class="panel-heading">
                    <h3 class="panel-title"> <?php echo"welcome  " . $ename . ", " . $user . " - - Applications"; ?></h3>
                </div>
                <h5 style="color: red">Please print on plain A4 size white paper only</h5>
                <?php
                $get_applications = new Database;
                $get_applications->query("select * from application order by date DESC");
                $application_count = $get_applications->count();
                if ($application_count == 0) {
                    echo 'No Circulers Yet';
                } else {
                    ?>
                    <style>
                        table tr th{
                            color: green;
                        }
                    </style>
                    <table class="table">
                        <tr>
                            <th>Description</th>
                            <th>Link</th>
                        </tr>
                        <?php
                        $applications = $get_applications->resultset();
                        foreach ($applications as $application) {
                            ?>
                            <tr>
                                <td><?php echo $application['description'] ?></td>
                                <td><a href="<?php echo $application['link'] ?>" target="_blank">View</a></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>

</div>
<?php include 'footer.php'; ?>