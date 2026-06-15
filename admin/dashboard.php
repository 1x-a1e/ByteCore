<?php

    require __DIR__ . '/assets/checkUser.php';

    checkUserAdmin();

    require __DIR__ . '/../api/posts/apiPosts.php';
    require __DIR__ . '/../api/users/apiUser.php';
    require __DIR__ . '/../api/progetti/apiProgetti.php';

    $totPosts = getCountPosts()[0]["tot"];
    $totUsers = getCountUsers()[0]["tot"];
    $totUsersAdmin = getCountUsersAdmin()[0]["tot"];
    $totProgetti = countProgetti()[0]["tot"];
    $categorie = getAllCategoria();
    $lastPost = getAllPostsDESC();
    $posts = getAllPosts();
    $users = getAllUsers();
    $admins = getAllUsersAdmin();
    $allProgetti = getAllProgetti();
?>
<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ByteCore — Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/admin/style/dashboard.css">
</head>
<body>

<aside class="sidebar" id="sidebar">
  <a href="/" class="sidebar-logo">
    <div class="logo-icon">▸</div>
    ByteCore
  </a>

  <div class="sidebar-section">
    <div class="sidebar-section-label">Generale</div>
    <a href="#" class="sidebar-link active" onclick="showPanel('overview', this)">
      <span class="link-icon">◈</span> Overview
    </a>
  </div>

  <div class="sidebar-section">
    <div class="sidebar-section-label">Contenuti</div>
    <a href="#" class="sidebar-link" onclick="showPanel('posts', this)">
      <span class="link-icon">📝</span> Gestione post
    </a>
    <a href="#" class="sidebar-link" onclick="showPanel('new-post', this)">
      <span class="link-icon">＋</span> Nuovo post
    </a>
    <a href="#" class="sidebar-link" onclick="showPanel('new-categoria', this)">
      <span class="link-icon">🏷</span> Categorie
    </a>
    <a href="#" class="sidebar-link" onclick="showPanel('progetti', this)">
      <span class="link-icon">📁</span> Gestione progetti
    </a>
    <a href="#" class="sidebar-link" onclick="showPanel('new-progetto', this)">
      <span class="link-icon">🗂</span> Nuovo progetto
    </a>
  </div>

  <div class="sidebar-section">
    <div class="sidebar-section-label">Utenti</div>
    <a href="#" class="sidebar-link" onclick="showPanel('users', this)">
      <span class="link-icon">👤</span> Gestione utenti
    </a>
    <a href="#" class="sidebar-link" onclick="showPanel('admins', this)">
      <span class="link-icon">🛡</span> Gestione admin
    </a>
  </div>

  <div class="sidebar-section">
    <div class="sidebar-section-label">Sistema</div>
    <a href="/settings" class="sidebar-link">
      <span class="link-icon">⚙</span> Impostazioni
    </a>
    <a href="/logout" class="sidebar-link danger">
      <span class="link-icon">🚪</span> Logout
    </a>
  </div>

  <div class="sidebar-footer">
    <div class="sidebar-user">
      <div class="user-avatar-sm"><?= strtoupper(substr($_SESSION['Nome'], 0, 2)) ?></div>
      <div class="user-info-sm">
        <div class="user-name-sm"><?= htmlspecialchars($_SESSION['Nome']) ?></div>
        <div class="user-role-sm"><?= htmlspecialchars($_SESSION['Role']) ?></div>
      </div>
    </div>
  </div>
</aside>

