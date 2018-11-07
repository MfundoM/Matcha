<?php
/**
 * Created by PhpStorm.
 * User: Mthethwa
 * Date: 10/21/2018
 * Time: 4:47 PM
 */
    session_start();
    require_once('../classes/class.likes.php');
    require_once('../classes/class.notifications.php');
    require_once('../classes/class.manageUsers.php');

    if (isset($_SESSION['id'])) {
        if (isset($_GET['id'])) {
            $notification = new notifications();
            $update = $notification->updateViewed($_GET['id']);
            if ($update > 0) {
                header("Location: viewNotifications");
            }
        }
    } else {
        header("Location: ../frontEnd/login");
    }