<?php
/**
 * Created by PhpStorm.
 * User: mmthethw
 * Date: 2018/10/18
 * Time: 08:10
 */
    session_start();
    include_once('../includes/form_cleaner.php');
?>
<!doctype html>
<html lang="en">
<?php if (isset($_SESSION['id'])) { ?>
    <?php include_once '../includes/header.php'; 
        $info = new manageUsers();
        $username = $_SESSION['username'];
        $userInfo = $info->getUserInfo($username);
        foreach ($userInfo as $value) {
            $fname = sanitize($value['firstname']);
            $lname = sanitize($value['lastname']);
            $email = sanitize($value['email']);
            $age = sanitize($value['age']);
            $gender = sanitize($value['gender']);
            $sex_pref = sanitize($value['sexual_pref']);
            $about = sanitize($value['about']);
            $interests = sanitize($value['interests']);
            $prof_pic = sanitize($value['profile_pic']);
            $country = sanitize($value['country']);
            $city = sanitize($value['city']);
            $active = sanitize($value['active']);
            $rating = sanitize($value['rating']);
        }
    ?>
    <body>
        <?php include_once '../includes/navbar.php';?>
        <div class="row" style="padding-top: 70px">
            <div class="column"> <!-- column 1 -->
                <div id="user-profile-2" class="user-profile">
                    <div class="table">
                        <ul class="nav nav-tabs padding-18">
                            <li class="active">
                                <a data-toggle="tab" href="#">
                                    <i class="green ace-icon fa fa-user bigger-120"></i>
                                    Profile
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content no-border padding-24">
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
                                                    <span><?php echo $age . "yrs"; ?></span>
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
                                                <p><?php echo $about; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pull-left">
                                    <a href="whoViewMe" class="h4" style="color: red"><i class="fa fa-eye views"> </i></a>
                                </div>
                                <div class="pull-right">
                                    <a href="whoLikedMe" class="h4" style="color: red"><i class="fa fa-heart likes"> </i></a>
                                </div>
                            </div><!-- /#home -->
                        </div>
                    </div>
                </div>
            </div> <!-- column 1 -->

            <div class="column"> <!-- column 2 -->
    <!--            <h2 style="text-align: center">List of suggestions</h2>-->
                <div id="user-profile-2" class="user-profile">
                    <div class="table">
                        <ul class="nav nav-tabs padding-18">
                            <li>
                                <a data-toggle="tab" href="home">
                                    <i></i>
                                    List of suggestions
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php
                    $users = $info->fetchRandUsers($sex_pref, $gender, $country, $city, $rating);
                    foreach ($users as $values) {
                        if ($values['id'] != $_SESSION['id']) {
                            ?>
                            <div class="tab-content no-border padding-24">
                                <div id="home" class="tab-pane in active">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-3 center">
                                <span class="profile-picture">
                                    <img class="editable img-responsive" alt="Profile pic" id="avatar2"
                                         src="<?php echo '../photos/' . $values['profile_pic']; ?>">
                                </span>
                                            <div class="space space-4"></div>
                                        </div><!-- /.col -->

                                        <div class="col-xs-12 col-sm-9">
                                            <h4 class="blue">
                                                <span class="middle"><?php echo sanitize($values['firstname']) . " " . sanitize($values['lastname']); ?></span>
                                                <?php if ($values['active'] == 1) { ?>
                                                    <span class="label label-purple arrowed-in-right">
                                                    <i class="ace-icon fa fa-circle smaller-80 align-middle"
                                                       style="color: green"></i>
                                                    <span style="color: black">online</span>
                                                </span>
                                                <?php } else { ?>
                                                    <span class="label label-purple arrowed-in-right">
                                                    <i class="ace-icon fa fa-circle smaller-80 align-middle"
                                                       style="color: red"></i>
                                                    <span style="color: black">offline last seen <?php echo $values['last_seen']; ?></span>
                                                </span>
                                                <?php } ?>
                                            </h4>
                                            <div class="profile-user-info">
                                                <div class="profile-info-row">
                                                    <div class="profile-info-value">
                                                        <span class="blue">@<?php echo sanitize($values['username']); ?></span>
                                                    </div>
                                                </div>
                                                <div class="profile-info-row">
                                                    <div class="profile-info-value">
                                                        <span><?php echo sanitize($values['interests']); ?></span>
                                                    </div>
                                                </div>
                                                <div class="profile-info-row">
                                                    <div class="profile-info-value">
                                                        <i class="fa fa-map-marker light-orange bigger-110"></i>
                                                        <span><?php echo sanitize($values['city']); ?></span>
                                                        <span><?php echo sanitize($values['country']); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="hr hr-8 dotted"></div>
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                    <?php
                                    $like = new likes();
                                    $check = $like->disableLikeBtn($_SESSION['id'], $values['id']);

                                    if ($check == 1) { ?>
                                        <button name="unlike_button" type="button"
                                                class="btn btn-xs btn-default unlike_button"
                                                value="<?php echo $values['id']; ?>">
                                            <span class="glyphicon glyphicon-thumbs-down"></span>
                                            Unlike
                                        </button>
                                    <?php } else { ?>
                                        <button name="like_button" type="button"
                                                class="btn btn-xs btn-default like_button"
                                                value="<?php echo $values['id']; ?>">
                                            <span class="glyphicon glyphicon-thumbs-up"></span>
                                            Like
                                        </button>
                                    <?php } ?>

                                    <a href="profiles?id=<?php echo $values['id']; ?>"
                                       class="btn btn-xs btn-default view"><span
                                                class="glyphicon glyphicon-user"></span> View Profile</a>
                                    <a href="block?id=<?php echo $values['id']; ?>"
                                       class="btn btn-xs btn-default block"><span
                                                class="glyphicon glyphicon-user"></span> Block User</a>
                                    <a href="report?id=<?php echo $values['id']; ?>"
                                       class="btn btn-xs btn-default report"><span
                                                class="glyphicon glyphicon-user"></span> Report Fake Account</a>
                                </div><!-- /#home -->
                            </div>
                            <?php
                        }
                    }
                        ?>
            </div> <!-- column 2 -->
        </div>
        <?php include_once '../includes/footer.php';?>
    <script>
        $(document).on("click", '.like_button', function () {
           var content_id = $(this).val();
           $('.like_button').attr('disabled', 'disabled');
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

            var chat = {}
            chat.fetchViews = function () {
                $.ajax({
                    url: 'fetch.php',
                    type: 'post',
                    data: { method: 'views' },
                    success: function (data) {
                        $('.h4 .views').html(data);
                    }
                });
            };
            chat.interval = setInterval(chat.fetchViews, 5000);
            chat.fetchViews();

            chat.fetchLikes = function () {
                $.ajax({
                    url: 'fetch.php',
                    type: 'post',
                    data: { method: 'likes' },
                    success: function (data) {
                        $('.h4 .likes').html(data);
                    }
                });
            };
            chat.interval = setInterval(chat.fetchLikes, 5000);
            chat.fetchLikes();
    </script>
    </body>
<?php } else {
        header("Location: ../frontEnd/login");
      } ?>
</html>
