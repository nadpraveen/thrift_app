<?php
include '../header.php';
?>
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

<script>
    tinymce.init({
        selector: 'textarea',
        height: 400,
        width: 800,
        theme: 'modern',
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools'
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
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<div class="content" style="margin-top: 200px">
    <div class="content_resize">

        <div class="mainbar">
            <div class="article">
                <h2> add Page </h2>
                <form action="" method="post">
                    <label for="title">
                        title
                        <br>
                        <input type="text" name="title" id="title" value="">
                    </label>
                    <br>
                    <label for="lable">
                        lable
                        <br>
                        <input type="text" name="lable" id="lable" value="">
                    </label>
                    <br>
                    <label for="slug">
                        slug
                        <br>
                        <input type="text" name="slug" id="slug" value="">
                    </label>
                    <br>
                    <label for="drop_down_cheack">
                        Drop Down
                        <br>
                        <input type="checkbox" name="drop_down" id="drop_down" value="">
                    </label>
                    <br>
                    <label for="parent">
                        Parent
                        <br>
                        <select name="parent" id="parent">
                            <option value="">-- Select Parent--</option>
                            <?php 
                            $get_parent_list = new Database;
                            $get_parent_list->prepare("select * from pages");
                            $parent_list = $get_parent_list->resultset();
                            foreach ($parent_list as $parent){
                                ?>
                            <option value="<?php echo $parent['id'] ?>"><?php echo $parent['lable'] ?></option>
                            <?php 
                            }
                            ?>
                        </select>
                    </label>
                    <br>
                    <label for="body">
                        body
                        <br>
                        <textarea name="body" id="body" cols="30" rows="10"></textarea>
                    </label>
                    <br>
                    <input type="submit" value="Add Page" name="btn_submit">

                </form>
                <?php
                if (isset($_POST['btn_submit'])) {

                    $title = $_POST['title'];
                    $lable = $_POST['lable'];
                    $slug = $_POST['slug'];
                    $body = $_POST['body'];
                    if(isset($_POST['drop_down'])){
                        $drop_down = 1;
                        
                    }else{
                        $drop_down = 0;
                    }
                    $parent_id = $_POST['parent'];
                    require_once '../db.php';

                    $q = "INSERT INTO pages (`lable` ,`title` ,`body` ,`slug`, `drop_down`, `parent_id`)VALUES ('$lable', '$title', '$body', '$slug', '$drop_down', '$parent_id')";
                    //echo $q;
                    $add_page = new Database;
                    $add_page->query($q);

                    if ($add_page) {
                        echo 'Page Created Sucess fully redircting to list .......';
                       header('location:http://localhost:81/thrift_bootstrap/admin/index.php');
                    } else {
                        echo 'Sorry Data not updated';
                    }
                }
                ?>

            </div>
        </div>
    </div>
</div>
<?php
include '../footer.php';
?>