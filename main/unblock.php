<?php
/**
 * Created by PhpStorm.
 * User: Mthethwa
 * Date: 11/4/2018
 * Time: 2:33 PM
 */
    session_start();
    require_once('../classes/class.manageUsers.php');

    if (isset($_GET['id'])) {
        $user = new manageUsers();
        $block = $user->unblock($_GET['id']);
        if ($block == 1) {
            header("Location: list");
        }
    }