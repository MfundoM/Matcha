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
    include_once('../includes/funtions.php');
    include_once('../includes/sendEmail.php');

    if (isset($_POST['signup'])) {

        $user = new manageUsers();

        $email      = sanitize($_POST['email']);
        $username   = sanitize($_POST['username']);
        $firstname  = sanitize($_POST['firstname']);
        $lastname   = sanitize($_POST['lastname']);
        $password   = sanitize($_POST['password']);
        $repassword = sanitize($_POST['repassword']);
        $signup_dat = date('Y-m-d H:i');

        $_SESSION['user'] = null;

        if (empty($email) || empty($username) || empty($firstname) || empty($lastname) || empty($password) ||
            empty($repassword))
        {
            $error = "All fields are required";
        }
        elseif (strlen($username) < 5)
        {
            $error = "Username cannot be less than 5 characters";
        }
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $error = "Email is invalid";
        }
        elseif (strlen($password) < 5)
        {
            $error = "Password must be atleast 8 characters";
        }
        elseif (is_numeric($password))
        {
            $error = "Password must be alphanumeric";
        }
        elseif (!preg_match('/[\'^£$%&*()}{@#~?!><>,|=_+¬-]/', $password))
        {
            $error = "Password must have at least one special character";
        }
        elseif($password !== $repassword)
        {
            $error = "Passwords do not match";
        }
        else
        {
            $usernameCheck = $user->getUserInfo($username);
            if (!empty($usernameCheck)) {
                foreach ($usernameCheck as $value) {
                    $userExist = $value['username'];
                }
                if (strcmp($username, $userExist) == 0) {
                    $user1 = rand(10, 30);
                    $user2 = rand(100, 300);
                    $error = "Username already exist. Please enter a different username. Or try ";
                    $error .= $username . $user1 . ", ";
                    $error .= $username . $user2;
                }
            } else {
                $password = hash('whirlpool', $password);
                $userSign = $user->signUp($email, $username, $firstname, $lastname, $password, $signup_dat);
                if ($userSign == 1) {
                    verify_email($email, $username);
                    $success = "Account created successfully please verify your email!!!";
                } else
                    $error = 'An unexpected error occurred please try again later';
            }
        }
    }