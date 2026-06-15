<?php
  session_start();


  include __DIR__ . '/../../assets/navbar/nav.php';
  include __DIR__ . '/../../api/progetti/apiProgetti.php';

  $progetti = getAllProgetti();
?>
<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ByteCore — Progetti</title>
<link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="./pages/progetti/style/progetti.css">
</head>
<body>
<?= nav() ?>
<div class="page">

  <!-- Header -->
  <div class="page-header">
    <div class="page-eyebrow">Portfolio</div>
    <h1 class="page-title">I miei progetti</h1>
    <p class="page-sub">// una raccolta di quello che ho costruito — dal blog ai tool, dai progetti scolastici agli script Linux.</p>
  </div>

  <!-- Lista progetti -->
  <div class="projects-list">

    <?php foreach($progetti as $ps):?>
      <div class="project">
        <div class="project-inner">
          <div class="project-thumb-placeholder">📝</div>
          <div class="project-content">
            <div class="project-top">
              <div class="project-name"><?= htmlspecialchars($ps["Nome"]) ?></div>
              <div class="project-badges">
                <span class="cat-badge cat-blog">Blog</span>
                <span class="status-badge status-wip"><?= htmlspecialchars($ps["stato"]) ?></span>
              </div>
            </div>
            <p class="project-desc">
              <?= htmlspecialchars($ps["Descrizione"]) ?>
            </p>
            <div class="tech-stack">
              <?php
                $tec = array_map('trim', explode(',', htmlspecialchars($ps["tecnologie"])));
                foreach ($tec as $t) {
                  echo "<span class='tech-tag'>" . htmlspecialchars($t) . "</span>";
                }
              ?>
            </div>
            <div class="project-links">
              <a href="<?= htmlspecialchars($ps["link"]) ?>" class="project-link">🐙 GitHub</a>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>

  </div>
</div>
</body>
</html>