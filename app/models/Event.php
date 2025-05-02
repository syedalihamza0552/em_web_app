<?php
require_once("../../config/config.php");

class Event
{
    public static function fetchAllEvents()
    {
        global $pdo;
        $qry = $pdo->prepare("SELECT * FROM events");
        $qry->execute();
        $data = $qry->fetchAll(PDO::FETCH_ASSOC);
        return [
            'success' => true,
            'events' => $data
        ];
    }

    public static function fetchFilterEvents($category, $search)
    {
        global $pdo;
        if ($category) {
            $qry = $pdo->prepare("SELECT * FROM events WHERE category = ?");
            $qry->execute([$category]);
            $data = $qry->fetchAll(PDO::FETCH_ASSOC);
            return [
                'success' => true,
                'events' => $data
            ];
        } else if ($search != '') {
            $qry = $pdo->prepare("SELECT * FROM events WHERE LOWER(title) LIKE LOWER(?) OR LOWER(description) LIKE LOWER(?)");
            $searchTerm = '%' . $search . '%';
            $qry->execute(params: [$searchTerm, $searchTerm]);
            $data = $qry->fetchAll(PDO::FETCH_ASSOC);
            return [
                'success' => true,
                'events' => $data
            ];
        }
    }

    public static function addEvent($title, $description, $date, $location, $category)
    {
        global $pdo;
        $qry = $pdo->prepare("INSERT INTO events (title,description,date,location,category) VALUES (?,?,?,?,?)");
        $qry->execute([$title, $description, $date, $location, $category]);
        return [
            'success' => true,
            'message' => "Event Added",
            'redirect' => "dashboard.php"
        ];
    }

    public static function editEvent($title, $description, $date, $location, $category, $id)
    {
        global $pdo;
        $qry = $pdo->prepare("UPDATE events SET title = ?, description = ?, date = ?, location = ?, category = ? WHERE id = ?");
        $qry->execute([$title, $description, $date, $location, $category, $id]);
        return [
            'success' => true,
            'message' => "Event Edit",
            'redirect' => "dashboard.php"
        ];
    }

    public static function deleteEvent($id)
    {
        global $pdo;
        $qry = $pdo->prepare("DELETE FROM events WHERE id=?");
        $qry->execute([$id]);
        return [
            'success' => true,
            'message' => "Event Deleted",
            'redirect' => "dashboard.php"
        ];
    }
}