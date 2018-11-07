<?php
/**
 * Created by PhpStorm.
 * User: mmthethw
 * Date: 2018/09/25
 * Time: 07:57
 */

    include_once('class.dbConection.php');
    class manageUsers
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

        function signUp($email, $username, $firstname, $lastname, $password, $sign_date) {
            try {
                $query = $this->link->prepare("INSERT INTO users (email, username, firstname, lastname, password, signup_date)
                      VALUES (?, ?, ?, ?, ?, ?)");
                $values = array($email, $username, $firstname, $lastname, $password, $sign_date);
                $query->execute($values);
                $rowCounts = $query->rowCount();
                return $rowCounts;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        function login($username, $password) {
            try {
                $query = $this->link->prepare("SELECT * FROM users WHERE username = ? AND password = ? AND verified = 'Y'");
                $values = array($username, $password);
                $query->execute($values);
                $rowCount = $query->rowCount();
                return $rowCount;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        function userRegistration($username, $age, $gender, $sexual_pref, $about, $interests, $image, $country, $city) {
            try {
                $query = $this->link->prepare("UPDATE users SET age = ?, gender = ?, sexual_pref = ?, about = ?,
                          interests = ?, profile_pic = ?, country = ?, city = ? WHERE username = ?");
                $values = array($age, $gender, $sexual_pref, $about, $interests, $image, $country, $city, $username);
                $query->execute($values);
                $rowCount = $query->rowCount();
                return $rowCount;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        function getUserInfo($username) {
            try {
                $query = $this->link->prepare("SELECT * FROM users WHERE username = ?");
                $values = array($username);
                $query->execute($values);
                $userInfo = $query->fetchAll();
                return $userInfo;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        function getUserById($id) {
            try {
                $query = $this->link->prepare("SELECT * FROM users WHERE id = ?");
                $values = array($id);
                $query->execute($values);
                $userInfo = $query->fetchAll();
                return $userInfo;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        function getFriends($id, $id2) {
            try {
                $query = $this->link->prepare("
                                        SELECT *
                                        FROM users
                                        WHERE id = ? OR id = ? AND blocked <> ? AND report <> ?
                                      ");
                $values = array($id, $id2, $_SESSION['id'], $_SESSION['id']);
                $query->execute($values);
                $userInfo = $query->fetchAll();
                return $userInfo;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        function getProfile($id) {
            try {
                $query = $this->link->prepare("SELECT * FROM users WHERE id = ?");
                $values = array($id);
                $query->execute($values);
                $userInfo = $query->fetchAll();
                return $userInfo;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        function updateLastseen($username) {
            try {
                $date = date("Y-m-d H:i");
                $query = $this->link->prepare("UPDATE users SET last_seen = ? WHERE username = ?");
                $values = array($date, $username);
                $query->execute($values);
                $rowCount = $query->rowCount();
                return $rowCount;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        function activate($username) {
            $query = $this->link->prepare("UPDATE users SET active = ? WHERE username = ?");
            $values = array("1", $username);
            $query->execute($values);
            $rowCount = $query->rowCount();
            return $rowCount;
        }

        function deactivate($username) {
            $query = $this->link->prepare("UPDATE users SET active = ? WHERE username = ?");
            $values = array("0", $username);
            $query->execute($values);
            $rowCount = $query->rowCount();
            return $rowCount;
        }

        function fetchRandUsers($sex_pref, $gender, $country, $city, $rating) {
            if ($sex_pref === $gender) {
                $query = $this->link->prepare("
                                      SELECT *
                                      FROM users
                                      WHERE gender = ?
                                      AND sexual_pref = ?
                                      AND country = ?
                                      AND city = ?
                                      AND rating = ?
                                      AND blocked <> ?
                                      AND report <> ?
                                      ORDER BY active DESC
                                  ");
                $values = array($sex_pref, $sex_pref, $country, $city, $rating, $_SESSION['id'], $_SESSION['id']);
                $query->execute($values);
                $userInfo = $query->fetchAll();
                return $userInfo;
            } else if ($sex_pref === "Other" || $sex_pref === "other") {
                $query = $this->link->prepare("
                                      SELECT *
                                      FROM users
                                      WHERE country = ?
                                      AND city = ?
                                      AND rating = ?
                                      AND blocked <> ?
                                      AND report <> ?
                                      AND id <> ?
                                      ORDER BY active DESC
                                  ");
                $values = array($country, $city, $rating, $_SESSION['id'], $_SESSION['id'], $_SESSION['id']);
                $query->execute($values);
                $userInfo = $query->fetchAll();
                return $userInfo;
            } else {
                $query = $this->link->prepare("
                                      SELECT *
                                      FROM users
                                      WHERE gender = ?
                                      AND gender <> sexual_pref
                                      AND country = ?
                                      AND city = ?
                                      AND rating = ?
                                      AND blocked <> ?
                                      AND report <> ?
                                      ORDER BY active DESC
                                  ");
                $values = array($sex_pref, $country, $city, $rating, $_SESSION['id'], $_SESSION['id']);
                $query->execute($values);
                $userInfo = $query->fetchAll();
                return $userInfo;
            }
        }

        function upload($userId, $image) {
            $query = $this->link->prepare("INSERT INTO gallery (user_id, imageName) VALUES (?,?)");
            $query->execute(array($userId, $image));
            $rowCount = $query->rowCount();
            return $rowCount;
        }

        function pullImages($userId) {
            $query = $this->link->prepare("SELECT * FROM gallery WHERE user_id = ?");
            $query->execute(array($userId));
            $data = $query->fetchAll();
            return $data;
        }

        function countImages($userId) {
            $query = $this->link->prepare("SELECT * FROM gallery WHERE user_id = ?");
            $query->execute(array($userId));
            $rowCount = $query->rowCount();
            return $rowCount;
        }

        function deleteImage($id) {
            $query = $this->link->prepare("DELETE FROM gallery WHERE id = ?");
            $query->execute(array($id));
            $rowCount = $query->rowCount();
            return $rowCount;
        }

        function editProfile($fname, $lname, $sex_pref, $email, $country, $city, $about, $interests, $id) {
            $query = $this->link->prepare("UPDATE users SET firstname=?, lastname=?, sexual_pref=?, email=?,
                      country=?, city=?, about=?, interests=? WHERE id=?");
            $query->execute(array($fname, $lname, $sex_pref, $email, $country, $city, $about, $interests, $id));
            $rowCount = $query->rowCount();
            return $rowCount;
        }

        function block($userId, $userToBeBlocked) {
            $query = $this->link->prepare("UPDATE users SET blocked = ? WHERE id = ?");
            $query->execute(array($userId, $userToBeBlocked));
            $rowCount = $query->rowCount();
            return $rowCount;
        }

        function report($userId, $userToBeBlocked) {
            $query = $this->link->prepare("UPDATE users SET report = ? WHERE id = ?");
            $query->execute(array($userId, $userToBeBlocked));
            $rowCount = $query->rowCount();
            return $rowCount;
        }

        function getBlocked($id) {
            $query = $this->link->prepare("SELECT * FROM users WHERE blocked = ?");
            $query->execute(array($id));
            $data = $query->fetchAll();
            return $data;
        }

        function unblock($id) {
            $query = $this->link->prepare("UPDATE users SET blocked = '0' WHERE id = ?");
            $query->execute(array($id));
            $rowCount = $query->rowCount();
            return $rowCount;
        }

        function checkPics($id) {
//            $check = 0;
            $query = $this->link->prepare("SELECT * FROM gallery WHERE id = ?");
            $query->execute(array($id));
            $rowCount = $query->rowCount();
            if ($rowCount === 0) {
                $query = $this->link->prepare("SELECT * FROM users WHERE id = ?");
                $query->execute(array($id));
                $data = $query->fetchAll();
                foreach ($data as $v) {
                    $pic = $v['profile_pic'];
                }
                if (empty($pic) || $pic === null) {
                    $check = 0;
                } else {
                    $check = 1;
                }
            } else {
                $check = 1;
            }
            return $check;
        }

        function verify($username) {
            $query = $this->link->prepare("UPDATE users SET verified = 'Y' WHERE username = ? LIMIT 1");
            $query->execute(array($username));
            $rowCount = $query->rowCount();
            return $rowCount;
        }

        function checkEmail($email) {
            $query = $this->link->prepare("SELECT * FROM users WHERE email = ?");
            $query->execute(array($email));
            $rowCount = $query->rowCount();
            return $rowCount;
        }

        function reset($pass, $email) {
            $query = $this->link->prepare("UPDATE users SET password = ? WHERE email = ? LIMIT 1");
            $query->execute(array($pass, $email));
            $rowCount = $query->rowCount();
            return $rowCount;
        }
    }

//    $inert = new manageUsers();
//    echo $t = $inert->checkEmail("mfundoyamanyambose@gmail.com");
//    echo '<pre>' . print_r($t = $inert->getProfile(14), true). '</pre>';
//    echo $inert->userRegistration("me123", "32", "male", "female", "you me", "#tag", "profile.jpeg", "south africa", "johannesburg");
