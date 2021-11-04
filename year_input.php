<?php
ob_start();
session_start();
if (!isset($_SESSION['suser'])) {
    echo('please login');
    header("location:../index.php");
}
$user = $_SESSION['suser'];
require_once 'db.php';
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

<html>
    <head>

        <script language="javascript" type="text/javascript">
<!--
            function popitup(url) {
                newwindow = window.open(url, 'name', 'height=300,width=500,scrollbars=1').style.overflow = 'auto';
                if (window.focus) {
                    newwindow.focus()
                }
                return false;
            }

// -->
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

    </head>
    <body align="center">
        <form action="ann_stmt_2.php" method="post" style=" margin-left: 30%; margin-top: 5%;">
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
                        
                        <select name="trans_date" required>
                            <option value="">--Select Year--</option>
                            <?php
                            $query = "SELECT TRANS_DATE_1 FROM thrift.th_members_ob_cb_data where EMP_NO1 = $user";
                            $get_year_list = new Database;
                            $get_year_list->prepare($query);
                            $year_list = $get_year_list->resultset();
                            foreach ($year_list as $year) {
                                $year_in = date('Y',strtotime($year['TRANS_DATE_1']));
                                $prev_year = $year_in - 1;
                                echo $year['TRANS_DATE_1'];
                                ?>
                                <option value="<?php echo $year['TRANS_DATE_1'] ?>"><?php echo $prev_year.' - '.$year_in ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <input type="hidden" value="<?php echo $prev_year.' - '.$year_in ?>" name="fin_year">
                    </td>
                </tr>          

                <tr>
                    <td><input type="submit" class="rep_input" name="btnSubmit" value="Submit" style="float: left" ></td>
                    <td><input type="submit" value="Close" style="float: right" onclick="return closewin();" ></td>
                </tr>

            </table>
        </form>

    </body>
</html>

