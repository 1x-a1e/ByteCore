<?php
    require __DIR__ . '/../../assets/checkUser.php';

    checkUserAdmin();

    require __DIR__ . "/../../../api/posts/apiPosts.php";

    $post = getPostFromId($_GET["id"] ?? null)[0];
    $categorie = getAllCategoria();
?>

<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Modifica Post</title>

<link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/admin/style/dashboard.css">
</head>

<body>

<div class="main" style="margin-left:0;">
  
  <!-- TOPBAR -->
  <div class="topbar">
    <span class="topbar-title">Modifica post</span>
    <div class="topbar-right">
      <a href="/admin" class="topbar-btn">← Dashboard</a>
    </div>
  </div>

  <div class="content">
    <div class="form-box">
      <form method="POST" action="/admin/update-post">
        <input type="hidden" name="id" value="<?= htmlspecialchars($post["id"]) ?>">
        <div class="form-grid">

          <!-- Titolo -->
          <div class="field" style="grid-column: 1 / -1;">
            <label class="field-label">Titolo</label>
            <input 
              class="field-input" 
              type="text" 
              name="titolo" 
              value="<?= htmlspecialchars($post["Titolo"]) ?>" 
              required>
          </div>

          <!-- Categoria -->
          <div class="field">
            <label class="field-label">Categoria</label>
            <select class="field-select" name="categoria">
              <?php foreach ($categorie as $cat): ?>
                <option 
                  value="<?= htmlspecialchars($cat["Nome"]) ?>"
                  <?= $cat["Nome"] == getCategoriaFromId($post["idCat"])[0]["Nome"] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($cat["Nome"]) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Estratto -->
          <div class="field">
            <label class="field-label">Estratto</label>
            <input 
              class="field-input" 
              type="text" 
              name="estratto"
              value="<?= htmlspecialchars($post["ContenutoEstratto"] ?? "") ?>">
          </div>

          <!-- Contenuto -->
          <div class="field" style="grid-column: 1 / -1;">
            <label class="field-label">Contenuto</label>
            <textarea 
              class="field-textarea" 
              name="contenuto"
              style="min-height:250px;"><?= htmlspecialchars($post["Contenuto"] ?? "") ?></textarea>
          </div>

        </div>

        <!-- AZIONI -->
        <div class="form-actions">
          <a href="/admin" class="btn btn-ghost">Annulla</a>
          <button type="submit" class="btn btn-primary">Salva modifiche →</button>
        </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>