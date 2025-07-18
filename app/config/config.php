<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$currentUrl1 = $protocol . $host;
$currentUrl = $protocol . $host . '/wardibaset';
//define('base_url', $currentUrl1 . '/forwader_bmi/public');
define('base_url', $currentUrl . '/forwader_bmi/public');
define('url_store', $currentUrl1 . "/UploadFilesForwader/");
define('FOLDER', 'C:/UploadFilesForwader/');
//define('FOLDER', 'D:/UploadFilesForwader/');
define('DB_HOST', 'localhost');
define('DB_USER', 'sa');
define('DB_PASS', '');
define('DB_NAME', 'um_db');
define('DB_NAME2', 'bambi-bmi');

define('SESSION_TIMEOUT', 1800);
