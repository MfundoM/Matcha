<?php
/**
 * Created by PhpStorm.
 * User: mmtheth
 * Date: 2018/10/19
 * Time: 09:35
 */
session_start();
?>
<!doctype html>
<html lang="en">
    <?php include_once '../includes/header.php'; ?>
<body>
<?php if (isset($_SESSION['id'])) { ?>
<!--    <div id="navbar">-->
        <?php include_once '../includes/navbar.php';?>
<!--    </div>-->
    <?php
        $id = $_GET['id'];
        $profile = new manageUsers();
        $userProfile = $profile->getProfile($id);
        foreach ($userProfile as $value) {
            $username = $value['username'];
            $fname = $value['firstname'];
            $lname = $value['lastname'];
            $age = $value['age'];
            $gender = $value['gender'];
            $sex_pref = $value['sexual_pref'];
            $about = $value['about'];
            $interests = $value['interests'];
            $prof_pic = $value['profile_pic'];
            $country = $value['country'];
            $city = $value['city'];
            $active = $value['active'];
            $last_seen = $value['last_seen'];
            $join = $value['signup_date'];
            $rating = $value['rating'];
        }

        $getInfo = new manageUsers();
        $userInfo = $getInfo->getUserById($_SESSION['id']);
        foreach ($userInfo as $value) {
            $firstname = $value['firstname'];
            $lastname = $value['lastname'];
        }

        $date = date('Y-m-d H:i');

        $like = new likes();
        $likeProfile = $like->viewProfile($_SESSION['id'], $id, $date);

        $msg = $firstname . " " . $lastname . " viewed your profile\n";

        $notify = new notifications();
        $addNotify = $notify->addNotification($_SESSION['id'], $id, $msg, $date);

        $update = $notify->updateViewed($id);
    ?>
    <div id="user-profile-2" class="user-profile" style="margin-top: 100px">
        <div class="tabbable">
            <ul class="nav nav-tabs padding-18">
                <li>
                    <a data-toggle="tab" href="javascript:;" onmousedown="toggleDiv('mydiv');">
                        <i class="green ace-icon fa fa-user bigger-120"></i>
                        Profile
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="javascript:;" onmousedown="toggleDiv('mydiv');">
                        <i class="pink ace-icon fa fa-picture-o bigger-120"></i>
                        Pictures
                    </a>
                </li>
            </ul>

            <div class="tab-content no-border padding-24" id="mydivon" style="display: block">
                <div id="home" class="tab-pane in active">
                    <div class="row">
                        <div class="col-xs-12 col-sm-3 center">
							<span class="profile-picture">
								<img class="editable img-responsive" alt="Profile pic" id="avatar2" src="<?php echo '../photos/'.$prof_pic; ?>">
							</span>
                            <div class="space space-4"></div>
                        </div><!-- /.col -->

                        <div class="col-xs-12 col-sm-9">
                            <h4 class="blue">
                                <span class="middle"><?php echo $fname . " " . $lname; ?></span>
                                <?php
                                if ($active == 1) { ?>
                                    <span class="label label-purple arrowed-in-right">
                                        <i class="ace-icon fa fa-circle smaller-80 align-middle" style="color: green"></i>
                                        <span style="color: black">online</span>
                                    </span>
                                <?php } else { ?>
                                    <span class="label label-purple arrowed-in-right">
                                        <i class="ace-icon fa fa-circle smaller-80 align-middle" style="color: red"></i>
                                        <span style="color: black">offline last seen <?php echo $last_seen; ?></span>
                                    </span>
                                <?php } ?>
                            </h4>
                            <div class="profile-user-info">
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Username </div>
                                    <div class="profile-info-value">
                                        <span>@<?php echo $username; ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Age </div>
                                    <div class="profile-info-value">
                                        <span><?php echo $age; ?>yrs</span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Gender </div>
                                    <div class="profile-info-value">
                                        <span><?php echo $gender; ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Sexual Preference </div>
                                    <div class="profile-info-value">
                                        <span><?php echo $sex_pref; ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Rating </div>
                                    <div class="profile-info-value">
                                        <span><?php echo $rating; ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Interests </div>
                                    <div class="profile-info-value">
                                        <span><?php echo $interests; ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Location </div>
                                    <div class="profile-info-value">
                                        <i class="fa fa-map-marker light-orange bigger-110"></i>
                                        <span><?php echo $city; ?></span><br>
                                        <span><?php echo $country; ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Joined </div>
                                    <div class="profile-info-value">
                                        <span><?php echo $join; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="hr hr-8 dotted"></div>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    <div class="space-20"></div>
                    <div>
                        <div>
                            <div class="widget-box transparent">
                                <div class="widget-header widget-header-small">
                                    <h4 class="widget-title smaller">
                                        <i class="ace-icon fa fa-check-square-o bigger-110"></i>
                                        About Me
                                    </h4>
                                    <p>
                                        <?php echo $about; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $like = new likes();
                    $check = $like->disableLikeBtn($_SESSION['id'], $id);
                    if ($check > 0) { ?>
                        <button name="unlike_button" type="button" class="btn btn-xs btn-default unlike_button" value="<?php echo $id; ?>">
                            <span class="glyphicon glyphicon-thumbs-down"></span>
                            Unlike
                        </button>
                    <?php } else { ?>
                        <button name="like_button" type="button" class="btn btn-xs btn-default like_button" value="<?php echo $id; ?>">
                            <span class="glyphicon glyphicon-thumbs-up"></span>
                            Like
                        </button>
                    <?php } ?>
                    <a href="block?id=<?php echo $id;?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-user"></span> Block User</a>
                    <a href="report?id=<?php echo $id;?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-user"></span> Report Fake Account</a>
                </div><!-- /#home -->
            </div>
            <div id="mydivoff" class="tab-pane" style="display: none"> <!------>
                <?php
                $pull = $profile->pullImages($_GET['id']);
                foreach ($pull as $image) {
                    ?>
                    <ul class="ace-thumbnails">
                        <li>
                            <span data-rel="colorbox">
                                <img alt="150x150" width="250px" height="250px" src="../photos/<?php echo $image['imageName']; ?>">
                            </span>
                        </li>
                    </ul>
                    <?php
                }
                ?>
            </div><!-- /#pictures -->
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

        $(document).on("click", '.unlike_button', function () {
            var content_id = $(this).val();
            $(this).attr('disabled', 'disabled');
            // alert(content_id);
            $.ajax({
                url: "unlike.php",
                method: "POST",
                data:{content_id:content_id},
                success:function (data) {
                    if (data == 'done') {
                        alert("Profile unliked");
                    } else {
                        alert("Error while processing request");
                    }
                }
            });
        });
    </script>
    <?php include_once '../includes/footer.php'; ?>
    <?php } else {
        header("Location: ../frontEnd/login");
    } ?>
</body>
</html>