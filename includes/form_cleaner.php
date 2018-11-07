<?php
/**
 * Created by PhpStorm.
 * User: mmthethw
 * Date: 2018/09/25
 * Time: 10:48
 */

    function sanitize($input) {
        $clean = htmlentities($input);
        return filter_var($clean, FILTER_SANITIZE_STRING);
    }