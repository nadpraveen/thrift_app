<?php
ob_start();
session_start();
if (!isset($_SESSION['suser'])) {
    header("location:index.php");
}
include 'header.php';

$get_feed_back_reply_query = "SELECT * FROM `feed_back_reply` where reply_to = $user and read_status = 'N'";
$get_feed_back_reply = new Database;
$get_feed_back_reply->query($get_feed_back_reply_query);
$reply_count = $get_feed_back_reply->count();
if ($reply_count > 0) {
    ?>
    <div class="alert alert-warning">
        You have Received replay for your Feedback/Suggestion.<a href="feedback.php"> Click Here to read</a>
    </div>
    <?php
}
?>
<?php
if (isset($_GET['add_msg'])) {
    if ($_GET['add_msg'] == 'success') {
        ?>
        <div class="row">
            <div class="alert alert-success">
                Address Updated Successfully.
            </div>
        </div>
        <?php
    }
}
?>

<div class="row">
    <div class="col-md-12 col-xs-12 col-sm-12 text-center">
        <?php
        if (file_exists("user_img/$fname")) {
            ?>
            <img class="img-responsiv img-thumbnail" src="user_img/<?php echo $fname ?>" style="height: 13vh" />
            <?php
        } else {
            ?>
            <div class="col-md-12 col-sm-12 col-xs-12">
                photo not found please upload. <br>
                Use Recent Color Passport Size Photo only in JPEG formate and size should be less thane 2MB
                <br>
                <form action='upcode.php' method='post' enctype='multipart/form-data'>
                    <input type='file' name='file'>
                    <br>
                    <input type='submit' name='submit' value='upload'>
                </form>
            </div>
            <?php
        }
        ?>

    </div>
</div>

