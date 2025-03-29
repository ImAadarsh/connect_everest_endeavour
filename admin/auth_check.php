<?php
session_start();

function checkAdminAuth() {
    if (!isset($_SESSION['admin_id'])) {
        header("Location: login.php");
        exit();
    }
}

function getAdminInfo() {
    return [
        'id' => $_SESSION['admin_id'],
        'name' => $_SESSION['admin_name'],
        'email' => $_SESSION['admin_email']
    ];
}
?> 