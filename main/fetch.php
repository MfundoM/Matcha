<?php
/**
 * Created by PhpStorm.
 * User: Mthethwa
 * Date: 11/2/2018
 * Time: 11:43 AM
 */

    session_start();
    require_once '../includes/form_cleaner.php';
    require_once '../classes/class.messages.php';
    require_once('../classes/class.likes.php');
    require_once('../classes/class.notifications.php');
    require_once('../classes/class.messages.php');

    if (isset($_POST['method']) === true && empty($_POST['method']) === false) {
        $chat = new messages();
        $method = $_POST['method'];

        if ($method === 'fetch') {
            $msg = $chat->getMessages();
            if (empty($msg) === true) {
                echo 'There are currently no messages in this chat';
            } else {
                foreach ($msg as $array) {
                    if ($array['userId'] === $_GET['id'] && $_SESSION['id'] === $array['recieverId']) {
                        ?>
                            <li class="sent">
                                <img src="<?php echo '../photos/'.$array['profile_pic']; ?>" alt=""/>
                                <p><?php echo $array['msg']; ?> <span style="color: #2f6f9f;"><?php echo $array['date_sent']; ?></span></p>
                            </li>
                        <?php
                    } else if ($array['userId'] === $_SESSION['id'] && $_GET['id'] === $array['recieverId']) {
                        ?>
                            <li class="replies">
                                <img src="<?php echo '../photos/'.$array['profile_pic']; ?>" alt=""/>
                                <p><?php echo $array['msg']; ?> <span style="color: #2f6f9f;"><?php echo $array['date_sent']; ?></span><span class="fa fa-check"
                                                                                          style="float: right"></span></p>
                            </li>
                        <?php
                    }
                }
            }
        } else if ($method === "throw" && isset($_POST['message']) === true) {
            $msgToSend = sanitize($_POST['message']);
            $date = date('Y-m-d H:i');

            if (empty($msgToSend) === false) {
                $sendMsg = $chat->InsertMessages($_SESSION{'id'}, $_GET['id'], $msgToSend, $date);
                if ($sendMsg == 1) {
                    echo "done";
                }
            }
        } else if ($method === "preview") {
            $prev = $chat->getPrev($_GET['id'], $_SESSION['id']);
            foreach ($prev as $v) {
                $prvMsg = $v['msg'];
            }
            ?>
                <p class="preview" id="show"><?php echo $prvMsg; ?></p>
            <?php
        } else if ($method === "views") {
            $view = new likes();
            $views = $view->fetchViews($_SESSION['id']);
            ?>
                <span class="view"><?php echo ' '.$views; ?></span>
            <?php
        } else if ($method === "likes") {
            $like = new likes();
            $likes = $like->fetchLikes($_SESSION['id']);
            ?>
                <span class="like"><?php echo ' '.$likes; ?></span>
            <?php
        } else if ($method === "notifications") {
            $notify = new notifications();
            $userNotify = $notify->fetchNumberOfNotifications($_SESSION['id']);
            ?>
                <span class="badge badge-danger notify"><?php echo $userNotify; ?></span>
            <?php
        } else if ($method === "msgNotifications") {
            $msgNotify = new messages();
            $msgNotification = $msgNotify->getMessagesNumber($_SESSION['id']);
            ?>
                <span class="badge badge-danger msg"><?php echo $msgNotification; ?></span>
            <?php
        }
    }