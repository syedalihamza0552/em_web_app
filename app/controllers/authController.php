<?php
session_start();
require_once("../models/User.php");


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $action = $_GET['action'];
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    switch ($action) {
        case 'login':
            $email = $data['email'] ?? '';
            $pass = $data['password'] ?? '';
            $res = User::loginUser($email, $pass);
            echo json_encode($res);
            break;
        case 'sign_up':
            $email = $data['email'] ?? '';
            $username = $data['username'] ?? '';
            $pass = $data['password'] ?? '';
            $res = User::signupUser($username, $email, $pass);
            error_log($res['success']);
            echo json_encode($res);
            break;
        default:
            echo json_encode([
                'success' => false,
                'error' => "No action provided"
            ]);
            break;

    }
}
