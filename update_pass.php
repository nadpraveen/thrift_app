<?php
ob_start();
session_start();
if (!isset($_SESSION['suser'])) {
    header("location:index.php");
}
include 'header.php';
?>

<script type="text/javascript">

    function checkForm(form)
    {
        if (form.pwd1.value != "" && form.pwd1.value == form.pwd2.value) {
            if (form.pwd1.value.length < 6) {
                alert("Error: Password must contain at least six characters!");
                form.pwd1.focus();
                return false;
            }
        } else {
            alert("Error: Please check that you've entered and confirmed your password!");
            form.pwd1.focus();
            return false;
        }
        return true;
    }

</script>

<div class="col-md-6 col-md-offset-3">
    <?php
    if (isset($_GET['err'])) {
        if ($_GET['err'] == 'blank') {
            ?>
            <div class="row">
                <div class="alert alert-danger">
                    All Fields are Mandatary.
                </div>
            </div>
            <?php
        }
    }
    ?>
    <form id="form" action="" method="post" >
        <div class="form-group">
            <label for="currunt_password"> Current Password </label>
            <input class="form-control" type="password" name="current_password" id="currunt_password" required> 
        </div>
        <div class="form-group">
            <label for="pwd1">New Password </label>
            <input class="form-control" type="password" name="pwd1" id="pwd1" required>
        </div>
        <div class="form-group">
            <label for="pwd2">Retype New Password</label>
            <input class="form-control" type="password" name="pwd2" id="pwd2" required> 
        </div>
        <div class="form-group">
            <input class="form-control btn-success" type="submit" name="submit" value="Update">
        </div>
    </form>
    <div>
        <?php
        if (isset($_POST['submit'])) {
            $query = "select * from pass_master where EMP_NO='$user'";
            $get_cur_paswd = new Database;
            $get_cur_paswd->query($query);
            $cur_paswd = $get_cur_paswd->resultset();
            foreach ($cur_paswd as $row) {
                $pass = $row['pswd'];
            }

                $curr_paswd = Hash::make(trim($_POST['current_password']));

            //$curr_paswd = $curr_pass;
            $new_pass = trim($_POST['pwd1']);
            $re_new_pass = trim($_POST['pwd2']);
            //$update_paswd = $new_pass;
            if ($curr_paswd == '' || $new_pass == '' || $re_new_pass == '') {
                header("location:update_pass.php?err=blank");
            } else {
                //require_once 'db.php';
                if ($pass == $curr_paswd) {
                    if ($new_pass == $re_new_pass) {
                        $new_pass_to_update = Hash::make($new_pass);
                        $query3 = "update pass_master set pswd='$new_pass_to_update' where EMP_NO='$user'";
                        $update_paswd = new Database;
                        $update_paswd->query($query3);
                        echo "<h3 style='color:red'>Password updated succesfully</h3>";
                    } else {
                        echo "<script>alert('New Password doest match with the retyped password!');</script>";
                    }
                } else {
                    echo "<script>alert('current password is incorrect!');</script>";
                }
            }
        }
        ?>
    </div>
</div>
</div>
</div>
</div>
</div>

<?php include 'footer.php'; ?>