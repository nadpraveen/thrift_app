<?php
ob_start();
session_start();
if (!isset($_SESSION['suser'])) {
    echo 'please login';
    header("location:index.php");
}
header("location:vtd.php");
//if ($_SESSION['vtd_app_status'] == FALSE) {
//    echo 'Not Eligible';
//    header("location:vtd.php");  
//}
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
    $bank_account_number = $row['BANK_AC_NO'];
    $bank_name = $row['BANK_NAME'];
}

$q2 = "select * from th_vtd_master where EMP_NO='$user' ";
$get_td_data = new Database;
$get_td_data->query($q2);
$result2 = $get_td_data->resultset();
foreach ($result2 as $row) {
    $cb = round($row['CLOSE_BAL'],0);
    $elg_amt = round($cb,0);
    $rec_rate = round($row['RECOVERY_RATE'],0);
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
        </script>

    </head>
    <body align="center">
        <form action="vtd_withdraw_form.php" method="post" style=" margin-left: 30%; margin-top: 5%;">
            <table >
                <td colspan="2">
                    <?php
                    if (isset($_GET['st'])) {
                        $status = $_GET['st'];
                        if ($status == 0) {
                            echo "<b style='color:red'>Amount Required must be below or equel to eligible amount  </b>";
                        }
                        if ($status == 1) {
                            echo "<b style='color:red'>Please enter any value for required amount </b>";
                        }
                        if ($status == 2) {
                            echo "<b style='color:red'>Please enter value in multiples of 100s </b>";
                        }
                    }
                    ?>
                    <hr style="opacity: 0.4;"/>
                </td>
                <tr>
                    <td>Name:</td><td><?php echo'' . $ename; ?></td>
                </tr>
                <tr>
                    <td>Emp No:</td><td><?php echo'' . $user; ?></td>
                </tr>
                <tr>
                    <td>Total amount :</td><td><?php echo'' . $cb; ?></td>
                </tr>
                <tr>
                    <td>Eligible withdrawal amount:</td><td><?php echo'' . round($elg_amt); ?></td>
                </tr>
                <tr>
                    <td>Account number:</td><td><?php echo $bank_account_number?></td>
                </tr>
                <tr>
                    <td>Bank name:</td><td><?php echo $bank_name ?><span style="color: red"> (Note: Amount will be credited to this bank account after processing)</span></td>
                </tr>
                <tr>
                    <td>Amount Required:</td><td><input type="text" name="txtamount" class="textfield" value="" id="extra7"  onkeypress="return isNumber(event)" /></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="btnSubmit" value="Submit" style="float: left" ><input type="reset" name="reset" value="reset" style="float: right"></td>
                </tr>
                <tr>
                    <td colspan="3" width="20px"><p style="color: red" >Note : This is not an online submission. Member has to take print out of the application and submit the same at Society office,failing which the application can't be processed for payment.</p></td>
                </tr>
            </table>
        </form>
    </body>
</html>

