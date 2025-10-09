# 🩺 Medboard — Tableau de bord adaptatif pour le suivi de patients

> **Projet scolaire – IUT Aix-Marseille (S3) – Full PHP (OOP, MVC)**

**Contributeurs** : Vassili Régnier — Jérémy Watripont — Alexis Barberis

---

## 🔗 Liens utiles

- **Démo en ligne** : https://medboard.alwaysdata.net/
- **Dépôt Git** : https://github.com/Vassili-REGNIER/medboard
- **Maquette Figma (design)** : https://www.figma.com/design/DMwtKDaEW6Zgvkj3uixIdW/MedBoard
- **Prototype Figma (desktop/mobile)** : https://www.figma.com/proto/DMwtKDaEW6Zgvkj3uixIdW/MedBoard?page-id=0%3A1&node-id=1-1414

> ⚠️ **Alerte sécurité immédiate**  
> Ne publiez jamais d’identifiants (SMTP, DB, comptes) dans un dépôt public ou un README.  
> **Action** : changez/rotoyez tous les secrets exposés et migrez vers des variables d’environnement (`.env`) et des secrets GitHub.

---

## 🧩 Description

**Medboard** est une application web en **PHP 8.2 orienté objet** suivant le pattern **MVC**, permettant à des professionnels de santé de **gérer et suivre leurs patients** via un tableau de bord **sécurisé** et **responsive**.

**Objectifs pédagogiques :**
- Architecture **MVC** propre, découplage Modèles/Contrôleurs/Vues.
- Respect des bonnes pratiques **OWASP Top 10 (2021)** et **sécurité des données** (hash **Argon2id**, CSRF, validations).
- Déploiement sur **AlwaysData** (PHP + PostgreSQL + SMTP).

---

## 🏗️ Architecture & stack

- **Langage** : PHP 8.2 (OOP)  
- **Pattern** : MVC  
- **BD** : PostgreSQL (PDO + requêtes préparées)  
- **Sécurité** : CSRF, validations serveur, Argon2id, cookies `HttpOnly`/`SameSite`, contrôle d’accès  
- **Hébergement** : AlwaysData (web + PostgreSQL + SMTP)  
- **Outils** : Composer, PHPMailer, PHPStan, GitHub Issues/Projects, Figma  
- **Qualité** : PHPDoc, W3C (HTML/CSS), PHPStan, (CI/CD GitHub Actions prêt)

Arborescence (extrait) :
```
medboard/
├── public/                # racine web (DocumentRoot)
│   └── index.php          # front controller + routeur
├── www/                   # (prod) pointé par AlwaysData
├── private/
│   ├── config/            # autoloader, routes, constants
│   ├── modules/           # MVC : Controllers / Models / Views
│   ├── Services/          # MailService, Csrf, Auth, Http, Inputs...
│   └── cache/, logs/
├── vendor/                # Composer
├── .env.example           # variables d’environnement (exemple)
├── phpstan.neon           # config PHPStan
└── README.md
```

---

## ✅ Fonctionnalités majeures

- Authentification (inscription, login, logout).
- Réinitialisation de mot de passe par e-mail (tokens temporaires).
- Gestion des utilisateurs et spécialités.
- Tableau de bord patient (listes, filtres…).
- Triggers PostgreSQL pour **normalisation** des champs et **audit minimal** (`updated_at`).
- Sécurité **CSRF** (token par formulaire) et **validation stricte** des entrées.

---

## 🔒 Sécurité (synthèse)

- Référentiel : **OWASP Top 10 (2021)**.  
- **Hash** : `password_hash()` **Argon2id** + `password_verify()`.  
- **Tokens** : reset/remember **hashés** en base, expirations.  
- **Sessions** : `session_regenerate_id(true)` après login, cookies `HttpOnly` + `SameSite=Strict`.  
- **CSRF** : token unique par formulaire/route.  
- **PDO** : requêtes préparées **partout**.  
- **.htaccess** : headers de sécurité (CSP, HSTS, X-Content-Type-Options…), réécritures propres.  
- **SMTP** : envoi via AlwaysData (port 465 TLS ou 587 STARTTLS).

