<?php
    function checkUserAdmin() {
        session_start();

        if (!isset($_SESSION['Nome']) || !isset($_SESSION['Username'])) {
            header("Location: /auth?error=Devi effettuare il login per accedere a questa pagina!");
            die("");
        }

        if ($_SESSION['Role'] !== 'Admin') {
            header("Location: /");
            die("");
        }
    }
?>