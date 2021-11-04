<?php
ob_start();
session_start();
include 'header_noc.php';
include 'dirreader.php';

//if(isset($_SESSION['ofc_user'])){
//    header("location:noc.php?menu=list");
//} else {
//header("location:index.php");    
//}

if (isset($_POST['ofc_login'])) {
    $ofc_pass = $_POST['ofc_pass'];
    if (strlen($ofc_pass) == 0) {
        header("location:noc.php?erro=1");
    } else {
        if ($ofc_pass === 'Thrift') {
            $_SESSION['ofc_usr'] = 'ofc_usr';
            header("location:noc.php?menu=list");
        }
    }
}
?>

<?php
if (!isset($_SESSION['ofc_usr'])) {
    ?>
    <br>
    <div class="row">
        <div class="col-md-4">

        </div>
        <div class="col-md-4">

            <h5 style="color: green">Use only for officials of HR / Finance Department</h5>
            <form method="post" action="" autocomplete="off">
                <div class="form-group">
                    <label for="ofc_pass" style="color: blue">Password</label>
                    <input type="password" name="ofc_pass" id="ofc_pass" placeholder="Password" class="form-control" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="ofc_login" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
    <?php
} else {
    if (isset($_GET['menu'])) {
        if ($_GET['menu'] == 'list') {
            ?>

            <div class="row">
                <div class="col-md-3">

                </div>
                <div class="col-md-6">
                    <h4 style="color: green">To print Due / No Due Certificate</h4>
                    <form method="post" action="" autocomplete="off">
                        <div class="form-group">
                            <label for="emp_no" style="color: blue">Emp No</label>
                            <input type="text" name="emp_no" id="emp_no" class="form-control" placeholder="EMP NUMBER">
                        </div>
                        <div class="form-group">
                            <button type="submit" name="emp_search" class="btn btn-primary">Search</button>
                        </div>
                    </form>

                    <?php
                    if (isset($_POST['emp_search'])) {
                        $emp_no = $_POST['emp_no'];

                        if (file_exists('noc/' . $emp_no . '.pdf')) {
                            ?>
                            <table class="table table-bordered">
                                <tr>
                                    <th><?php echo $emp_no ?></th>
                                    <th>
                                        <?php
                                        $get_emp_name = new Database;
                                        $get_emp_name->query("select EMP_NAME from th_member_master where EMP_NO = " . $emp_no);
                                        $emp_name = $get_emp_name->resultset();
                                        foreach ($emp_name as $emp_name) {
                                            echo $emp_name['EMP_NAME'];
                                        }
                                        ?>
                                    </th>
                                    <td><a href="<?php echo 'noc/' . $emp_no . '.pdf' ?>" target="_blank">Print</a></td>
                                </tr>

                            </table>
                            <?php
                        } else {
                            ?>
                            <div class="alert alert-danger">
                                <h4>NOC Not found</h4> 
                                <br>
                                <h5>Inter office Memo not yet received by the Society. Kindly send it to the Society office</h5>
                            </div>

                            <?php
                            $get_missing_noc_list = new Database;
                            $get_missing_noc_list->query("select * from noc_doc where emp_no = ".$emp_no);
                            $noc_count = $get_missing_noc_list->count();
                            if($noc_count == 0){
                                $save_missing_noc = new Database;
                                $save_missing_noc->query("insert into noc_doc (`emp_no`, `searchd_on`) "
                                        . "values('$emp_no', now())");
                            }
                        }
                    }
                    ?>

                </div>
            </div>
            <?php
        }
    }else{
        header("location:noc.php?menu=list");
    }
}
?>

<?php include 'footer.php'; ?>