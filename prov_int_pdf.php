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
if (isset($_POST['btnSubmit'])) {
    $trans_date = urlencode($_POST['trans_date']);
    $close_year = date('Y', strtotime($_POST['trans_date']));
    $start_year = $close_year - 1;
    $fin_year_for_file = $start_year.'-'.$close_year;
    $fin_year = urlencode($_POST['fin_year']);
}
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
$url = 'https://vspthrift.com/web_app_ver01/prov_int_statement.php?emp_no=' . $user . '&auth=' . $auth.'&type=pdf';
$output = file_get_contents($url);


require 'vendor/autoload.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

//$output = file_get_contents('https://vspthrift.com/web_app_ver01/ann_statement.php?auth=' . $auth . '&fin_year=' . $fin_year . '&trans_date=' . $trans_date);

$dompdf->loadHtml($output);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', '');

// Render the HTML as PDF
$dompdf->render();
$output = $dompdf->output();
// Output the generated PDF to Browser
//$file_name = $user . '_int_stmt';
//$dompdf->stream($file_name, array("Attachment" => 1));

$file_name = $user . '_prov_int_stmt_' . $fin_year_for_file . '.pdf';


file_put_contents('reports/' . $file_name, $output);

header("location:prov_int_statement.php?emp_no=$user&auth=$auth&file=$file_name");
?>

