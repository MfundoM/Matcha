<?php
/**
 * Created by PhpStorm.
 * User: mmthethw
 * Date: 2018/10/18
 * Time: 08:10
 */
    session_start();
?>
<!doctype html>
<html lang="en">
<?php if (isset($_SESSION['id'])) { ?>
    <?php include_once '../includes/header.php';
    ?>
    <body>
    <?php include_once '../includes/navbar.php';?>
    <div class="container" style="margin-top:100px">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong> Search</strong>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="displaySearch">
                            <div class="form-group">
                                <div class="input-group">
												<span class="input-group-addon">
													<i class="glyphicon glyphicon-search"></i>
												</span>
                                    <input class="form-control" placeholder="Age from" name="age" type="number" id="age">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
												<span class="input-group-addon">
													<i class="glyphicon glyphicon-search"></i>
												</span>
                                    <input class="form-control" placeholder="Age to" name="age1" type="number" id="age1">
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="search" class="btn btn-lg btn-primary btn-block" value="Search">
                            </div>
                            <?php
                            if (isset($error)) {
                                echo "<div class='alert alert-danger'>" . $error . "</div>";
                            }
                            ?>
                        </form>
                    </div>
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