<div class="main">

  <div class="topbar">
    <span class="topbar-title" id="topbar-title">Overview</span>
    <div class="topbar-right">
      <a href="#" class="topbar-btn primary" onclick="showPanel('new-post', document.querySelector('[onclick*=new-post]'))">+ Nuovo post</a>
      <a href="/" class="topbar-btn">← Sito</a>
    </div>
  </div>

  <div class="content">

    <!-- ══ OVERVIEW ══ -->
    <div class="panel active" id="panel-overview">
      <div class="stats-grid">
        <div class="stat-card green">
          <span class="stat-icon">📝</span>
          <div class="stat-val"><?= htmlspecialchars($totPosts) ?></div>
          <div class="stat-lbl">Post totali</div>
        </div>
        <div class="stat-card blue">
          <span class="stat-icon">👤</span>
          <div class="stat-val"><?= htmlspecialchars($totUsers) ?></div>
          <div class="stat-lbl">Utenti</div>
        </div>
        <div class="stat-card yellow">
          <span class="stat-icon">🛡</span>
          <div class="stat-val"><?= htmlspecialchars($totUsersAdmin) ?></div>
          <div class="stat-lbl">Admin</div>
        </div>
        <div class="stat-card red">
          <span class="stat-icon">📂</span>
          <div class="stat-val"><?= htmlspecialchars($totProgetti) ?></div>
          <div class="stat-lbl">Progetti</div>
        </div>
      </div>

      <div class="sec-header">
        <span class="sec-title">Ultimi post</span>
      </div>
      <div class="table-wrap" style="margin-bottom: 32px;">
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Titolo</th>
              <th>Categoria</th>
              <th>Autore</th>
              <th>Data</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($lastPost as $ps): ?>
            <tr>
              <td style="color:var(--muted);"><?= htmlspecialchars($ps["id"]) ?></td>
              <td><?= htmlspecialchars($ps["Titolo"]) ?></td>
              <td><span class="badge badge-green"><?= htmlspecialchars(getCategoriaFromId($ps["idCat"])[0]["Nome"]) ?></span></td>
              <td>@<?= htmlspecialchars($ps["Username"]) ?></td>
              <td><?= htmlspecialchars($ps["dataPublicazione"]) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="sec-header">
        <span class="sec-title">Ultimi utenti registrati</span>
      </div>
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Nome</th>
              <th>Username</th>
              <th>Email</th>
              <th>Ruolo</th>
              <th>Azioni</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>

    <!-- ══ GESTIONE POST ══ -->
    <div class="panel" id="panel-posts">
      <div class="sec-header">
        <span class="sec-title">Tutti i post</span>
        <a href="#" class="topbar-btn primary" style="font-size:11px;padding:7px 14px;" onclick="showPanel('new-post', document.querySelector('[onclick*=new-post]'))">+ Nuovo</a>
      </div>
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Titolo</th>
              <th>Categoria</th>
              <th>Autore</th>
              <th>Data</th>
              <th>Azioni</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($posts as $ps): ?>
            <tr>
              <td style="color:var(--muted);"><?= htmlspecialchars($ps["id"]) ?></td>
              <td><?= htmlspecialchars($ps["Titolo"]) ?></td>
              <td><span class="badge badge-green"><?= htmlspecialchars(getCategoriaFromId($ps["idCat"])[0]["Nome"]) ?></span></td>
              <td>@<?= htmlspecialchars($ps["Username"]) ?></td>
              <td><?= htmlspecialchars($ps["dataPublicazione"]) ?></td>
              <td>
                <div class="actions">
                  <a href="/admin/modify-post?id=<?= $ps['id'] ?>" class="act-btn edit">Modifica</a>
                  <a class="act-btn del" href="/admin/delete-post?id=<?= $ps["id"] ?>">Elimina</a>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- ══ NUOVO POST ══ -->
    <div class="panel" id="panel-new-post">
      <div class="form-box">
        <form method="POST" action="/admin/create-post">
          <div class="form-grid">
            <div class="field" style="grid-column: 1 / -1;">
              <label class="field-label">Titolo</label>
              <input class="field-input" type="text" name="titolo" placeholder="Titolo del post..." required>
            </div>
            <div class="field">
              <label class="field-label">Categoria</label>
              <select class="field-select" name="categoria">
                <option value="">Seleziona categoria</option>
                <?php foreach ($categorie as $cat): ?>
                  <option value="<?= htmlspecialchars($cat["Nome"]) ?>"><?= htmlspecialchars($cat["Nome"]) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="field">
              <label class="field-label">Estratto</label>
              <input class="field-input" type="text" name="estratto" placeholder="Breve descrizione...">
            </div>
            <div class="field" style="grid-column: 1 / -1;">
              <label class="field-label">Contenuto</label>
              <textarea class="field-textarea" name="contenuto" placeholder="Scrivi il contenuto del post..." style="min-height:200px;"></textarea>
            </div>
          </div>
          <div class="form-actions">
            <button type="reset" class="btn btn-ghost">Annulla</button>
            <button type="submit" class="btn btn-primary">Pubblica post →</button>
          </div>
        </form>
      </div>
    </div>

    <!-- ══ NUOVA CATEGORIA ══ -->
    <div class="panel" id="panel-new-categoria">
      <div class="sec-header">
        <span class="sec-title">Categorie esistenti</span>
      </div>
      <div class="table-wrap" style="margin-bottom: 32px;">
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Nome categoria</th>
              <th>Azioni</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($categorie as $cat): ?>
            <tr>
              <td style="color:var(--muted);"><?= htmlspecialchars($cat["id"]) ?></td>
              <td><span class="badge badge-green"><?= htmlspecialchars($cat["Nome"]) ?></span></td>
              <td>
                <div class="actions">
                  <a class="act-btn del" href="/admin/delete-cat?id=<?= $cat["id"] ?>">Cancella</a>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="sec-header">
        <span class="sec-title">Aggiungi categoria</span>
      </div>
      <div class="form-box">
        <form method="POST" action="/admin/create-categoria">
          <div class="form-grid">
            <div class="field" style="grid-column: 1 / -1;">
              <label class="field-label">Nome categoria</label>
              <input class="field-input" type="text" name="nome" placeholder="Es. Networking, Cybersecurity..." required>
            </div>
          </div>
          <div class="form-actions">
            <button type="reset" class="btn btn-ghost">Annulla</button>
            <button type="submit" class="btn btn-primary">Crea categoria →</button>
          </div>
        </form>
      </div>
    </div>

    <!-- ══ GESTIONE PROGETTI ══ -->
    <div class="panel" id="panel-progetti">
      <div class="panel-search">
        <input type="search" placeholder="Cerca progetto per nome...">
        <button class="btn btn-ghost">Cerca</button>
      </div>
      <div class="sec-header">
        <span class="sec-title">Tutti i progetti</span>
        <a href="#" class="topbar-btn primary" style="font-size:11px;padding:7px 14px;" onclick="showPanel('new-progetto', document.querySelector('[onclick*=new-progetto]'))">+ Nuovo</a>
      </div>
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Nome</th>
              <th>Categoria</th>
              <th>Stato</th>
              <th>Tecnologie</th>
              <th>GitHub</th>
              <th>Azioni</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($allProgetti as $p): ?>
            <tr>
              <td style="color:var(--muted);"><?= htmlspecialchars($p["id"]) ?></td>
              <td><?= htmlspecialchars($p["Nome"]) ?></td>
              <td><span class="badge badge-blue"><?= htmlspecialchars($p["Categoria"]) ?></span></td>
              <td><span class="badge <?= $p['stato'] === 'Completato' ? 'badge-green' : 'badge-yellow' ?>"><?= htmlspecialchars($p["stato"]) ?></span></td>
              <td style="color:var(--muted);font-size:11px;"><?= htmlspecialchars($p["tecnologie"]) ?></td>
              <td>
                <a href="<?= htmlspecialchars($p["link"]) ?>" target="_blank" class="act-btn" style="color:var(--accent2);">🐙 Link</a>
              </td>
              <td>
                <div class="actions">
                  <a class="act-btn del" href="/admin/delete-progetto?id=<?= $p["id"] ?>">Elimina</a>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- ══ NUOVO PROGETTO ══ -->
    <div class="panel" id="panel-new-progetto">
      <div class="sec-header">
        <span class="sec-title">Aggiungi progetto</span>
      </div>
      <div class="form-box">
        <form method="POST" action="/admin/create-progetto">
          <div class="form-grid">
            <div class="field">
              <label class="field-label">Nome progetto</label>
              <input class="field-input" type="text" name="nome" placeholder="Es. ByteCore..." required>
            </div>
            <div class="field">
              <label class="field-label">Stato</label>
              <select class="field-select" name="stato">
                <option value="In corso">In corso</option>
                <option value="Completato">Completato</option>
              </select>
            </div>
            <div class="field">
              <label class="field-label">Categoria</label>
              <select class="field-select" name="categoria">
                <?php foreach($categorie as $ct): ?>
                  <option value="<?= $ct["Nome"] ?>"><?= $ct["Nome"] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="field">
              <label class="field-label">Link GitHub</label>
              <input class="field-input" type="url" name="github" placeholder="https://github.com/utente/repo">
            </div>
            <div class="field" style="grid-column: 1 / -1;">
              <label class="field-label">Tecnologie usate</label>
              <input class="field-input" type="text" name="tech" placeholder="PHP, MySQL, HTML/CSS  (separate da virgola)">
            </div>
            <div class="field" style="grid-column: 1 / -1;">
              <label class="field-label">Descrizione</label>
              <textarea class="field-textarea" name="descrizione" placeholder="Descrivi il progetto..."></textarea>
            </div>
          </div>
          <div class="form-actions">
            <button type="reset" class="btn btn-ghost">Annulla</button>
            <button type="submit" class="btn btn-primary">Aggiungi progetto →</button>
          </div>
        </form>
      </div>
    </div>

    <!-- ══ GESTIONE UTENTI ══ -->
    <div class="panel" id="panel-users">
      <div class="panel-search">
        <input type="search" placeholder="Cerca utente per nome o username...">
        <button class="btn btn-ghost">Cerca</button>
      </div>
      <div class="sec-header">
        <span class="sec-title">Tutti gli utenti</span>
      </div>
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Nome</th>
              <th>Username</th>
              <th>Email</th>
              <th>Ruolo</th>
              <th>Azioni</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users as $u): ?>
            <tr>
              <td style="color:var(--muted);"><?= htmlspecialchars($u["id"]) ?></td>
              <td><?= htmlspecialchars($u["Nome"]) ?></td>
              <td>@<?= htmlspecialchars($u["Username"]) ?></td>
              <td><?= htmlspecialchars($u["Email"]) ?></td>
              <td><span class="badge badge-<?= strtolower($u['Role_user']) === 'admin' ? 'red' : ($u["Role_user"] === 'author' ? 'green' : 'gray') ?>"><?= htmlspecialchars($u["Role_user"]) ?></span></td>
              <td>
                <div class="actions">
                  <a class="act-btn del" href="/admin/delete-user?id=<?= $u["id"] ?>">Elimina</a>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- ══ GESTIONE ADMIN ══ -->
    <div class="panel" id="panel-admins">
      <div class="sec-header">
        <span class="sec-title">Amministratori</span>
      </div>
      <div class="table-wrap" style="margin-bottom: 32px;">
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Nome</th>
              <th>Username</th>
              <th>Email</th>
              <th>Ruolo attuale</th>
              <th>Cambia ruolo</th>
              <th>Azioni</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($admins as $a): ?>
            <tr>
              <td style="color:var(--muted);"><?= htmlspecialchars($a["id"]) ?></td>
              <td><?= htmlspecialchars($a["Nome"]) ?></td>
              <td>@<?= htmlspecialchars($a["Username"]) ?></td>
              <td><?= htmlspecialchars($a["Email"]) ?></td>
              <td><span class="badge badge-red"><?= htmlspecialchars($a["Role_user"]) ?></span></td>
              <td>
                <form method="POST" action="/admin/change-role" style="display:flex;gap:6px;">
                  <input type="hidden" name="user_id" value="<?= $a['id'] ?>">
                  <select class="field-select" name="ruolo" style="padding:4px 10px;font-size:11px;">
                    <option value="Admin" <?= $a['Role_user'] === 'Admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="Author" <?= $a['Role_user'] === 'Author' ? 'selected' : '' ?>>Author</option>
                    <option value="User" <?= $a['Role_user'] === 'User' ? 'selected' : '' ?>>User</option>
                  </select>
                  <button type="submit" class="act-btn approve">Salva</button>
                </form>
              </td>
              <td>
                <div class="actions">
                  <button class="act-btn del">Rimuovi</button>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="sec-header">
        <span class="sec-title">Promuovi utente</span>
      </div>
      <div class="form-box">
        <form method="POST" action="/admin/promote">
          <div class="form-grid">
            <div class="field">
              <label class="field-label">Username o Email</label>
              <input class="field-input" type="text" name="utente" placeholder="@username oppure email...">
            </div>
            <div class="field">
              <label class="field-label">Nuovo ruolo</label>
              <select class="field-select" name="ruolo">
                <option value="Author">Author</option>
                <option value="Admin">Admin</option>
              </select>
            </div>
          </div>
          <div class="form-actions">
            <button type="reset" class="btn btn-ghost">Annulla</button>
            <button type="submit" class="btn btn-primary">Promuovi →</button>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>

