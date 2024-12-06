<?php
require 'constants.php';
require 'config.php';
include BASE_PATH . "libs/lib-helpers.php";

try {
    $pdo = new PDO("mysql:dbname={$database_config->db};host={$database_config->host}", $database_config->user, $database_config->pass);
    dd($pdo);
} catch (PDOException $e) {
    diePage("Connection failed: " . $e->getMessage());
    
}