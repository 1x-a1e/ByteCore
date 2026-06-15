<?php

require_once __DIR__ . "/../../assets/checkUser.php";

checkUserAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . "/../../../databaseApi/dbConnect.php";
    $db = new dbConnect();

    $nome = $_POST['nome'] ?? null;
    $stato = $_POST['stato'] ;
    $idCat = $db->getCatIdByName($_POST['categoria'])[0]['idCat'] ?? null;
    $link = $_POST['github'] ?? null;
    $tecnologie = $_POST['tech'] ?? null;
    $descrizione = $_POST['descrizione'] ?? null;
    $idUser = $_SESSION['id'] ?? null;
    $data = date("Y-m-d H:i:s");

    $createProj = $db->createProject($nome, $stato, $idCat, $link, $tecnologie, $descrizione, $idUser, $data);

    if (!$createProj) {
        http_response_code(500);
        echo json_encode(["error" => "Errore durante la creazione del post"]);
    } else {
        http_response_code(200);
        header("Location: /admin");
        exit();
    };
}

?>