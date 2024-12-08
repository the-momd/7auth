<?php
require "bootstrap/init.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $action = $_GET['action'];
    $params = $_POST;
    if($action == 'register'){
        #validation
        if(empty($params['name']) or empty($params['email']) or empty($params['phone'])){
            setErrorAndRedirect('All input fields required','auth.php?action=register');
        }
        if(!filter_var($params['email'],FILTER_VALIDATE_EMAIL)){
            setErrorAndRedirect('Enter the valid email address','auth.php?action=register');

        }
        
    }
}
if(isset($_GET['action']) and $_GET['action'] == 'register'){
    include "tpl/register-tpl.php";
}else {
    include "tpl/login-tpl.php";
}