> Détails et recommandations complètes dans la section **« Revue OWASP Top 10 & recommandations »** plus bas.

---

## 🗃️ Modèle de données

Tables principales : `specializations`, `users`, `password_resets`, `remember_tokens`.  
Le script SQL complet (PostgreSQL) se trouve ci-dessous (section « Script SQL »).

**Extrait (contraintes clés) :**
- Unicité : `users.username`, `users.email`, `specializations.name_fr`, `password_resets.token_hash`, `remember_tokens.selector`.
- **CHECK** : formats `email`, `username`, noms FR, **pattern Argon2id** pour `password_hash`.
- **FK** : `users.specialization_id` → `specializations`, `ON DELETE SET NULL`.  
- **Triggers** : normalisation lowercase/trim + `updated_at`.

---

## 🧪 Qualité & tests

- **PHPStan** (niveau progressif)  
- **PHPDoc** et types stricts (`declare(strict_types=1)`)  
- **Tests fonctionnels** simples (auth, reset, formulaires)  
- **W3C** : HTML & CSS validés (preuves dans `/docs/`)

### Configuration PHPStan

`phpstan.neon` (placé à la racine) :
```neon
parameters:
  paths:
    - www
    - private
  level: 1
  excludePaths:
    - vendor
    - cache
    - logs
```

### Intégration continue (suggestion)

`.github/workflows/phpstan.yml` :
```yaml
name: PHPStan
on: [push, pull_request]
jobs:
  phpstan:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - uses: php-actions/composer@v6
      - uses: php-actions/phpstan@v3
        with:
          path: .
          configuration: phpstan.neon
```

---

## 🧭 Gestion de projet

- **GitHub Issues** : user stories, bugs, tâches techniques (labels `feature`, `bug`, `security`, `docs`).  
- **Projets** (kanban) : Backlog → En cours → PR → Done.  
- **Conventions de commit** : `feat:`, `fix:`, `sec:`, `docs:`, `refactor:`…

---

## 📦 Installation locale

1) **Cloner**
```bash
git clone git@github.com:Vassili-REGNIER/medboard.git
cd medboard
composer install
cp .env.example .env
```

2) **Variables d’environnement** (`.env`)
```env
DB_HOST=postgresql-<compte>.alwaysdata.net
DB_PORT=5432
DB_NAME=<nom_bdd>
DB_USER=<user>
DB_PASS=<mot_de_passe>
DB_CHARSET=utf8

SMTP_HOST=smtp-<compte>.alwaysdata.net
SMTP_PORT=587
SMTP_USERNAME=<adresse_email>
SMTP_PASSWORD=<mot_de_passe>
SMTP_FROM_EMAIL=<expediteur@domaine>
SMTP_FROM_NAME="Medboard"
```

3) **Base PostgreSQL**  
Importer le script SQL ci-dessous.

4) **Démarrer le serveur local**
```bash
php -S localhost:8000 -t public
# http://localhost:8000
```

---

## ☁️ Déploiement sur AlwaysData

1) **Créer le site** : Panel → Web → Sites → **PHP** → **Répertoire** : `/www`  
2) **Déployer** via `git clone` en SSH :
```bash
ssh <user>@ssh-<compte>.alwaysdata.net
cd ~ && git clone git@github.com:Vassili-REGNIER/medboard.git
```
3) **Base PostgreSQL** : créer la base puis importer le script.  
4) **Variables d’environnement** : Web → Sites → Modifier → Variables :
```
DB_HOST, DB_PORT, DB_USER, DB_PASS, DB_NAME, DB_CHARSET,
SMTP_HOST, SMTP_PORT, SMTP_USERNAME, SMTP_PASSWORD, SMTP_FROM_EMAIL, SMTP_FROM_NAME
```
5) **E-mail** : créer une boîte (Panel → E-mail). Utiliser **smtp-<compte>.alwaysdata.net**, port **465 (TLS)** ou **587 (STARTTLS)**.

