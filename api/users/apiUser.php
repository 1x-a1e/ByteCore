<?php

    function getCountUsers() {
        require_once __DIR__ . '/../../databaseApi/dbConnect.php';

        $db = new dbConnect();
        $count = $db->getCountUsers();

        return $count;
    }

    function getCountUsersAdmin() {
        require_once __DIR__ . '/../../databaseApi/dbConnect.php';

        $db = new dbConnect();
        $count = $db->getCountUsersAdmin();

        return $count;
    }

    function getAllUsers() {
        require_once __DIR__ . '/../../databaseApi/dbConnect.php';

        $db = new dbConnect();
        $Users = $db->getAllUser();

        return $Users ?? null;
    }

    function getAllUsersAdmin() {
        require_once __DIR__ . '/../../databaseApi/dbConnect.php';

        $db = new dbConnect();
        $Users = $db->getAdminUsers();

        return $Users ?? null;
    }

?>