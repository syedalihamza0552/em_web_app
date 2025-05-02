<?php
session_start();
require_once('../models/Event.php');


if ($_SERVER['REQUEST_METHOD'] == "POST" || $_SERVER['REQUEST_METHOD'] == "GET") {
    $action = $_GET['action'];
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    switch ($action) {
        case 'add_event':
            $res = Event::addEvent($data->title, $data->description, $data->date, $data->location, $data->category);
            echo json_encode($res);
            break;

        case 'edit_event':
            $res = Event::editEvent($data->title, $data->description, $data->date, $data->location, $data->category, $data->id);
            echo json_encode($res);
            break;

        case 'delete_event':
            $res = Event::deleteEvent($data->id);
            echo json_encode($res);
            break;

        case 'fetch_all':
            $res = Event::fetchAllEvents();
            echo json_encode($res);
            break;

        case 'fetch_filtered':
            $res = Event::fetchFilterEvents($data->category, $data->search);
            echo json_encode($res);
            break;
        default:
            echo json_encode(value: [
                'success' => false,
                'error' => "No action provided"
            ]);
            break;
    }
}
