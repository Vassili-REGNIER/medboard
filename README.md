# 🩺 Medboard — Tableau de bord adaptatif pour le suivi de patients

## 👨‍💻 Projet scolaire — Développement full PHP (IUT Aix-Marseille, S3)

**Contributeurs :**  
Vassili Régnier — Jérémy Watripont — Alexis Barberis  

---
a rajouter :  
utilisation de github issues  
utilisation de php Linter

## 🧩 Description

**Medboard** est une application web développée en **PHP orienté objet (architecture MVC)**.  
Elle permet à des professionnels de santé de suivre leurs patients via un tableau de bord interactif et sécurisé.

L’objectif est de proposer une application :
- conforme aux bonnes pratiques **OWASP Top 10 (2021)**,
- respectueuse de la **sécurité des données** et de la **cryptographie moderne**,
- et déployée sur un hébergement **AlwaysData**.

---

## ⚙️ Architecture du projet

- **Langage :** PHP 8.2  
- **Base de données :** PostgreSQL  
- **Pattern :** MVC orienté objet  
- **Modèles :** PDO avec requêtes préparées  
- **Sécurité :** Vérifications CSRF, validations `Inputs`, hashage Argon2id  
- **Hébergement :** AlwaysData (PHP + PostgreSQL + SMTP)  
- **Outils :** Composer, PHPMailer, GitHub, Figma  

---

## 📦 Installation locale

### 1️⃣ Cloner le projet
```bash
git clone git@github.com:Vassili-REGNIER/medboard.git
cd medboard
```

### 2️⃣ Créer la base PostgreSQL
Exécute le script SQL fourni dans ce README (section suivante) pour créer les tables :
- `specializations`
- `users`
- `password_resets`

### 3️⃣ Configurer les variables d’environnement
Créer un fichier `.env` à la racine du projet :
```env
DB_HOST=postgresql-<toncompte>.alwaysdata.net
DB_NAME=<nom_bdd>
DB_USER=<user>
DB_PASS=<mot_de_passe>

SMTP_HOST=smtp-alwaysdata.com
SMTP_USERNAME=<ton_email_alwaysdata>
SMTP_PASSWORD=<mot_de_passe>
SMTP_FROM_EMAIL=<adresse_expediteur>
SMTP_FROM_NAME="medboard"
```

### 4️⃣ Lancer le serveur local
```bash
php -S localhost:8000 -t public
```

