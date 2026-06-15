<?php
  function nav() {
    return "
<style>
  @import url('https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Syne:wght@400;600;700;800&display=swap');

  :root {
    --bg:      #080b10;
    --surface: #0d1117;
    --s2:      #161b22;
    --s3:      #1c2128;
    --border:  #21262d;
    --accent:  #00ff88;
    --accent2: #0066ff;
    --accent3: #ff4d6d;
    --text:    #e6edf3;
    --muted:   #7d8590;
    --mono: 'Share Tech Mono', monospace;
    --sans: 'Syne', sans-serif;
  }
  /* ── Navbar ─────────────────────────────── */
  .navbar {
    position: sticky;
    top: 0;
    z-index: 100;
    background: rgba(8,11,16,0.92);
    backdrop-filter: blur(16px);
    border-bottom: 1px solid var(--border);
    padding: 0 40px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 64px;
  }

  .nav-logo {
    font-family: var(--mono);
    font-size: 14px;
    color: var(--accent);
    letter-spacing: 3px;
    text-transform: uppercase;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
  }

  .nav-logo-icon {
    width: 26px; height: 26px;
    border: 1.5px solid var(--accent);
    display: grid;
    place-items: center;
    font-size: 13px;
  }

  .nav-links {
    display: flex;
    align-items: center;
    gap: 6px;
    list-style: none;
  }

  .nav-links a {
    font-family: var(--mono);
    font-size: 12px;
    color: var(--muted);
    text-decoration: none;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    padding: 6px 14px;
    border: 1px solid transparent;
    transition: color 0.2s, border-color 0.2s;
  }

  .nav-links a:hover,
  .nav-links a.active {
    color: var(--accent);
    border-color: rgba(0,255,136,0.25);
  }

  .nav-links a.active {
    background: rgba(0,255,136,0.05);
  }

  .nav-right {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .nav-toggle { display: none; }

  /* ── User menu dropdown ─────────────────── */
  .user-menu { position: relative; }

  .user-trigger {
    display: flex;
    align-items: center;
    gap: 10px;
    background: var(--s2);
    border: 1px solid var(--border);
    color: var(--text);
    padding: 6px 14px 6px 8px;
    cursor: pointer;
    font-family: var(--mono);
    font-size: 12px;
    letter-spacing: 1px;
    transition: border-color 0.2s;
  }

  .user-trigger:hover,
  .user-menu.open .user-trigger { border-color: var(--accent); }

  .user-avatar {
    width: 26px; height: 26px;
    background: rgba(0,255,136,0.12);
    border: 1px solid rgba(0,255,136,0.3);
    color: var(--accent);
    font-family: var(--mono);
    font-size: 11px;
    display: grid;
    place-items: center;
    flex-shrink: 0;
    text-transform: uppercase;
  }

  .user-name {
    color: var(--text);
    max-width: 120px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  .user-chevron {
    color: var(--muted);
    font-size: 10px;
    transition: transform 0.2s;
  }

  .user-menu.open .user-chevron { transform: rotate(180deg); }

  .user-dropdown {
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    min-width: 180px;
    background: var(--s2);
    border: 1px solid var(--border);
    z-index: 200;
    opacity: 0;
    pointer-events: none;
    transform: translateY(-6px);
    transition: opacity 0.18s ease, transform 0.18s ease;
  }

  .user-dropdown::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--accent), var(--accent2));
  }

  .user-menu.open .user-dropdown {
    opacity: 1;
    pointer-events: auto;
    transform: translateY(0);
  }

  .dropdown-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    font-family: var(--mono);
    font-size: 12px;
    letter-spacing: 1px;
    color: var(--muted);
    text-decoration: none;
    transition: background 0.15s, color 0.15s;
  }

  .dropdown-item:hover {
    background: rgba(0,255,136,0.05);
    color: var(--accent);
  }

  .dropdown-icon { font-size: 14px; width: 16px; text-align: center; }

  /* ── Responsive navbar ──────────────────── */
  @media (max-width: 768px) {
    .navbar { padding: 0 20px; }
    .nav-links { display: none; }
    .user-name { display: none; }
  }
</style>
<nav class=\"navbar\">
  <a href=\"/\" class=\"nav-logo\">
    <div class=\"nav-logo-icon\">▸</div>
    BYTECORE
  </a>

  <ul class=\"nav-links\">
    <li><a href=\"/\">Home</a></li>
    <li><a href=\"/articoli\">Articoli</a></li>
    <li><a href=\"/progetti\">Progetti</a></li>
    <li><a href=\"/about\">About</a></li>
  </ul>
  " . 
  (
    
  (isset($_SESSION["Nome"]) && isset($_SESSION["Username"]))
    
  ? "
  <div class=\"nav-right\">
    <div class=\"user-menu\">
      <button class=\"user-trigger\" onclick=\"this.parentElement.classList.toggle('open')\">
        <div class=\"user-avatar\"> " . substr($_SESSION['Nome'], 0, 2) . "</div>
        <span class=\"user-name\">" . $_SESSION['Nome'] . " </span>
        <span class=\"user-chevron\">▾</span>
      </button>
      <div class=\"user-dropdown\">
        <a href=\"/settings\" class=\"dropdown-item\">
          <span class=\"dropdown-icon\">⚙</span> Impostazioni
        </a>
        <a href=\"/logout\" class=\"dropdown-item\">
          <span class=\"dropdown-icon\">➜]</span> Logout
        </a>
      </div>
    </div>
  </div>"

  :

  "
  <div class=\"nav-right\">
    <div class=\"user-menu\">
      <button class=\"user-trigger\" onclick=\"this.parentElement.classList.toggle('open')\">
        <span class=\"user-name\"> 🍔 </span>
        <span class=\"user-chevron\">▾</span>
      </button>
      <div class=\"user-dropdown\">
        <a href=\"/auth\" class=\"dropdown-item\">
          <span class=\"dropdown-icon\">⚙</span> Login / Register
        </a>
      </div>
    </div>
  </div>
  "

  ) . "</nav>";
};
?>