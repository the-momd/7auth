<?php
session_start();
date_default_timezone_set('Asia/Tehran');
require 'constants.php';
require BASE_PATH . 'vendor/autoload.php';
require 'config.php';
require BASE_PATH . 'libs/lib-helpers.php';
require BASE_PATH . 'libs/lib-auth.php';
require 'mail.php';

try {
    $pdo = new PDO("mysql:dbname={$database_config->db};host={$database_config->host}", $database_config->user, $database_config->pass);

} catch (PDOException $e) {
    diePage("Connection failed: " . $e->getMessage());
    
}