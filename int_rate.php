<?php
ob_start();
session_start();
if (!isset($_SESSION['suser'])) {
    header("location:index.php");
}
include 'header.php';
?>

<table class="table table-bordered">
    <tr>
        <th colspan="3">Deposits</th>
    </tr>
    <tr>
        <td>1</td>
        <td colspan="2">Fixed Deposits</td>        
    </tr>
    <tr>
        <td></td>
        <td>i . From 90 Days to 179 Days</td>
        <td>5.5%</td>
    </tr>
    <tr>
        <td></td>
        <td>ii . From 180 Days to bellow 1 Year</td>
        <td>6.5%</td>
    </tr>
    <tr>
        <td></td>
        <td>iii . For 1 Year</td>
        <td>8.5%</td>
    </tr>
    <tr>
        <td>2</td>
        <td>Thrift Deposit</td>
        <td>9.75</td>
    </tr>
    <tr>
        <td>3</td>
        <td>Voluntary Thrift Deposit</td>
        <td>8.25</td>
    </tr>
</table>

<table class="table table-bordered">
    <tr>
        <th colspan="3">Loans</th>
    </tr>
    <tr>
        <td>1</td>
        <td>Long Term Loan</td>
        <td>10%</td>
    </tr>
    <tr>
        <td>2</td>
        <td>Medium Term Loan</td>
        <td>10%</td>
    </tr>  
</table>


<?php include 'footer.php'; ?>