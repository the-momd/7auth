<?php
require "bootstrap/init.php";

if(isLoggedIn()){
    redirect();
}

deleteExpiredTokens(); 

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
        # Requested data is valid and ok.
        if (createUser($params)) {
            $_SESSION['email'] = $params['email'];
            redirect('auth.php?action=verify');
    }
    }
    
    if ($action == 'login') {
        # validation data
        if (empty($params['email']))
            setErrorAndRedirect('Email is required!', 'auth.php?action=login');
        if (!filter_var($params['email'], FILTER_VALIDATE_EMAIL))
            setErrorAndRedirect('Enter the valid email address!', 'auth.php?action=login');
        if (!isUserExists($params['email']))
            setErrorAndRedirect('User Not Exists with this email: <br>' . $params['email'], 'auth.php?action=login');

        $_SESSION['email'] = $params['email'];
        redirect('auth.php?action=verify');
    }
    
    if($action == 'verify'){
        $token = findTokenByHash($_SESSION['hash'])->token;
        if($token === $params['token']){
           $session = bin2hex(random_bytes(32));
           chengeLoginSession($session, $_SESSION['email']);
           setcookie('auth',$session,time() + 1728000, '/');
           deleteTokenByHash($_SESSION['hash']);
           unset($_SESSION['hash'], $_SESSION['email']);
           redirect();
        }else{
            setErrorAndRedirect('the token is wrong', 'auth.php?action=verify');
        }
    }
}

if(isset($_GET['action']) and $_GET['action'] == 'verify' and !empty($_SESSION['email'])){ 
    if(!IsuserExists($_SESSION['email']))
    setErrorAndRedirect('User is not exists with this data', 'auth.php?action=login');
    if(isset($_SESSION['hash']) and isAliveToken($_SESSION['hash'])){
        sendTokenByMail($_SESSION['email'], findTokenByHash($_SESSION['hash'])->token);
        
    } else{
    $tokenResult = createLoginToken();
    sendTokenByMail($_SESSION['email'],$tokenResult['token']);
    $_SESSION['hash'] = $tokenResult['hash'];}
    include "tpl/verify-tpl.php";
}


if (isset($_GET['action']) && $_GET['action'] == 'register') {
    include "tpl/register-tpl.php";
} else {
    include "tpl/login-tpl.php";
}


