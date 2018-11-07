<?php
/**
 * Created by PhpStorm.
 * User: mmthethw
 * Date: 2018/11/05
 * Time: 12:28
 */
    function verify_email($toAddr, $toUsername)
    {
        $subject = "MATCHA Email verification";
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $headers .= 'From: <no_reply>' . "\r\n";
        $message = '
        <html>
            <head>
                <title>' . $subject . '</title>
            </head>
            <body>
                Hi ' . htmlspecialchars($toUsername) . ' </br>
                Please click on the link below to verify your profile </br>
                <a href="http://localhost:8080/Project/main/verify?username=' . $toUsername . '">Verify email</a>      
            </body>
        </html>
        ';
        mail($toAddr, $subject, $message, $headers);
    }

    function resetPassword($toAddr)
    {
        $subject = "MATCHA Reset Password";
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $headers .= 'From: <no_reply>' . "\r\n";
        $message = '
            <html>
                <head>
                    <title>' . $subject . '</title>
                </head>
                <body>
                    Hi </br>
                    Please click on the link below to reset your password </br>
                    <a href="http://localhost:8080/Project/frontEnd/reset?email=' . $toAddr . '">Reset Password</a>      
                </body>
            </html>
            ';
        mail($toAddr, $subject, $message, $headers);
    }
?>