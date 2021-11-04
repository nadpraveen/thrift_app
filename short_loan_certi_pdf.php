<?php

ob_start();
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION['suser'])) {
    echo('please login');
    header("location:../index.php");
}
$user = $_SESSION['suser'];
require_once 'db.php';
include 'function.php';
$loan_no = $_GET['loan_no'];
$user = $_SESSION['suser'];

$get_auth_code = new Database;
$get_auth_code->query("select * from pass_master where EMP_NO = " . $user);
$auth_count = $get_auth_code->count();
if ($auth_count > 0) {
    $auth_code = $get_auth_code->resultset();
    foreach ($auth_code as $auth_code) {
        $auth = $auth_code['auth_code'];
    }
}
$url = 'https://vspthrift.com/web_app_ver01/short_loan_certi.php?emp_no=' . $user . '&auth=' . $auth . '&loan_no=' . $loan_no . '&type=pdf';
//$output = file_get_contents('https://vspthrift.com/web_app_ver01/loan_certi.php?auth=' . $auth . '&fin_year=' . $fin_year.'&trans_date='.$trans_date);

require 'vendor/autoload.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();
//$dompdf->set_base_path("lib/bootstrap/css/");


$output = file_get_contents($url);

$dompdf->loadHtml($output);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', '');

// Render the HTML as PDF
$dompdf->render();

$output = $dompdf->output();

// Output the generated PDF to Server
$file_name = $user . '_med_term_loan_stmt_' . $loan_no . '.pdf';


file_put_contents('reports/' . $file_name, $output);

header("location:short_loan_certi.php?emp_no=$user&auth=$auth&loan_no=$loan_no&file=$file_name");

// Output the generated PDF to Browser
//$dompdf->stream($file_name, array("Attachment" => 1));
?>