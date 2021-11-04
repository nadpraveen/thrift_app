<?php
include 'header.php';
?>
<script type="text/javascript">
    $(document).ready(function () {

        // colorbox settings
        $(".albumpix").colorbox({rel: 'albumpix'});

        // fancy box settings
        /*
         $("a.albumpix").fancybox({
         'autoScale	'		: true, 
         'hideOnOverlayClick': true,
         'hideOnContentClick': true
         });
         */
    });
</script>
<div class="about-area area-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-9 col-xs-12">
                <div class="gallery">  
                    <?php include "folio-gallery.php"; ?>
                </div> 
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