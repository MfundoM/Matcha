<?php
/**
 * Created by PhpStorm.
 * User: mmthethw
 * Date: 2018/11/05
 * Time: 12:32
 */
    require_once '../classes/class.manageUsers.php';
    require_once  '../includes/form_cleaner.php';

    if (isset($_GET['username'])) {
        $verify = new manageUsers();
        $verifyEmail = $verify->verify(sanitize($_GET['username']));
        if ($verifyEmail == 1) {
            header("Location: ../frontEnd/login");
        }
    }