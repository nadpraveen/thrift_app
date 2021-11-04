<?php
ob_start();
session_start();
require 'db.php';
require 'sanitize.php';

$edit_scrol = new Database;
$edit_scrol->query("select * from scrole where id = " . $_GET['id']);
$scrol = $edit_scrol->resultset();
foreach ($scrol as $scroles) {
    ?>
    <div style="width: 60%; margin-left: auto; margin-right: auto;">
        <form method="post" action>
            <textarea name="scrol" rows="5" style="width: 100%;
                      margin-left: auto;
                      margin-right: auto;
                      padding: 15px;
                      border: 1px solid;
                      border-radius: 10px;
                      }"><?php echo $scroles['description'] ?></textarea>
            <br>
            <input type="submit" name="edit_scrole" value="Update Scrol"
                   style="margin-top: 15px;
                   width: 100%;
                   height: 30px;
                   border: 1px solid;
                   background-color: beige;
                   border-radius: 10px;"
                   >
        </form>
    </div>
    <?php
    if (isset($_POST['edit_scrole'])) {
        $new_scrol = escape(trim($_POST['scrol']));
        $update_scrol = new Database;
        $update_scrol->query("update scrole set description = '$new_scrol' where id =" . $_GET['id']);
        header("location:admin_panel.php?menu=scrole&result=updated");
    }
}

//