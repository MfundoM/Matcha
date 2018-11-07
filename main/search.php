<?php
/**
 * Created by PhpStorm.
 * User: mmthethw
 * Date: 2018/10/18
 * Time: 08:10
 */
    session_start();
    include_once('../includes/form_cleaner.php');

    if (isset($_POST['search'])) {
        if ($_POST['look'] === 'age') {
            header("Location: searchage");
        } else {
            header("Location: searchform");
        }
    }
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
                        <strong> Search By</strong>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="">
                            <select style="width: 100%" name="look">
                                <optgroup label="Search options">
                                    <option value="age">Age</option>
                                    <option value="location">Location</option>
                                    <option value="interests">Interests</option>
                                    <option value="rating">Fame rating</option>
                                </optgroup>
                            </select>
                            <p></p>
                            <div class="form-group">
                                <input type="submit" name="search" class="btn btn-lg btn-primary btn-block" value="Search">
                            </div>
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
