<?php
/**
 * Created by PhpStorm.
 * User: Mthethwa
 * Date: 10/21/2018
 * Time: 9:50 AM
 */

    include_once('class.dbConection.php');

    class likes
    {
        public $link;

        function __construct()
        {
            $conn = new dbConection();
            $this->link = $conn->connect();
            return $this->link;
        }

        function likeProfile($userId, $userLikedId, $date) {
            $query = $this->link->prepare("INSERT INTO likes (userId, userLikedId, like_date) VALUES (?, ?, ?)");
            $values = array($userId, $userLikedId, $date);
            $query->execute($values);

            $stmt = $this->link->prepare("SELECT * FROM likes WHERE userLikedId = $userLikedId");
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count >= 5) {
                $update = $this->link->prepare("UPDATE users SET rating = 'Veteran' WHERE id = ?");
                $update->execute(array($userLikedId));
            } else if ($count >= 10) {
                $update = $this->link->prepare("UPDATE users SET rating = 'Cool Kid' WHERE id = ?");
                $update->execute(array($userLikedId));
            } else if ($count >= 15) {
                $update = $this->link->prepare("UPDATE users SET rating = 'Dating God' WHERE id = ?");
                $update->execute(array($userLikedId));
            }

            $rowCount = $query->rowCount();
            return $rowCount;
        }

        function disableLikeBtn($userId, $userLikedId) {
            $query = $this->link->prepare("SELECT * FROM likes WHERE userId = ? AND userLikedId = ?");
            $values = array($userId, $userLikedId);
            $query->execute($values);
            $rowCount = $query->rowCount();
            return $rowCount;
        }

        function fetchLikes($userLiked) {
            $query = $this->link->prepare("SELECT * FROM likes WHERE userLikedId = ?");
            $values = array($userLiked);
            $query->execute($values);
            $rowCount = $query->rowCount();
            return $rowCount;
        }

        function viewProfile($userId, $userLikedId, $date) {
            $query = $this->link->prepare("INSERT INTO views (userId, userViewedId, view_date) VALUES (?, ?, ?)");
            $values = array($userId, $userLikedId, $date);
            $query->execute($values);
            $rowCount = $query->rowCount();
            return $rowCount;
        }

        function fetchViews($userViewed) {
            $query = $this->link->prepare("SELECT * FROM views WHERE userViewedId = ?");
            $values = array($userViewed);
            $query->execute($values);
            $rowCount = $query->rowCount();
            return $rowCount;
        }

        function unlike($userId, $userUnliked) {
            $query = $this->link->prepare("UPDATE friends SET status = ? WHERE userId = ? AND userLikedId = ?");
            $query->execute(array('0', $userId, $userUnliked));
            $rowCount = $query->rowCount();
            if ($rowCount == 0) {
                $query = $this->link->prepare("UPDATE friends SET status = ? WHERE userId = ? AND userLikedId = ?");
                $query->execute(array('0', $userUnliked, $userId));
            }

            $unlike = $this->link->prepare("SELECT * FROM likes WHERE userId = ? AND userLikedId = ?");
            $unlike->execute(array($userId, $userUnliked));
            $data = $unlike->fetchAll();
            foreach ($data as $val) {
                $id = $val['id'];
            }

            $delete = $this->link->prepare("DELETE FROM likes WHERE id = ?");
            $delete->execute(array($id));
            $count = $delete->rowCount();
            return $count;
        }
    }