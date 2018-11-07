<?php
/**
 * Created by PhpStorm.
 * User: Mthethwa
 * Date: 10/21/2018
 * Time: 9:37 AM
 */

    session_start();
    require_once('../classes/class.likes.php');
    require_once('../classes/class.notifications.php');
    require_once('../classes/class.manageUsers.php');
    require_once('../classes/class.matched.php');

    if (isset($_POST['content_id'])) {
        $date = date('Y-m-d H:i');
        $getInfo = new manageUsers();
        $userInfo = $getInfo->getUserById($_SESSION['id']);
        foreach ($userInfo as $value) {
            $fname = $value['firstname'];
            $lname = $value['lastname'];
        }
        $msg = $fname . " " . $lname . " Unliked your profile";

        $unlike = new likes();
        $hate = $unlike->unlike($_SESSION['id'], $_POST['content_id']);
        if ($hate === 1) {
            $notify = new notifications();
            $addNotify = $notify->addNotification($_SESSION['id'], $_POST['content_id'], $msg, $date);
            if ($addNotify == 1) {
                echo "done";
            }
        }
    }
?>