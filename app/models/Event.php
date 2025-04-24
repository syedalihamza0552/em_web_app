<?php
require_once("../../config/config.php");

class Event
{
    public static function fetchAllEvents()
    {
        global $pdo;
        $qry = $pdo->prepare("SELECT * FROM events");
        $qry->execute();
        $qry->fetch();

        return [
            'success' => true,
            'events' => $qry
        ];
    }

    public static function addEvent($title, $description, $date, $location, $category)
    {
    }

    public static function editEvent($title, $description, $date, $location, $category, $id)
    {
    }

    public static function deleteEvent($id)
    {
    }
}