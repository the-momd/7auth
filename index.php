<?php
require 'bootstrap/init.php';
if(!isLoggedIn()){
    redirect('auth.php?action=login');
}

$userData = getAuthenticateUserBySession($_COOKIE['auth']);

if(isset($_GET['action']) and $_GET['action'] == 'logout'){
    logOut($userData->email);
}

include "tpl/index-tpl.php";
?>