Ouvre ensuite ton navigateur sur [http://localhost:8000](http://localhost:8000)

---

## ☁️ Déploiement sur AlwaysData

### 1️⃣ Création du site
- Connecte-toi sur [https://admin.alwaysdata.com](https://admin.alwaysdata.com)
- Crée un **site web PHP**
- Indique le **répertoire racine :** `/www`

### 2 Cloner le projet

- Connecte toi sur ton serveur alwaysdata en ssh
```bash
ssh [utilisateur]@ssh-[compte].alwaysdata.net 
```

- Clone le projet
```bash
cd ~/
git clone git@github.com:Vassili-REGNIER/medboard.git
```

### 3 Base de données PostgreSQL
- Dans **Base de données → PostgreSQL**, crée une nouvelle base.
- Importer le script SQL du projet.

### 4 Définir les variables d’environnement
Depuis **Web → Sites → Modifier → Variables d'environnement**, ajoute les variables suivantes :
```
DB_HOST
DB_PORT
DB_USER
DB_PASS
DB_NAME
DB_CHARSET
SMTP_HOST
SMTP_USERNAME
SMTP_PASSWORD
SMTP_FROM_EMAIL
SMTP_FROM_NAME
```

### 5 Créer une adresse mail AlwaysData
- Ouvre **E-mail → Comptes → Ajouter un compte**
- Utilise le SMTP `smtp-alwaysdata.com` sur le port `587` (STARTTLS)
- Renseigne cette adresse dans `MailService.php` pour l’envoi d’e-mails (mot de passe oublié, notifications).
---

## 🧱 Script SQL — Création des tables

> (Script conforme à PostgreSQL)

```sql
CREATE TABLE specializations (
    specialization_id INT GENERATED ALWAYS AS IDENTITY,
    name_en           VARCHAR(64) NOT NULL UNIQUE,

    CONSTRAINT pk_specializations PRIMARY KEY (specialization_id),
    CONSTRAINT ck_name_en_not_blank CHECK (btrim(name_en) <> ''),
    CONSTRAINT ck_name_en_trim      CHECK (name_en = btrim(name_en)),
    -- tout en minuscules
    CONSTRAINT ck_name_en_lower     CHECK (name_en = lower(name_en)),
    -- caractères autorisés
    CONSTRAINT ck_name_en_chars     CHECK (name_en ~ '^[a-zà-öø-ÿ'' _-]+$')
);

INSERT INTO specializations (name_en) VALUES
    ('cardiology'),
    ('general_practice'),
    ('dermatology'),
    ('neurology'),
    ('psychiatry'),
    ('pediatrics'),
    ('endocrinology'),
    ('oncology'),
    ('orthopedics'),
    ('radiology'),
    ('urology'),
    ('gastroenterology');

CREATE TABLE users (
    user_id           INT GENERATED ALWAYS AS IDENTITY,
    firstname         VARCHAR(32)  NOT NULL,
    lastname          VARCHAR(32)  NOT NULL,
    username          VARCHAR(32)  NOT NULL,
    password_hash     VARCHAR(255) NOT NULL,
    email             VARCHAR(254) NOT NULL,
    specialization_id INT REFERENCES specializations(specialization_id) ON DELETE SET NULL,

    -- Identité & unicité
    CONSTRAINT pk_user     PRIMARY KEY (user_id),
    CONSTRAINT uq_username UNIQUE (username),
    CONSTRAINT uq_email    UNIQUE (email),

    -- Qualité de données : trim + non vide + minuscules
    CONSTRAINT ck_firstname_not_blank CHECK (btrim(firstname) <> ''),
    CONSTRAINT ck_lastname_not_blank  CHECK (btrim(lastname)  <> ''),
    CONSTRAINT ck_firstname_trim      CHECK (firstname = btrim(firstname)),
    CONSTRAINT ck_lastname_trim       CHECK (lastname  = btrim(lastname)),
    CONSTRAINT ck_username_trim       CHECK (username  = btrim(username)),
    CONSTRAINT ck_email_trim          CHECK (email     = btrim(email)),

    -- minuscules obligatoires
    CONSTRAINT ck_firstname_lower CHECK (firstname = lower(firstname)),
    CONSTRAINT ck_lastname_lower  CHECK (lastname  = lower(lastname)),
    CONSTRAINT ck_username_lower  CHECK (username  = lower(username)),
    CONSTRAINT ck_email_lower     CHECK (email     = lower(email)),

    -- jeux de caractères autorisés (acceptent accents, espaces/tirets pour noms)
    CONSTRAINT ck_firstname_chars CHECK (firstname ~ '^[a-zà-öø-ÿ'' -]+$'),
    CONSTRAINT ck_lastname_chars  CHECK (lastname  ~ '^[a-zà-öø-ÿ'' -]+$'),

    -- Username : 3–32, commence par une lettre, autorise lettres/chiffres/._-
    CONSTRAINT ck_username_len   CHECK (length(username) BETWEEN 3 AND 32),
    CONSTRAINT ck_username_chars CHECK (username ~ '^[a-z][a-z0-9_.-]*$'),

    -- Email : format raisonnable
    CONSTRAINT ck_email_format CHECK (
        email ~ '^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$'
    ),

    -- Hash Argon2id (format PHC)
    CONSTRAINT ck_password_hash_format CHECK (
        password_hash ~ '^\$argon2id\$v=\d+\$m=\d+,t=\d+,p=\d+\$[A-Za-z0-9+/=]+\$[A-Za-z0-9+/=]+$'
    ),

    -- Traçabilité
    created_at TIMESTAMPTZ NOT NULL DEFAULT now(),
    updated_at TIMESTAMPTZ NOT NULL DEFAULT now()
);

-- 3) Trigger de normalisation (lower + trim) et mise à jour updated_at
CREATE OR REPLACE FUNCTION users_normalize_and_touch()
RETURNS trigger LANGUAGE plpgsql AS $fn$
BEGIN
  -- normalisation en minuscules + trim
  NEW.firstname := lower(btrim(NEW.firstname));
  NEW.lastname  := lower(btrim(NEW.lastname));
  NEW.username  := lower(btrim(NEW.username));
  NEW.email     := lower(btrim(NEW.email));
  -- updated_at pour INSERT/UPDATE
  NEW.updated_at := now();
  RETURN NEW;
END;
$fn$;

DROP TRIGGER IF EXISTS trg_users_norm ON users;
CREATE TRIGGER trg_users_norm
BEFORE INSERT OR UPDATE ON users
FOR EACH ROW
EXECUTE FUNCTION users_normalize_and_touch();

-- 4) Trigger pour normaliser la table specializations (lower + trim)
CREATE OR REPLACE FUNCTION specializations_normalize()
RETURNS trigger LANGUAGE plpgsql AS $fs$
BEGIN
  NEW.name_en := lower(btrim(NEW.name_en));
  RETURN NEW;
END;
$fs$;

DROP TRIGGER IF EXISTS trg_specializations_norm ON specializations;
CREATE TRIGGER trg_specializations_norm
BEFORE INSERT OR UPDATE ON specializations
FOR EACH ROW
EXECUTE FUNCTION specializations_normalize();

-- Table pour gérer les demandes de réinitialisation de mot de passe
CREATE TABLE public.password_resets (
    id          BIGSERIAL PRIMARY KEY,
    user_id     INT NOT NULL,
    token_hash  CHAR(64) NOT NULL,               -- hash SHA-256 hex (64 chars)
    expires_at  TIMESTAMPTZ NOT NULL,            -- avec fuseau horaire
    used_at     TIMESTAMPTZ NULL,
    created_at  TIMESTAMPTZ NOT NULL DEFAULT NOW(),

    CONSTRAINT fk_password_resets_user
        FOREIGN KEY (user_id) REFERENCES public.users(user_id)
        ON DELETE CASCADE
);

-- Un même token_hash ne doit exister qu’une seule fois
CREATE UNIQUE INDEX ux_password_resets_token_hash
    ON public.password_resets (token_hash);

-- Index utiles pour les vérifs / purges
CREATE INDEX ix_password_resets_expires_at
    ON public.password_resets (expires_at);

CREATE INDEX ix_password_resets_user_id
    ON public.password_resets (user_id);



CREATE TABLE remember_tokens (
    remember_token_id SERIAL PRIMARY KEY,
    user_id           INTEGER NOT NULL REFERENCES users(user_id) ON DELETE CASCADE,
    selector          VARCHAR(24) NOT NULL UNIQUE,
    validator_hash    CHAR(64) NOT NULL,
    user_agent_hash   CHAR(64) NOT NULL,
    expires_at        TIMESTAMP WITH TIME ZONE NOT NULL,
    created_at        TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT NOW()
);

-- Index utile pour les vérifications de validité et le nettoyage
CREATE INDEX idx_remember_tokens_expires_at ON remember_tokens (expires_at);
CREATE INDEX idx_remember_tokens_user_id ON remember_tokens (user_id);


```

---

## 🔒 Sécurité et conformité OWASP Top 10 (2021)

L’application Medboard a été développée en suivant les bonnes pratiques de sécurité du **Top 10 OWASP (2021)**.  

| OWASP | Vulnérabilité | Mesures appliquées |
|-------|----------------|--------------------|
| **A01 – Contrôles d’accès défaillants** | Accès non autorisé | Vérifications `Auth::requireGuest()` / `Auth::requireUser()`, routes protégées, sessions sécurisées |
| **A02 – Défaillances cryptographiques** | Hachage faible ou données sensibles en clair | `password_hash()` avec **Argon2id**, tokens de reset hashés (SHA-256) et expirant après 30 min |
| **A03 – Injection** | SQL injection | Toutes les requêtes SQL passent par des **requêtes préparées PDO** |
| **A04 – Conception non sécurisée** | Absence de validations | Entrées validées par `Inputs.php` (regex, longueurs, typage), logique PRG sur tous les formulaires |
| **A05 – Mauvaise configuration de sécurité** | Fichiers exposés, erreurs visibles | Dossier `/private/` non accessible, `display_errors=0` en prod, variables d’environnement isolées |
| **A06 – Composants vulnérables et obsolètes** | Libs non maintenues | **Composer** pour la gestion des dépendances, **PHPMailer** à jour, vérification CVE avant déploiement |
| **A07 – Authentification faible** | Sessions prévisibles, login non protégé | Sessions régénérées (`session_regenerate_id(true)`), contrôle du couple identifiant/mot de passe, CSRF actif |
| **A08 – Manque d’intégrité** | Données modifiées ou non vérifiées | Validation forte côté serveur & BD, hash du token de réinitialisation, triggers SQL de normalisation |
| **A09 – Journalisation insuffisante** | Pas de traçabilité | `error_log()` utilisé pour toutes les erreurs critiques (sans fuite d’infos sensibles) |
| **A10 – Falsification côté serveur (SSRF)** | Appels HTTP non filtrés | Aucune requête externe depuis les entrées utilisateur, hôtes SMTP/DB définis par variable d’environnement |

---

### 🔐 Protection contre les attaques CSRF

Bien que le CSRF ne soit plus une catégorie distincte depuis 2021, il est couvert par **A01** et **A05**.

**Mesures mises en œuvre :**
- Génération d’un **token CSRF unique par formulaire et par route**.  
- Vérification systématique avec `Csrf::requireValid()`.  
- Rejet immédiat des requêtes POST sans token valide.  
- **Cookies `HttpOnly` et `SameSite=Strict`** pour limiter les attaques cross-site.  
- **Renouvellement du token** à chaque session utilisateur.  

---

## 🧰 Bonnes pratiques techniques

- Validation côté client (HTML5 + attributs `required`, `pattern`, `minlength`).
- Validation/Nettoyage systématique côté serveur avec la classe `Inputs`.
- Encodage des sorties (`htmlspecialchars`) pour prévenir les injections XSS.
- Séparation stricte des responsabilités (Modèles / Contrôleurs / Vues).
- Redirections sécurisées (`Http::redirect()`).
- Désactivation des index de répertoires sur le serveur.

---

## 🧪 Qualité du code et tests

- **Validation W3C :** HTML5 et CSS3  
- **Analyse statique :** PHPStan  
- **Documentation :** PHPDoc complète  
- **Tests :** scénarios fonctionnels (connexion, inscription, mot de passe oublié, etc.)  
- **Compatibilité navigateurs :** Chrome, Firefox, Safari  
- **CI/CD :** en préparation (GitHub Actions)

---

## 🎓 Respect des consignes du projet

- Architecture **MVC** claire et complète  
- Pages obligatoires : Accueil, Connexion, Inscription, Mot de passe oublié, Mentions légales, Plan du site  
- Responsivité (mobile / tablette / desktop)  
- Hébergement **AlwaysData** fonctionnel  
- Respect des bonnes pratiques **OWASP**, **éco-conception** et **accessibilité**  
- Validation W3C et configuration serveur sécurisée  

---

## 🧾 Licence

Projet scolaire — Licence libre d’étude (usage académique uniquement).  
© 2025 — Régnier, Watripont & Barberis.