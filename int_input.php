<?php
ob_start();
session_start();
include 'header.php';
if (!isset($_SESSION['suser'])) {
    echo('please login');
    header("location:../index.php");
}
$user = $_SESSION['suser'];
$q = "select * from th_member_master where EMP_NO='$user'";
$member_data = new Database;
$member_data->query($q);
$result1 = $member_data->resultset();
foreach ($result1 as $row) {
    $ename = $row['EMP_NAME'];
    $glno = $row['GL_NO'];
    $DOJ = $row['DATE_OF_JOIN'];
}
?>

<script language="javascript" type="text/javascript">
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function closewin() {
        window.close();
    }
</script>
<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12 col-sm-12">
            <form action="int_statement_pdf.php" method="post" style=" margin-left: 15%; margin-top: 5%;">
                <?php
                $curr_month = date("m", time());
                if ($curr_month > 3) {
                    $year1 = intval(date('Y'));
                    $year2 = $year1 + 1;
                    //echo $year1;
                } elseif ($curr_month <= 3) {
                    $year1 = intval(date('Y') - 1);
                    $year2 = $year1 + 1;
                    //echo $year1;
                }
                $prov_year = $year1 . '-' . $year2;
                ?>
                <table >
                    <tr>
                        <td>Name:</td><td><?php echo'' . $ename; ?></td>
                    </tr>
                    <tr>
                        <td>Emp No:</td><td><?php echo'' . $user; ?></td>
                    </tr>
                    <tr>
                        <td>Select Year</td>
                        <td>
                            <select name="fin_year" required>
                                <option value="">--Select Year--</option>
                                <?php
                                $query = "SELECT FIN_YEAR FROM th_int_paid WHERE EMP_NO = $user and FIN_YEAR < '$prov_year' order by FIN_YEAR desc";
                                $get_year_list = new Database;
                                $get_year_list->prepare($query);
                                $year_list = $get_year_list->resultset();
                                foreach ($year_list as $year) {
                                    ?>
                                    <option value="<?php echo $year['FIN_YEAR'] ?>"><?php echo $year['FIN_YEAR'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>          
                    <tr>
                        <td colspan="2"> &nbsp;</td>
                    </tr>
                    <tr>
                        <td><input type="submit" class="rep_input" name="btnSubmit" value="Submit" style="float: left" ></td>
                        <td><a href="reports.php" class="btn btn-default" style="float: right">Close</a></td>
                    </tr>

                </table>
            </form>
        </div>
    </div>
</div>