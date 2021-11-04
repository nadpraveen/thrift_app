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
        <img src="../images/img1.jpg" width="927" height="240" alt="image" class="ctop" />
        <div class="mainbar">
            <div class="article">
                <?php
                $get_id = $_GET['id'];
                require_once '../db.php';
                $quiry = "select * from pages where id=$get_id";
                $get_page_data = new Database;
                $get_page_data->prepare($quiry);
                $result = $get_page_data->resultset();
                foreach ($result as $row) {
                    $id = $row['id'];
                    $lable = $row['lable'];
                    $title = $row['title'];
                    $slug = $row['slug'];
                    $body = $row['body'];
                }
                ?>
                <h2> Edit Page </h2>
                <form action="" method="post">
                    <label for="title">
                        title
                        <br>
                        <input type="text" name="title" id="title" value="<?php echo $title ?>">
                    </label>
                    <br>
                    <label for="lable">
                        lable
                        <br>
                        <input type="text" name="lable" id="lable" value="<?php echo $lable ?>">
                    </label>
                    <br>
                    <label for="slug">
                        slug
                        <br>
                        <input type="text" name="slug" id="slug" value="<?php echo $slug ?>">
                    </label>
                    <br>
                    <label for="body">
                        body
                        <br>
                        <textarea name="body" id="body" cols="30" rows="10"><?php echo $body ?></textarea>
                    </label>
                    <br>
                    <input type="hidden" name="id" value=" <?php echo $id ?> ">
                    <input type="submit" value="update Page" name="btn_update">

                </form>
                <?php
                if (isset($_POST['btn_update'])) {
                    $id = $_POST['id'];
                    $title = $_POST['title'];
                    $lable = $_POST['lable'];
                    $slug = $_POST['slug'];
                    $body = $_POST['body'];
                    $q = "update pages set lable='$lable', title='$title', slug='$slug', body='$body' where id=$id";
                    $editpage = new Database;
                    $editpage->query($q);
                    
                    if ($editpage) {
                        echo 'Updates Sucess fully redircting to list .......';
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