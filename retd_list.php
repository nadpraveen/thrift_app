<?php
$file_data = file_get_contents("http://ess.vspsite.org/monthly_plan/previous_month_retirements.jsp");
$file = explode('<tr>', $file_data);
$list = implode(",", $file);
print_r($list);
