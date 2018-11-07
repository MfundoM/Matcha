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
        $userLikedId = $_POST['content_id'];
        $userId = $_SESSION['id'];
        $date = date('Y-m-d H:i');

        $getInfo = new manageUsers();
        $userInfo = $getInfo->getUserById($userId);
        foreach ($userInfo as $value) {
            $fname = $value['firstname'];
            $lname = $value['lastname'];
        }

        $msg = $fname . " " . $lname . " liked your profile";


        $like = new likes();
        $notify = new notifications();
        $match = new matched();

        $likeinfo = $match->fetchLike($userId, $userLikedId);
        $likeProfile = $like->likeProfile($userId, $userLikedId, $date);

        if ($likeinfo == 0) {
            if ($likeProfile == 1) {
                $addNotify = $notify->addNotification($userId, $userLikedId, $msg, $date);
                if ($addNotify == 1) {
                    $matched = $match->likeProfile($userId, $userLikedId, $date);
                    if ($matched == 1) {
                        echo "done";
                    }
                }
            } else {
                echo "error";
            }
        } else {
            if ($likeProfile == 1) {
                $update = $match->likeBack($userLikedId, $userId);
                if ($update == 1) {
                    $addNotify = $notify->addNotification($userId, $userLikedId, $msg, $date);
                    if ($addNotify == 1) {
                        echo "done";
                    }
                } else {
                    echo "error";
                }
            }
        }
    }
?>