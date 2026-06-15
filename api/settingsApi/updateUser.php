<?php



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);

    echo $nome . " " . $username . " " . $email;
}
exit;

?>