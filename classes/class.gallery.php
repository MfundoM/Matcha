<?php
/**
 * Created by PhpStorm.
 * User: mmthethw
 * Date: 2018/10/12
 * Time: 07:42
 */

    require_once('class.dbConection.php');

    class gallery
    {
        public $link;

        function __construct()
        {
            try {
                $db_connection = new dbConection();
                $this->link = $db_connection->connect();
                return $this->link;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        function addImage($imageName, $user_id, $upload_date) {
            try {
                $query = $this->link->prepare("INSERT INTO gallery (imageName, user_id, upload_date) VALUES (?,?,?)");
                $values = array($imageName, $user_id, $upload_date);
                $query->execute($values);
                $rowCount = $query->rowCount();
                return $rowCount;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        function deleteImage($image_id) {
            try {
                $query = $this->link->query("DELETE FROM gallery WHERE id = $image_id");
                $query->execute();
                $rowCount = $query->rowCount();
                return $rowCount;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    }

//    $inert = new gallery();
//    echo $inert->deleteImage("2");