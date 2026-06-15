<?php

require_once __DIR__ . "/../../assets/checkUser.php";

checkUserAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . "/../../../databaseApi/dbConnect.php";
    $db = new dbConnect();

    $categoria = $db->getCatIdByName($_POST['categoria'])[0]['idCat'] ?? null;

    if (!$categoria) {
        http_response_code(400);
        echo json_encode(["error" => "Categoria non trovata"]);
    }

    $titolo = $_POST['titolo'] ?? null;
    $estratto = $_POST['estratto'] ?? null;
    $contenuto = $_POST['contenuto'] ?? null;
    $id = $_SESSION['id'] ?? null;
    $dataPublicazione = date("Y-m-d H:i:s");

    $createPosts = $db->createPosts($titolo, $dataPublicazione, $contenuto, $estratto, $id, $categoria);

    if (!$createPosts) {
        http_response_code(500);
        echo json_encode(["error" => "Errore durante la creazione del post"]);
    } else {
        http_response_code(200);
        header("Location: /admin");
        exit();
    };
}

?>