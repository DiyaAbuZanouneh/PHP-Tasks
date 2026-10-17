<?php

session_start();

// Connect to MySQL (XAMPP defaults) and create the database/tables on first run
$pdo = new PDO("mysql:host=localhost;charset=utf8mb4", "root", "", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);
$pdo->exec("CREATE DATABASE IF NOT EXISTS php_tasks_app");
$pdo->exec("USE php_tasks_app");
$pdo->exec("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    mobile VARCHAR(20) DEFAULT '',
    governorate VARCHAR(50) DEFAULT '',
    track VARCHAR(50) DEFAULT '',
    skills VARCHAR(255) DEFAULT '',
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
$pdo->exec("CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

function e($v)
{
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}

$governorates = ['Amman', 'Irbid', 'Zarqa', 'Balqa', 'Aqaba', 'Mafraq', 'Jerash', 'Ajloun', 'Karak', 'Tafilah', 'Maan', 'Madaba'];
$tracks = ['Web Development', 'Data Science', 'Cyber Security', 'UI/UX Design'];
$skillList = ['HTML', 'CSS', 'JavaScript', 'PHP', 'MySQL'];
