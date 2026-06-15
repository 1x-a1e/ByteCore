<?php

  require __DIR__ . "/../../assets/checkuser/checkLoginUser.php";
  checkLoginUser();

  require __DIR__ . "/../../assets/navbar/nav.php";

?>
<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ByteCore — Impostazioni</title>
<link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="./pages/settings/style/settings.css">
</head>
<body>
<?php echo nav(); ?>
<div class="page">

  <!-- Page header -->
  <div class="page-header">
    <div class="page-eyebrow">Account</div>
    <h1 class="page-title">Impostazioni</h1>
    <p class="page-sub">// gestisci il tuo profilo e le preferenze</p>
  </div>

  <div class="settings-layout">

    <!-- Sidebar -->
    <nav class="settings-nav">
      <a href="#profilo">
        <span class="nav-icon">◈</span> Profilo
      </a>
      <a href="#password">
        <span class="nav-icon">⚿</span> Password
      </a>
      <a href="#elimina" class="danger">
        <span class="nav-icon">⚠</span> Elimina
      </a>
    </nav>

    <!-- Sections -->
    <div class="settings-sections">

      <!-- ── PROFILO ── -->
      <section class="settings-section section-profile" id="profilo">
        <div class="section-head">
          <div class="section-icon">◈</div>
          <div class="section-head-text">
            <div class="section-title">Modifica profilo</div>
            <div class="section-desc">// aggiorna le tue informazioni pubbliche</div>
          </div>
        </div>

        <div class="section-body">
          <form method="POST" action="/impostazioni/profilo">
            <div class="field-row">
              <div class="field">
                <label class="field-label" for="nome">Nome</label>
                <input
                  class="field-input"
                  type="text"
                  id="nome"
                  name="nome"
                  value="<?php echo $_SESSION['Nome'] ?>"
                  placeholder="Il tuo nome"
                  required
                  minlength="2"
                >
              </div>
              <div class="field">
                <label class="field-label" for="username">Username</label>
                <input
                  class="field-input"
                  type="text"
                  id="username"
                  name="username"
                  value="<?php echo $_SESSION['Username'] ?>"
                  placeholder="il_tuo_username"
                  required
                  minlength="3"
                  pattern="[a-zA-Z0-9_]+"
                >
                <span class="field-hint">Solo lettere, numeri e _</span>
              </div>
            </div>

            <div class="field">
              <label class="field-label" for="email">Email</label>
              <input
                class="field-input"
                type="email"
                id="email"
                name="email"
                placeholder="email@example.com"
                required
              >
            </div>
        </div>

        <div class="section-footer">
          <button type="reset" class="btn btn-ghost">Annulla</button>
          <button type="submit" class="btn btn-primary">Salva modifiche →</button>
        </div>
          </form>
      </section>

      <!-- ── PASSWORD ── -->
      <section class="settings-section section-password" id="password">
        <div class="section-head">
          <div class="section-icon">⚿</div>
          <div class="section-head-text">
            <div class="section-title">Cambio password</div>
            <div class="section-desc">// aggiorna le credenziali di accesso</div>
          </div>
        </div>

        <div class="section-body">
          <form method="POST" action="/impostazioni/password">
            <div class="field">
              <label class="field-label" for="pwd-attuale">Password attuale</label>
              <input
                class="field-input"
                type="password"
                id="pwd-attuale"
                name="password_attuale"
                placeholder="••••••••"
                required
                autocomplete="current-password"
              >
            </div>

            <div class="form-divider"></div>

            <div class="field-row">
              <div class="field">
                <label class="field-label" for="pwd-nuova">Nuova password</label>
                <input
                  class="field-input"
                  type="password"
                  id="pwd-nuova"
                  name="password_nuova"
                  placeholder="••••••••"
                  required
                  minlength="8"
                  autocomplete="new-password"
                >
                <span class="field-hint">Min. 8 caratteri</span>
              </div>
              <div class="field">
                <label class="field-label" for="pwd-conferma">Conferma password</label>
                <input
                  class="field-input"
                  type="password"
                  id="pwd-conferma"
                  name="password_conferma"
                  placeholder="••••••••"
                  required
                  minlength="8"
                  autocomplete="new-password"
                >
              </div>
            </div>
        </div>

        <div class="section-footer">
          <button type="reset" class="btn btn-ghost">Annulla</button>
          <button type="submit" class="btn btn-primary">Aggiorna password →</button>
        </div>
          </form>
      </section>

      <!-- ── ELIMINA ACCOUNT ── -->
      <section class="settings-section section-danger" id="elimina">
        <div class="section-head">
          <div class="section-icon">⚠</div>
          <div class="section-head-text">
            <div class="section-title">Zona pericolosa</div>
            <div class="section-desc">// azioni irreversibili sull'account</div>
          </div>
        </div>

        <div class="section-body">
          <div class="danger-box">
            <div class="danger-box-text">
              <div class="danger-box-title">Elimina account</div>
              <div class="danger-box-desc">
                Tutti i tuoi dati, articoli e commenti verranno eliminati<br>
                permanentemente. Questa azione non è reversibile.
              </div>
            </div>
            <a href="#confirm-delete" class="btn btn-danger">Elimina account</a>
          </div>
        </div>
      </section>

    </div>
  </div>
</div>

<!-- ── MODALE CONFERMA ELIMINAZIONE (CSS :target) ── -->
<div class="confirm-overlay" id="confirm-delete">
  <div class="confirm-box">
    <span class="confirm-icon">⚠</span>
    <div class="confirm-title">Sei sicuro?</div>
    <p class="confirm-desc">
      Stai per eliminare l'account <strong>@{{username}}</strong>.<br>
      Tutti i tuoi dati verranno rimossi <strong>definitivamente</strong> e non potranno essere recuperati.
    </p>
    <div class="confirm-actions">
      <a href="#" class="btn btn-ghost">Annulla</a>
      <form method="POST" action="/impostazioni/elimina" style="flex:1;">
        <button type="submit" class="btn btn-danger" style="width:100%; justify-content:center;">
          Sì, elimina
        </button>
      </form>
    </div>
  </div>
</div>

</body>
</html>