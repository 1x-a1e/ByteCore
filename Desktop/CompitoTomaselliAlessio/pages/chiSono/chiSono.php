<?php
    session_start();

    include __DIR__ . '/../../assets/navbar/nav.php';
?>
<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ByteCore — Chi sono</title>
<link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/pages/chiSono/style/chiSono.css">
</head>
<body>
<?php echo nav() ?>
<div class="page">
  <div class="hero-card">
    <div class="avatar-wrap">
      <div class="avatar">AL</div>
      <span class="avatar-badge">Dev</span>
    </div>
    <div class="hero-info">
      <div class="hero-eyebrow">// about me</div>
      <div class="hero-name">Alessio Tomaselli</div>
      <div class="hero-role">Studente ITIS · Backend Developer · Arch Linux enjoyer</div>
      <p class="hero-bio">
        Ciao! Sono <strong>Alessio</strong>, uno studente di un ITIS appassionato di informatica a 360°.
        Mi occupo principalmente di <strong>backend</strong> — PHP, MySQL, Python — ma non mi spavento di fronte a reti, sistemi Linux e sicurezza informatica.
        Questo blog è il posto dove condivido quello che imparo ogni giorno.
      </p>
      <div class="social-links">
        <a href="https://github.com/1x-a1e" target="_blank" class="social-btn github">
          <span class="social-icon">🐙</span> Github
        </a>
        <a href="https://instagram.com/__tomaselli.alessio__.cpp" target="_blank" class="social-btn instagram">
          <span class="social-icon">📸</span> Instagram
        </a>
        <a href="https://discord.com/users/474908643427614730" class="social-btn discord">
          <span class="social-icon">💬</span> Discord
        </a>
      </div>
    </div>
  </div>

  <div class="section">
    <div class="section-header">
      <span class="section-icon">⚡</span>
      <span class="section-title">Skill tecniche</span>
    </div>
    <div class="skills-grid">
      <div class="skill-item">
        <div class="skill-left">
          <span class="skill-emoji">🐘</span>
          <span class="skill-name">PHP</span>
        </div>
        <div class="skill-level">
          <div class="skill-dot on"></div>
          <div class="skill-dot on"></div>
          <div class="skill-dot on"></div>
          <div class="skill-dot on"></div>
          <div class="skill-dot"></div>
        </div>
      </div>
      <div class="skill-item">
        <div class="skill-left">
          <span class="skill-emoji">🐬</span>
          <span class="skill-name">MySQL / PDO</span>
        </div>
        <div class="skill-level">
          <div class="skill-dot on"></div>
          <div class="skill-dot on"></div>
          <div class="skill-dot on"></div>
          <div class="skill-dot on"></div>
          <div class="skill-dot"></div>
        </div>
      </div>
      <div class="skill-item">
        <div class="skill-left">
          <span class="skill-emoji">🐧</span>
          <span class="skill-name">Linux / Arch</span>
        </div>
        <div class="skill-level">
          <div class="skill-dot on"></div>
          <div class="skill-dot on"></div>
          <div class="skill-dot on"></div>
          <div class="skill-dot on"></div>
          <div class="skill-dot on"></div>
        </div>
      </div>
      <div class="skill-item">
        <div class="skill-left">
          <span class="skill-emoji">🐍</span>
          <span class="skill-name">Python</span>
        </div>
        <div class="skill-level">
          <div class="skill-dot on"></div>
          <div class="skill-dot on"></div>
          <div class="skill-dot on"></div>
          <div class="skill-dot on"></div>
          <div class="skill-dot on"></div>
        </div>
      </div>
      <div class="skill-item">
        <div class="skill-left">
          <span class="skill-emoji">🔐</span>
          <span class="skill-name">Cybersecurity</span>
        </div>
        <div class="skill-level">
          <div class="skill-dot on"></div>
          <div class="skill-dot on"></div>
          <div class="skill-dot on"></div>
          <div class="skill-dot on"></div>
          <div class="skill-dot"></div>
        </div>
      </div>
      <div class="skill-item">
        <div class="skill-left">
          <span class="skill-emoji">🌐</span>
          <span class="skill-name">Networking</span>
        </div>
        <div class="skill-level">
          <div class="skill-dot on"></div>
          <div class="skill-dot on"></div>
          <div class="skill-dot on"></div>
          <div class="skill-dot on"></div>
          <div class="skill-dot"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="section">
    <div class="section-header">
      <span class="section-icon">🎯</span>
      <span class="section-title">Interessi & Hobby</span>
    </div>
    <div class="hobbies">
      <div class="hobby-chip">🐧 Linux</div>
      <div class="hobby-chip">🔐 CTF & Security</div>
      <div class="hobby-chip">💾 Self-hosting</div>
      <div class="hobby-chip">📡 Networking</div>
      <div class="hobby-chip">🖥 Open Source</div>
      <div class="hobby-chip">📚 Studio continuo</div>
      <div class="hobby-chip">🎮 Gaming</div>
    </div>
  </div>

  <div class="section">
    <div class="section-header">
      <span class="section-icon">✉</span>
      <span class="section-title">Contattami</span>
    </div>
    <div class="contact-box">
      <p class="contact-intro">
        Hai una domanda, vuoi collaborare su un progetto o semplicemente vuoi parlare di tech?
        Scrivimi su uno di questi canali — rispondo sempre.
      </p>
      <div class="contact-methods">
        <a href="https://github.com/1x-a1e" target="_blank" class="contact-method">
          <span class="contact-method-icon">🐙</span>
          <span class="contact-method-label">GitHub</span>
          <span class="contact-method-value">1x-a1e</span>
        </a>
        <a href="https://instagram.com/__tomaselli.alessio__.cpp" target="_blank" class="contact-method">
          <span class="contact-method-icon">📸</span>
          <span class="contact-method-label">Instagram</span>
          <span class="contact-method-value">__tomaselli.alessio__.cpp</span>
        </a>
        <a href="#" class="contact-method">
          <span class="contact-method-icon">💬</span>
          <span class="contact-method-label">Discord</span>
          <span class="contact-method-value">nonsochenomemettere._.</span>
        </a>
      </div>
    </div>
  </div>

</div>

</body>
</html>