<?php
/**
 * Created by PhpStorm.
 * User: Mthethwa
 * Date: 10/21/2018
 * Time: 2:53 PM
 */
session_start();
require_once('../classes/class.manageUsers.php');
require_once('../classes/class.likes.php');
require_once('../classes/class.notifications.php');
?>

<!doctype html>
<html lang="en">
<?php include_once '../includes/header.php'; ?>
<body>

<?php if (isset($_SESSION['id'])) { ?>

<div id="wrapper">
    <?php require_once('../includes/navbar.php'); ?>
    <?php
        $notify = new notifications();
        $getNotifications = $notify->fetchNotificationData($_SESSION['id']);
        if (!empty($getNotifications)) {
    ?>
    <div id="page-wrapper" style="margin-top: 50px">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="dataTable_wrapper" style="overflow-x: scroll">
                        <table id="myTable" class="table table-striped table-bordered table-hover text_data selected">
                            <thead>
                                <tr>
                                    <th>Notification</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($getNotifications as $value) { ?>
                                    <tr>
                                        <td><?php echo $value['msg']; ?></td>
                                        <td><?php echo $value['notify_date']; ?></td>
                                        <td>
                                            <?php
                                            $like = new likes();
                                            $check = $like->disableLikeBtn($_SESSION['id'], $value['userId']);

                                            if ($check == 1) { ?>
                                                <button style="display: none" name="like_button" type="button" class="btn btn-xs btn-default like_button" value="<?php echo $value['userId']; ?>">
                                                    <span class="glyphicon glyphicon-thumbs-up"></span>
                                                    Like
                                                </button>
                                            <?php } else { ?>
                                                <button name="like_button" type="button" class="btn btn-xs btn-default like_button" value="<?php echo $value['userId']; ?>">
                                                    <span class="glyphicon glyphicon-thumbs-up"></span>
                                                    Like
                                                </button>
                                            <?php } ?>
                                            <a href="profiles?id=<?php echo $value['userId'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-user"></span> View Profile</a>
                                            <a href="deleteNotification?id=<?php echo $value['userId'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-trash"></span> Delete</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).on("click", '.like_button', function () {
            var content_id = $(this).val();
            $(this).attr('disabled', 'disabled');
            // alert(content_id);
            $.ajax({
                url: "likes.php",
                method: "POST",
                data:{content_id:content_id},
                success:function (data) {
                    if (data == 'done') {
                        alert("Profile liked");
                    } else {
                        alert("Error while processing request");
                    }
                }
            });
        });
    </script>
    <?php } else { ?>
            <div class="alert-warning" style="text-align: center; font-weight: bold; font-size: 20px; position: relative; top: 50px;">You have no notifications!</div>
     <?php } ?>
    <?php require('../includes/footer.php');?>
</div>
<?php } else {
    header("Location:../frontEnd/login");
} ?>
</body>
</html>
