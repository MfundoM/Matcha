<?php
/**
 * Created by PhpStorm.
 * User: Mthethwa
 * Date: 11/4/2018
 * Time: 7:55 AM
 */
    session_start();
    require_once '../classes/class.manageUsers.php';

    if (isset($_POST['submit'])) {
        $target_dir = '../photos/';
        $target_file = $target_dir . basename($_FILES['pic']["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["pic"]["tmp_name"]);
        if ($check !== false) {
            if (file_exists($target_file)) {
                $error = "Sorry, file already exists.";
            }
            if ($_FILES["pic"]["size"] > 200000) {
                $error = "Sorry, your file is too large.";
            }
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            } else {
                if (move_uploaded_file($_FILES["pic"]["tmp_name"], $target_file)) {
                    $profile = new manageUsers();
                    $image = basename($_FILES['pic']['name']);
                    $prof = $profile->upload($_SESSION['id'], $image);
                    if ($prof == 1) {
                        header("Location: gallery");
                    }
                } else {
                    $error = "Error moving file";
                }
            }
        }
    }

    if (isset($_GET['delete'])) {
        $del = new manageUsers();
        $path = "../photos/".$_GET['name'];
        unlink($path);
        $delImg = $del->deleteImage($_GET['delete']);
        if ($delImg == 1) {
            header("Location: gallery");
        }
    }
?>
<!doctype html>
<html lang="en">
<?php if (isset($_SESSION['id'])) { ?>
    <?php include_once '../includes/header.php';
        $img = new manageUsers();
        $pull = $img->pullImages($_SESSION['id']);
        $count = $img->countImages($_SESSION['id']);
    ?>
    <body>
    <?php include_once '../includes/navbar.php';?>
    <div id="user-profile-2" class="user-profile" style="padding-top: 70px">
        <div class="table">
            <ul class="nav nav-tabs padding-18">
                <li class="active">
                    <a data-toggle="tab" href="#">
                        <i class="green ace-icon fa fa-user bigger-120"></i>
                        Gallery
                    </a>
                </li>
            </ul>
            <div class="tab-pane"> <!------>
                <?php
                    foreach ($pull as $image) {
                        ?>
                        <ul class="ace-thumbnails">
                            <li>
                                <a href="gallery?delete=<?php echo $image['id']; ?>&name=<?php echo $image['imageName']; ?>" data-rel="colorbox">
                                    <span class="glyphicon glyphicon-trash" style="position: absolute; color: red"></span>
                                    <img alt="150x150" width="250px" height="250px" src="../photos/<?php echo $image['imageName']; ?>">
                                </a>
                            </li>
                        </ul>
                        <?php
                    }
                ?>
            </div><!-- /#pictures -->
            <?php
                if ($count < 4) {
                    ?>
                    <div style="margin-top: 20px">
                        <form method="post" action="" enctype="multipart/form-data">
                            <div class="card card-default">
                                <div id="collapse1" class="collapse show">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 col-lg-5">
                                                <div class="form-group">
                                                    <div id="wrapper">
                                                        <input type="file" name="pic" accept="image/*">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        if (isset($error)) {
                                            echo "<div class='alert alert-danger'>" . $error . "</div>";
                                        }
                                        ?>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div>
                                                    <input type="submit" name="submit" value="Upload" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php
                }
            ?>
        </div>
    </div>

        <?php include_once '../includes/footer.php';?>
    </body>
<?php } else {
    header("Location: ../frontEnd/login");
} ?>
</html>

