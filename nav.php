<?php
ob_start();
session_start();
if (!isset($_SESSION['suser'])) {
    header("location:logout.php");
}
include 'header.php';
$error = '';
$info = '';
?>
<ul class="nav navbar-nav">
    <li class=""><a href="admin.php">Member Info</a></li>
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"> Loans
            <span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li><a href="lloan.php">Long Term Loan</a></li>
            <li><a href="slone.php">Medium Term Loan</a></li>
            <li><a href="sur_data.php">Surety Data </a></li>
        </ul>
    </li>
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"> Deposits
            <span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li><a href="td.php">Thrift Deposit</a></li>
            <li><a href="vtd.php">Voluntary Thrift Deposit </a></li>
            <li><a href="fd.php">Fixed Deposit</a></li>
            <li><a href="rb.php">Retirement Benefit Scheme</a></li>
            <li><a href="share.php">Shares</a></li>
        </ul>
    </li>
    <li class=""><a href="miscellaneous.php">Miscellaneous</a></li>
    <li class=""><a href="reports.php">Reports</a></li>
    <li class=""><a href="feedback.php">Feed Back / Suggestions</a></li>
    <!--<li class=""><a href="download_appl.php">Downloads</a></li>-->
    <li><a href="update_pass.php">Change Password</a></li>
    <li><a href="logout.php"><span style="color: red">Logout</span></a></li>
</ul>

<?php include 'footer.php'; ?>