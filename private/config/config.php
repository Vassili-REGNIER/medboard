<?php

// Chemins de base
define('MODULES_PATH', dirname(__DIR__) . '/modules/');
define('BASE_PATH', dirname(__DIR__, 2));

// Config DB
define("DB_HOST", getenv("DB_HOST"));
define("DB_PORT",getenv("DB_PORT"));
define("DB_USER", getenv("DB_USER"));
define("DB_PASS", getenv("DB_PASS"));
define("DB_NAME", getenv("DB_NAME"));
define("DB_CHARSET", getenv("DB_CHARSET"));

// Config SMTP
define("SMTP_HOST",getenv("SMTP_HOST"));
define("SMTP_USERNAME",getenv("SMTP_USERNAME"));
define("SMTP_PASSWORD",getenv("SMTP_PASSWORD"));
define("SMTP_FROM_EMAIL",getenv("SMTP_FROM_EMAIL"));
define("SMTP_FROM_NAME",getenv("SMTP_FROM_NAME"));