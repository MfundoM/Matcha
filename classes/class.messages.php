<?php
/**
 * Created by PhpStorm.
 * User: Mthethwa
 * Date: 10/27/2018
 * Time: 2:54 PM
 */

    include_once('class.dbConection.php');

    class messages
    {
        public $link;
        protected $results;
        private $row;

        function __construct() {
            $db_conn = new dbConection();
            $this->link = $db_conn->connect();
            return $this->link;
        }

        function InsertMessages($userId, $recieverId, $msg, $date) {
            $query = $this->link->prepare("INSERT INTO messages (userId, recieverId, msg, date_sent) VALUES (?, ? ,?, ?)");
            $values = array($userId, $recieverId, $msg, $date);
            $query->execute($values);
            $rowCount = $query->rowCount();
            return $rowCount;
        }

        function getMessages() {
            $query = $this->link->prepare("
                SELECT `messages`.*,
                       `users`.*
                FROM   `messages`
                JOIN   `users`
                ON     `messages`.`userId` = `users`.`id`
                ORDER BY `messages`.`date_sent`
                ASC
             ");
            $query->execute();
            $data = $query->fetchAll();
            return $data;
        }

        function getPrev($recieverId) {
            $query = $this->link->prepare("SELECT * FROM messages WHERE recieverId = ?");
            $values = array($recieverId);
            $query->execute($values);
            $data = $query->fetchAll();
            return $data;
        }

        function getMessagesNumber($recieverId) {
            $query = $this->link->prepare("
                                    SELECT `messages`.*,
                                           `users`.*
                                    FROM   `messages`
                                    JOIN   `users`
                                    ON     `messages`.`userId` = `users`.`id`
                                    WHERE  `messages`.`recieverId` = ?
                                    AND    `messages`.`status` = '0'
                                    AND    `users`.`blocked` <> ?
                                    AND    `users`.`report` <> ?
                                  ");
            $values = array($recieverId, $_SESSION['id'], $_SESSION['id']);
            $query->execute($values);
            $rowCount = $query->rowCount();
            return $rowCount;
        }

        function updateStatus($userId) {
            $query = $this->link->prepare("UPDATE messages SET status = '1' WHERE userId = ?");
            $query->execute(array($userId));
            $rowCount = $query->rowCount();
            return $rowCount;
        }
    }

//    $q = new messages();
//echo '<pre>'.print_r($m = $q->getPrev(14), true).'</pre>';
//    $t = $q->query("SELECT * FROM likes");
//    print_r($r = $q->rows());