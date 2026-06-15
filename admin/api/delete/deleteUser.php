<?php

require_once __DIR__ . "/../../assets/checkUser.php";

checkUserAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    require_once __DIR__ . "/../../../databaseApi/dbConnect.php";
    $db = new dbConnect();

    $id = $_GET['id'] ?? null;
    $deleteUser = $db->deleteUserById($id);

    if (!$deleteUser) {
        http_response_code(500);
        echo json_encode(["error" => "Errore durante l'eliminazione del post"]);
    } else {
        http_response_code(200);
        header("Location: /admin");
        exit();
    };
}

?>