<?php

require_once __DIR__ . "/../../assets/checkUser.php";

checkUserAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . "/../../../databaseApi/dbConnect.php";
    $db = new dbConnect();

    $nome = $_POST["nome"] ?? null;
    $createCategoria = $db->createCat($_POST['nome']);

    if (!$createCategoria) {
        http_response_code(500);
        echo json_encode(["error" => "Errore durante la creazione del post"]);
    } else {
        http_response_code(200);
        header("Location: /admin");
        exit();
    };
}

?>