<?php
/**
 * Created by PhpStorm.
 * User: mmthethw
 * Date: 2018/10/19
 * Time: 12:46
 */
    session_start();

?>

<!doctype html>
<html lang="en">
    <?php include_once '../includes/header.php' ?>
    <link type="text/css" rel="stylesheet" href="../css/messaging.css">
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css'><link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>
    <style>
        #frame {
            width: 95%;
            min-width: 360px;
            max-width: 1000px;
            height: 92vh;
            min-height: 300px;
            max-height: 720px;
            background: #E6EAEA;
            margin: auto;
            position: relative;
            top: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "proxima-nova", "Source Sans Pro", sans-serif;
            font-size: 1em;
            letter-spacing: 0.1px;
            color: #32465a;
            text-rendering: optimizeLegibility;
            text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.004);
            -webkit-font-smoothing: antialiased;
        }

        #frame .content .messages ul li.sent img {
            float: left;
            margin: 6px 8px 0 0;
        }
        #frame .content .messages ul li.sent p {
            float: left;
            background: #435f7a;
            color: #f5f5f5;
        }
    </style>
    <?php if (isset($_SESSION['id'])) { ?>
    <?php include_once '../includes/header.php';
    $info = new manageUsers();
    $username = $_SESSION['username'];
    $userInfo = $info->getUserInfo($username);
    foreach ($userInfo as $value) {
        $fname = $value['firstname'];
        $lname = $value['lastname'];
        $prof_pic = $value['profile_pic'];
        $active = $value['active'];
    }

    ?>
        <body>
        <?php if (isset($_SESSION['id'])) { ?>
            <?php include_once '../includes/navbar.php' ?>
            <div id="frame">
                <div id="sidepanel">
                    <div id="profile">
                        <div class="wrap">
                            <?php
                            if ($active == 1) { ?>
                                <img id="profile-img" src="<?php echo '../photos/'.$prof_pic; ?>" class="online" alt="" />
                            <?php } ?>
                            <p><?php echo $fname . " " . $lname; ?></p>
                            <p><?php echo '@' . $username; ?></p>
                            <i class="fa fa-chevron-down expand-button" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div id="contacts">
                    <?php
                        $likes = new matched();
                        $userLiked = $likes->friends($_SESSION['id']);
                        foreach ($userLiked as $v) {
                            $userId = $v['userId'];
                            $liked = $v['userLikedId'];
                            $likBack = $v['likeBack'];
                            $stats = $v['status'];

                            if ($stats == 1) {
                                $friend = $info->getFriends($userId, $liked);
                                foreach ($friend as $list) {
                                    if ($list['id'] != $_SESSION['id']) { ?>
                                        <a style="text-decoration: none; color: white"
                                           href="messaging?id=<?php echo $list['id']; ?>">
                                            <ul>
                                                <li class="contact">
                                                    <div class="wrap">
                                                        <?php
                                                        if ($list['active'] == 1) { ?>
                                                            <span class="contact-status online"></span>
                                                        <?php } else { ?>
                                                            <span class="contact-status offline"></span>
                                                        <?php } ?>
                                                        <img src="<?php echo '../photos/' . $list['profile_pic']; ?>"
                                                             alt=""/>
                                                        <div class="meta">
                                                            <p class="name"><?php echo $list['firstname'] . " " . $list['lastname']; ?></p>
                                                            <?php
                                                                $chat = new messages();
                                                                $prev = $chat->getPrev($_SESSION['id']);
                                                                foreach ($prev as $val) {
                                                                    $prvMsg = $val['msg'];
                                                                    $sender = $val['userId'];
                                                                    $st = $val['status'];
                                                                }
                                                            if (isset($sender) && $sender === $list['id']) {
                                                                if ($st === '0') {
                                                                    ?>
                                                                    <p class="preview"
                                                                       id="show" style="color: red"><?php echo $prvMsg; ?></p>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <p class="preview"
                                                                       id="show"><?php echo $prvMsg; ?></p>
                                                                    <?php
                                                                }
                                                            }

                                                            ?>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </a>
                                    <?php }
                                }
                            }
                        }
                    ?>
                    </div>
                </div>
                <div class="content">
                <?php if (isset($_GET['id'])) {
                        $user = $info->getUserById($_GET['id']);
                        foreach ($user as $users) {
                            $firstname = $users['firstname'];
                            $lastname = $users['lastname'];
                            $profile_pic = $users['profile_pic'];
                            $activ = $users['active'];
                        }

                        $update = new messages();
                        $update->updateStatus($_GET['id']);
                    ?>
                        <div class="contact-profile">
                            <img src="<?php echo '../photos/'.$profile_pic; ?>" alt="" />
                            <p><?php echo $firstname . " " . $lastname; ?></p>
                        </div>
                        <div class="messages">
                            <ul>
                                <span class="msg"></span>
                            </ul>
                        </div>
                        <div class="message-input">
                            <div class="wrap">
                                <input type="text" class="text" placeholder="Write your message..." value="<?php if(isset($_POST['name'])) echo $_POST['name']; ?>" name="msg" />
                                <i class="fa fa-paperclip attachment" aria-hidden="true"></i>
                                <button class="submit msg_btn" onclick="chat.sendMessages();" ><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                            </div>
                        </div>
                <?php } ?>
                </div> <!--- --->
            </div>

            <?php include_once '../includes/footer.php' ?>
            <script>
                var chat = {}
                chat.fetchMessages = function () {
                    $.ajax({
                       url: 'fetch.php?id=<?php echo $_GET['id'] ?>',
                        type: 'post',
                        data: { method: 'fetch' },
                        success: function (data) {
                            $('.messages .msg').html(data);
                        }
                    });
                };

                chat.fetchPrev = function () {
                    $.ajax({
                        url: 'fetch.php?id=<?php echo $_GET['id'] ?>',
                        type: 'post',
                        data: { method: 'preview' },
                        success: function (data) {
                            $('.prev').html(data);
                        }
                    });
                };

                // chat.interval = setInterval(chat.fetchPrev, 1000);
                chat.fetchPrev();

                chat.msg = $('.text');
                chat.sendMessages = function () {
                    var msg = chat.msg.val();
                    if ($.trim(msg).length != 0) {
                        console.log(msg);
                        $.ajax({
                            url: 'fetch.php?id=<?php echo $_GET['id'] ?>',
                            type: 'post',
                            data: { method: 'throw', message: msg },
                            success: function (data) {
                                if (data == "done") {
                                    chat.fetchMessages();
                                    chat.msg.val('');
                                }
                            }
                        });
                    }
                };

                chat.interval = setInterval(chat.fetchMessages, 1000);
                chat.fetchMessages();
            </script>
        <?php  } else {
          header("Location:../frontEnd/login");
        } ?>
        </body>
    <?php } else {
        header("Location: ../frontEnd/login");
    } ?>
</html>