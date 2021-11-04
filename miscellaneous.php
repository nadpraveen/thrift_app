<?php
ob_start();
session_start();
if (!isset($_SESSION['suser'])) {
    header("location:index.php");
}
include 'header.php';
?>

</div>
</div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table">
<!--                <tr>
                <td>Bye Law of the Society</td>
                <td><a href="documents/BYELAWS.pdf" target="_blank">View</a></td>
            </tr>-->
            <tr>
                <td>Death Fund Recovery Details</td>
                <td><a href="df_rep.php">View</a></td>
            </tr>
            <tr>
                <td>Rate of Interests</td>
                <td><a href="int_rate.php">View</a></td>
            </tr>
            <tr>
                <td>EMI Calculator</td>
                <td><a href="emi_table.php">View</a></td>
            </tr>
            <tr>
                <td>EMI Recovery Charts</td>
                <td><a href="documents/Loan EMI Tabl.pdf" target="_blank">Download</a></td>
            </tr>
            <tr>
                <td>Important Telephone Numbers</td>
                <td><a href="documents/2018 Pocket Book.pdf" target="_blank">Download</a></td>
            </tr>

        </table>
    </div>
</div>
</div>
<?php include 'footer.php'; ?>