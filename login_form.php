<?php
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'invalid') {
        ?>
        <div class="row">
            <div class="alert alert-danger">
                Please fill the Details
            </div>
        </div>
        <?php
    }
}
?>
<h5 class="star" style="color: green;">Login Here</h5>
<form action="login.php" method="post" autocomplete="off">
    <div class="form-group">
        <label>Emp No</label>
        <input class="form-control login_input" type="text" name="id" placeholder="Emp No" required maxlength="6" onkeypress="return isNumber(event)"/>  
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control login_input" placeholder="Password" required  />
    </div>
    <!--    <div class="form-group">
    <?php
//        create_image();
//        display();
    ?>
        </div>-->
    <div class="form-group">
        <input type="submit" class="form-control btn-success" name="btnSubmit" value="Login" >
    </div>
</form>
<p>
    New user <i class="fa fa-hand-o-right" aria-hidden="true"></i> use Date of Birth as Password in <strong>ddmmyy</strong> formate to login.
    <br>
    <br>
<h4>Forgot Password <a  href="forgot_pass.php"><span class="btn btn-info" style="color: red;">Click Here</span></a></h4>
        </p>
