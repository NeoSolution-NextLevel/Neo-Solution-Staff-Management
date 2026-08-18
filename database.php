<?php

include_once __DIR__ . '/imports/need/DB.php';

if (!function_exists('Database')) {
    function Database()
    {
        $get_database = new DataBase();
        return $get_database->get_data_base_connction();
    }
}