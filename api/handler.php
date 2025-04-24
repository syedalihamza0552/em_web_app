<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../config/config.php");


header("Content-Type:application/json");

$action = $_GET['action'] ?? '';

switch ($action){
    case 'get_users':
        $qry = $pdo->query("SELECT * FROM users");
        echo json_encode(value: $qry->fetchAll(PDO::FETCH_ASSOC));
        break;
    case "add_user":
        $body = json_decode(file_get_contents("php://input"));
        $qry = $pdo->query("INSERT into users (name,email) VALUES (?,?)");
        $res = $qry->execute([$body->name,$body->email]);
        echo json_encode(['success'=>$res]);
        break;
    default:
        echo json_encode(['error'=>"Invalid Creds"]);
}