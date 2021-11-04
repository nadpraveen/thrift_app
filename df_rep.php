<?php
ob_start();
session_start();
if (!isset($_SESSION['suser'])) {
    header("location:logout.php");
}
include 'header.php';

if (isset($_POST['btn_date'])) {
    $year = $_POST['year'];
    $month = $_POST['month'];
} else {
    $month = date('m');
    $year = date('Y');
}
$query = "SELECT count(*) as total_count FROM th_death_fund_master where month(CLAIM_SENT_DATE) = $month and year(CLAIM_SENT_DATE) = $year";
$df_count = new Database;
$df_count->query($query);
$count = $df_count->resultset();
if ($count[0]['total_count'] == 0) {
    if ($month == 1) {
        $year = $year - 1;
    } else {
        $year = $year;
    }
    $month = $month - 1;
}
$date_obj = DateTime::createFromFormat('!m', $month);
$month_name = $date_obj->format('F');
?>
<div class="row">
    <div class="col-md-12">
        <form method="post" action="">
            <div class="col-md-3">
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <select class="form-control" name="year">
                        <option value="">Select year</option>
                        <?php
                        $feth_year = new Database;
                        $feth_year->query("SELECT distinct year(CLAIM_SENT_DATE) as year FROM th_death_fund_master order by CLAIM_SENT_DATE desc");
                        $year_fetch = $feth_year->resultset();
                        foreach ($year_fetch as $year_fetch) {
                            if ($year_fetch['year'] >= 2010) {
                                ?>
                                <option value="<?php echo $year_fetch['year'] ?>"><?php echo $year_fetch['year']; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <select class="form-control" name="month">
                        <option value="">Select Month</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <input type="submit" name="btn_date" class="btn btn-primary" value="Search">
                </div>
            </div>
        </form>
    </div>
    <br>
    <div class="col-md-12 text-center alert" style="padding: 10px;  background-color: green">
        <h3 style="color: white;">Death Fund Recovery Details for the month of <?php echo $month_name . ' ' . $year ?> </h3>
    </div>
    <?php include 'table_slide.php'; ?>
    <div class="col-md-12 table-responsive">
        <table class="table table-bordered">
            <tr>
                <th>S.no</th>
                <th>Name</th>
                <th>Emp no</th>
                <th>Dept</th>
                <th>Design</th>
                <th>Date of Death</th>
                <th>Amount</th>
                <th>Photo</th>
            </tr>

            <?php
            $i = 1;
            $get_df_data = new Database;
            $get_df_data->query("SELECT * FROM th_death_fund_master where month(CLAIM_SENT_DATE) = $month and year(CLAIM_SENT_DATE) = $year and CLAIM_SENT = 'Y' order by CLAIM_SENT_DATE desc ");
            $df_data_count = $get_df_data->count();
            if ($df_data_count > 0) {
                $df_data = $get_df_data->resultset();
                foreach ($df_data as $data) {
                    ?>
                    <tr>
                        <td><?php echo $i++ ?></td>
                        <td><?php echo $data['EMP_NAME'] ?></td>
                        <td><?php echo $data['EMP_NO'] ?></td>
                        <?php
                        $get_emp_data = new Database;
                        $get_emp_data->query("select * from th_member_master where EMP_NO = " . $data['EMP_NO']);
                        $emp_data = $get_emp_data->resultset();
                        foreach ($emp_data as $emp_data) {
                            
                        }
                        ?>
                        <td><?php echo $emp_data['DEPT']; ?></td>
                        <td><?php echo $emp_data['DESIG']; ?></td>
                        <td>
                            <?php
                            $get_death_date = new Database;
                            $get_death_date->query("select SEPARTION_DATE from th_sbf where EMP_NO = " . $data['EMP_NO']);
                            $death_date = $get_death_date->resultset();
                            foreach ($death_date as $date) {
                                echo date('d - M - Y', strtotime($date['SEPARTION_DATE']));
                            }
                            ?>
                        </td>
                        <td><?php echo round($data['DF_REC']) ?>/-</td>
                        <td><img src="user_img/<?php echo $data['EMP_NO'] ?>_pht.jpg" alt="<?php echo $data['EMP_NO'] ?> Photo not avilable" width="75" class="img-responsiv"></td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="8" align="center"><h5>Please select Valid Month and Year</h5></td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>

</div>

<?php include 'footer.php'; ?>