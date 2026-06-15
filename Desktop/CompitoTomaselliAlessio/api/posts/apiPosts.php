<?php

    function getAllPosts() {
        require_once __DIR__ . '/../../databaseApi/dbConnect.php';

        $db = new dbConnect();
        $Posts = $db->getAllPosts();
        
        return $Posts ?? null;
    }

    function getAllPostsDESC() {
        require_once __DIR__ . '/../../databaseApi/dbConnect.php';

        $db = new dbConnect();
        $Posts = $db->getAllPostsDESC();

        return $Posts ?? null;
    }

    function getCountPosts() {
        require_once __DIR__ . '/../../databaseApi/dbConnect.php';

        $db = new dbConnect();
        $Posts = $db->getCountPosts();

        return $Posts ?? null;
    }

    function searchPosts($title) {
        require_once __DIR__ . '/../../databaseApi/dbConnect.php';

        $db = new dbConnect();
        $Posts = $db->searchPosts($title);

        return $Posts ?? null;
    }

    function getCategoriaFromId($id) {
        require_once __DIR__ . "/../../databaseApi/dbConnect.php";

        $db = new dbConnect();
        $post = $db->getNameCatById($id);

        return $post ?? null;
    }

    function getPostFromId($id) {
        require_once __DIR__ . "/../../databaseApi/dbConnect.php";

        $db = new dbConnect();
        $post = $db->getPostFromId($id);

        return $post ?? null;
    }

    function getAllCategoria() {
        require_once __DIR__ . "/../../databaseApi/dbConnect.php";

        $db = new dbConnect();
        $post = $db->getAllCategoria();

        if ($post) {
            return $post;
        }
        return false;
    }

    function getCountCategoria() {
        require_once __DIR__ . "/../../databaseApi/dbConnect.php";

        $db = new dbConnect();
        $post = $db->getCountCategoria();

        return $post ?? null;
    }

    function createCat() {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            require_once __DIR__ . "/../../databaseApi/dbConnect.php";

            $db = new dbConnect();
            $post = $db->createCat($_POST["nome"]);

            if ($post) {
                return true;
            }
            return false;
        }
    }

?>