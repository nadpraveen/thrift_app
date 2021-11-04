<div class="scroll">
    <h3 class="btn btn-success btn-lg"> Notifications </h3>
    <style>
        .scroll{
            max-height: 500px;
        }
        .scrol_li{
            padding: 5px;
            /*color: white;*/

        }
        /*        .scrol_li a{
                    color: #0000b3;
                }*/

    </style>
    <?php
    $get_scrol_list = new Database;
    $get_scrol_list->query("select * from scrole order by date DESC");
    $scrol_count = $get_scrol_list->count();
    if ($scrol_count == 0) {
        echo 'No Scrols Yet';
    } else {
        ?>
        <marquee behavior="scroll" direction="up" SCROLLAMOUNT=2>
            <ul>
                <?php
                $scroles = $get_scrol_list->resultset();
                foreach ($scroles as $scroles) {

                    if ($scroles['link'] == '') {
                        ?>
                        &nbsp;<li class = "scrol_li"><?php echo $scroles['description'] ?></li>
                        <?php
                    } else {
                        ?>

                        &nbsp; <li class = "scrol_li"><a href = "<?php echo $scroles['link'] ?>" target = "_blank">&nbsp;<?php echo $scroles['description'] ?></a></li>
                            <?php
                        }
                    }
                    ?>
            </ul>
        </marquee>
        <?php
    }
    ?>
</div>