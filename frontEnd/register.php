<?php
/**
 * Created by PhpStorm.
 * User: mmthethw
 * Date: 2018/09/25
 * Time: 11:13
 */

    include_once('../libs/register.php');
    include_once('../classes/class.manageUsers.php');
    include_once('../classes/nocsrf.php');
    include_once('../includes/form_cleaner.php');

    if (isset($_SESSION['id'])) {

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
            $country  = $value['country'];
            $city = $value['city'];
        }

        if (empty($age) || empty($about) && empty($interests) || empty($country) || empty($city)) { ?>

            <!doctype html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport"
                      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <title>Register</title>
                <script type="text/javascript" src="../js/jquery.min.js"></script>
                <link type="text/css" rel="stylesheet" href="../bootstrap/dist/css/bootstrap.min.css"
                      id="bootstrap-css">
                <link rel="stylesheet" href="../bootstrap/dist/js/bootstrap.min.js">
                <link type="text/css" rel="stylesheet" href="../css/style.css">
                <script type="text/javascript" src="../js/functions.js"></script>
                <script type="text/javascript">
                    function preview_image(event) {
                        var reader = new FileReader();
                        reader.onload = function () {
                            var output = document.getElementById('output_image');
                            output.src = reader.result;
                        }
                        reader.readAsDataURL(event.target.files[0]);
                    }
                </script>
                <style>
                    .card-default {
                        color: #333;
                        background: linear-gradient(#fff, #ebebeb) repeat scroll 0 0 transparent;
                        font-weight: 600;
                        border-radius: 6px;
                    }

                    #wrapper {
                        text-align: center;
                        margin: 0 auto;
                        padding: 0px;
                        width: 400px;
                    }

                    .wrapper {
                        text-align: center;
                        margin: 0 auto;
                        padding: 0;
                        width: 100px;
                    }

                    #output_image {
                        vertical-align: middle;
                        width: 180px;
                        height: 180px;
                        border-radius: 50%;
                    }

                </style>
            </head>
            <body>
            <?php include_once '../includes/navbar.php'; ?>
            <div class="container">
                <div id="accordion">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <h3>Profile</h3>
                            </div>
                        </div>
                    </div>
                    <form method="post" action="register" enctype="multipart/form-data">
                        <div class="card card-default">
                            <div class="card-header">
                                <h4 class="card-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                                        <i class="glyphicon glyphicon-user text-gold"></i>
                                        <b>Complete profile registration</b>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse1" class="collapse show">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label">Username</label>
                                                <input type="text" class="form-control" name="username" value="<?php echo sanitize($username); ?>" disabled="disabled"/>
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label">First Name</label>
                                                <input type="text" class="form-control" value="<?php echo sanitize($firstname); ?>" disabled="disabled"/>
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label">Last Name</label>
                                                <input type="text" class="form-control" value="<?php echo sanitize($lastname); ?>" disabled="disabled"/>
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-lg-1">
                                            <div class="form-group">
                                                <label class="control-label">Age</label>
                                                <input class="form-control" name="age" type="number" value="<?php if (!empty($_POST['age'])) { echo sanitize($_POST['age']); } ?>" autofocus/>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label">Gender</label>
                                                <small>e.g Male, Female, or Other</small>
                                                <input type="text" name="gender" class="form-control" value="<?php if (!empty($_POST['gender'])) { echo sanitize($_POST['gender']); } ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label">Sexual Preference</label>
                                                <small>e.g Male, Female, or Other which is both</small>
                                                <input type="text" name="sex_pref" class="form-control" value="<?php if (!empty($_POST['sex_pref'])) { echo sanitize($_POST['sex_pref']); } ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-lg-5">
                                            <div class="form-group">
                                                <label class="control-label">Email</label>
                                                <input type="text" class="form-control" value="<?php echo sanitize($email); ?>" disabled="disabled"/>
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label">Country</label>
                                                <input type="text" name="country" class="form-control" value="<?php if (!empty($_POST['country'])) { echo sanitize($_POST['country']); } ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label">City</label>
                                                <input type="text" name="city" class="form-control" value="<?php if (!empty($_POST['city'])) { echo sanitize($_POST['city']); } ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-12">
                                            <div class="form-group">
                                                <label class="control-label">Biography</label>
                                                <textarea type="text" name="about" class="form-control" rows="5"
                                                          cols="50"><?php if (!empty($_POST['about'])) { echo sanitize($_POST['about']); } ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-12">
                                            <div class="form-group">
                                                <label class="control-label">Interests
                                                    <small>e.g #soccer, #coding</small>
                                                </label>
                                                <textarea type="text" name="interests" class="form-control" rows="4"
                                                          cols="50"><?php if (!empty($_POST['interests'])) { echo sanitize($_POST['interests']); } ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-5">
                                            <div class="form-group">
                                                <label class="control-label">Profile Pic</label>
                                                <div id="wrapper">
                                                    <input type="file" name="prof_pic" accept="image/*"
                                                           onchange="preview_image(event)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-lg-3">
                                            <div class="form-group">
                                                <img id="output_image" src="../images/photo.png"/>
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
                                                <input type="submit" name="submit" class="btn btn-lg btn-primary btn-block"
                                                   id="btnSubmit" value="Save" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php include_once '../includes/footer.php'; ?>
            </body>
            </html>

            <?php
        } else {
            header("Location: ../main/home");
        }
    } else {
        header("Location: login");
    }
?>
