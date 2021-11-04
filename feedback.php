<?php
ob_start();
session_start();
if (!isset($_SESSION['suser'])) {
    header("location:logout.php");
}
include 'header.php';

if (isset($_POST['btn_feed_back'])) {
    $feed_back = escape(trim($_POST["feed_back"]));
    if ($_POST["feed_back"] == '') {
        header("location:feedback.php?err=blank");
    } else {
        $insert_feed_back = new Database;
        $feed_back_query = "INSERT INTO `feed_back` (`emp_no`, `message`, `date`, `read_status`) VALUES ('$user', '$feed_back', now(), 'N')";
        $insert_feed_back->query($feed_back_query);
        header("location:feedback.php?res=success");
    }
}
?>

</div>
</div>
</div>

<div class="row">

    <div class="col-md-6 col-md-offset-3">
        <?php
        if (isset($_GET['err'])) {
            if ($_GET['err'] == 'blank') {
                ?>
                <div class="row">
                    <div class="alert alert-danger">
                        Empty Feedback Not Allowed.
                    </div>
                </div>
                <?php
            }
        }
        ?>
        <form method="post" action="" autocomplete="off">
            <div class="form-group">
                <label for="feed_back">Feed Back / Suggestion</label>
                <textarea name="feed_back" id="feed_back" rows="5" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <input type="submit" name="btn_feed_back" class="form-control btn btn-info" value="Submit">
            </div>
        </form>
    </div>

    <div class="col-md-12">
        <div>                
            <table class="table">
                <tr>
                    <th>My Feedback/Suggestion</th>
                    <th>Reply from Society</th>
                    <th>Date</th>
                    <!--<th>READ</th>-->
                </tr>

                <?php
                $get_feed_back_reply_query = "SELECT * FROM `feed_back_reply` where reply_to = $user and read_status = 'N'";
                $get_feed_back_reply = new Database;
                $get_feed_back_reply->query($get_feed_back_reply_query);
                $reply_count = $get_feed_back_reply->count();
                if ($reply_count > 0) {
                    $reply = $get_feed_back_reply->resultset();
                    foreach ($reply as $reply) {
                        $get_user_feedback = new Database;
                        $get_user_feedback->query("SELECT * FROM `feed_back` where id =" . $reply['feed_back_id']);
                        $user_feedback = $get_user_feedback->resultset();
                        foreach ($user_feedback as $feedback) {
                            ?>
                            <tr>
                                <td><?php echo $feedback['message'] ?></td>
                                <td>
                                    <a class="btn btn-success" type="button" data-toggle="modal" data-target="#message_modal_<?php echo $reply['id'] ?>">
                                        View
                                    </a>
                                    <?php //echo $reply['reply']  ?>
                                </td>
                                <td><?php echo date('d-m-Y h:i a', strtotime($reply['reply_on'])) ?></td>
                                <!--<td><a href="read_reply.php?id=<?php echo $reply['id']; ?>"<i class="fa fa-check" aria-hidden="true"></i></a></td>-->
                            </tr>
                            <div class="modal fade" id="message_modal_<?php echo $reply['id'] ?>" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h6 class="modal-title" style="color: green">View Message</h6>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12" >
                                                    <?php echo $reply['reply'] ?>
                                                </div>
                                                <div class="col-md-4 col-md-offset-4">
                                                    <a class="btn btn-success" href="read_reply.php?id=<?php echo $reply['id']; ?>" >
                                                        Close
                                                    </a>
                                                </div>
                                            </div>
                                            <!--                                    <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                </div>-->
                                        </div>

                                    </div>
                                </div>
                                <?php
                            }
                        }
                    }
                    ?>
            </table>
        </div>
    </div>
    <?php
    if (isset($_GET['res'])) {
        if ($_GET['res'] == 'success') {
            ?>
            <div class="col-md-12">
                <div class="alert alert-success">
                    Your Feed back / suggestion has been submitted successfully.
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>
</div>
<?php include 'footer.php'; ?>