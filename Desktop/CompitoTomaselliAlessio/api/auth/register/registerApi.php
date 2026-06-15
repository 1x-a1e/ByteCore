<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require __DIR__ . '/../../../databaseApi/dbConnect.php';

        $nome = $_POST['name'] ?? '';
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $passwd = password_hash($_POST['password'], PASSWORD_DEFAULT) ?? '';

        $db = new dbConnect();

        if ($db->registerUser($nome, $username, $email, $passwd)) {
            header("Location: /auth?success=Registrazione avvenuta con successo!");
            exit();
        }
        else {
            header("Location: /auth?error=Errore durante la registrazione dell'utente!");
            exit();
        }
    }
?>