<?php
/**
 * Created by PhpStorm.
 * User: mmthethw
 * Date: 2018/09/25
 * Time: 11:08
 */
    include_once('classes/class.setup.php');

    $database = new setup();
    $setupDatabase = $database->setUpDatabase();
    if ($setupDatabase == 1) {
        header("Location: frontEnd/login");
    }
?>
