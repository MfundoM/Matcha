<?php
/**
 * Created by PhpStorm.
 * User: mmthethw
 * Date: 2018/09/25
 * Time: 10:24
 */

    session_start();

    include_once('../classes/class.manageUsers.php');
    include_once('../classes/nocsrf.php');
    include_once('../includes/form_cleaner.php');

    if (isset($_POST['submit'])) {

        $username = $_SESSION['username'];
        $age      = sanitize($_POST['age']);
        $gender   = sanitize($_POST['gender']);
        $sex_pref = sanitize($_POST['sex_pref']);
        $about    = sanitize($_POST['about']);
        $interest = sanitize($_POST['interests']);
        $country  = sanitize($_POST['country']);
        $city     = sanitize($_POST['city']);
        $error = "";

        if (!file_exists('../photos/')) {
            mkdir('../photos/', 0777, true);
        }

        if (empty($age) || empty($about) || empty($interest) || empty($country) || empty($city)) {
            $error = "Please fill in all fields";
        } else {
            $target_dir = '../photos/';
            $target_file = $target_dir . basename($_FILES['prof_pic']["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $check = getimagesize($_FILES["prof_pic"]["tmp_name"]);
            if ($check !== false) {
                if (file_exists($target_file)) {
                    $error = "Sorry, file already exists.";
                }
                if ($_FILES["prof_pic"]["size"] > 200000) {
                    $error = "Sorry, your file is too large.";
                }
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                }
                else {
                    if (move_uploaded_file($_FILES["prof_pic"]["tmp_name"], $target_file)) {
                        $profile = new manageUsers();
                        $image = basename($_FILES['prof_pic']['name']);
                        if (empty($gender)) {
                            $gender = "Other";
                        }
                        if (empty($sex_pref)) {
                            $sex_pref = "Other";
                        }
                        $prof = $profile->userRegistration($username, $age, $gender, $sex_pref, $about, $interest, $image, $country, $city);
                        if ($prof == 1) {
                            header("Location: ../main/home");
                        }
                    } else {
                        $error = "Error moving file";
                    }
                }
            } else {
                $error = "File is not an image";
            }
        }
    }