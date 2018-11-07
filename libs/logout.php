<?php
/**
 * Created by PhpStorm.
 * User: mmthethw
 * Date: 2018/09/27
 * Time: 13:06
 */

    session_start();

    include_once('../classes/class.manageUsers.php');
    include_once('../classes/nocsrf.php');
    include_once('../includes/form_cleaner.php');

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $_SESSION['username'] = null;
    }

    $user = new manageUsers();
    $logout = $user->updateLastseen($username);
    if ($logout == 1) {
        $deactive = $user->deactivate($username);
        if ($deactive == 1) {
            session_destroy();
            unset($_SESSION);
            header("Location: ../frontEnd/login");
        }
    }