<?php
$query = "select * from th_member_master where emp_no='$user'";
$get_member_info = new Database;
$get_member_info->query($query);
$result = $get_member_info->resultset();
foreach ($result as $row) {
    $empno = $row['EMP_NO'];
    $name = $row['EMP_NAME'];
    $dep = $row['DEPT'];
    $desg = $row['DESIG'];
    $dob = date('d-M-Y', strtotime($row["DOB"]));
    $phone = $row['PH_NO_R'];
    //$email = $row['EMAIL_ID'];
    ?>
    <style>
        #einfo tr td:nth-child(1) {
            color: brown;
            font-weight: bold;
        }
    </style>
    <div id="edata" style="padding: 5px;" >
        <?php
        if (isset($_GET['email_update'])) {
            if ($_GET['email_update'] == 'success') {
                ?>
                <div class="alert alert-success">
                    Email Updates Successfully
                </div>
                <?php
            }
        }
        ?>
        <table class="table table-striped" id="einfo" >
            <tr>
                <td>GL No</td>
                <td style="padding: 5px;"><?php
                    echo $row['GL_NO'];
                    ?>
                </td> 
            </tr>
            <tr>
                <td>Name</td><td><?php echo $name; ?></td>
            </tr>
            <tr>
                <td>Department</td><td><?php echo $dep; ?></td>
            </tr>
            <tr>
                <td>Designation</td><td><?php echo $desg; ?></td> 
            </tr> 
            <tr>
                <td>Phone</td><td><?php
                    if ($phone == '') {
                        ?>
                        <a href="documents/address updation form.pdf" target="_blank">Click Here</a> to download mobile number updation form
                        <?php
                    } else {
                        echo $phone;
                    }
                    ?></td>
            </tr>    
            <tr>
                <td>Email</td><td><?php
                    $get_email = new Database;
                    $get_email->prepare("select * from email_master where EMP_NO = $user");
                    $email_id = $get_email->resultset();
                    foreach ($email_id as $email_id) {
                        $email = $email_id['EMAIL_ID'];
                    }
                    if ($email == '') {
                        if ($ub != 'IE') {
                            ?>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#update_email">
                                Update Email
                            </button>
                            <?php
                        } else {
                            ?>
                            <a href="documents/address updation form.pdf" target="_blank">Click Here</a> to download mobile number updation form
                            <?php
                        }
                        if (isset($_POST['btn_update_email'])) {
                            $new_email = $_POST['email'];
                            $update_email = new Database;
                            $update_email->query("insert into email_master values($user,'$new_email')");
                            header("location:admin.php?email_update=success");
                        }
                        ?>
                        <?php
                        if ($ub != 'IE') {
                            ?>
                            <div class="modal fade" id="update_email" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Update Email</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="">
                                                <div class=" form-group">
                                                    <input name="email" type="email" placeholder="EMAIL" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="submit" name="btn_update_email" value="Update Email" class="btn btn-info">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <?php
                        }
                        ?>

                        <?php
                    } else {
                        echo $email;
                    }
                    ?></td>
            </tr>
            <tr>
                <td>Date of Joining in Society</td><td><?php
                    $date_of_joining = date('d-m-Y', strtotime($row['DATE_OF_JOIN']));
                    echo $date_of_joining
                    ?></td>
            </tr>
            <tr>
                <?php
                if (trim($row['NOMIN_NAME1']) != '' || trim($row['NOMIN_NAME1']) != NULL || strlen(trim($row['NOMIN_NAME1'])) != 0) {
                    ?>
                    <td>Nominee</td><td><?php echo ucwords($row['NOMIN_NAME1']); ?>, <?php echo $row['NOMIN1_RELATION'] ?> </td>
                    <?php
                } else {
                    ?>
                    <td colspan="2">Nomination not available Please visit the Society office to update Nomination</td>
                    <?php
                }
                ?>
            </tr>            
            <?php
            $chk_address = new Database;
            $chk_address->query("select * from address_data where EMP_NO = $user");
            $address_count = $chk_address->count();
            if ($address_count > 0) {
                if ($ub != 'IE') {
                    ?>
                    <tr>
                        <td>Address</td>
                        <td>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#address_modl">
                                View
                            </button>
                        </td>
                    </tr>

                    <?php
                }
            }
        }
        ?>
    </table>
    <?php
    if ($ub != 'IE') {
        ?>
        <div class="modal fade" id="address_modl" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Address</h4>
                    </div>
                    <div class="modal-body">

                        <table class="table table-bordered">
                            <tr>
                                <th>Present Address</th>
                                <th>Permanent Address</th>
                            </tr>
                            <?php
                            $address = $chk_address->resultset();
                            foreach ($address as $address) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo strtoupper($address['d_no']) ?>,<br>
                                        <?php echo strtoupper($address['street']) ?>,<br>
                                        <?php echo strtoupper($address['area']) ?>,<br>
                                        <?php echo strtoupper($address['city']) ?>,<br>
                                        <?php echo strtoupper($address['district']) ?>,<br>
                                        <?php echo strtoupper($address['state']) ?>,<br>
                                        <?php echo strtoupper($address['pin']) ?>
                                    </td>
                                    <td>
                                        <?php echo strtoupper($address['p_d_no']) ?>,<br>
                                        <?php echo strtoupper($address['p_street']) ?>,<br>
                                        <?php echo strtoupper($address['p_area']) ?>,<br>
                                        <?php echo strtoupper($address['p_city']) ?>,<br>
                                        <?php echo strtoupper($address['p_district']) ?>,<br>
                                        <?php echo strtoupper($address['p_state']) ?>,<br>
                                        <?php echo strtoupper($address['p_pin']) ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>                                
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
        <?php
    }
    ?>
    <?php
    if ($row['TDS_CONSENT_NO'] == '') {
        ?>
        <div class=" alert alert-danger">
            you have not given TDS consent so far. <a href="documents/tds concent.pdf" target="_blank">Click Here</a> to download consent form. 
        </div>
        <?php
    }
    ?>
</div>
</div>
</div>
</div>
<div class="row">
    <?php
    $chk_address = new Database;
    $chk_address->query("select * from address_data where EMP_NO = $user");
    $address_count = $chk_address->count();
    if ($address_count == 0) {
        ?>
        <div class="alert alert-warning">
            Please update your address <a href="add_update.php">Click Here</a>
        </div>
        <?php
    } else {
        
    }
    ?>
</div>

</div>
<?php include 'footer.php'; ?>