---

## 🧱 Script SQL — Création des tables (PostgreSQL)

```sql
DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS specializations CASCADE;
DROP TABLE IF EXISTS password_resets CASCADE;
DROP TABLE IF EXISTS remember_tokens CASCADE;

CREATE TABLE specializations (
  specialization_id    INT           GENERATED ALWAYS AS IDENTITY,
  name_fr              VARCHAR(32)   NOT NULL,
  CONSTRAINT pk_specializations PRIMARY KEY (specialization_id),
  CONSTRAINT unique_name_fr UNIQUE (name_fr),
  CONSTRAINT ck_name_fr CHECK (
    name_fr ~ '^[a-zà-öø-ÿ]+([\s-][a-zà-öø-ÿ]+)*$'
    AND length(name_fr) >= 3
  )
);

CREATE TABLE users (
  user_id               INT           GENERATED ALWAYS AS IDENTITY,
  firstname             VARCHAR(32)   NOT NULL,
  lastname              VARCHAR(32)   NOT NULL,
  username              VARCHAR(32)   NOT NULL,
  email                 VARCHAR(254)  NOT NULL,
  password_hash         VARCHAR(255)  NOT NULL,
  specialization_id     INT,
  created_at            TIMESTAMP     NOT NULL DEFAULT now(),
  updated_at            TIMESTAMP     NOT NULL DEFAULT now(),
  CONSTRAINT pk_user PRIMARY KEY (user_id),
  CONSTRAINT fk_specializations_users FOREIGN KEY (specialization_id)
    REFERENCES specializations(specialization_id)
    ON DELETE SET NULL,
  CONSTRAINT unique_username UNIQUE (username),
  CONSTRAINT unique_email UNIQUE (email),
  CONSTRAINT ck_firstname CHECK (
    firstname ~ '^[a-zà-öø-ÿ]+([\s-][a-zà-öø-ÿ]+)*$'
    AND length(firstname) >= 2
  ),
  CONSTRAINT ck_lastname CHECK (
    lastname ~ '^[a-zà-öø-ÿ]+([\s-][a-zà-öø-ÿ]+)*$'
    AND length(lastname) >= 1
  ),
  CONSTRAINT ck_username CHECK (
    username ~ '^[a-z][a-z0-9]*([._-][a-z0-9]+)*$'
    AND length(username) >= 3
  ),
  CONSTRAINT ck_email CHECK (
    email ~ '^[a-z0-9]+([._+-][a-z0-9]+)*@[a-z0-9]+([.-][a-z0-9]+)*\.[a-z]{2,}$'
  ),
  CONSTRAINT ck_argon2id CHECK (
    password_hash ~ '^\$argon2id\$v=\d+\$m=\d+,t=\d+,p=\d+\$[A-Za-z0-9+/=]+\$[A-Za-z0-9+/=]+$'
  )
);

CREATE TABLE password_resets (
  password_reset_id   INT         GENERATED ALWAYS AS IDENTITY,
  user_id             INT         NOT NULL,
  token_hash          CHAR(64)    NOT NULL UNIQUE,
  expires_at          TIMESTAMP   NOT NULL,
  used_at             TIMESTAMP,
  created_at          TIMESTAMP   DEFAULT now() NOT NULL,
  CONSTRAINT pk_password_resets PRIMARY KEY (password_reset_id),
  CONSTRAINT fk_password_resets_users FOREIGN KEY (user_id)
    REFERENCES users(user_id)
    ON DELETE CASCADE,
  CONSTRAINT ck_token_hash CHECK (token_hash ~ '^[a-f0-9]{64}$')
);

CREATE TABLE remember_tokens (
  remember_token_id   INT         GENERATED ALWAYS AS IDENTITY,
  user_id             INT         NOT NULL,
  selector            VARCHAR(24) NOT NULL UNIQUE,
  validator_hash      CHAR(64)    NOT NULL,
  user_agent_hash     CHAR(64)    NOT NULL,
  expires_at          TIMESTAMP   NOT NULL,
  created_at          TIMESTAMP   DEFAULT now() NOT NULL,
  CONSTRAINT pk_remember_tokens PRIMARY KEY (remember_token_id),
  CONSTRAINT fk_remember_tokens_users FOREIGN KEY (user_id)
    REFERENCES users(user_id)
    ON DELETE CASCADE,
  CONSTRAINT ck_selector CHECK (selector ~ '^[A-Za-z0-9_-]+$'),
  CONSTRAINT ck_validator_hash CHECK (validator_hash ~ '^[a-f0-9]{64}$'),
  CONSTRAINT ck_user_agent_hash CHECK (user_agent_hash ~ '^[a-f0-9]{64}$')
);

CREATE OR REPLACE FUNCTION users_normalize_and_touch()
RETURNS TRIGGER AS $$
BEGIN
  NEW.firstname := lower(NEW.firstname);
  NEW.lastname  := lower(NEW.lastname);
  NEW.username  := lower(btrim(NEW.username));
  NEW.email     := lower(btrim(NEW.email));
  NEW.updated_at := now();
  RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE TRIGGER trg_users
BEFORE INSERT OR UPDATE ON users
FOR EACH ROW
EXECUTE FUNCTION users_normalize_and_touch();

CREATE OR REPLACE FUNCTION specializations_normalize()
RETURNS TRIGGER AS $$
BEGIN
  NEW.name_fr := lower(NEW.name_fr);
  RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE TRIGGER trg_specializations
BEFORE INSERT OR UPDATE ON specializations
FOR EACH ROW
EXECUTE FUNCTION specializations_normalize();

CREATE INDEX idx_users_specialization_id ON users(specialization_id);
CREATE INDEX idx_password_resets_user_id ON password_resets(user_id);
CREATE INDEX idx_remember_tokens_user_id ON remember_tokens(user_id);
```

