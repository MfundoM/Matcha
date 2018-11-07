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

    if (isset($_POST['signin'])) {

        // CSRF start
        try {
            // Run CSRF check, on POST data, in exception mode, for 10 minutes, in one-time mode.
            NoCSRF::check('csrf_token', $_POST, true, 60*10, false);
            $result = 'CSRF check passed. Form passed';

            $stmp = new manageUsers();

            $username = sanitize($_POST['username']);
            $password = sanitize($_POST['password']);

            $_SESSION['username'] = null;

            if (empty($username) || empty($password)) {
                $error = 'Please fill in all fields';
            }
            else {
                $password = hash('whirlpool', $password);
                $checkPass = $stmp->getUserInfo($username);
                if (!empty($checkPass)) {
                    foreach ($checkPass as $value) {
                        $userExist = $value['username'];
                        $passExist = $value['password'];
                        $id = $value['id'];
                    }
                    if ($username !== $userExist) {
                        $error = "Incorrect username";
                    }
                    else if ($password !== $passExist) {
                        $error = "Incorrect password";
                    } else {
                        $login = $stmp->login($username, $password);
                        if ($login == 1) {
                            $active = $stmp->activate($username);
                            if ($active == 1) {
                                $_SESSION['id'] = $id;
                                $_SESSION['username'] = $username;
                                header("Location: ../frontEnd/register?reg=1");
                            } else {
                                $error = "An unexpected error occurred";
                            }
                        } else {
                            $error = "Please verify your email before you can login!";
                        }
                    }
                } else {
                    $error = "User does not exist";
                }
            }

        } catch (Exception $e) {
            // CSRF attack detected
            $result = $e->getMessage() . ' Form ignored.';
        }
        // Generate CSRF token to use in hidden form
        $token = NoCSRF::generate('csrf_token');
    }