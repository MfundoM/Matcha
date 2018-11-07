<?php
/**
 * Created by PhpStorm.
 * User: mmthethw
 * Date: 2018/11/03
 * Time: 14:30
 */
session_start();
?>
<!doctype html>
<html lang="en">
<?php if (isset($_SESSION['id'])) { ?>
    <?php include_once '../includes/header.php';
    $info = new manageUsers();
    ?>
    <body>
    <?php include_once '../includes/navbar.php';?>
    <div class="row" style="padding-top: 70px">
        <div> <!-- column 2 -->
            <!--            <h2 style="text-align: center">List of suggestions</h2>-->
            <div id="user-profile-2" class="user-profile">
                <div class="table">
                    <ul class="nav nav-tabs padding-18">
                        <li>
                            <a data-toggle="tab" href="#">
                                <i></i>
                                List of blocked users
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <?php
            $users = $info->getBlocked($_SESSION['id']);
            if (empty($users)) {
                ?>
                    <div class="alert-warning" style="text-align: center">There are currently no blocked users!!!</div>
                <?php
            } else {
                foreach ($users as $values) { ?>
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
                                        <span
                                            class="middle"><?php echo $values['firstname'] . " " . $values['lastname']; ?></span>
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
                                                    <span
                                                        style="color: black">offline last seen <?php echo $values['last_seen']; ?></span>
                                                </span>
                                        <?php } ?>
                                    </h4>
                                    <div class="profile-user-info">
                                        <div class="profile-info-row">
                                            <div class="profile-info-value">
                                                <span class="blue">@<?php echo $values['username']; ?></span>
                                            </div>
                                        </div>
                                        <div class="profile-info-row">
                                            <div class="profile-info-value">
                                                <span><?php echo $values['interests']; ?></span>
                                            </div>
                                        </div>
                                        <div class="profile-info-row">
                                            <div class="profile-info-value">
                                                <i class="fa fa-map-marker light-orange bigger-110"></i>
                                                <span><?php echo $values['city']; ?></span>
                                                <span><?php echo $values['country']; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hr hr-8 dotted"></div>
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                            <a href="unblock?id=<?php echo $values['id']; ?>" class="btn btn-xs btn-default"><span
                                    class="glyphicon glyphicon-user"></span> UnBlock</a>
                        </div><!-- /#home -->
                    </div>
                    <?php
                }
            }
            ?>
        </div> <!-- column 2 -->
    </div>
    <?php include_once '../includes/footer.php';?>
    </body>
<?php } else {
    header("Location: ../frontEnd/login");
} ?>
</html>