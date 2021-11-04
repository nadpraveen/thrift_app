<?php
ob_start();
session_start();

include 'header.php';
?>

<div class="row" style="margin-top: 15px;">
    <a href="about_us.php">
        <div class="col-md-12 col-xs-12 col-sm-12 home-nav">
            About Us
        </div>
    </a>
    <a href="activites.php">
        <div class="col-md-12 col-xs-12 col-sm-12 home-nav">
            Activities
        </div>
    </a>
    <a href="commette.php">
        <div class="col-md-12 col-xs-12 col-sm-12 home-nav">
            Management
        </div>
    </a>
    <a href="circulers.php">
        <div class="col-md-12 col-xs-12 col-sm-12 home-nav">
            Circulars
        </div>
    </a>
    <?php
    $check_admin_access = new Database;
    $check_admin_access->query("select * from admin_login where admin_id = " . $user);
    $admin_count = $check_admin_access->count();
    if ($admin_count > 0) {
        ?>
        <a href="query.php">
            <div class="col-md-12 col-xs-12 col-sm-12 home-nav">
                Query
            </div>
        </a>
        <?php
    }
    ?>
</div>


<?php include 'footer.php'; ?>