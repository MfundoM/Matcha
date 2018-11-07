<?php
/**
 * Created by PhpStorm.
 * User: mmthethw
 * Date: 2018/09/25
 * Time: 11:12
 */

    include_once('../libs/login.php');
    include_once('../includes/funtions.php');
    include_once('../includes/form_cleaner.php');

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <link type="text/css" rel="stylesheet" href="../bootstrap/dist/css/bootstrap.min.css" id="bootstrap-css">
    <link rel="stylesheet" href="../bootstrap/dist/js/bootstrap.min.js">
    <link type="text/css" rel="stylesheet" href="../css/style.css">
    <script type="text/javascript" src="../js/functions.js"></script>
    <style>
        .panel-heading {
            padding: 5px 15px;
        }

        .panel-footer {
            padding: 1px 15px;
            color: #A0A0A0;
        }

        .profile-img {
            width: 96px;
            height: 96px;
            margin: 0 auto 10px;
            display: block;
            -moz-border-radius: 50%;
            -webkit-border-radius: 50%;
            border-radius: 50%;
        }
    </style>
</head>
<body>
<?php include_once '../includes/navbar.php'; ?>
<div class="container" style="margin-top:100px">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong> Sign In</strong>
                </div>
                <div class="panel-body">
                    <form role="form" action="login" method="POST">
                        <fieldset>
                            <div class="row">
                                <div class="center-block">
                                    <img class="profile-img"
                                         src="../images/photo.png" alt="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-10  col-md-offset-1 ">
                                    <div class="form-group">
                                        <div class="input-group">
												<span class="input-group-addon">
													<i class="glyphicon glyphicon-user"></i>
												</span>
                                            <input class="form-control" placeholder="Username" name="username" type="text" value="<?php if (!empty($_POST['username'])) { echo sanitize($_POST['username']); } ?>" autofocus>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
												<span class="input-group-addon">
													<i class="glyphicon glyphicon-lock"></i>
												</span>
                                            <input class="form-control" placeholder="Password" name="password" type="password" id="password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="checkbox" onclick="myFunction()"> Show Password
                                    </div>
                                    <!-- CSRF token holder -->
                                    <td><input type="hidden" name="csrf_token" value="<?php if (isset($token)) { echo $token; } ?>"></td>
                                    <!-- CSRF token holder -->
                                    <div class="form-group">
                                        <input type="submit" name="signin" class="btn btn-lg btn-primary btn-block" value="Sign In">
                                    </div>
                                    <div class="form-group">
                                        <a href="resetPass" onClick=""> Forgot password? </a>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <?php
                        if (isset($_GET['msg'])) {
                            echo "<div class='alert alert-success'>Password was changed successfully</div>";
                        }
                        if (isset($error)) {
                            echo "<div class='alert alert-danger'>" . $error . "</div>";
                        }
                        ?>
                    </form>
                </div>
                <div class="panel-footer ">
                    Don't have an account? <a href="signup" onClick=""> Sign Up </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once '../includes/footer.php'; ?>
</body>
</html>