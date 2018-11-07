<?php
/**
 * Created by PhpStorm.
 * User: mmthethw
 * Date: 2018/10/31
 * Time: 12:07
 */

    include_once('class.dbConection.php');

    class matched
    {
        public $link;

        function __construct()
        {
            $conn = new dbConection();
            $this->link = $conn->connect();
            return $this->link;
        }

        function likeProfile($userId, $userLikedId, $date) {
            $check = $this->link->prepare("SELECT * FROM friends WHERE userId = ? AND userLikedId = ?");
            $check->execute(array($userId, $userLikedId));
            $rc = $check->rowCount();

            $check2 = $this->link->prepare("SELECT * FROM friends WHERE userId = ? AND userLikedId = ?");
            $check2->execute(array($userLikedId, $userId));
            $rcwnt = $check2->rowCount();

            if ($rc == 1) {
                $check1 = $this->link->prepare("UPDATE friends SET status = ? WHERE userId = ? AND userLikedId = ?");
                $check1->execute(array('1', $userId, $userLikedId));
                $rowCount = $check1->rowCount();
                return $rowCount;
            } else if ($rcwnt == 1) {
                $check3 = $this->link->prepare("UPDATE friends SET status = ? WHERE userId = ? AND userLikedId = ?");
                $check3->execute(array('1', $userLikedId, $userId));
                $rowCount = $check3->rowCount();
                return $rowCount;
            } else {
                $query = $this->link->prepare("INSERT INTO friends (userId, userLikedId, likeBack, like_date) VALUES (?, ?, ?,?)");
                $values = array($userId, $userLikedId, '0', $date);
                $query->execute($values);
                $rowCount = $query->rowCount();
                return $rowCount;
            }
        }

        function likeBack($userLikedId, $userId) {
            $check = $this->link->prepare("SELECT * FROM friends WHERE userId = ? AND userLikedId = ?");
            $check->execute(array($userId, $userLikedId));
            $rc = $check->rowCount();
            if ($rc == 1) {
                $check1 = $this->link->prepare("UPDATE friends SET status = ? WHERE userId = ? AND userLikedId = ?");
                $check1->execute(array('1', $userId, $userLikedId));
                $rowCount = $check1->rowCount();
                return $rowCount;
            }

            $check2 = $this->link->prepare("SELECT * FROM friends WHERE userId = ? AND userLikedId = ?");
            $check2->execute(array($userLikedId, $userId));
            $rcwnt = $check2->rowCount();
            if ($rcwnt == 1) {
                $check3 = $this->link->prepare("UPDATE friends SET status = ? WHERE userId = ? AND userLikedId = ?");
                $check3->execute(array('1', $userLikedId, $userId));
                $rowCount = $check3->rowCount();
                return $rowCount;
            }

            $stmt = $this->link->prepare("SELECT * FROM friends WHERE userId = $userLikedId AND userLikedId = $userId");
            $stmt->execute();
            $res = $stmt->fetchAll();
            foreach ($res as $v) {
                $id = $v['id'];
            }

            $query = $this->link->prepare("UPDATE friends SET likeBack = ?, status = ? WHERE id = ?");
            $values = array($userId, '1', $id);
            $query->execute($values);
            $rowCount = $query->rowCount();
            return $rowCount;
        }

        function fetchLike($userId, $userLiked) {
            $query = $this->link->prepare("SELECT * FROM friends WHERE userId = ? AND userLikedId = ?");
            $values = array($userLiked, $userId);
            $query->execute($values);
            $rowCount = $query->rowCount();
            return $rowCount;
        }

        function friends($userId) {
            $query = $this->link->prepare("SELECT * FROM friends WHERE userId=$userId OR userLikedId=$userId AND status = '1'");
            $values = array($userId);
            $query->execute($values);
            $res = $query->fetchAll();
            return $res;
        }
    }