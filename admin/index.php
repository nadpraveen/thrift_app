<?php
include '../header.php';
?>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<div class="content" style="margin-top: 200px">
    <div class="content_resize">

        <div class="mainbar">
            <div class="article">
                <table border="1"  >
                    <tr>
                        <th>id</th>
                        <th>lable</th>
                        <th>title</th>
                        <th>slug</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <?php
                    $quiry = "select * from pages";
                    $select_pages = new Database;
                    $select_pages->query($quiry);
                    $count = $select_pages->count();
                    if ($count > 0) {
                        $result = $select_pages->resultset();
                        foreach ($result as $row) {
                            $id = $row['id'];
                            $lable = $row['lable'];
                            $title = $row['title'];
                            $slug = $row['slug'];
                            $body = $row['body'];
                            ?>

                            <tr>
                                <td><?php echo '' . $id; ?></td>
                                <td><?php echo '' . $lable; ?></td>
                                <td><?php echo '' . $title; ?></td>
                                <td><a href="http://localhost:81/thrift_bootstrap/page.php?page=<?php echo $slug; ?>"><?php echo '' . $slug; ?></a></td>
                                <td><a href="http://localhost:81/thrift_bootstrap/admin/edit.php?id=<?php echo '' . $id; ?>">Edit</a></td>
                                <td><a href="http://localhost:81/thrift_bootstrap/admin/delete.php?id=<?php echo '' . $id; ?>" onclick="return confirm('Are you sure?')">Delete </a></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </table>

                <a href="http://localhost:81/thrift_bootstrap/admin/add.php">Add Page</a>
                <br>
                <a href="localhost:81/thrift_bootstrap/scrole_edit.php">Edit Scroles</a>


            </div>
        </div>
    </div>
</div>
<?php
include '../footer.php';
?>