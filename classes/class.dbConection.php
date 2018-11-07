<?php
/**
 * Created by PhpStorm.
 * User: mmthethw
 * Date: 2018/09/25
 * Time: 07:56
 */

    class dbConection
    {
        protected $db_conn;
        public    $db_name = "matcha";
        public    $db_user = "root";
        public    $db_pass = "password";
        public    $db_host = "localhost";

        function connect() {
            try {
                $this->db_conn = new PDO("mysql:host=$this->db_host;dbname=$this->db_name", "$this->db_user", "$this->db_pass");
                $this->db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return ($this->db_conn);
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        function connection() {
            try {
                $this->db_conn = new PDO("mysql:host=$this->db_host", "$this->db_user", "$this->db_pass");
                $this->db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return ($this->db_conn);
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    }