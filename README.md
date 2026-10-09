# ByteCore — Documentazione Tecnica

**Autore:** Alessio Tomaselli  
**Versione:** 1.0  
**Data:** Giugno 2026

Progetto usato per l'esame finale di stato 2025/2026

---

## Indice

1. [Panoramica del progetto](#1-panoramica-del-progetto)
2. [Stack tecnologico](#2-stack-tecnologico)
3. [Struttura delle directory](#3-struttura-delle-directory)
4. [Database](#4-database)
5. [Routing](#5-routing)
6. [Sistema di autenticazione](#6-sistema-di-autenticazione)
7. [Layer dati — dbConnect](#7-layer-dati--dbconnect)
8. [API interne (funzioni wrapper)](#8-api-interne-funzioni-wrapper)
9. [Pagine pubbliche](#9-pagine-pubbliche)
10. [Area amministrativa](#10-area-amministrativa)
11. [Componenti condivisi](#11-componenti-condivisi)
12. [Design system e stili](#12-design-system-e-stili)
13. [Sicurezza](#13-sicurezza)
14. [Funzionalità mancanti o parziali](#14-funzionalità-mancanti-o-parziali)
15. [Guida all'avvio](#15-guida-allavvio)

---

## 1. Panoramica del progetto

**ByteCore** è un blog tecnico personale costruito in PHP puro (senza framework), con database MySQL e rendering Markdown tramite la libreria Parsedown. Il sito si rivolge ad appassionati di informatica e sviluppatori, ed è gestito da Alessio Tomaselli, studente ITIS con interessi in backend, Linux, cybersecurity e networking.

Le funzionalità principali sono:

- Pubblicazione e consultazione di **articoli** tecnici scritti in Markdown
- Showcase di **progetti** personali con stato, tecnologie e link GitHub
- Sistema di **autenticazione** con ruoli (Admin / Author / User)
- **Dashboard amministrativa** per la gestione completa di post, categorie, progetti e utenti
- Pagina **Chi sono** con profilo, skill e contatti

---

## 2. Stack tecnologico

| Componente | Tecnologia |
|---|---|
| Linguaggio backend | PHP 8.x |
| Database | MySQL / MariaDB (via PDO) |
| Rendering Markdown | `erusev/parsedown ^1.8` |
| Frontend | HTML5 + CSS3 puro (nessun framework) |
| Font | Google Fonts — *Share Tech Mono*, *Syne* |
| Server di sviluppo | PHP built-in server (`php -S`) con `router.php` |
| Server di produzione | XAMPP (Apache + MySQL/MariaDB) |

---

## 3. Struttura delle directory

```
CompitoTomaselliAlessio/
│
├── router.php                        ← Entry point: routing URL → file PHP
├── setup.sh                          ← Script di installazione automatica
├── start.sh                          ← Avvio del server PHP built-in
│
├── databaseApi/
│   ├── dbConnect.php                 ← Classe PDO con tutti i metodi DB
│   └── database.sql                  ← Schema SQL del database
│
├── api/                              ← Funzioni wrapper per le query (incluse nelle pagine)
│   ├── auth/
│   │   ├── login/loginApi.php        ← Gestione POST login
│   │   └── register/registerApi.php  ← Gestione POST registrazione
│   ├── logout/logout.php             ← Distruzione sessione
│   ├── posts/apiPosts.php            ← Funzioni sui post e categorie
│   ├── progetti/apiProgetti.php      ← Funzioni sui progetti
│   ├── settingsApi/updateUser.php    ← Endpoint impostazioni profilo (parziale)
│   └── users/apiUser.php             ← Funzioni sugli utenti
│
├── assets/
│   └── navbar/nav.php                ← Componente navbar (funzione PHP)
│
├── pages/                            ← Pagine pubbliche del sito
│   ├── index/index.php               ← Home page
│   ├── auth/auth.php                 ← Login / Registrazione
│   ├── chiSono/chiSono.php           ← Pagina "Chi sono"
│   ├── articoli/articoli.php         ← Lista articoli + ricerca
│   ├── page/page.php                 ← Visualizzazione singolo articolo
│   ├── progetti/progetti.php         ← Lista progetti
│   ├── settings/settings.php         ← Impostazioni account
│   └── 404/index.html                ← Pagina 404 con animazione typed.js
│
├── admin/                            ← Area riservata agli amministratori
│   ├── dashboard.php                 ← Dashboard SPA (Single Page App via JS)
│   ├── assets/checkUser.php          ← Guard: verifica ruolo Admin
│   ├── style/dashboard.css           ← Stile della dashboard
│   ├── page/modifyPost/edit-post.php ← Pagina modifica post
│   └── api/                          ← Endpoint admin (POST/GET)
│       ├── createPost/createPost.php
│       ├── createCategoria/createCategoria.php
│       ├── delete/deleteCat.php
│       ├── delete/deletePost.php
│       ├── delete/deleteUser.php
│       ├── delete/deleteProject.php
│       ├── progetti/createProgetti.php
│       └── update/
│           ├── updatePost.php
│           └── updateToAdmin.php
│
└── vendor/                           ← Dipendenze Composer (Parsedown)
```

---

## 4. Database

Il database si chiama `DBPortfolio` e contiene quattro tabelle.

### 4.1 Tabella `Users`

```sql
CREATE TABLE Users (
    id           INT PRIMARY KEY AUTO_INCREMENT,
    Nome         VARCHAR(255) NOT NULL,
    Username     VARCHAR(255) NOT NULL,
    Email        VARCHAR(255) NOT NULL UNIQUE,
    Passwd       VARCHAR(255) NOT NULL,              -- hash bcrypt
    Role_user    VARCHAR(255) DEFAULT 'User'
                 CHECK (Role_user IN ('Admin','Author','User'))
);
```

| Campo | Descrizione |
|---|---|
| `id` | Identificativo univoco |
| `Nome` | Nome reale dell'utente |
| `Username` | Nome utente pubblico |
| `Email` | Email univoca (usata per il login) |
| `Passwd` | Password in hash bcrypt (`password_hash`) |
| `Role_user` | Ruolo: `Admin`, `Author` o `User` (default: `User`) |

### 4.2 Tabella `Categoria`

```sql
CREATE TABLE Categoria (
    idCat INT AUTO_INCREMENT PRIMARY KEY,
    Nome  VARCHAR(255) NOT NULL UNIQUE
);
```

Categorie degli articoli e dei progetti (es. "Networking", "Cybersecurity").

### 4.3 Tabella `Posts`

```sql
CREATE TABLE Posts (
    id                 INT PRIMARY KEY AUTO_INCREMENT,
    Titolo             VARCHAR(255) NOT NULL,
    dataPublicazione   DATETIME NOT NULL,
    Contenuto          TEXT NOT NULL,                -- scritto in Markdown
    ContenutoEstratto  VARCHAR(24) NOT NULL,          -- anteprima breve
    idUser             INT NOT NULL,
    idCat              INT NOT NULL,
    FOREIGN KEY (idUser) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (idCat)  REFERENCES Categoria(idCat) ON DELETE CASCADE
);
```

| Campo | Descrizione |
|---|---|
| `Contenuto` | Testo completo in formato Markdown |
| `ContenutoEstratto` | Estratto max 24 caratteri, mostrato nelle anteprime |
| `idUser` | FK → autore del post |
| `idCat` | FK → categoria del post |

### 4.4 Tabella `Progetti`

```sql
CREATE TABLE Progetti (
    id             INT PRIMARY KEY AUTO_INCREMENT,
    Nome           VARCHAR(255) NOT NULL,
    Descrizione    TEXT NOT NULL,
    DataCreazione  DATETIME NOT NULL,
    link           VARCHAR(255) NOT NULL,            -- URL GitHub
    stato          VARCHAR(255) NOT NULL
                   CHECK (stato IN ('In corso','Completato')),
    tecnologie     TEXT,                             -- lista separata da virgole
    idUser         INT NOT NULL,
    idCat          INT NOT NULL,
    FOREIGN KEY (idUser) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (idCat)  REFERENCES Categoria(idCat) ON DELETE CASCADE
);
```

| Campo | Descrizione |
|---|---|
| `link` | URL del repository GitHub |
| `stato` | `In corso` oppure `Completato` |
| `tecnologie` | Stringa con tecnologie separate da virgola (es. `PHP, MySQL, CSS`) |

---

## 5. Routing

Il file `router.php` è l'entry point dell'applicazione. Viene utilizzato dal **server built-in di PHP** (`php -S 127.0.0.1:8080 router.php`) e mappa ogni URL al file PHP corrispondente tramite uno `switch`.

Se il percorso corrisponde a un file statico esistente (CSS, immagini ecc.), il server lo serve direttamente (`return false`).

### Mappa completa delle route

| URL | File | Metodo | Descrizione |
|---|---|---|---|
| `/` | `pages/index/index.php` | GET | Home page |
| `/auth` | `pages/auth/auth.php` | GET | Login / Registrazione |
| `/about` | `pages/chiSono/chiSono.php` | GET | Chi sono |
| `/posts` | `pages/page/page.php` | GET (`?id=`) | Singolo articolo |
| `/articoli` | `pages/articoli/articoli.php` | GET (`?q=`, `?cat=`) | Lista articoli |
| `/progetti` | `pages/progetti/progetti.php` | GET | Lista progetti |
| `/settings` | `pages/settings/settings.php` | GET | Impostazioni account |
| `/api/auth/login` | `api/auth/login/loginApi.php` | POST | Login |
| `/api/auth/register` | `api/auth/register/registerApi.php` | POST | Registrazione |
| `/logout` | `api/logout/logout.php` | GET | Logout |
| `/admin` | `admin/dashboard.php` | GET | Dashboard admin |
| `/admin/create-post` | `admin/api/createPost/createPost.php` | POST | Crea post |
| `/admin/create-categoria` | `admin/api/createCategoria/createCategoria.php` | POST | Crea categoria |
| `/admin/delete-cat` | `admin/api/delete/deleteCat.php` | GET (`?id=`) | Elimina categoria |
| `/admin/delete-post` | `admin/api/delete/deletePost.php` | GET (`?id=`) | Elimina post |
| `/admin/delete-user` | `admin/api/delete/deleteUser.php` | GET (`?id=`) | Elimina utente |
| `/admin/delete-progetto` | `admin/api/delete/deleteProject.php` | GET (`?id=`) | Elimina progetto |
| `/admin/create-progetto` | `admin/api/progetti/createProgetti.php` | POST | Crea progetto |
| `/admin/modify-post` | `admin/page/modifyPost/edit-post.php` | GET (`?id=`) | Pagina modifica post |
| `/admin/update-post` | `admin/api/update/updatePost.php` | POST | Salva modifiche post |
| `/admin/promote` | `admin/api/update/updateToAdmin.php` | POST | Promuovi utente ad Admin |
| `/impostazioni/profilo` | `api/settingsApi/updateUser.php` | POST | Aggiorna profilo (parziale) |
| *(qualsiasi altro)* | `pages/404/index.html` | — | Pagina 404 |

---

## 6. Sistema di autenticazione

L'autenticazione è basata sulle **sessioni PHP** (`$_SESSION`).

### 6.1 Login (`/api/auth/login`)

**File:** `api/auth/login/loginApi.php`

1. Accetta una richiesta `POST` con i campi `email` e `password`.
2. Istanzia `dbConnect` e chiama `loginUserByEmail($email, $password)`.
3. Il metodo cerca l'utente per email e verifica la password con `password_verify()`.
4. Se il login ha successo, avvia la sessione e salva:

```php
$_SESSION['Nome']     = $login['Nome'];
$_SESSION['Username'] = $login['Username'];
$_SESSION['Email']    = $login['Email'];
$_SESSION['Role']     = $login['Role'];   // 'Admin', 'Author' o 'User'
$_SESSION['id']       = $login['id'];
```

5. Redireziona a `/` in caso di successo, o a `/auth?error=...` in caso di errore.

### 6.2 Registrazione (`/api/auth/register`)

**File:** `api/auth/register/registerApi.php`

1. Accetta `POST` con i campi `name`, `username`, `email`, `password`.
2. La password viene hashata immediatamente con `password_hash($_POST['password'], PASSWORD_DEFAULT)`.
3. Chiama `registerUser()` → `INSERT INTO Users`.
4. Redireziona a `/auth?success=...` o `/auth?error=...`.

### 6.3 Logout (`/logout`)

**File:** `api/logout/logout.php`

Svuota `$_SESSION`, elimina il cookie di sessione se configurato, chiama `session_destroy()` e redireziona a `/`.

### 6.4 Guard Admin

**File:** `admin/assets/checkUser.php`

```php
function checkUserAdmin() {
    session_start();
    if (!isset($_SESSION['Nome']) || !isset($_SESSION['Username'])) {
        header("Location: /auth?error=...");
        die();
    }
    if ($_SESSION['Role'] !== 'Admin') {
        header("Location: /");
        die();
    }
}
```

Ogni file dell'area admin chiama `checkUserAdmin()` all'inizio. Se l'utente non è loggato viene mandato alla pagina di login; se è loggato ma non Admin viene mandato alla home.

---

## 7. Layer dati — dbConnect

**File:** `databaseApi/dbConnect.php`

La classe `dbConnect` centralizza **tutta** la comunicazione con il database. Usa PDO con:

- `ATTR_EMULATE_PREPARES = false` → prepared statement nativo (protezione SQL injection)
- `ATTR_ERRMODE = ERRMODE_EXCEPTION` → gli errori lanciano eccezioni
- `SET NAMES utf8mb4` → supporto completo Unicode

Connessione default: `host=127.0.0.1`, `porta=3306`, `user=root`, `password=` (vuota), `db=DBPortfolio`.

### Metodi disponibili

#### Autenticazione

| Metodo | Parametri | Ritorna | Descrizione |
|---|---|---|---|
| `loginUserByEmail` | `$email, $passwd` | `array\|false` | Login con verifica bcrypt |
| `registerUser` | `$nome, $username, $email, $passwd` | `bool` | Inserisce nuovo utente |

#### Post

| Metodo | Parametri | Ritorna | Descrizione |
|---|---|---|---|
| `getAllPosts` | — | `array\|false` | Tutti i post con dati autore |
| `getAllPostsDESC` | — | `array\|false` | Ultimi 5 post ordinati per data |
| `getPostFromId` | `$id` | `array\|false` | Singolo post con dati autore |
| `getCountPosts` | — | `array\|false` | Conteggio totale post |
| `searchPosts` | `$title` | `array\|false` | Ricerca per titolo (`LIKE`) |
| `createPosts` | `$titolo, $data, $contenuto, $estratto, $idUser, $idCat` | `bool` | Crea nuovo post |
| `deletePost` | `$id` | `bool` | Elimina post per ID |
| `updatePost` | `$id, $titolo, $contenuto, $estratto, $idCat` | `bool` | Aggiorna post |

#### Categorie

| Metodo | Parametri | Ritorna | Descrizione |
|---|---|---|---|
| `getAllCategoria` | — | `array\|false` | Tutte le categorie |
| `getCountCategoria` | — | `array\|false` | Conteggio categorie |
| `getCatIdByName` | `$nome` | `array\|false` | ID categoria dal nome |
| `getNameCatById` | `$id` | `array\|false` | Nome categoria dall'ID |
| `createCat` | `$nome` | `bool` | Crea nuova categoria |
| `deleteCat` | `$id` | `bool` | Elimina categoria |

#### Utenti

| Metodo | Parametri | Ritorna | Descrizione |
|---|---|---|---|
| `getAllUser` | — | `array\|false` | Tutti gli utenti |
| `getAdminUsers` | — | `array\|false` | Solo gli Admin |
| `getCountUsers` | — | `array\|false` | Conteggio utenti totali |
| `getCountUsersAdmin` | — | `array\|false` | Conteggio Admin |
| `deleteUserById` | `$id` | `bool` | Elimina utente |
| `addAdminUserByEmail` | `$email` | `bool` | Promuove utente ad Admin |

#### Progetti

| Metodo | Parametri | Ritorna | Descrizione |
|---|---|---|---|
| `getAllProgetti` | — | `array\|false` | Tutti i progetti con categoria e autore |
| `getAllProject` | — | `array\|false` | Alias di `getAllProgetti` |
| `countProgetti` | — | `array\|false` | Conteggio progetti |
| `getProjectFromId` | `$id` | `array\|false` | Singolo progetto |
| `createProject` | `$nome, $stato, $idCat, $link, $tecnologie, $descrizione, $idUser, $data` | `bool` | Crea progetto |
| `deleteProjectById` | `$id` | `bool` | Elimina progetto |

---

## 8. API interne (funzioni wrapper)

Le pagine PHP non istanziano mai `dbConnect` direttamente. Usano funzioni wrapper definite in tre file inclusi via `require`/`include`.

### `api/posts/apiPosts.php`

| Funzione | Descrizione |
|---|---|
| `getAllPosts()` | Tutti i post |
| `getAllPostsDESC()` | Ultimi 5 post |
| `getCountPosts()` | Totale post |
| `searchPosts($title)` | Ricerca per titolo |
| `getCategoriaFromId($id)` | Nome categoria da ID |
| `getPostFromId($id)` | Post singolo per ID |
| `getAllCategoria()` | Tutte le categorie |
| `getCountCategoria()` | Totale categorie |

### `api/progetti/apiProgetti.php`

| Funzione | Descrizione |
|---|---|
| `getAllProgetti()` | Tutti i progetti |
| `getAllProject()` | Alias di `getAllProgetti` |
| `countProgetti()` | Totale progetti |
| `getProgettoById($id)` | Progetto singolo |

### `api/users/apiUser.php`

| Funzione | Descrizione |
|---|---|
| `getCountUsers()` | Totale utenti |
| `getCountUsersAdmin()` | Totale Admin |
| `getAllUsers()` | Tutti gli utenti |
| `getAllUsersAdmin()` | Solo gli Admin |

---

## 9. Pagine pubbliche

### 9.1 Home page — `/`

**File:** `pages/index/index.php`  
**Include:** `nav.php`, `apiPosts.php`, `apiProgetti.php`

Sezioni della pagina:

| Sezione | Contenuto |
|---|---|
| **Hero** | Titolo, sottotitolo, CTA "Leggi gli articoli" e "Scopri i miei progetti" |
| **Stat bar** | Tre contatori dinamici: articoli pubblicati, progetti, categorie |
| **Chi sono** | Box con avatar, bio e skill tag |
| **Categorie** | Chip cliccabili → `/articoli?cat=<id>` |
| **Ricerca** | Form GET → `/articoli?q=<query>` |
| **Ultimi articoli** | Griglia con gli ultimi 5 post (data DESC), card con categoria, data, titolo, estratto, autore |
| **Footer** | Link navigazione, copyright |

### 9.2 Autenticazione — `/auth`

**File:** `pages/auth/auth.php`

Pagina a due pannelli affiancati:

- **Pannello sinistro:** branding ByteCore con statistiche statiche (1.2k articoli, 48k lettori, 312 autori)
- **Pannello destro:** sistema a tab Login / Registrati implementato con il **CSS `:checked` trick** (due radio button nascosti controllano la visibilità dei form)

**Form Login:** campi `email` + `password`, checkbox "Ricordami" (solo UI), invio a `POST /api/auth/login`.

**Form Registrazione:** campi `name`, `username`, `email`, `password`, `password_confirmation`, checkbox termini, invio a `POST /api/auth/register`.

Gli errori vengono mostrati tramite un **toast** in basso, popolato via JavaScript dal parametro GET `?error=`.

### 9.3 Chi sono — `/about`

**File:** `pages/chiSono/chiSono.php`

Profilo completo di Alessio Tomaselli con:

- **Hero card:** avatar testuale "AL", nome, ruolo, bio
- **Social:** link a GitHub (`1x-a1e`), Instagram, Discord
- **Skill tecniche:** griglia con indicatore a punti (5 dot) per PHP, MySQL/PDO, Linux/Arch, Python, Cybersecurity, Networking
- **Interessi & Hobby:** chip decorativi (Linux, CTF, Self-hosting, Networking, Open Source, Studio, Gaming)
- **Contattami:** box con metodi di contatto (GitHub, Instagram, Discord)

### 9.4 Lista articoli — `/articoli`

**File:** `pages/articoli/articoli.php`  
**Include:** `nav.php`, `apiUser.php`, `apiPosts.php`

Funzionamento:

- Se è presente il parametro GET `?q=`, chiama `searchPosts($q)` per la ricerca per titolo
- Altrimenti chiama `getAllPosts()` per mostrare tutti gli articoli
- Se la ricerca non produce risultati, mostra un messaggio "Nessun articolo trovato"

Ogni card mostra: categoria (link filtro), data, titolo (link al post), estratto, autore.

> **Nota:** la paginazione è presente nell'HTML con placeholder `{{page_prev}}` e `{{page_next}}` ma non è implementata funzionalmente.

### 9.5 Singolo articolo — `/posts?id=<n>`

**File:** `pages/page/page.php`  
**Include:** `nav.php`, `apiPosts.php`, `vendor/autoload.php` (Parsedown)

Funzionamento:

1. Legge `$_GET['id']` (intero); se assente redireziona a `/`
2. Recupera il post via `getPostFromId($id)`
3. Istanzia `Parsedown` con `setSafeMode(true)` e converte il Markdown in HTML
4. Mostra titolo, data, autore (nome + @username) e contenuto renderizzato

Il **safe mode** di Parsedown sanitizza l'HTML inline nel Markdown, prevenendo XSS.

### 9.6 Progetti — `/progetti`

**File:** `pages/progetti/progetti.php`  
**Include:** `nav.php`, `apiProgetti.php`

Mostra la lista di tutti i progetti con:

- Nome, badge categoria, badge stato (`In corso` / `Completato`)
- Descrizione testuale
- Tag delle tecnologie (generate da `explode(',', $tecnologie)`)
- Link GitHub

### 9.7 Impostazioni — `/settings`

**File:** `pages/settings/settings.php`

**Guard:** richiede sessione attiva (`Nome` + `Email`); se non loggato redireziona a `/auth?error=...`.

La pagina ha un layout a due colonne (sidebar fissa + sezioni):

| Sezione | ID | Descrizione |
|---|---|---|
| Modifica profilo | `#profilo` | Campi nome, username, email pre-compilati dalla sessione |
| Cambio password | `#password` | Password attuale + nuova password + conferma |
| Zona pericolosa | `#elimina` | Pulsante "Elimina account" con modale di conferma (CSS `:target`) |

> **Attenzione:** solo il form "Modifica profilo" ha una route associata (`/impostazioni/profilo`) ma il backend è incompleto (stampa i campi e termina). I form per cambio password e eliminazione account puntano a route inesistenti nel router.

### 9.8 Pagina 404

**File:** `pages/404/index.html`

Pagina statica con animazione testo tramite `typed.js` (incluso localmente in `pages/404/assets/typed.js`).

---

## 10. Area amministrativa

L'accesso all'area admin richiede:

1. Sessione PHP attiva
2. `$_SESSION['Role'] === 'Admin'`

La verifica è delegata alla funzione `checkUserAdmin()` chiamata in ogni file admin.

### 10.1 Dashboard — `/admin`

**File:** `admin/dashboard.php`

La dashboard è una **Single Page Application** client-side: il contenuto è diviso in **pannelli** HTML e la funzione JavaScript `showPanel(id, linkEl)` attiva quello selezionato nascondendo gli altri, senza ricaricare la pagina.

**Struttura:**

```
┌──────────────────┬──────────────────────────────────────┐
│   SIDEBAR        │   TOPBAR                             │
│                  │──────────────────────────────────────│
│  Generale        │   CONTENUTO (panel attivo)           │
│    Overview      │                                      │
│                  │                                      │
│  Contenuti       │                                      │
│    Post          │                                      │
│    Nuovo post    │                                      │
│    Categorie     │                                      │
│    Progetti      │                                      │
│    Nuovo proj    │                                      │
│                  │                                      │
│  Utenti          │                                      │
│    Utenti        │                                      │
│    Admin         │                                      │
│                  │                                      │
│  Sistema         │                                      │
│    Impostazioni  │                                      │
│    Logout        │                                      │
└──────────────────┴──────────────────────────────────────┘
```

**Pannelli disponibili:**

| ID pannello | Titolo | Contenuto |
|---|---|---|
| `overview` | Overview | 4 stat card + tabella ultimi post + tabella utenti |
| `posts` | Gestione post | Tabella tutti i post con pulsanti Modifica / Elimina |
| `new-post` | Nuovo post | Form: titolo, categoria, estratto, contenuto |
| `new-categoria` | Categorie | Tabella categorie con elimina + form creazione |
| `progetti` | Gestione progetti | Tabella progetti con stato, tech, link, elimina |
| `new-progetto` | Nuovo progetto | Form: nome, stato, categoria, GitHub, tech, descrizione |
| `users` | Gestione utenti | Tabella tutti gli utenti con elimina |
| `admins` | Gestione admin | Tabella admin con cambio ruolo + form promozione |

**Notifiche:** la dashboard legge i parametri GET `?S=` (successo) e `?E=` (errore) e mostra un popout colorato che può essere chiuso dall'utente.

### 10.2 Creare un post — `POST /admin/create-post`

**File:** `admin/api/createPost/createPost.php`

1. Verifica admin (`checkUserAdmin`)
2. Risolve l'ID categoria dal nome selezionato nel form
3. Recupera titolo, estratto, contenuto, ID utente dalla sessione
4. Imposta `dataPublicazione = now()`
5. Chiama `$db->createPosts(...)` e redireziona a `/admin`

### 10.3 Creare una categoria — `POST /admin/create-categoria`

**File:** `admin/api/createCategoria/createCategoria.php`

Legge il campo `nome` dal POST e chiama `$db->createCat($nome)`.

### 10.4 Eliminare risorse — `GET /admin/delete-*`

Tutti i file di eliminazione seguono lo stesso pattern:

1. `checkUserAdmin()`
2. Leggono `$_GET['id']`
3. Chiamano il metodo DB appropriato
4. Redirezionano a `/admin`

| Route | Metodo DB |
|---|---|
| `/admin/delete-post` | `deletePost($id)` |
| `/admin/delete-cat` | `deleteCat($id)` |
| `/admin/delete-user` | `deleteUserById($id)` |
| `/admin/delete-progetto` | `deleteProjectById($id)` |

### 10.5 Creare un progetto — `POST /admin/create-progetto`

**File:** `admin/api/progetti/createProgetti.php`

Campi richiesti: `nome`, `stato`, `categoria`, `github`, `tech`, `descrizione`. L'ID categoria viene risolto dal nome; `idUser` viene letto dalla sessione; la data viene impostata a `now()`.

### 10.6 Modificare un post

**Pagina di modifica:** `GET /admin/modify-post?id=<n>`  
**File:** `admin/page/modifyPost/edit-post.php`

Mostra un form pre-compilato con i dati del post (titolo, categoria selezionata, estratto, contenuto). Il submit invia a `POST /admin/update-post`.

**Salvataggio:** `POST /admin/update-post`  
**File:** `admin/api/update/updatePost.php`

1. Legge id, titolo, categoria, estratto, contenuto dal POST
2. Applica `htmlspecialchars` ai campi
3. Risolve l'ID categoria dal nome
4. Chiama `$db->updatePost(...)` e redireziona a `/admin?S=Post aggiornato con successo!`

### 10.7 Promuovere un utente ad Admin — `POST /admin/promote`

**File:** `admin/api/update/updateToAdmin.php`

Legge il campo `email` dal POST e chiama `$db->addAdminUserByEmail($email)` che esegue:

```sql
UPDATE Users SET Role_user = "Admin" WHERE Email = :email;
```

> **Nota:** il file contiene `echo 1;` e `echo var_dump($addAdmin)` rimasti dal debug — da rimuovere prima del deploy in produzione.

---

## 11. Componenti condivisi

### 11.1 Navbar — `assets/navbar/nav.php`

La navbar è generata dalla funzione PHP `nav()` che restituisce una stringa HTML. Include stili CSS inline e si comporta in modo diverso a seconda dello stato di sessione:

- **Utente loggato:** mostra avatar con le iniziali del nome, nome utente e un dropdown con "Impostazioni" e "Logout"
- **Utente non loggato:** mostra un'icona hamburger con dropdown che porta a "Login / Register"

Link di navigazione: Home, Articoli, Progetti, About.

La navbar è `position: sticky` con `backdrop-filter: blur(16px)` e si semplifica su mobile (< 768px).

---

## 12. Design system e stili

L'intera applicazione usa un tema scuro coerente definito tramite **CSS custom properties**.

### Palette colori

| Variabile | Valore | Uso |
|---|---|---|
| `--bg` | `#080b10` | Sfondo principale |
| `--surface` | `#0d1117` | Superficie card |
| `--s2` | `#161b22` | Superficie secondaria |
| `--s3` | `#1c2128` | Superficie terziaria |
| `--border` | `#21262d` | Bordi |
| `--accent` | `#00ff88` | Verde primario (CTA, highlights) |
| `--accent2` | `#0066ff` | Blu (link, secondario) |
| `--accent3` | `#ff4d6d` | Rosso (danger, errori) |
| `--text` | `#e6edf3` | Testo principale |
| `--muted` | `#7d8590` | Testo secondario / label |

### Tipografia

| Variabile | Font | Uso |
|---|---|---|
| `--mono` | `Share Tech Mono` | Codice, label, metadata, navbar |
| `--sans` | `Syne` | Titoli, body, pulsanti |

### Breakpoint responsive

| Breakpoint | Comportamento |
|---|---|
| `≤ 768px` | Layout a colonna singola, navbar semplificata |
| `≤ 480px` | Font ridotti, griglie a colonna singola |
| `≤ 360px` | Padding minimo |

### Effetti visivi ricorrenti

- **Griglia di sfondo:** `background-image` con linee sottili in `rgba(0,255,136,0.03)` (effetto "graph paper")
- **Gradiente radiale animato:** su `/auth`, sfondo blu animato con `@keyframes drift`
- **Shimmer sui pulsanti:** effetto luce con `::before` + `left: -100% → 100%` al hover
- **Glow:** `box-shadow` verde su focus/hover dei pulsanti primari

---

## 13. Sicurezza

| Misura | Implementazione |
|---|---|
| **Hashing password** | `password_hash()` con `PASSWORD_DEFAULT` (bcrypt) alla registrazione; `password_verify()` al login |
| **SQL injection** | PDO prepared statements con `ATTR_EMULATE_PREPARES = false` |
| **XSS output** | `htmlspecialchars()` su tutti i dati DB visualizzati nell'HTML |
| **XSS Markdown** | Parsedown in `safeMode(true)` — sanitizza l'HTML inline nei contenuti |
| **Autenticazione admin** | `checkUserAdmin()` a inizio di ogni file admin — redireziona se non loggato o non Admin |
| **Guard pagina settings** | Controllo sessione prima del rendering; redirect a `/auth` se non loggato |
| **Validazione client** | Attributi HTML5 (`required`, `minlength`, `pattern`, `type="email"`) sui form |

---

## 14. Funzionalità mancanti o parziali

Le seguenti funzionalità sono presenti nell'interfaccia grafica ma **non hanno un backend completo**:

| Funzionalità | Stato | Note |
|---|---|---|
| Modifica profilo utente | Route presente, backend incompleto | `/impostazioni/profilo` esiste nel router ma `updateUser.php` si limita a stampare i campi e terminare |
| Cambio password | UI presente, nessun backend | Il form punta a `/impostazioni/password`, route inesistente |
| Eliminazione account | UI con modale CSS, nessun backend | Il form punta a `/impostazioni/elimina`, route inesistente |
| Paginazione articoli | Placeholder `{{page_prev}}` / `{{page_next}}` | Non funzionale |
| Cambio ruolo admin dalla dashboard | Form punta a `/admin/change-role` | Route inesistente nel router |
| "Password dimenticata" | Link presente in `/auth` | Punta a `/password-reset`, route inesistente |
| Ricordami (login) | Checkbox presente | Nessuna logica implementata |

Sono presenti anche **output di debug** in `admin/api/update/updateToAdmin.php` da rimuovere prima del deploy:

```php
echo 1;
echo var_dump($addAdmin);
```

---

## 15. Guida all'avvio

### Prerequisiti

- PHP 8.x con estensione PDO e PDO_MySQL
- MySQL / MariaDB
- Composer (per le dipendenze)
- XAMPP (opzionale, per Apache + MySQL integrati)

### Installazione automatica con setup.sh

Il progetto include uno script `setup.sh` che automatizza l'installazione delle dipendenze di sistema, la creazione del database e la creazione del primo utente Admin.

```bash
chmod +x setup.sh
./setup.sh
```

Lo script:
1. Rileva la distribuzione (Ubuntu o Arch Linux) e installa i pacchetti necessari
2. Avvia Apache e MySQL tramite XAMPP (`/opt/lampp/lampp`)
3. Chiede interattivamente nome, email, username e password dell'Admin
4. Hasha la password con `password_hash` via PHP
5. Importa lo schema SQL (`databaseApi/database.sql`) nel database `DBPortfolio`
6. Crea l'utente Admin direttamente nel database

### Installazione manuale

```bash
# 1. Clonare il repository
git clone <url-repo> ByteCore
cd ByteCore

# 2. Installare le dipendenze PHP
composer install

# 3. Creare il database e lo schema
mysql -u root -h 127.0.0.1 -P 3306 < databaseApi/database.sql

# 4. Verificare le credenziali DB in databaseApi/dbConnect.php
#    (host, port, user, password, dbName)

# 5. Avviare il server PHP built-in
php -S 127.0.0.1:8080 router.php
```

Oppure usare direttamente lo script:

```bash
chmod +x start.sh
./start.sh
```

L'applicazione sarà disponibile su `http://127.0.0.1:8080`.

### Primo utente Admin (installazione manuale)

Dopo la registrazione tramite `/auth`, promuovere l'utente ad Admin direttamente sul database:

```sql
USE DBPortfolio;
UPDATE Users SET Role_user = 'Admin' WHERE Email = 'tua@email.com';
```

Successivamente è possibile usare il pannello "Promuovi utente" nella dashboard admin per gestire i ruoli senza accedere direttamente al DB.

---

*Documentazione aggiornata il 15 giugno 2026 — Versione 1.0*
