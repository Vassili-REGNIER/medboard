# 🩺 Medboard — Tableau de bord adaptatif pour le suivi de patients

## 👨‍💻 Projet scolaire — Développement full PHP (IUT Aix-Marseille, S3)

**Contributeurs :**  
Vassili Régnier — Jérémy Watripont — Alexis Barberis  

---
a rajouter :  
utilisation de github issues  
implémentation de PHP stan avec comme fichier de config phpstan.neon placé à la racine : 
parameters:
  paths:
    - www
    - private
  level: 1
  excludePaths:
    - vendor
    - cache
    - logs


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

DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS specializations CASCADE;
DROP TABLE IF EXISTS password_resets CASCADE;
DROP TABLE IF EXISTS remember_tokens CASCADE;

CREATE TABLE specializations (
	specialization_id		INT 			GENERATED ALWAYS AS IDENTITY,
	name_fr					VARCHAR(32)		NOT NULL,

	CONSTRAINT pk_specializations PRIMARY KEY (specialization_id),

	CONSTRAINT unique_name_fr UNIQUE (name_fr),
	
	CONSTRAINT ck_name_fr CHECK (
    	name_fr ~ '^[a-zà-öø-ÿ]+([\s-][a-zà-öø-ÿ]+)*$'
		AND length(name_fr) >= 3
	)
);

CREATE TABLE users (
    user_id                	INT           GENERATED ALWAYS AS IDENTITY,
    firstname           	VARCHAR(32)   NOT NULL,
    lastname            	VARCHAR(32)   NOT NULL,
    username           		VARCHAR(32)   NOT NULL,
	email                	VARCHAR(254)  NOT NULL,
    password_hash        	VARCHAR(255)  NOT NULL,
    specialization_id       INT,
    created_at 				TIMESTAMP   NOT NULL DEFAULT now(),
    updated_at 				TIMESTAMP   NOT NULL DEFAULT now(),

    CONSTRAINT pk_user PRIMARY KEY (user_id),

	CONSTRAINT fk_specializations_users FOREIGN KEY (specialization_id) 
	REFERENCES specializations(specialization_id)
	ON DELETE SET NULL,
	
    CONSTRAINT unique_username  UNIQUE (username),
	
    CONSTRAINT unique_email UNIQUE (email),
    
    CONSTRAINT ck_firstname CHECK (
        firstname  ~ '^[a-zà-öø-ÿ]+([\s-][a-zà-öø-ÿ]+)*$'
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
	password_reset_id		INT			  GENERATED ALWAYS AS IDENTITY,
	user_id					INT			  NOT NULL,
	token_hash				CHAR(64)	  NOT NULL UNIQUE,
	expires_at				TIMESTAMP	  NOT NULL,
	used_at				TIMESTAMP,
	created_at				TIMESTAMP	  DEFAULT now() NOT NULL,

	CONSTRAINT pk_password_resets PRIMARY KEY (password_reset_id),

	CONSTRAINT fk_password_resets_users FOREIGN KEY (user_id)
	REFERENCES users(user_id)
	ON DELETE CASCADE,

	CONSTRAINT ck_token_hash CHECK (
    	token_hash ~ '^[a-f0-9]{64}$'
    )
);

CREATE TABLE remember_tokens (
	remember_token_id		INT		    GENERATED ALWAYS AS IDENTITY,
	user_id					INT			NOT NULL,
	selector				VARCHAR(24) NOT NULL UNIQUE,
	validator_hash			CHAR(64)	NOT NULL,
	user_agent_hash			CHAR(64)	NOT NULL,
	expires_at				TIMESTAMP	NOT NULL,
	created_at				TIMESTAMP	DEFAULT now() NOT NULL,

	CONSTRAINT pk_remember_tokens PRIMARY KEY (remember_token_id),

	CONSTRAINT fk_remember_tokens_users FOREIGN KEY (user_id)
	REFERENCES users(user_id)
	ON DELETE CASCADE,

	CONSTRAINT ck_selector CHECK (
		selector ~ '^[A-Za-z0-9_-]+$'
	),

	CONSTRAINT ck_validator_hash CHECK (
		validator_hash ~ '^[a-f0-9]{64}$'
	),

	CONSTRAINT ck_user_agent_hash CHECK (
		user_agent_hash ~ '^[a-f0-9]{64}$'
	)
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