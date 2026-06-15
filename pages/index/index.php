<?php
  session_start();

  include __DIR__ . '/../../assets/navbar/nav.php';
  include __DIR__ . '/../../api/posts/apiPosts.php';
  include __DIR__ . '/../../api/progetti/apiProgetti.php';

  $totPosts = getCountPosts()[0]["tot"];
  $totCat = getCountCategoria()[0]["tot"];
  $totProgetti = countProgetti()[0]["tot"];
  $posts = getAllPostsDESC();
  $allCategoria = getAllCategoria();
?>
<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ByteCore — Home</title>
<link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/pages/index/style/index.css">
</head>
<body>

<?php echo nav(); ?>

<!-- ══════════════════════════════════════
     HERO
══════════════════════════════════════ -->
<section class="hero">
  <div class="hero-content">
    <div class="hero-eyebrow">Benvenuto su ByteCore</div>
    <h1 class="hero-title">
      Il futuro<br>
      del <span class="hl">software</span><br>
      è <span class="hl2">open.</span>
    </h1>
    <p class="hero-sub">
      “It’s not a bug — it’s a feature.” <br>
      Appassionato di Informatica che condivide la propria passione!
    <div class="hero-ctas">
      <a href="/articoli" class="cta-primary">Leggi gli articoli →</a>
      <a href="/progetti" class="cta-secondary">Scopri i miei progetti</a>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════
     STAT BAR
══════════════════════════════════════ -->
<div class="stat-bar">
  <div class="stat-item">
    <div class="stat-value"><?= $totPosts ?></div>
    <div class="stat-label">Articoli pubblicati</div>
  </div>
  <div class="stat-item">
    <div class="stat-value"><?= $totProgetti ?></div>
    <div class="stat-label">Progetti</div>
  </div>
  <div class="stat-item">
    <div class="stat-value"><?= $totCat ?></div>
    <div class="stat-label">Categorie</div>
  </div>
</div>

<!-- ══════════════════════════════════════
     CHI SONO
══════════════════════════════════════ -->
<div class="about-section">
  <div class="section-header">
    <span class="section-title">Chi sono</span>
    <a href="/about" class="section-link">Scopri di più →</a>
  </div>
  <div class="about-box">
    <div class="about-avatar">AL</div>
    <div class="about-content">
      <div class="about-label">// developer & student</div>
      <div class="about-name">Alessio</div>
      <div class="about-role">Studente ITIS · @1xa1e</div>
      <p class="about-bio">
        Appassionato di informatica, sicurezza e sistemi Linux. Scrivo su questo blog per condividere quello che imparo ogni giorno — dal networking alla programmazione, passando per tool e configurazioni che uso davvero.
      </p>
      <div class="skill-list">
        <span class="skill-tag">PHP</span>
        <span class="skill-tag">Linux / Arch</span>
        <span class="skill-tag">MySQL</span>
        <span class="skill-tag">Python</span>
        <span class="skill-tag">Cybersecurity</span>
      </div>
    </div>
  </div>
</div>

<!-- ══════════════════════════════════════
     CATEGORIE
══════════════════════════════════════ -->
<div class="section">
  <div class="section-header">
    <span class="section-title">Categorie</span>
    <a href="/articoli" class="section-link">Tutti gli articoli →</a>
  </div>
  <div class="categories">

      <?php foreach($allCategoria as $ac): ?>
  
        <a href="/articoli?cat=<?= $ac["id"] ?>" class="cat-chip">
          <span class="cat-count"><?= $ac["Nome"] ?></span>
        </a>

      <?php endforeach; ?>
      
  </div>
</div>

<!-- ══════════════════════════════════════
     SEARCH
══════════════════════════════════════ -->
<div class="search-section">
  <form action="/articoli" method="GET">
    <div class="search-wrap">
      <div class="search-icon">⌕</div>
      <input
        class="search-input"
        type="search"
        name="q"
        placeholder="Cerca articoli, guide, argomenti..."
        autocomplete="off"
      >
      <button type="submit" class="search-btn">Cerca</button>
    </div>
  </form>
</div>

<!-- ══════════════════════════════════════
     ARTICLES GRID
══════════════════════════════════════ -->
<div class="section">
  <div class="section-header">
    <span class="section-title">Ultimi articoli</span>
    <a href="/articoli" class="section-link">Vedi tutti →</a>
  </div>

  <div class="articles-grid">

    <?php foreach ($posts as $ps): ?>

      <article class="card">
        <div class="card-body">
          <div class="card-meta">
            <a href="/articoli?cat=<?= urlencode($ps['idCat']) ?>" class="card-tag">
              <?= htmlspecialchars(getCategoriaFromId($ps["idCat"])[0]["Nome"]) ?>
            </a>
            <span class="card-date"><?= htmlspecialchars($ps['dataPublicazione']) ?></span>
          </div>
          <h2 class="card-title">
            <a href="/posts?id=<?= $ps['id'] ?>"><?= htmlspecialchars($ps['Titolo']) ?></a>
          </h2>
          <p class="card-excerpt"><?= htmlspecialchars($ps['ContenutoEstratto']) ?></p>
          <div class="card-footer">
            <div class="card-author">
              <span class="author-name">@<?= htmlspecialchars($ps['Username']) ?></span>
            </div>
          </div>
        </div>
      </article>

    <?php endforeach; ?>

  </div>

  <div class="load-more-wrap" style="margin-top: 32px;">
    <a href="/articoli" class="load-more-btn">↓ Carica altri articoli</a>
  </div>
</div>

<!-- ══════════════════════════════════════
     FOOTER
══════════════════════════════════════ -->
<footer>
  <div class="footer-top">
    <div class="footer-brand">
      <a href="/" class="nav-logo" style="margin-bottom:16px;">
        <div class="nav-logo-icon">▸</div>
        BYTECORE
      </a>
      <p class="footer-desc">Il blog italiano di informatica per sviluppatori, sysadmin e appassionati di tecnologia.</p>
    </div>

    <div>
      <div class="footer-col-title">Esplora</div>
      <ul class="footer-links">
        <li><a href="/articoli">Articoli</a></li>
        <li><a href="/progetti">Progetti</a></li>
        <li><a href="/autori">Autori</a></li>
        <li><a href="/about">About</a></li>
      </ul>
    </div>

    <div>
      <div class="footer-col-title">Info</div>
      <ul class="footer-links">
        <li><a href="/about">Chi siamo</a></li>
        <li><a href="/settings">Impostazioni</a></li>
      </ul>
    </div>
  </div>

  <div class="footer-bottom">
    <span>© 2025 <span>ByteCore</span> — Tutti i diritti riservati</span>
    <span>Fatto con <span>♥</span> da dev italiani</span>
  </div>
</footer>

</body>
</html>