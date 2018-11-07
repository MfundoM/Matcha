<?php
/**
 * Created by PhpStorm.
 * User: mmthethw
 * Date: 2018/11/05
 * Time: 14:39
 */

    require_once('../classes/class.manageUsers.php');
    require_once('../includes/form_cleaner.php');

    if (isset($_GET['email']) && isset($_POST['reset'])) {
        $pass = sanitize($_POST['newpass']);
        $pass1 = sanitize($_POST['newpass1']);

        if (empty($pass) || empty($pass1)) {
            $error = "All fields are required";
        }
        elseif (strlen($pass) < 5)
        {
            $error = "Password must be atleast 8 characters";
        }
        elseif (is_numeric($pass))
        {
            $error = "Password must be alphanumeric";
        }
        elseif (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $pass))
        {
            $error = "Password must have atleast one special character";
        }
        else if ($pass !== $pass1) {
            $error = "Passwords do not match";
        } else {
            $password = hash('whirlpool', $pass);
            $pass = new manageUsers();
            $reset = $pass->checkEmail(sanitize($_GET['email']));
            if ($reset == 1) {
                $res = $pass->reset($password, sanitize($_GET['email']));
                if ($res == 1) {
                    header("Location: ../frontEnd/login?msg=1");
                } else {
                    $error = "Error resetting password please try again";
                }
            } else {
                $error = "Email does not exists in our database";
            }
        }
    }