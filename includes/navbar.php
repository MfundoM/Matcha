<?php
/**
 * Created by PhpStorm.
 * User: mmthethw
 * Date: 2018/09/28
 * Time: 11:16
 */
?>

<?php if (isset($_SESSION['id'])) { ?>
    <style>
        /* Style The Dropdown Button */
        .a {
            color: gray;
            margin-top: 15px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        /* The container <div> - needed to position the dropdown content */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        /* Dropdown Content (Hidden by Default) */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        }

        /* Links inside the dropdown */
        .dropdown-content a {
            color: white;
            background-color: rgb(41, 41, 41);
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        /* Change color of dropdown links on hover */
        .dropdown-content a:hover {background-color: black}

        /* Show the dropdown menu on hover */
        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
    <?php if (isset($_GET['reg'])) { ?>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="">Matcha</a>
            </div>
                <ul class="nav navbar-nav navbar-right">
                    <li style="float: right"><a href="../libs/logout"><span class="glyphicon glyphicon-log-out"></span>Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <?php } else { ?>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="">Matcha</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li class="nav-item active"><a href="home" class="nav-link">Home</a></li>
                    <li class="nav-link">
                        <a href="viewNotifications">
                            Notifications
                            <span class="not"></span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="messaging">
                            Messages
                            <span class="msg"></span>
                        </a>
                    </li>
                    <a class="btn btn-success" href="search" style="margin-top: 7px"><i class="glyphicon glyphicon-search"> Search</i></a>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <div class="dropdown">
                        <li class="a"><span class="glyphicon glyphicon-user"></span><span class="caret"></span></li>
                        <lu class="dropdown-content">
                            <li><a href="gallery">Gallery</a></li>
                            <li><a href="editProfile">Edit Profile</a></li>
                            <li><a href="list">Blocked Users</a></li>
                            <li><a href="history">History</a></li>
                        </lu>
                    </div>
                    <li style="float: right"><a href="../libs/logout"><span class="glyphicon glyphicon-log-out"></span>Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <?php } ?>
    <script>
        var chat = {}
        chat.fetchNotification = function () {
            $.ajax({
                url: 'fetch.php',
                type: 'post',
                data: { method: 'notifications' },
                success: function (data) {
                    $('.not').html(data);
                }
            });
        };
        chat.interval = setInterval(chat.fetchNotification, 2000);
        chat.fetchNotification();

        chat.fetchMsgNotification = function () {
            $.ajax({
                url: 'fetch.php',
                type: 'post',
                data: { method: 'msgNotifications' },
                success: function (data) {
                    $('.msg').html(data);
                }
            });
        };
        chat.interval = setInterval(chat.fetchMsgNotification, 2000);
        chat.fetchMsgNotification();
    </script>
<?php } else { ?>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="">Matcha</a>
            </div>
        </div>
    </nav>
<?php } ?>
