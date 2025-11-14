<?php
session_start();
require('utils/helper.php');
require_once 'utils/update_last_activity.php';

header('Content-Type: application/json'); // réponse JSON si tu veux un retour

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validation
    if (empty($firstName) || empty($lastName)) {
        $error
