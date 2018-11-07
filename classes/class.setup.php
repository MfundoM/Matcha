<?php
    include_once('class.dbConection.php');

    class setup {
        public $link;

        function __construct() {
            try {
                $db_con = new dbConection();
                $this->link = $db_con->connection();
                return $this->link;
            } catch(PDOException $e) {
                return $e->getMessage();
            }
        }

        function setUpDatabase() {
            $check = 0;

            $query = "DROP DATABASE IF EXISTS `matcha`";
            if ($this->link->exec($query)) {
                $check = 1;
            }

            $query = "CREATE DATABASE IF NOT EXISTS `matcha`";
            if ($this->link->exec($query)) {
                $check = 1;
            }
            
            $con = new dbConection();
            $conn = $con->connect();

            $query = "CREATE TABLE `users` (
                `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `email` varchar(100) NOT NULL,
                `username` varchar(100) NOT NULL,
                `firstname` varchar(50) NOT NULL,
                `lastname` varchar(50) NOT NULL,
                `password` text NOT NULL,
                `age` int(11) NULL,
                `gender` varchar(50) NOT NULL DEFAULT 'Other',
                `sexual_pref` varchar(50) NOT NULL DEFAULT 'Other',
                `about` text NULL,
                `interests` text NULL,
                `profile_pic` varchar(255) NULL,
                `country` varchar(50) NULL,
                `city` varchar(50) NULL,
                `signup_date` varchar(50) NOT NULL DEFAULT '0000-00-00 00:00',
                `last_seen` varchar(50) NOT NULL DEFAULT '0000-00-00 00:00',
                `active` enum('0','1') NOT NULL DEFAULT '0',
                `rating` varchar(50) NOT NULL DEFAULT 'Ameture',
                `blocked` INT(11) NOT NULL DEFAULT '0',
                `report` INT(11) NOT NULL DEFAULT '0',
                `verified` VARCHAR(1) NOT NULL DEFAULT 'N'
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
            if ($conn->exec($query)) {
                $check = 1;
            }

            $query = "CREATE TABLE `gallery` (
                `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `user_id` int(255) NOT NULL,
                `imageName` text NOT NULL,
                `upload_date` TIMESTAMP,
                `delete_date` DATETIME
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
            if ($conn->exec($query)) {
                $check = 1;
            }

            $query = "CREATE TABLE `likes` (
                  `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                  `userId` int(11) NOT NULL,
                  `userLikedId` int(11) NOT NULL,
                  `status` enum('0','1') NOT NULL DEFAULT '0',
                  `like_date` varchar(50) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
            if ($conn->exec($query)) {
                $check = 1;
            }

            $query = "CREATE TABLE `friends` (
                  `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                  `userId` int(11) NOT NULL,
                  `userLikedId` int(11) NOT NULL,
                  `likeBack` int(11) NOT NULL,
                  `status` enum('0','1') NOT NULL DEFAULT '0',
                  `like_date` varchar(50) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
            if ($conn->exec($query)) {
                $check = 1;
            }

            $query = "CREATE TABLE `notifications` (
                  `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                  `userId` int(11) NOT NULL,
                  `userToBeNotified` int(11) NOT NULL,
                  `msg` text NOT NULL,
                  `notify_date` varchar(50) NOT NULL,
                  `status` enum('0','1') NOT NULL DEFAULT '0'
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
            if ($conn->exec($query)) {
                $check = 1;
            }

            $query = "CREATE TABLE `views` (
                  `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                  `userId` int(10) NOT NULL,
                  `userViewedId` int(10) NOT NULL,
                  `view_date` varchar(50) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
            if ($conn->exec($query)) {
                $check = 1;
            }

            $query = "CREATE TABLE `messages` (
                  `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                  `userId` int(10) NOT NULL,
                  `recieverId` int(10) NOT NULL,
                  `msg` text NOT NULL,
                  `status` ENUM('0','1') NOT NULL DEFAULT '0',
                  `date_sent` varchar(50) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
            if ($conn->exec($query)) {
                $check = 1;
            }

            // begin the transaction
            $conn->beginTransaction();
            // our SQL statements
            $password = hash('whirlpool', "1234@r");
            $date = date('Y-m-d H:i:s');

            $conn->exec("INSERT INTO users (email, username, firstname, lastname, password, age,
            gender, sexual_pref, about, interests, profile_pic, country, city, signup_date)
            VALUES ('john@example.com', 'john', 'John', 'Doe', '$password', '25', 'Male', 'Female', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.',
            '#coding, #running, #Traveling', '1.jpg', 'South Africa', 'Pretoria', '$date')");
            $conn->exec("INSERT INTO users (email, username, firstname, lastname, password, age,
            gender, sexual_pref, about, interests, profile_pic, country, city, signup_date)
            VALUES ('jane@yahoo.com', 'jane', 'Jane', 'More', '$password', '30', 'Female', 'Male', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.',
            '#coding, #running, #Traveling', '1.jpg', 'South Africa', 'Johannesburg', '$date')");
            $conn->exec("INSERT INTO users (email, username, firstname, lastname, password, age,
            gender, sexual_pref, about, interests, profile_pic, country, city, signup_date)
            VALUES ('mary@gmail.com', 'mary', 'Mary', 'Ndlovu', '$password', '28', 'Female', 'Male', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.',
            '#Eating, #Reading, #Traveling', '1.jpg', 'South Africa', 'Cape Town', '$date')");
            $conn->exec("INSERT INTO users (email, username, firstname, lastname, password, age,
            gender, sexual_pref, about, interests, profile_pic, country, city, signup_date)
            VALUES ('joe@example.com', 'joe', 'Joe', 'Thwala', '$password', '35', 'Male', 'Male', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.',
            '#Walking, #GoingOut', '1.jpg', 'South Africa', 'Limpopo', '$date')");
            $conn->exec("INSERT INTO users (email, username, firstname, lastname, password, age,
            gender, sexual_pref, about, interests, profile_pic, country, city, signup_date)
            VALUES ('garry@amazon.com', 'garry', 'Garry', 'Kabongo', '$password', '23', 'Male', 'Female', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.',
            '#coding, #running, #Traveling', '1.jpg', 'South Africa', 'Durban', '$date')");
            $conn->exec("INSERT INTO users (email, username, firstname, lastname, password, age,
            gender, sexual_pref, about, interests, profile_pic, country, city, signup_date)
            VALUES ('nacy@example.com', 'nacy', 'Nacy', 'Chan', '$password', '40', 'Female', 'Female', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.',
            '#coding, #eating, #Traveling', '1.jpg', 'South Africa', 'Pretoria', '$date')");
            $conn->exec("INSERT INTO users (email, username, firstname, lastname, password, age,
            gender, sexual_pref, about, interests, profile_pic, country, city, signup_date)
            VALUES ('panny@jhb.com', 'panny', 'Panny', 'Cooper', '$password', '27', 'Female', 'Male', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.',
            '#coding, #running, #Traveling', '1.jpg', 'South Africa', 'Krugersdorp', '$date')");
            $conn->exec("INSERT INTO users (email, username, firstname, lastname, password, age,
            gender, sexual_pref, about, interests, profile_pic, country, city, signup_date)
            VALUES ('mbongeni@github.com', 'mbongeni', 'Mbongeni', 'Ndlovu', '$password', '30', 'Male', 'Female', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.',
            '#coding, #running, #Traveling', '1.jpg', 'South Africa', 'Johannesburg', '$date')");
            $conn->exec("INSERT INTO users (email, username, firstname, lastname, password, age,
            gender, sexual_pref, about, interests, profile_pic, country, city, signup_date)
            VALUES ('zoe@clicks.co.za', 'zoe', 'Zoe', 'Malema', '$password', '32', 'Female', 'Male', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.',
            '#coding, #running, #Traveling', '1.jpg', 'South Africa', 'Johannesburg', '$date')");
            $conn->exec("INSERT INTO users (email, username, firstname, lastname, password, age,
            gender, sexual_pref, about, interests, profile_pic, country, city, signup_date)
            VALUES ('shaldon@bing.com', 'shaldon', 'Shaldon', 'Cooper', '$password', '26', 'Male', 'Female', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.',
            '#coding, #running, #Traveling', '1.jpg', 'South Africa', 'Pretoria', '$date')");
            $conn->exec("INSERT INTO users (email, username, firstname, lastname, password, age,
            gender, sexual_pref, about, interests, profile_pic, country, city, signup_date)
            VALUES ('gwen@takealot.co.za', 'gwen', 'Gwen', 'Shayi', '$password', '29', 'Female', 'Male', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.',
            '#coding, #running, #Traveling', '1.jpg', 'South Africa', 'Pretoria', '$date')");
            $conn->exec("INSERT INTO users (email, username, firstname, lastname, password, age,
            gender, sexual_pref, about, interests, profile_pic, country, city, signup_date)
            VALUES ('lucky@unity.com', 'lucky', 'Lucky', 'Makhathini', '$password', '37', 'Male', 'Female', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.',
            '#coding, #running, #Traveling', '1.jpg', 'South Africa', 'Johannesburg', '$date')");
            $conn->exec("INSERT INTO users (email, username, firstname, lastname, password, age,
            gender, sexual_pref, about, interests, profile_pic, country, city, signup_date)
            VALUES ('zodwa@nibbler.com', 'zodwa', 'Zodwa', 'Swift', '$password', '20', 'Female', 'Male', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.',
            '#coding, #running, #Traveling', '1.jpg', 'South Africa', 'Johannesburg', '$date')");

            // commit the transaction
            if ($conn->commit()) {
                $check = 1;
            } else {
                // roll back the transaction if something failed
                $conn->rollback();
            }

            return $check;
        }
    }
?>