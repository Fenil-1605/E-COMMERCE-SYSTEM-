<?php
// BookVerse configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'bookverse');
define('DB_USER', 'root');
define('DB_PASS', '');
define('SITE_NAME', 'BookVerse');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('Asia/Kolkata');
