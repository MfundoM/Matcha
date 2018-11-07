<?php
/**
 * Created by PhpStorm.
 * User: mmthethw
 * Date: 2018/09/25
 * Time: 11:12
 */

include_once('../libs/signup.php');
include_once('../includes/form_cleaner.php');
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Signup</title>
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <link type="text/css" rel="stylesheet" href="../bootstrap/dist/css/bootstrap.min.css" id="bootstrap-css">
    <link rel="stylesheet" href="../bootstrap/dist/js/bootstrap.min.js">
    <link type="text/css" rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include_once '../includes/navbar.php'; ?>
<div class="container" style="margin-top:100px">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong> Sign Up</strong>
                </div>
                <div class="panel-body">
                    <form role="form" action="signup" method="POST">
                        <fieldset>
                            <div class="row">
                                <div class="col-sm-12 col-md-10  col-md-offset-1 ">
                                    <div class="form-group">
                                        <div class="input-group">
												<span class="input-group-addon">
													<i class="glyphicon glyphicon-envelope"></i>
												</span>
                                            <input class="form-control" placeholder="Email" name="email" type="email" value="<?php if (!empty($_POST['email'])) { echo sanitize($_POST['email']); } ?>" autofocus>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
												<span class="input-group-addon">
													<i class="glyphicon glyphicon-user"></i>
												</span>
                                            <input class="form-control" placeholder="Username" name="username" type="text" value="<?php if (!empty($_POST['username'])) { echo sanitize($_POST['username']); } ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
												<span class="input-group-addon">
													<i class="glyphicon glyphicon-user"></i>
												</span>
                                            <input class="form-control" placeholder="Firstname" name="firstname" type="text" value="<?php if (!empty($_POST['firstname'])) { echo sanitize($_POST['firstname']); } ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
												<span class="input-group-addon">
													<i class="glyphicon glyphicon-user"></i>
												</span>
                                            <input class="form-control" placeholder="Lastname" type="text" name="lastname" value="<?php if (!empty($_POST['lastname'])) { echo sanitize($_POST['lastname']); } ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
												<span class="input-group-addon">
													<i class="glyphicon glyphicon-lock"></i>
												</span>
                                            <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
												<span class="input-group-addon">
													<i class="glyphicon glyphicon-lock"></i>
												</span>
                                            <input class="form-control" placeholder="RE-Password" name="repassword" type="password" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="signup" class="btn btn-lg btn-primary btn-block" value="Sign Up">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <?php
                        if (isset($success)) {
                            echo "<div class='alert alert-success'>" . $success. "</div>";
                        }
                        ?>
                        <?php
                        if (isset($error)) {
                            echo "<div class='alert alert-danger'>" . $error . "</div>";
                        }
                        ?>
                    </form>
                </div>
                <div class="panel-footer ">
                    Already have an account? <a href="login" onClick=""> Sign In </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once '../includes/footer.php'; ?>
</body>
</html>
