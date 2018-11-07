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
    include_once('../includes/sendEmail.php');

    if (isset($_POST['email'])) {

        $email = sanitize($_POST['email']);

        if (empty($email)) {
            $error = 'Please fill in all fields';
        }
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Please enter a valid email";
        }
        else {
            $check = new manageUsers();
            $mail = $check->checkEmail($email);
            if ($mail == 1) {
                resetPassword($email);
                $success = "Please check your email";
            } else {
                $error = "Email is not registered on this site";
            }
        }
    }