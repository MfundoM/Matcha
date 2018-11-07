<?php
/**
 * Created by PhpStorm.
 * User: Mthethwa
 * Date: 10/21/2018
 * Time: 12:25 PM
 */

    include_once('class.dbConection.php');

    class notifications
    {
        public $link;

        function __construct()
        {
            $connection = new dbConection();
            $this->link = $connection->connect();
            return $this->link;
        }

        function addNotification($userId, $userToBeNotified, $msg, $notify_date) {
            $query = $this->link->prepare("INSERT INTO notifications (userId, userToBeNotified, msg, notify_date) VALUES (?, ?, ?,?)");
            $values = array($userId, $userToBeNotified, $msg, $notify_date);
            $query->execute($values);
            $rowCount = $query->rowCount();
            return $rowCount;
        }

        function fetchNumberOfNotifications($userToBeNotified) {
            $query = $this->link->prepare("
                                      SELECT `notifications`.*,
                                              `users`.*
                                      FROM   `notifications`
                                      JOIN   `users`
                                      ON     `notifications`.`userId` = `users`.`id`
                                      WHERE  `notifications`.`userToBeNotified` = ?
                                      AND    `notifications`.`status` = '0'
                                      AND    `users`.`blocked` <> ?
                                      AND    `users`.report <> ?
                                  ");
            $value = array($userToBeNotified, $_SESSION['id'], $_SESSION['id']);
            $query->execute($value);
            $rowCount = $query->rowCount();
            return $rowCount;
        }

        function fetchNotificationData($userToBeNotified) {
            $query = $this->link->prepare("
                                      SELECT `notifications`.*,
                                             `users`.*
                                      FROM   `notifications`
                                      JOIN   `users`
                                      ON     `notifications`.`userId` = `users`.`id`
                                      WHERE  `notifications`.`userToBeNotified` = ?
                                      AND    `notifications`.`status` = '0'
                                      AND    `users`.`blocked` <> ?
                                      AND    `users`.report <> ?
                                      ORDER BY notify_date
                                      DESC
                                  ");
            $value = array($userToBeNotified, $_SESSION['id'], $_SESSION['id']);
            $query->execute($value);
            $results = $query->fetchAll();
            return $results;
        }

        function updateViewed($id) {
            $query = $this->link->query("UPDATE notifications SET status = '1' WHERE userId = $id");
            $rowCount = $query->rowCount();
            return $rowCount;
        }
    }