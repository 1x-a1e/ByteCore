<?php
    session_start();

    include __DIR__ . '/../../assets/navbar/nav.php';
    include __DIR__ . '/../../api/users/apiUser.php';
    include __DIR__ . '/../../api/posts/apiPosts.php';

    $totPosts = getCountPosts()[0]["tot"];

    if (isset($_GET["q"]) && $_GET["q"] != "") {
      $posts = searchPosts($_GET["q"]);
    }
    else {
      $posts = getAllPosts();
    }
?>
<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ByteCore — Tutti gli articoli</title>
<link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="./pages/articoli/style/articoli.css">
</head>
<body>
<?= nav() ?>
<div class="page">

  <!-- Header -->
  <div class="page-header">
    <div>
      <div class="page-eyebrow">Blog</div>
      <h1 class="page-title">Tutti gli articoli</h1>
    </div>
    <div class="page-count">
      <span><?= $totPosts ?></span> articoli trovati
    </div>
  </div>

  <!-- Search + filtri -->
  <form method="GET" action="/articoli">
    <div class="toolbar">
      <div class="search-wrap">
        <div class="search-icon">⌕</div>
        <input
          class="search-input"
          type="search"
          name="q"
          placeholder="Cerca per titolo, contenuto..."
          autocomplete="off"
        >
        <button type="submit" class="search-btn">Cerca</button>
      </div>
    </div>
  </form>

  <!-- Griglia -->
  <div class="articles-grid">

    <?php if (isset($_GET["q"]) && $_GET["q"] != ""): ?>
      <?php if (count($posts) == 0): ?>

        <div class="no-results">
          <span class="no-results-icon">🔍</span>
          <div class="no-results-title">Nessun articolo trovato</div>
          <div class="no-results-sub">Prova con un'altra parola chiave o categoria</div>
        </div>

      <?php else: ?>
        <?php foreach ($posts as $ps): ?>
        <article class="card">
          <div class="card-body">
            <div class="card-meta">
              <a href="/articoli?cat=<?= htmlspecialchars($ps["idCat"]) ?>" class="card-tag tag-green"><?= htmlspecialchars(getCategoriaFromId($ps["idCat"])[0]["Nome"]) ?></a>
              <span class="card-date"><?= htmlspecialchars($ps["dataPublicazione"]) ?></span>
            </div>
            <h2 class="card-title">
              <a href="/posts?id=<?= htmlspecialchars($ps["id"]) ?></a>"><?= htmlspecialchars($ps["Titolo"]) ?></a>
            </h2>
            <p class="card-excerpt"><?= htmlspecialchars($ps["ContenutoEstratto"]) ?></p>
            <div class="card-footer">
              <div class="card-author">
                <div class="author-avatar"><?php echo htmlspecialchars(substr($ps["Username"], 0, 2)) ?></div>
                <span class="author-name">@<?= htmlspecialchars($ps["Username"]) ?></span>
              </div>
            </div>
          </div>
        </article>
        <?php endforeach; ?>
      <?php endif ?>

    <?php else: ?>

      <?php foreach ($posts as $ps): ?>
        <article class="card">
          <div class="card-body">
            <div class="card-meta">
              <a href="/articoli?cat=<?= htmlspecialchars($ps["idCat"]) ?>" class="card-tag tag-green"><?= htmlspecialchars(getCategoriaFromId($ps["idCat"])[0]["Nome"]) ?></a>
              <span class="card-date"><?= htmlspecialchars($ps["dataPublicazione"]) ?></span>
            </div>
            <h2 class="card-title">
              <a href="/posts?id=<?= htmlspecialchars($ps["id"]) ?></a>"><?= htmlspecialchars($ps["Titolo"]) ?></a>
            </h2>
            <p class="card-excerpt"><?= htmlspecialchars($ps["ContenutoEstratto"]) ?></p>
            <div class="card-footer">
              <div class="card-author">
                <div class="author-avatar"><?php echo htmlspecialchars(substr($ps["Username"], 0, 2)) ?></div>
                <span class="author-name">@<?= htmlspecialchars($ps["Username"]) ?></span>
              </div>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    <?php endif ?>
  </div>

  <!-- Paginazione -->
  <nav class="pagination">
    <!-- Precedente -->
    <a href="/articoli?page={{page_prev}}" class="page-btn {{#
    <a href="/articoli?page=1" class="page-btn active">1</a>

    <!-- Successivo -->
    <a href="/articoli?page={{page_next}}" class="page-btn {{#if ultima_pagina}}disabled{{/if}}">→</a>
  </nav>

</div>
</body>
</html>