<?php
/**
 * Created by PhpStorm.
 * User: mmthethw
 * Date: 2018/11/06
 * Time: 12:36
 */

    require_once('class.dbConection.php');

    class search
    {
        public $link;

        function __construct()
        {
            $conn = new dbConection();
            $this->link = $conn->connect();
            return $this->link;
        }

        function searchAge($age1, $age2) {
            $query = $this->link->prepare("SElECT * FROM users WHERE age BETWEEN ? AND ?");
            $query->execute(array($age1, $age2));
            $data = $query->fetchAll();
            return $data;
        }

        function search($text) {
            $query = $this->link->prepare("SElECT * FROM users WHERE city=? OR interests=? OR rating=?");
            $query->execute(array($text, $text, $text));
            $data = $query->fetchAll();
            return $data;
        }
    }

//    $t = new search();
//    print_r($l = $t->search("Johannesburg"));