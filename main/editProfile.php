<?php
/**
 * Created by PhpStorm.
 * User: Mthethwa
 * Date: 11/4/2018
 * Time: 7:55 AM
 */
    session_start();
    require_once '../classes/class.manageUsers.php';
    include_once('../classes/nocsrf.php');
    include_once('../includes/form_cleaner.php');

    if (isset($_POST['submit'])) {
        $fname    = sanitize($_POST['fname']);
        $lname    = sanitize($_POST['lname']);
        $sex_pref = sanitize($_POST['sex_pref']);
        $email    = sanitize($_POST['email']);
        $about    = sanitize($_POST['about']);
        $interest = sanitize($_POST['interests']);
        $country  = sanitize($_POST['country']);
        $city     = sanitize($_POST['city']);
        $error = "";

        if (empty($fname) || empty($lname) || empty($sex_pref) || empty($email) || empty($about)
            || empty($interest) || empty($country) || empty($city)) {
            $error = "Please fill in all fields";
        } else {
            $profile = new manageUsers();
            $update = $profile->editProfile($fname, $lname, $sex_pref, $email, $country, $city, $about, $interest, $_SESSION['id']);
            if ($update == 1) {
                header("Location: home");
            }
        }
    }
?>
<!doctype html>
<html lang="en">
<?php if (isset($_SESSION['id'])) { ?>
    <?php include_once '../includes/header.php';
    $username = $_SESSION['username'];
    $user = new manageUsers();
    $user_info = $user->getUserInfo($username);

    foreach ($user_info as $value) {
        $username = $value['username'];
        $firstname = $value['firstname'];
        $lastname = $value['lastname'];
        $email = $value['email'];
        $age = $value['age'];
        $gender = $value['gender'];
        $sexual_pref = $value['sexual_pref'];
        $about = $value['about'];
        $interests = $value['interests'];
    }
    ?>
    <body>
    <?php include_once '../includes/navbar.php';?>
    <div id="user-profile-2" class="user-profile" style="padding-top: 70px">
        <div class="table">
            <ul class="nav nav-tabs padding-18">
                <li class="active">
                    <a data-toggle="tab" href="#">
                        <i class="green ace-icon fa fa-user bigger-120"></i>
                        Edit Profile
                    </a>
                </li>
            </ul>
            <div class="container">
                <div id="accordion">
                    <form method="post" action="editProfile">
                        <div class="card card-default">
                            <div class="card-header">
                                <h4 class="card-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                                        <i class="glyphicon glyphicon-user text-gold"></i>
                                        <b>Edit profile</b>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse1" class="collapse show">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label">Username</label>
                                                <input type="text" class="form-control" name="username" value="<?php echo $username; ?>" disabled="disabled"/>
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label">First Name</label>
                                                <input type="text" class="form-control" name="fname" value="<?php if (!empty($_POST['fname'])) { echo $_POST['fname']; } ?>" autofocus/>
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label">Last Name</label>
                                                <input type="text" class="form-control" name="lname" value="<?php if (!empty($_POST['lname'])) { echo $_POST['lname']; } ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-lg-1">
                                            <div class="form-group">
                                                <label class="control-label">Age</label>
                                                <input class="form-control" name="age" type="number" value="<?php echo $age; ?>" disabled="disabled"/>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label">Gender</label>
                                                <small>e.g Male, Female, or Other which is bio</small>
                                                <input type="text" name="gender" class="form-control" value="<?php echo $gender; ?>" disabled="disabled"/>
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label">Sexual Preference</label>
                                                <small>e.g Male, Female, or Other which is both</small>
                                                <input type="text" name="sex_pref" class="form-control" value="<?php if (!empty($_POST['sex_pref'])) { echo $_POST['sex_pref']; } ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-lg-5">
                                            <div class="form-group">
                                                <label class="control-label">Email</label>
                                                <input type="email" class="form-control" name="email" value="<?php if (!empty($_POST['email'])) { echo $_POST['email']; } ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label">Country</label>
                                                <input type="text" name="country" class="form-control" value="<?php if (!empty($_POST['country'])) { echo $_POST['country']; } ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label">City</label>
                                                <input type="text" name="city" class="form-control" value="<?php if (!empty($_POST['city'])) { echo $_POST['city']; } ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-12">
                                            <div class="form-group">
                                                <label class="control-label">Biography</label>
                                                <textarea type="text" name="about" class="form-control" rows="5"
                                                          cols="50"><?php if (!empty($_POST['about'])) { echo $_POST['about']; } ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-12">
                                            <div class="form-group">
                                                <label class="control-label">Interests
                                                    <small>e.g #soccer, #coding</small>
                                                </label>
                                                <textarea type="text" name="interests" class="form-control" rows="4"
                                                          cols="50"><?php if (!empty($_POST['interests'])) { echo $_POST['interests']; } ?></textarea>
                                            </div>
<!--                                        </div>-->
<!--                                        <div class="col-md-3 col-lg-5">-->
<!--                                            <div class="form-group">-->
<!--                                                <label class="control-label">Profile Pic</label>-->
<!--                                                <div id="wrapper">-->
<!--                                                    <input type="file" name="prof_pic" accept="image/*"-->
<!--                                                           onchange="preview_image(event)">-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                        <div class="col-md-1 col-lg-3">-->
<!--                                            <div class="form-group">-->
<!--                                                <img id="output_image" src="../images/photo.png"/>-->
<!--                                            </div>-->
<!--                                        </div>-->
                                    </div>
                                    <?php
                                    if (isset($error)) {
                                        echo "<div class='alert alert-danger'>" . $error . "</div>";
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div>
                                                <input type="submit" name="submit" class="btn btn-lg btn-primary btn-block"
                                                       id="btnSubmit" value="Update" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include_once '../includes/footer.php';?>
    </body>
<?php } else {
    header("Location: ../frontEnd/login");
} ?>
</html>