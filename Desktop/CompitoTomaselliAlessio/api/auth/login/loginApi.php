<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require __DIR__ . '/../../../databaseApi/dbConnect.php';

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $db = new dbConnect();
        $login = $db->loginUserByEmail($email, $password);

        if ($login) {
            session_start();
            $_SESSION['Nome'] = $login['Nome'];
            $_SESSION['Username'] = $login['Username'];
            $_SESSION['Email'] = $login['Email'];
            $_SESSION['Role'] = $login['Role'];
            $_SESSION['id'] = $login['id'];

            header("Location: /");

            exit();
        }
        else {
            header("Location: /auth?error=Accesso non riuscito!");

            exit();
        }
    }

?>