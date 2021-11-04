<?php
ob_start();
include 'header.php';
//session_start();
global $input_emp;
$input_emp = '';
$error = [];
if (isset($_POST['btn_get_data'])) {
    $input_emp = $_POST['emp_no'];
}
?>

<style>
    input:not([type="email"]){
        text-transform: uppercase;
    }
    .table-condensed>tbody>tr>td, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>td, .table-condensed>tfoot>tr>th, .table-condensed>thead>tr>td, .table-condensed>thead>tr>th
    {
        padding: 0;
    }
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
        padding: 0;
        border-top: none;
    }
    .sno{
        padding: 0px;
    }
    .wrap{
        margin-top: 60px;
    }
    .headding{
        display: none;
    }
    ol li{
        font-size: 12px;
    }
    @media print{
        .report{
            font-size: x-small;
        }
        .headding{
            display: block;
        }
        /*        .article{
                    padding: 0;
                }*/
        .area-padding {
            padding: 0;
        }
    }

</style>

<div class="about-area area-padding">
    <div class="container">
        <div class="row">


            <div class="panel-heading hidden-print">
                <h3 class="panel-title"> New User Registration </h3>
            </div>

            <div class="col-md-12 hidden-print">
                <div class=" alert alert-danger" id="alert_div">

                </div>
                <?php
                if (!empty($error)) {
                    ?>

                    <?php
                }
                ?>
            </div>
            <div class="col-md-12" id="info_div">
                <?php
                if (!isset($_GET['page'])) {
                    ?>
                    <div class="col-md-6 col-md-offset-3" id="input_div">
                        <strong>Enter Your Employee Number</strong>
                        <form method="POST" action="">
                            <div class="form-group">
                                <input class="form-control" placeholder="EMP NO" type="text" name="emp_no" id="emp_no" onkeypress="return isNumber(event)" required
                                       value="<?php echo $input_emp ?>"> 
                            </div>
                            <!--                            <div class="form-group">
                                                            <input class="form-control" placeholder="Mobile No" type="text" name="Phone_No" onkeypress="return isNumber(event)" required> 
                                                        </div>-->
                            <div class="form-group">
                                <input class="form-control btn btn-success" type="submit" name="btn_get_data" value="Proced">
                            </div>
                        </form>
                    </div>
                    <?php
                    if (isset($_POST['btn_get_data'])) {
                        $input_emp = $_POST['emp_no'];

//                            $input_mobile = $_POST['Phone_No'];
                        $fetch_emp_data = new Database;
                        $fetch_emp_data_query = "select * from th_member_master where EMP_NO = $input_emp ";
                        $fetch_emp_data->query($fetch_emp_data_query);
                        $emp_count = $fetch_emp_data->count();
                        if ($emp_count > 0) {
                            $emp_data = $fetch_emp_data->resultset();
                            foreach ($emp_data as $data) {
                                if ($data['MEMBER_STATUS'] == 'R') {
                                    $chk_existing_password = new Database;
                                    $chk_existing_password_query = "select * from pass_word where EMP_NO = $input_emp";
                                    $chk_existing_password->query($chk_existing_password_query);
                                    $pass_count = $chk_existing_password->count();
                                    if ($pass_count == 0) {
                                        $cheak_existing_registraion = new Database;
                                        $cheak_existing_registraion->query("select * from reg_user where EMP_NO = $input_emp and Status = 'N' ");
                                        $reg_count = $cheak_existing_registraion->count();
                                        if ($reg_count == 0) {
                                            ?>

                                            <div class="col-md-6 col-md-offset-3">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>Name</th><td><?php echo $data['EMP_NAME'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Designation</th><td><?php echo $data['DESIG'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Department</th><td><?php echo $data['DEPT'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Mobile</th>
                                                    <input type="hidden" name="emp_no" value="<?php echo $input_emp ?>">
                                                    <td><input type="text" name="mobile" id="mobile" class="form-control" value="" maxlength="10" onkeypress="return isNumber(event)"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Email</th>
                                                        <td><input type="email" name="email" id="email" class="form-control" value="" ></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Aadhar Number</th>
                                                        <td><input type="text" name="aadhar" id="aadhar" class="form-control" value="" maxlength="12" onkeypress="return isNumber(event)" ></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <hr>
                                            <div class="col-md-6">
                                                <span class="side_heading">Present Address</span>
                                                <div class="form-group">
                                                    <input class="form-control" name="d_no" id="d_no" placeholder="D.No / Q.No">
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" name="street" id="street" placeholder="Street">
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" name="area" id="area" placeholder="Area" onblur="enable_copy();">
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" name="city" id="city" placeholder="CIty" >
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" name="district" id="district" placeholder="District" value="Visakhapatnam">
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" name="state" id="state" placeholder="State" value="Andhra Pradesh">
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" name="pin" id="pin" placeholder="Pin">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <span class="side_heading">Permanent Address</span>
                                                <span id="copy">
                                                    <input  type="checkbox" id="same_address" name="same_address" onchange="return copy_address();"> <small>Click this if this is same as Present Address</small>
                                                </span>
                                                <div class="form-group">
                                                    <input class="form-control" name="p_d_no" id="p_d_no" placeholder="D.No / Q.No">
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" name="p_street" id="p_street" placeholder="Street">
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" name="p_area" id="p_area" placeholder="Area">
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" name="p_city" id="p_city" placeholder="CIty">
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" name="p_district" id="p_district" placeholder="District">
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" name="p_state" id="p_state" placeholder="State">
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" name="p_pin" id="p_pin" placeholder="Pin">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="checkbox" name="terms" id="terms" onchange="return enable_eliment();"> I Accepted all <a href="documents/terms.pdf" target="_blank">Terms and Conditions</a> 
                                            </div>

                                            <div class="col-md-4 col-md-offset-4">
                                                <button class="form-control btn btn-success" id="sub_reg" onclick="return submit_reg();" >Submit</button>
                                            </div>

                                            <?php
                                        } else {
                                            $chk_reg_status = new Database;
                                            $chk_reg_status->query("select * from reg_user where EMP_NO = $input_emp and Status = 'y'");
                                            $status_count = $chk_reg_status->count();
                                            if ($status_count > 0) {
                                                echo "<script>alert('You are a registerd user please login to continu')</script>";
                                                header("location:index.php");
                                            } else {
                                                ?>
                                                <div class="col-md-6 col-md-offset-3" id="aadhar_div">
                                                    <h5>You are alredy Registerd if u wish to update please enter your Registration number to proceed  </h5>
                                                    <div class="form-group">
                                                        <input type="text" name="reg_no" id="reg_no" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="submit" name="submit_adhar" id="submit_adhar" class="btn btn-info form-control" onclick="return update_reg();" >
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                    } else {
                                        echo "<script>alert('You are a registerd user please login to continu')</script>";
                                        header("location:index.php");
                                    }
                                } else {
                                    $close_date = date('d-m-Y', strtotime($date['CLOSING_DATE']));
                                    echo "<script>alert('Your Account is closed on $close_date ')</script>";
                                    header("location:index.php");
                                }
                            }
                        } else {
                            echo "<script>alert('You are not a member')</script>";
                            header("location:index.php");
                        }
                    }
                } else if ($_GET['page'] == 'update') {
                    $get_data = new Database;
                    $get_data->query("select * from reg_user where EMP_NO =" . $_GET['emp'] . " and Reg_no =" . $_GET['reg_no'] . " and status = 'N'");
                    $data_count = $get_data->count();
                    if ($data_count > 0) {
                        $data_update = $get_data->resultset();
                        foreach ($data_update as $update) {
                            ?>
                            <div class = "col-md-12" id = "update_div">
                                <div class = "col-md-6 col-md-offset-3">
                                    <div class = "form-group">
                                        <input class = "form-control" type = "text" name = "emp_no" id = "emp_no" value = "<?php echo $update['EMP_NO'] ?>" readonly>
                                    </div>
                                </div>
                                <div class = "col-md-6 col-md-offset-3">
                                    <table class = "table table-bordered">
                                        <?php
                                        $get_name_data = new Database;
                                        $get_name_data->query("select * from th_member_master where EMP_NO = " . $update['EMP_NO']);
                                        $name_data = $get_name_data->resultset();
                                        foreach ($name_data as $name_data) {
                                            
                                        }
                                        ?>
                                        <tr>
                                            <th>Name</th><td><?php echo $name_data['EMP_NAME'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>Designation</th><td><?php echo $name_data['DESIG'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>Department</th><td><?php echo $name_data['DEPT'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>Mobile</th>
                                            <td><input type="text" name="mobile" id="mobile" class="form-control" value="<?php echo $update['Mobile'] ?>" maxlength="10" onkeypress="return isNumber(event)"></td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td><input type="email" name="email" id="email" class="form-control" value="<?php echo $update['Email'] ?>" ></td>
                                        </tr>
                                        <tr>
                                            <th>Aadhar Number</th>
                                            <td><input type="text" name="aadhar" id="aadhar" class="form-control" value="<?php echo $update['Aadhar'] ?>" maxlength="12" onkeypress="return isNumber(event)" ></td>
                                        </tr>
                                    </table>
                                </div>
                                <hr>
                                <div class="col-md-6">
                                    <span class="side_heading">Present Address</span>
                                    <div class="form-group">
                                        <input class="form-control" name="d_no" id="d_no" placeholder="D.No / Q.No" value="<?php echo $update['Aadhar'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" name="street" id="street" placeholder="Street" value="<?php echo $update['street'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" name="area" id="area" placeholder="Area" value="<?php echo $update['area'] ?>" onblur="enable_copy();">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" name="city" id="city" placeholder="CIty" value="<?php echo $update['city'] ?>" >
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" name="district" id="district" placeholder="District" value="<?php echo $update['district'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" name="state" id="state" placeholder="State" value="<?php echo $update['state'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" name="pin" id="pin" placeholder="Pin" value="<?php echo $update['pin'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <span class="side_heading">Permanent Address</span>
                                    <span id="copy">
                                        <input  type="checkbox" id="same_address" name="same_address" onchange="return copy_address();"> <small>Click this if this is same as Present Address</small>
                                    </span>
                                    <div class="form-group">
                                        <input class="form-control" name="p_d_no" id="p_d_no" placeholder="D.No / Q.No" value="<?php echo $update['p_d_no'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" name="p_street" id="p_street" placeholder="Street" value="<?php echo $update['p_street'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" name="p_area" id="p_area" placeholder="Area" value="<?php echo $update['p_area'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" name="p_city" id="p_city" placeholder="CIty" value="<?php echo $update['p_city'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" name="p_district" id="p_district" placeholder="District" value="<?php echo $update['p_district'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" name="p_state" id="p_state" placeholder="State" value="<?php echo $update['p_state'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" name="p_pin" id="p_pin" placeholder="Pin" value="<?php echo $update['p_pin'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-4 col-md-offset-4">
                                    <button class="form-control btn btn-success" onclick="return submit_reg();">Submit</button>
                                </div>
                            </div>  
                            <?php
                        }
                    } else {
                        ?>
                        <div class="col-md-12">
                            <div class="alert alert-danger">
                                Sorry incorrect data. you are beeing redircting to Home Page......
                            </div>
                        </div>
                        <?php
                        header("Refresh:3; url=index.php", true, 303);
                    }
                } else if ($_GET['page'] == 'report') {
                    $fname = $_GET['emp_no'] . '_pht.jpg';
                    $get_registration_data = new Database;
                    $get_registration_data->query("select * from reg_user where EMP_NO =" . $_GET['emp_no'] . " and status = 'N'");
                    $reg_data_count = $get_registration_data->count();
                    if ($reg_data_count > 0) {
                        $reg_data = $get_registration_data->resultset();
                        foreach ($reg_data as $reg_data) {
                            ?>
                            <div class="headding">
                                <table class="table" style="border: none">
                                    <tr >
                                        <td><img class="img-responsive" src="img/th.png" width="80" height="100"/></td>
                                        <td  align="center" colspan="3"><h5>Visakhapatnam Steel Plant Employees Co-op Thrift and Credit Society Ltd.</h4>

                                                <p align="center">(REGD.NO.B-1918)<br>
                                                    <b align="center">Ukkunagaram - 530032</b></p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <table class="table">
                                <tr>
                                    <td>
                                        To
                                        <br>
                                        The Secretary,
                                        <br>
                                        VSP ECT&CS  Ltd.<br>
                                        Ukkunagaram,<br>
                                        Visakhapatnam – 32
                                    </td>
                                    <td>
                                        <?php
                                        if (file_exists("user_img/$fname")) {
                                            ?>
                                            <div class="col-md-3 pull-right">
                                                <img src="user_img/<?php echo $fname ?>" class="img-responsive" width="80"/>
                                            </div>
                                            <?php
                                        } else {
                                            ?>
                                            <div class="col-md-3 pull-right">
                                                Please Afixe Pasport Photo Here
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </table>
                            <table class="table">
                                <tr>
                                    <td>
                                        Respected Sir,<br>
                                        Sub – Request for Permission for using Access and Transactional Rights on Thrift Website Reg.
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        I Request you to sanction transactional rights in Thrift Society Website for making fallowing Transactions.
                                        <ol>
                                            <li>Withdrawal of Thrift Deposit.</li>
                                            <li>Change of Thrift Deposit Recovery rate.</li>
                                            <li> Withdrawal of Voluntary Thrift Deposit.</li>
                                            <li>Change / Stoppage of Voluntary Thrift Deposit Recovery rate.</li>
                                            <li>Joining of Voluntary Thrift Deposit Scheme</li>
                                            <li>Change of Main Loan (Surety Loan) Recovery rate.</li>
                                            <li>Change of Medium Term Loan Recovery rate.</li>
                                        </ol>
                                    </td>
                                </tr>
                            </table>
                            <table class="table">
                                <tr>
                                    <td colspan="2">
                                        Further I request you to sent OTPs and SMS Alerts to my fallowing Mobile Number and E-mail.
                                    </td>                        
                                </tr>
                                <tr>
                                    <th>Mobile Number</th><td><?php echo $reg_data['Mobile'] ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th><td><?php echo $reg_data['Email'] ?></td>
                                </tr>
                            </table>
                            <table class="table table-bordered">
                                <tr>
                                    <th colspan="2"> Present Address</th>
                                    <th colspan="2"> Permanent Address </th>
                                </tr>
                                <tr>
                                    <td><strong>D.No / Q.No : </strong></td><td> <?php echo $reg_data['d_no'] ?></td>
                                    <td><strong>D.No / Q.No : </strong></td><td> <?php echo $reg_data['p_d_no'] ?></td>
                                </tr>
                                <tr>
                                    <td> <strong>Street : </strong></td><td> <?php echo $reg_data['street'] ?></td>
                                    <td> <strong>Street : </strong></td><td> <?php echo $reg_data['p_street'] ?></td>
                                </tr>
                                <tr>
                                    <td> <strong>Area : </strong></td><td> <?php echo $reg_data['area'] ?></td>
                                    <td> <strong>Area : </strong></td><td> <?php echo $reg_data['p_area'] ?></td>
                                </tr>
                                <tr>
                                    <td> <strong>City : </strong></td><td> <?php echo $reg_data['city'] ?></td>
                                    <td> <strong>City : </strong></td><td> <?php echo $reg_data['p_city'] ?></td>
                                </tr>
                                <tr>
                                    <td> <strong>District : </strong></td><td> <?php echo $reg_data['district'] ?></td>
                                    <td> <strong>District : </strong></td><td> <?php echo $reg_data['p_district'] ?></td>
                                </tr>
                                <tr>
                                    <td> <strong>State : </strong></td><td> <?php echo $reg_data['state'] ?></td>
                                    <td> <strong>State : </strong></td><td> <?php echo $reg_data['p_state'] ?></td>
                                </tr>
                                <tr>
                                    <td> <strong>Pin : </strong></td><td> <?php echo $reg_data['pin'] ?></td>
                                    <td> <strong>Pin : </strong></td><td> <?php echo $reg_data['p_pin'] ?></td>
                                </tr>

                            </table>
                            <table class="table">
                                <tr>
                                    <td colspan="2">
                                        <small>I have read and agree to abide the by the all terms and conditions/ bylaws of the Society for sanction of transactional rights to me in force and those that may be enacted here after. I here with enclose duly signed terms and conditions form.</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        Date : <?php echo date('d-m-Y', strtotime($reg_data['Date_of_registration'])) ?><br> 										
                                        Visakhapatnmam.
                                    </td>
                                    <td align="right">
                                        Yours Faithfully<br>
                                        <br><br>
                                        Signature of the Member 
                                    </td>
                                </tr>
                            </table>
                            <script type="text/javascript">
                                function hideme() {
                                    document.getElementById('printing').style.visibility = 'hidden';
                                }

                                function hideme_div() {
                                    document.getElementById('click').style.visibility = 'hidden';
                                }
                            </script>
                            <div id="click">
                                <p align="right" style="margin-right: 30%;"><a id="printing" onclick="hideme(), closewin();"   href="javascript:window.print();">Print</a></p>
                            </div>
                            <?php
                        }
                    } else {
                        
                    }
                }
                ?>
            </div>
            <div class="col-md-12" id="confirm_div">
                <div align="center">
                    <h4>Registration Successful</h4>
                    <a href="reg.php?page=report&&emp_no=<?php echo isset($_GET['emp']) != '' ? $_GET['emp'] : $input_emp ?>">Print</a> the form and submit to the  society office for activation of web services
                </div>
            </div>
        </div>
    </div>
</div>
<div class=" hidden-print">
    <?php
    include 'footer.php';
    ?>
</div>