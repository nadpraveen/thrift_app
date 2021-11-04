<?php

ob_start();

include 'db.php';
$file_name = date('dmy');
$myFile = $file_name . "rec.csv";
$fo = fopen($myFile, 'w') or die("can't open file");
$fetch_rec_table_qiry = "select * from rec_updates";
$fetch_rec_table = new Database;
$fetch_rec_table->query($fetch_rec_table_qiry);
$rec_data = $fetch_rec_table->resultset();
fputcsv($fo, array_keys($rec_data[0]));
foreach ($rec_data as $row) {
    fputcsv($fo, $row);
}
fclose($fo);

$update_status_query = "update rec_updates set status = 1, status_update_date = now()";
$update_status = new Database();
$update_status->query($update_status_query);

header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . basename($myFile));
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($myFile));
readfile($myFile);
exit;
