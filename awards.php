<?php
ob_start();
include 'header.php';
?>

<div class="about-area area-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-9 col-xs-12">
                <span class=" side_heading">Awards:</span>
                <br>
                <?php
                if ($ub != 'IE') {
                    ?>
                    <img src="img/Awards.jpg" class="img-responsiv" >
                    <?php
                } else {
                    ?>
                    <img src="img/Awards.jpg" class="img-responsiv" >
                    <?php
                }
                ?>

            </div>

            <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="row">
                    <?php include 'sidebar.php'; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>