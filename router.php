<?php
$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$file = __DIR__ . $path;

if ($path !== "/" && file_exists($file) && !is_dir($file)) {
    return false;
}

$page = $path;

switch ($page) {
    case "/":
        require __DIR__ . "/pages/index/index.php";
        break;

    case "/auth":
        require __DIR__ . "/pages/auth/auth.php";
        break;
    
    case "/settings":
        require __DIR__ . "/pages/settings/settings.php";
        break;

    case "/about":
        require __DIR__ . "/pages/chiSono/chiSono.php";
        break;

    case "/posts":
        require __DIR__ . "/pages/page/page.php";
        break;

    case "/articoli":
        require __DIR__ . "/pages/articoli/articoli.php";
        break;

    case "/progetti":
        require __DIR__ . "/pages/progetti/progetti.php";
        break;

    case "/api/auth/login":
        require __DIR__ . "/api/auth/login/loginApi.php";
        break;
    
    case "/api/auth/register":
        require __DIR__ . "/api/auth/register/registerApi.php";
        break;

    case "/logout":
        require __DIR__ . "/api/logout/logout.php";
        break;

    case "/admin":
        require __DIR__ . "/admin/dashboard.php";
        break;

    case "/admin/create-post":
        require __DIR__ . "/admin/api/createPost/createPost.php";
        break;
    
    case "/admin/create-categoria":
        require __DIR__ . "/admin/api/createCategoria/createCategoria.php";
        break;

    case "/admin/delete-cat":
        require __DIR__ . "/admin/api/delete/deleteCat.php";
        break;

    case "/admin/delete-post":
        require __DIR__ . "/admin/api/delete/deletePost.php";
        break;

    case "/admin/delete-user":
        require __DIR__ . "/admin/api/delete/deleteUser.php";
        break;

    case "/admin/create-progetto":
        require __DIR__ . "/admin/api/progetti/createProgetti.php";
        break;

    case "/admin/delete-progetto":
        require __DIR__ . "/admin/api/delete/deleteProject.php";
        break;

    case "/admin/promote":
        require __DIR__ . "/admin/api/update/updateToAdmin.php";
        break;

    case "/admin/modify-post":
        require __DIR__ . "/admin/page/modifyPost/edit-post.php";
        break;

    case "/admin/update-post":
        require __DIR__ . "/admin/api/update/updatePost.php";
        break;

    case "/impostazioni/profilo":
        require __DIR__ . "/api/settingsApi/updateUser.php";
        break;
    default:
        require __DIR__ . "/pages/404/index.html";
        break;
}

?>