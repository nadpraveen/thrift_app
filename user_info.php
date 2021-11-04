<?php
$q = "select * from th_member_master where EMP_NO='$user'";
    $get_member_data = new Database;
    $get_member_data->query($q);
    $member_data = $get_member_data->resultset();
    foreach ($member_data as $row) {
        $ename = $row['EMP_NAME'];
        
        $gl_no = $row['GL_NO'];
        $DOJ = $row['DATE_OF_JOIN'];
        $bank_account_number = $row['BANK_AC_NO'];
        $bank_name = substr($row['BANK_NAME'], 12);
    }
    
    $reg_data = new Database;
    $reg_date_query = "SELECT * FROM `reg_user` where EMP_NO = '$user'";
    $reg_data->query($reg_date_query);
    $reg_user_data = $reg_data->resultset();
    foreach ($reg_user_data as $user_data){
       $phone = $user_data['Mobile'];
        $email = $user_data['Email']; 
    }
