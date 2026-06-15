<?php

require_once __DIR__ . "/../../assets/checkUser.php";

checkUserAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . "/../../../databaseApi/dbConnect.php";
    $db = new dbConnect();

    $email = $_POST['email'] ?? null;
    $addAdmin = $db->addAdminUserByEmail($email);

    if (!$addAdmin) {
        http_response_code(500);
        echo json_encode(["error" => "Errore durante l'eliminazione del post"]);
    } else {
        http_response_code(200);
        header("Location: /admin");
    };
}

?>