<!-- Popout notifiche -->
<?php if ($_GET["S"]): ?>
<div class="popout popout-ok">
  <button class="popout-close" onclick="this.parentElement.remove()">✕</button>
  <?= htmlspecialchars($_GET["S"]) ?>
</div>
<?php endif; ?>  
<?php if ($_GET["E"]): ?>
<div class="popout popout-err">
  <button class="popout-close" onclick="this.parentElement.remove()">✕</button>
  <?= htmlspecialchars($_GET["E"]) ?>
</div>
<?php endif; ?>

<script>
  const titles = {
    'overview':      'Overview',
    'posts':         'Gestione post',
    'new-post':      'Nuovo post',
    'new-categoria': 'Categorie',
    'progetti':      'Gestione progetti',
    'new-progetto':  'Nuovo progetto',
    'users':         'Gestione utenti',
    'admins':        'Gestione admin',
  };

  function showPanel(id, linkEl) {
    document.querySelectorAll('.panel').forEach(p => p.classList.remove('active'));
    const panel = document.getElementById('panel-' + id);
    if (panel) panel.classList.add('active');
    document.querySelectorAll('.sidebar-link').forEach(l => l.classList.remove('active'));
    if (linkEl) linkEl.classList.add('active');
    document.getElementById('topbar-title').textContent = titles[id] || 'Dashboard';
  }
</script>

</body>
</html>