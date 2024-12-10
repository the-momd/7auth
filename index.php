<?php
require 'bootstrap/init.php';
if(!isLoggedIn()){
    redirect('auth.php?action=login');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User profile</title>
</head>
<body>
    <h1 style="text-align: center;">User Profile</h1>
    <ul>
        <?php foreach (getAuthenticateUserBySession($_COOKIE['auth']) as $key => $value) : ?>
            <li><?= "$key: $value" ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>