---

## 🧰 Bonnes pratiques techniques

- Validation côté client (HTML5) **+** validation/assainissement **côté serveur** (`Inputs`).  
- Encodage des sorties `htmlspecialchars()` pour prévenir le **XSS réfléchi**.  
- Redirections sûres `Http::redirect()`.  
- Séparation stricte Modèles / Contrôleurs / Vues.  
- Désactivation de l’index de répertoires côté serveur.  
- Cookies `HttpOnly` + `SameSite=Strict`.

---

## 🌐 SEO, accessibilité & éco-conception (résumé)

- `robots.txt`, `sitemap.xml`, **balises meta** (title/description, Open Graph).  
- Sémantique HTML (landmarks), contrastes, `aria-*` si nécessaire.  
- Minification CSS/JS, compression Gzip/Brotli, mise en cache, poids images.  
- Pages obligatoires : Accueil, Connexion, Inscription, Mot de passe oublié, Mentions légales, Plan du site.

---

## 🔭 Roadmap (extraits)

- [ ] **Rate limiting** formulaire d’authentification & endpoints sensibles.  
- [ ] **CSP stricte** avec nonces et suppression des `inline` scripts.  
- [ ] **Journaux applicatifs** dédiés (audits login/reset) + alerting.  
- [ ] **2FA** (TOTP) et politique de mots de passe configurable.  
- [ ] **CI** : tests e2e (Playwright), **SAST** (Psalm), **DAST** (OWASP ZAP).

---

## Exemples concrets

