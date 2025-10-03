# DashMed — Tableau de bord adaptatif pour le suivi de patients

## Projet scolaire — développement full PHP
Contributeurs : **Vassili Régnier, Jérémy Watripont, Alexis Barberis**

### Description

DashMed est une application web (PHP, MVC) qui permet le suivi de patients via un tableau de bord adaptatif :

- stockage des observations (séries temporelles d’indicateurs),

- affichage de graphiques pour indicateurs présélectionnés,

- enregistrement des préférences d’affichage par médecin,

- gestion de seuils d’alerte et génération d’alertes,

- prototype de recommandation d’indicateurs via ML.

Ce README fournit les instructions pour installer, développer et livrer le projet.




Script de création de la base de donnée : 

```sql 
-- ============================================================================
-- PostgreSQL — Medical supervision DB (lowercase-only inputs, no CITEXT)
-- ============================================================================

-- 0) Nettoyage idempotent
DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS specializations CASCADE;

-- 1) Table de référence des spécialités (liste réduite)
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

-- Liste réduite, non exhaustive (en anglais, déjà en minuscules)
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

-- 2) Table users
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

-- 5) (Option) Index utiles
-- CREATE INDEX idx_users_username ON users (username);
-- CREATE INDEX idx_users_email    ON users (email);
-- CREATE INDEX idx_users_spec     ON users (specialization_id);

-- ============================================================================
-- Fin du script
-- ============================================================================
 
```