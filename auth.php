<?php
require "bootstrap/init.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_GET['action'];
    $params = $_POST;

    if ($action == 'register') {
        # Validation
        if (empty($params['name']) || empty($params['email']) || empty($params['phone'])) {
            setErrorAndRedirect('All input fields required', 'auth.php?action=register');
        }

        if (!filter_var($params['email'], FILTER_VALIDATE_EMAIL)) {
            setErrorAndRedirect('Enter a valid email address', 'auth.php?action=register');
        }

        // Phone number validation for Iranian phone numbers starting with 0
        $phonePattern = '/^0[0-9]{10}$/';
        if (!preg_match($phonePattern, $params['phone'])) {
            setErrorAndRedirect('Enter a valid Iranian phone number', 'auth.php?action=register');
        }

        if (IsuserExists($params['email'], $params['phone'])) {
            setErrorAndRedirect('User already exists with this data', 'auth.php?action=register');
        }
    }

    # Requested data is valid and ok.
    if (createUser($params)) {
        $_SESSION['email'] = $params['email'];
        redirect('auth.php?action=verify');
    }
}

if(isset($_GET['action']) and $_GET['action'] == 'verify' and !empty($_SESSION['email'])){ 
    if(!IsuserExists($_SESSION['email']))
    setErrorAndRedirect('User is not exists with this data', 'auth.php?action=login');
    if(isset($_SESSION['hash']) and isAliveToken($_SESSION['hash'])){
        # send old token
        
    } else{
    $tokenResult = createLoginToken();
    $_SESSION['hash'] = $tokenResult['hash'];}
    include "tpl/verify-tpl.php";
}


if (isset($_GET['action']) && $_GET['action'] == 'register') {
    include "tpl/register-tpl.php";
} else {
    include "tpl/login-tpl.php";
}
?>
