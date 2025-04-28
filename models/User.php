<?php
require_once('../../config/config.php');

class User
{
    public static function getAllUsers()
    {
    }

    public static function getSpecificUser($email)
    {
        global $pdo;
        $qry = $pdo->prepare("SELECT * FROM users WHERE email=?");
        $qry->execute([$email]);
        $res = $qry->fetch();
        return [
            'success' => true,
            'user' => $res
        ];
    }

    public static function signupUser($name, $email, $pass, )
    {
        global $pdo;
        $sQry = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $sQry->execute(params: [$email]);
        $sRes = $sQry->fetch();
        if ($sRes && $sRes['email'] == $email) {
            return [
                'success' => false,
                'error' => "User already exists"
            ];
        }
        $qry = $pdo->prepare("INSERT INTO users (username,email,password) VALUES (?,?,?)");
        $qry->execute([$name, $email, hash('sha256', $pass)]);
        $_SESSION['logged_in'] = true;
        $_SESSION['email'] = $email;
        return [
            'success' => true,
        ];
    }

    public static function loginUser($email, $pass)
    {
        global $pdo;
        $qry = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $qry->execute(params: [$email]);
        $res = $qry->fetch();
        if ($res && hash('sha256', $pass) == $res['password']) {
            $_SESSION['logged_in'] = true;
            $_SESSION['email'] = $email;
            $_SESSION['username'] = $res['username'];
            return [
                'success' => true,
                'redirect' => '../views/home.php'
            ];
        } else {
            return [
                'success' => false,
                'error' => "Invalid Creds"
            ];
        }
    }
}

