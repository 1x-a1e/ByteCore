<?php

  include __DIR__ . '/../../api/posts/apiPosts.php';
  include __DIR__ . '/../../api/progetti/apiProgetti.php';

  $totPosts = getCountPosts()[0]["tot"];
  $totCat = getCountCategoria()[0]["tot"];
  $totProgetti = countProgetti()[0]["tot"];

?>
<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ByteCore — Auth</title>
<link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Syne:wght@400;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="./pages/auth/style/auth.css">
</head>
<body>

<!-- ═══ LEFT PANEL ═══════════════════════════════ -->
<div class="left-panel">
  <div class="logo">
    <div class="logo-icon">▸</div>
    BYTECORE
  </div>

  <div class="hero-tag">// il blog dell'informatica</div>
  <h1 class="hero-title">
    Codice.<br>
    <span>Conoscenza.</span><br>
    Comunità.
  </h1>
  <p class="hero-desc">
    Articoli tecnici, guide pratiche e deep-dive su sistemi, linguaggi, architetture e molto altro. Scritto da dev, per dev.
  </p>

  <div class="stats">
    <div class="stat-item">
      <span class="stat-num"><?= htmlspecialchars($totPosts) ?></span>
      <span class="stat-label">Articoli</span>
    </div>
    <div class="stat-item">
      <span class="stat-num"><?= htmlspecialchars($totProgetti) ?></span>
      <span class="stat-label">Progetti</span>
    </div>
    <div class="stat-item">
      <span class="stat-num"><?= htmlspecialchars($totCat) ?></span>
      <span class="stat-label">Categorie</span>
    </div>
  </div>


</div>

<!-- ═══ RIGHT PANEL ════════════════════════════════ -->
<div class="auth-shell">

  <!-- Radio inputs for tab state (hidden) -->
  <input type="radio" name="auth-tab" id="tab-login" checked>
  <input type="radio" name="auth-tab" id="tab-register">

  <!-- Tabs -->
  <div class="tabs">
    <label class="tab-label" for="tab-login">Login</label>
    <label class="tab-label" for="tab-register">Registrati</label>
  </div>

  <!-- Panels -->
  <div class="panels">

    <!-- ── LOGIN ── -->
    <div class="form-panel" id="panel-login">
      <h2 class="form-heading">Bentornato.</h2>
      <p class="form-sub">// inserisci le tue credenziali</p>

      <form method="POST" action="/api/auth/login" novalidate>

        <div class="field">
          <label class="field-label" for="login-email">Email</label>
          <input
            class="field-input"
            type="email"
            id="login-email"
            name="email"
            placeholder="dev@example.com"
            required
            autocomplete="email"
          >
          <span class="field-error">Inserisci un'email valida</span>
        </div>

        <div class="field">
          <label class="field-label" for="login-pwd">Password</label>
          <input
            class="field-input"
            type="password"
            id="login-pwd"
            name="password"
            placeholder="••••••••"
            required
            minlength="1"
            autocomplete="current-password"
          >
          <span class="field-error">La password è obbligatoria</span>
        </div>

        <div class="extras">
          <label class="check-wrap" style="margin-bottom:0;">
            <input type="checkbox" name="remember">
            Ricordami
          </label>
          <a href="/password-reset" class="forgot-link">Password dimenticata?</a>
        </div>

        <button type="submit" class="submit-btn">Accedi →</button>
      </form>

      <p class="bottom-note">
        Non hai un account?
        <label for="tab-register" style="color:var(--accent2);cursor:pointer;">Registrati gratis</label>
      </p>
    </div>

    <!-- ── REGISTER ── -->
    <div class="form-panel" id="panel-register">
      <h2 class="form-heading">Crea account.</h2>
      <p class="form-sub">// unisciti alla community</p>

      <form method="POST" action="/api/auth/register" novalidate>

        <div class="field-row">
          <div class="field">
            <label class="field-label" for="reg-name">Nome</label>
            <input
              class="field-input"
              type="text"
              id="reg-name"
              name="name"
              placeholder="Mario"
              required
              minlength="2"
              autocomplete="given-name"
            >
            <span class="field-error">Nome obbligatorio</span>
          </div>

          <div class="field">
            <label class="field-label" for="reg-username">Username</label>
            <input
              class="field-input"
              type="text"
              id="reg-username"
              name="username"
              placeholder="m4rio_dev"
              required
              minlength="3"
              pattern="[a-zA-Z0-9_]+"
              autocomplete="username"
            >
            <span class="field-error">Min. 3 caratteri (lettere, numeri, _)</span>
          </div>
        </div>

        <div class="field">
          <label class="field-label" for="reg-email">Email</label>
          <input
            class="field-input"
            type="email"
            id="reg-email"
            name="email"
            placeholder="mario@example.com"
            required
            autocomplete="email"
          >
          <span class="field-error">Inserisci un'email valida</span>
        </div>

        <div class="field">
          <label class="field-label" for="reg-pwd">Password</label>
          <input
            class="field-input"
            type="password"
            id="reg-pwd"
            name="password"
            placeholder="••••••••"
            required
            minlength="8"
            autocomplete="new-password"
          >
          <span class="field-error">Minimo 8 caratteri</span>
          <p class="pwd-hint">Min. 8 caratteri — usa lettere, numeri e simboli per una password forte.</p>
        </div>

        <div class="field">
          <label class="field-label" for="reg-pwd2">Conferma Password</label>
          <input
            class="field-input"
            type="password"
            id="reg-pwd2"
            name="password_confirmation"
            placeholder="••••••••"
            required
            minlength="8"
            autocomplete="new-password"
          >
          <span class="field-error">Ripeti la password</span>
        </div>

        <label class="check-wrap">
          <input type="checkbox" name="terms" required>
          Accetto i <a href="/terms">&nbsp;termini di servizio</a>&nbsp;e la&nbsp;<a href="/privacy">privacy policy</a>
        </label>

        <button type="submit" class="submit-btn">Crea Account →</button>
      </form>

      <p class="bottom-note">
        Hai già un account?
        <label for="tab-login" style="color:var(--accent2);cursor:pointer;">Accedi</label>
      </p>
    </div>

  </div><!-- /panels -->
</div>

<!-- Toast -->
<div class="toast" id="toast" style="display: none"></div>

</body>

<script>
  const toast = document.getElementById('toast');
  toast.onclick = () => toast.style.display = 'none';

  const urlP = new URLSearchParams(window.location.search);

  if (urlP.get('error')) {
    toast.style.display = 'flex';
    toast.textContent = urlP.get('error');
  }
</script>
</html>