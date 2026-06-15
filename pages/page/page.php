<?php
  session_start();


  if ($_SERVER['REQUEST_METHOD'] === "GET") {
    $id = (int) $_GET["id"] ?? null;

    if (!$id) {
      header("Location: /");
      die("");
    }
  }

  require __DIR__ . "/../../assets/navbar/nav.php";
  require __DIR__ . "/../../api/posts/apiPosts.php";
  require __DIR__ . "/../../vendor/autoload.php";

  $post = getPostFromId($id)[0];

  $Parsedown = new Parsedown();
  $Parsedown->setSafeMode(true);
  $contenuto = $Parsedown->text($post["Contenuto"]);
?>
<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ByteCore — <?= htmlspecialchars($post["Titolo"]) ?></title>
<link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/pages/page/style/page.css">
</head>
<body>
  
<?= nav(); ?>
<div class="page">

  <!-- Back -->
  <a href="/articoli" class="back-link">← Torna indietro nel futuro</a>

  <!-- Header -->
  <div class="post-header">
    <div class="post-meta">
      <a href="/categoria/{{categoria}}" class="post-tag">cat</a>
      <span class="post-date"><?= htmlspecialchars($post["dataPublicazione"]) ?></span>
    </div>

    <h1 class="post-title"><?= htmlspecialchars($post["Titolo"]) ?></h1>

    <div class="post-author">
      <div class="author-avatar"><?php echo substr($post["Username"], 0, 2) ?></div>
      <div>
        <div class="author-name"><?= htmlspecialchars($post["Nome"]) ?></div>
        <div class="author-username">@<?= htmlspecialchars($post["Username"]) ?></div>
      </div>
    </div>
  </div>

  <!-- Divider -->
  <div class="post-divider"></div>

  <!-- Contenuto -->
  <div class="post-content">
    <?= $contenuto ?>
  </div>
</div>
</body>
</html>