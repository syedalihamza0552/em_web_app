<?php
require_once("../../config/config.php");

class Category
{
    public static function fetchAllCategories()
    {
        global $pdo;
        $qry = $pdo->prepare("SELECT * FROM category");
        $qry->execute();
        $data = $qry->fetchAll($pdo::FETCH_ASSOC);
        return [
            'success' => true,
            'categories' => $data
        ];
    }
}