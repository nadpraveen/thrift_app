<?php
include 'header.php';
?>
<?php
ob_start();
//session_start();
?>


<!-- Start Slider Area -->
<div id="home" class="slider-area">
    <div class="bend niceties preview-2">
        <div id="ensign-nivoslider" class="slides" style="max-height: 300px; overflow: hidden">
            <img src="img/slider/slider1.jpg" alt="" title="#slider-direction-1" />
            <img src="img/slider/slider2.jpg" alt="" title="#slider-direction-2" />
            <img src="img/slider/slider3.jpg" alt="" title="#slider-direction-3" />
        </div>                             
    </div>
</div>
<!-- End Slider Area -->


<div class="about-area area-padding">
    <div class="container">
        <div class="row">
            <?php
//            $code=$_GET['page'];
//            global $code;
//require_once 'db.php';
            $get_page_data = new Database;
            $get_page_data->prepare("select * from pages where slug='$code'");
            $result1 = $get_page_data->resultset();
            foreach ($result1 as $row) {
                $id = $row['id'];
                $lable = $row['lable'];
                $title = $row['title'];
                $slug = $row['slug'];
                $body = $row['body'];
            }
            ?>
            <div class="col-md-8 col-sm-8 col-xs-12">
                
                    <?php
                    echo'' . $body;
                    ?> 
                
            </div>

            <div class="col-md-3 col-sm-3 col-xs-12">
                <?php include 'login_form.php'; ?>
            </div>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>