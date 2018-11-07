<?php
/**
 * Created by PhpStorm.
 * User: mmthethw
 * Date: 2018/11/03
 * Time: 14:35
 */

include_once('class.dbConection.php');

class who
{
    public $link;

    function __construct()
    {
        $conn = new dbConection();
        $this->link = $conn->connect();
        return $this->link;
    }

    function whoViewedMe($userId) {
        $query = $this->link->prepare("
                        SELECT `views`.*,
                               `users`.*
                        FROM   `views`
                        JOIN   `users`
                        ON     `views`.`userId` = `users`.`id`
                        WHERE  `views`.`userViewedId` = ?
                        AND    `users`.`blocked` <> ?
                        AND    `users`.`report` <> ?
                        ORDER BY `views`.`view_date`
                        DESC 
                        ");
        $query->execute(array($userId, $_SESSION['id'], $_SESSION['id']));
        $data = $query->fetchAll();
        return $data;
    }

    function whoLikedMe($userId) {
        $query = $this->link->prepare("
                        SELECT `likes`.*,
                                `users`.*
                        FROM   `likes`
                        JOIN   `users`
                        ON     `likes`.`userId` = `users`.`id`
                        WHERE  `likes`.`userLikedId` = ?
                        AND    `users`.`blocked` <> ?
                        AND    `users`.`report` <> ?
                        ORDER BY `likes`.`like_date`
                        DESC 
                        ");
        $query->execute(array($userId, $_SESSION['id'], $_SESSION['id']));
        $data = $query->fetchAll();
        return $data;
    }

    function history($id) {
        $query = $this->link->prepare("
                        SELECT `views`.*,
                                `users`.*
                        FROM   `views`
                        JOIN   `users`
                        ON     `views`.`userViewedId` = `users`.`id`
                        WHERE  `views`.`userId` = ?
                        AND    `users`.`blocked` <> ?
                        AND    `users`.`report` <> ?
                        ORDER BY `views`.`view_date`
                        DESC 
                        ");
        $query->execute(array($id, $_SESSION['id'], $_SESSION['id']));
        $data = $query->fetchAll();
        return $data;
    }
}

//$t = new who();
//print_r($t->whoLikedMe(14));