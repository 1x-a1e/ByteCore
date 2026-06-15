<?php

require_once __DIR__ . "/../../assets/checkUser.php";

checkUserAdmin();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    try {
        $id = $_POST["id"];
        $titolo = htmlspecialchars($_POST["titolo"]);
        $categoria = htmlspecialchars($_POST["categoria"]);
        $estratto = htmlspecialchars($_POST["estratto"] ?? "");
        $contenuto = htmlspecialchars($_POST["contenuto"] ?? "");

        require_once __DIR__ . "/../../../databaseApi/dbConnect.php";

        $db = new dbConnect();

        $catResult = $db->getCatIdByName($categoria);

        if (!$catResult) {
            header("Location: /admin?E=Categoria non valida!");
            exit();
        }

        $idCat = $catResult[0]["idCat"];
        $db->updatePost($id, $titolo, $contenuto, $estratto, $idCat);
        header("Location: /admin?S=Post aggiornato con successo!");
        exit();
    } catch (Exception $e) {
        header("Location: /admin?E=Si è verificato un errore durante l'aggiornamento del post!");
        exit();
    }

}

?>