<?php
session_start();

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['userID']) && (basename($_SERVER['PHP_SELF']) !== 'login.php' && basename($_SERVER['PHP_SELF']) !== 'register.php')) {
    // Если пользователь не авторизован, перенаправляем его на страницу входа
    header("Location: /auth/login.php");
    exit;
}

// Проверяем, если пользователь уже авторизован, и если пытается зайти на страницы аутентификации (login.php или register.php)
if (isset($_SESSION['userID']) && (basename($_SERVER['PHP_SELF']) == 'login.php' || basename($_SERVER['PHP_SELF']) == 'register.php')) {
    // Если пользователь авторизован и пытается зайти на страницы аутентификации, перенаправляем его на другую страницу (например, на главную страницу)
    header("Location: /list.php");
    exit;
}

// Ограничиваем доступ к admin.php
if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin' && basename($_SERVER['PHP_SELF']) == 'admin.php') {
    header("HTTP/1.0 404 Not Found");
    exit;
}

// Проверяем, если пользователь авторизован как администратор и пытается зайти на страницы, отличные от admin.php
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin' && basename($_SERVER['PHP_SELF']) !== 'admin.php') {
    header("Location: /admin.php");
    exit;
}