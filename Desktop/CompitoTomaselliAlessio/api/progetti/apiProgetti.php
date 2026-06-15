<?php

    function getAllProgetti() {
        require_once __DIR__ . '/../../databaseApi/dbConnect.php';

        $db = new dbConnect();
        $Progetti = $db->getAllProgetti();

        return $Progetti ?? null;
    }

    function getAllProject() {
        require_once __DIR__ . '/../../databaseApi/dbConnect.php';

        $db = new dbConnect();
        $Project = $db->getAllProject();

        return $Project ?? null;
    }

    function countProgetti() {
        require_once __DIR__ . '/../../databaseApi/dbConnect.php';

        $db = new dbConnect();
        $Progetti = $db->countProgetti();

        return $Progetti ?? null;
    }

    function getProgettoById($id) {
        require_once __DIR__ . '/../../databaseApi/dbConnect.php';

        $db = new dbConnect();
        $Progetto = $db->getProjectFromId($id);

        return $Progetto ?? null;
    }
?>