### 🔐 `.htaccess` (racine `public/`)
```apache
# Redirection HTTPS + HSTS
RewriteEngine On
RewriteCond %{HTTPS} !=on
RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains; preload"

# Réécriture vers front controller
DirectoryIndex index.php
RewriteRule ^(.+)$ index.php?route=$1 [L,QSA]

# Empêcher l’accès aux dossiers sensibles
RedirectMatch 404 ^/(private|logs|cache|vendor|\.env|composer\.(json|lock)).*$

# Désactiver le sniff MIME
Header set X-Content-Type-Options "nosniff"
# Clickjacking
Header set X-Frame-Options "DENY"
# XSS (héritage)
Header set X-XSS-Protection "0"

# CSP stricte (adapter les sources)
Header set Content-Security-Policy "default-src 'self'; img-src 'self' data:; style-src 'self'; script-src 'self'; base-uri 'self'; frame-ancestors 'none'; form-action 'self'"
# Referrer policy minimale
Header set Referrer-Policy "no-referrer"
# Permissions (API)
Header set Permissions-Policy "geolocation=(), microphone=(), camera=()"
```

### 🔑 Sessions (PHP – bootstrap)
```php
declare(strict_types=1);

ini_set('session.use_strict_mode', '1');
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_secure', '1');     // HTTPS only
ini_set('session.cookie_samesite', 'Strict');

session_name('medboard_sid');
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
```

### 🧱 Rate limiting / anti-bruteforce

**Schéma PostgreSQL (exemple) :**
```sql
CREATE TABLE IF NOT EXISTS rate_limit (
  key text PRIMARY KEY,
  hits int NOT NULL DEFAULT 0,
  window_start timestamp NOT NULL DEFAULT now()
);
```

**Service PHP (exemple) :**
```php
final class Throttle {
    public static function tooManyAttempts(PDO $pdo, string $key, int $max, int $seconds): bool {
        $stmt = $pdo->prepare('
            INSERT INTO rate_limit ("key", hits, window_start)
            VALUES (:k, 1, now())
            ON CONFLICT ("key")
            DO UPDATE SET hits = rate_limit.hits + 1
            RETURNING hits, extract(epoch from (now() - window_start))::int AS age
        ');
        $stmt->execute([':k' => $key]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row['age'] > $seconds) {
            $pdo->prepare('UPDATE rate_limit SET hits = 1, window_start = now() WHERE "key" = :k')->execute([':k' => $key]);
            return false;
        }
        return (int)$row['hits'] > $max;
    }
}
```

**Dans le contrôleur de login :**
```php
$key = 'login:'.hash('sha256', ($_SERVER['REMOTE_ADDR'] ?? 'na').':'.strtolower((string)($_POST['username'] ?? '')));
if (Throttle::tooManyAttempts($pdo, $key, 5, 900)) { // 5 tentatives / 15 min
    header('Retry-After: 300'); // 5 min
    Flash::set('error', 'Trop de tentatives, réessayez plus tard.');
    Http::redirect('/auth/login');
    exit;
}
```

### 🧾 Journaux applicatifs (sécurité)
- Logger : horodatage, route, IP (facultatif/hashed), UA (hash), username (si KO).  
- Événements : login OK/KO, reset demandé, reset utilisé, accès refusés.  
- Ne pas consigner de secrets (tokens, mots de passe).

---

## 📚 Sources & références

- **OWASP Top 10 (2021)** : https://owasp.org/Top10/
- **OWASP Project Top Ten** : https://owasp.org/www-project-top-ten/
- **AlwaysData – SMTP** : https://help.alwaysdata.com/en/e-mails/use-an-e-mail-address/
- **PostgreSQL – Regex & String** : https://www.postgresql.org/docs/current/functions-matching.html  
  https://www.postgresql.org/docs/9.1/functions-string.html
- **W3C Validators** : http://validator.w3.org/ • http://jigsaw.w3.org/css-validator/ • http://validator.w3.org/checklink
- Cours/TD & ressources pédagogiques : (Flouvat, Mickaël Martin-Nevot, etc.).

---

## 🧾 Licence

Projet scolaire — Licence libre d’étude (usage académique uniquement).  
© 2025 — Régnier, Watripont & Barberis.
