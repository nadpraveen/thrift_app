<?php

//vtd eligibility

?>
<div class="row">
        <div class="col-md-12" style="margin-top: 10px">

            <?php
            if ($opt_count > 0) {
                $query3 = "select * from th_vtd_register where emp_no='$user'";
                $get_vtd_registration_data = new Database;
                $get_vtd_registration_data->query($query3);
                $count = $get_vtd_registration_data->count();

                if ($count > 0) {
                    $_SESSION['vtd_app_status'] = FALSE;
                    $result3 = $get_vtd_registration_data->resultset();
                    foreach ($result3 as $row2) {
                        $app_amount = round($row2['APPLIED_AMOUNT'],0);
                        $reg_date = date('d-M-Y', strtotime($row2['REGISTRATION_DATE']));
                        echo"<br>";
                        echo "<h5 style='margin-left: 5%'>you have applaied for Withdrawal of Rs.$app_amount/-  on $reg_date</h5>";
                    }
                } else {
                    $curr_month = date("m", time());
                    //echo $curr_month;
                    if ($curr_month > 3) {
                        $year1 = intval(date('Y'));
                        $date1 = date('Y-m-d', strtotime('04/01/' . $year1));
                        $year2 = intval(date('Y') + 1);
                        $date2 = date('Y-m-d', strtotime('03/31/' . $year2));
                        //echo $date1 . ',' . $date2;
                    } elseif ($curr_month <= 3) {
                        $year1 = intval(date('Y') - 1);
                        $date1 = date('Y-m-d', strtotime('01/04/' . $year1));
                        $year2 = intval(date('Y'));
                        $date2 = date('Y-m-d', strtotime('31/03/' . $year2));
                        //echo $date1 . ',' . $date2;
                    }
                    $cheak_eligibility = new Database;
                    $query = "SELECT * FROM `th_vtd_trans` WHERE EMP_NO = $user AND TYPE_OF_TRANS = 'P' AND TRANS_DATE >= $date1 AND TRANS_DATE <= $date2";
                    //echo $query;
                    $cheak_eligibility->query($query);
                    //print_r($cheak_eligibility);
                    $withdraw_count = $cheak_eligibility->count();
                    if ($withdraw_count >= 2) {
                        $_SESSION['vtd_app_status'] = FALSE;
                        echo"<h3>You have alredy withdraw 2 times in this financial yaer </h3>";
                    } else {
                        ?>
                        <h3>You are eligible for withdrawal <a href="vtd_withdraw.php" target="_blank">click here </a> for withdrawal form</h3>
                        <?php
                    }
                }
            }
            ?>
        </div>  
    </div>

