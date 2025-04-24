<?php
session_start();
require_once("../../config/config.php");


// testing commit
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    switch ($data['fType']) {
        case 'login':
            $email = $data['email'] ?? '';
            $pass = $data['password'] ?? '';
            $qry = $pdo->prepare('SELECT * FROM users WHERE email = ?');
            $qry->execute(params: [$email]);
            $admin = $qry->fetch();
            if ($admin && hash('sha256', $pass) == $admin['password']) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['email'] = $email;
                echo json_encode([
                    'success' => true,
                    'redirect' => '../../public/dashboard.php'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'error' => "Invalid Creds"
                ]);
            }
            break;
        case 'signup':
            $email = $data['email'] ?? '';
            $username = $data['username'] ?? '';
            $pass = $data['password'] ?? '';
            $qry = $pdo->prepare("INSERT INTO users (username,email,password) VALUES (?,?,?)");
            $qry->execute([$username, $email, hash('sha256', $pass)]);
            error_log("User signup" . $qry);
            $_SESSION['logged_in'] = true;
            $_SESSION['email'] = $email;
            echo json_encode([
                'success' => true,
            ]);
    }
}
