<?php
include '../templets/header.php';
?>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script src="../tiny/plugins/filemanager/plugin.min.js"></script>
<script src="../tiny/plugins/image/plugin.min.js"></script>
<script src="../tiny/plugins/link/plugin.min.js"></script>
<script src="../tiny/plugins/media/plugin.min.js"></script>
<script>
    tinymce.init({
        selector: 'textarea',
        height: 200,
        width: 600,
        forced_root_block: "",
        theme: 'modern',
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools',
//    'table contextmenu directionality emoticons paste textcolor filemanager'
        ],
        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons',
        image_advtab: true,
        templates: [
            {title: 'Test template 1', content: 'Test 1'},
            {title: 'Test template 2', content: 'Test 2'}
        ],
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tinymce.com/css/codepen.min.css'
        ]
    });
</script>
<?php

function disp() {
    if (isset($_POST['btn2'])) {

        $field = trim($_POST['field']);
        require_once '../db.php';
        $query = "select $field from cms ";
//        echo ''.$query;
        $disp_scrole = new Database;
        $disp_scrole->query($query);
        $res = mysql_query($query);
        while ($row = mysql_fetch_array($res)) {
            $data = $row['' . $field];
        }
        echo '' . $data;
    }
}
?>

<?php

function input() {
    if (isset($_POST['btn1'])) {

        $field = trim($_POST['field']);
        $data = trim($_POST['data']);
        require_once '../db.php';
        $query = "UPDATE cms SET `$field` = '$data' ;";
        $res = mysql_query($query);

        if ($res) {
            echo "data inserted succesefully";
        } else {
            echo "please insert correct data";
        }
    }
}
?>
<div class="content">
    <div class="content_resize">
        <img src="../images/img1.jpg" width="927" height="240" alt="image" class="ctop" />
        <div class="mainbar">
            <div class="article">

                <form method="post" action="">
                    <table>
                        <tr>
                            <td colspan="2">

                                <?php
                                input();
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Select the page 
                            </td>
                            <td>
                                <select name="field">
                                    <option value="">--Select--</option>
                                    <option value="scrole">Scrole</option>
                                    <option value="side_scrole">Side Scrole</option>
                                </select>

                            </td>

                        </tr>
                        <tr>
                            <td>
                                <input type="submit" name="btn2" value="view">
                            </td>
                        </tr>
                        <tr>

                            <td colspan='2'>
                                Enter Data
                                <br>
                                <textarea name="data" cols="50" rows="10"><?php disp() ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="submit" name="btn1" value="Update">
                            </td>
                        </tr>
                    </table>
                </form>
                <h2><a href="http://www.techbuzzguy.org/thrift/admin/index.php"> <-Back </a></h2>

            </div>
        </div>

        <div class="sidebar">
            n
            <?php
            include '../templets/scrole.php';
            ?>

        </div>

        <div class="clr"></div>
    </div>
</div>

<div class="fbg">
    <div class="fbg_resize">
        <div class="col c1">
            <h2>About</h2>

        </div>
        <div class="col c3">

        </div>
        <div class="clr"></div>
    </div>
</div>
<?php
include '../templets/footer.php';
?>