<style>
    .scrol_span a{
        color: #009999;
        font-weight: bold;
        font-size: medium;
    }
    
    .scroll_container{
        padding: 0;
    }
</style>
<div class="col-md-12 scroll_container">
    <?php
    $get_scrol_list = new Database;
    $get_scrol_list->query("select * from scrole order by date DESC limit 1");
    $scrol_count = $get_scrol_list->count();
    if ($scrol_count == 0) {
        echo 'No Scrols Yet';
    } else {
        ?>
        <marquee behavior="scroll" direction="left" scrollamount="2">

            <?php
            $scroles = $get_scrol_list->resultset();
            foreach ($scroles as $scroles) {
                if ($scroles['link'] == '') {
                    ?>
                    <span class="scrol_span"><a href="#"><?php echo $scroles['description'] ?></a></span>
                    <?php
                } else {
                    ?>

                    <span class="scrol_span"><a href="<?php echo $scroles['link'] ?>" target="_blank"><?php echo $scroles['description'] ?></a></span>
                        <?php
                    }
                }
                ?>
        </marquee>
        <?php
    }
    ?>
</div>