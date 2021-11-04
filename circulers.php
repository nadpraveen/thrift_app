<?php
ob_start();
include 'header.php';
?>
<div class="about-area area-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-9 col-xs-12">
                <h4 class="page_title" >Circulars</h4>
                <?php
                $get_circulers_list = new Database;
                $get_circulers_list->query("select * from circulers order by date DESC");
                $circuler_count = $get_circulers_list->count();
                if ($circuler_count == 0) {
                    echo 'No Circulers Yet';
                } else {
                    ?>
                <style>
                    table tr th{
                        color: green;
                    }
                </style>
                    <table class="table">
                        <tr>
                            <th>Description</th>
                            <th>Link</th>
                        </tr>
                        <?php
                        $circulers = $get_circulers_list->resultset();
                        foreach ($circulers as $circuler) {
                            ?>
                            <tr>
                                <td><?php echo $circuler['description'] ?></td>
                                <td><a href="<?php echo $circuler['link'] ?>" target="_blank">Download</a></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                    <?php
                }
                ?>
            </div>

        </div>
    </div>
</div>

<?php
include 'footer.php';
?>