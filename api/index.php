<?php

// 1. Set Laravel Application Key
putenv('APP_KEY=base64:X2uwLnbu1kM7SdFlWU2BFPXoYfEyah5fUWMfHaMTNZY=');
putenv('APP_ENV=production');
putenv('APP_DEBUG=true');

// 2. Configure Database to copy SQLite to writable /tmp directory
putenv('DB_CONNECTION=sqlite');
$tmpDatabase = '/tmp/database.sqlite';
$sourceDatabase = realpath(__DIR__ . '/../database/database.sqlite');

// Copy database to /tmp if it doesn't exist, or if the current one is empty/invalid (under 100KB)
if ($sourceDatabase && (!file_exists($tmpDatabase) || filesize($tmpDatabase) < 100000)) {
    copy($sourceDatabase, $tmpDatabase);
    chmod($tmpDatabase, 0666);
}
putenv('DB_DATABASE=' . $tmpDatabase);

// 3. Configure Serverless Caching and Compiled View directories to use /tmp
putenv('APP_CONFIG_CACHE=/tmp/config.php');
putenv('APP_ROUTES_CACHE=/tmp/routes.php');
putenv('APP_SERVICES_CACHE=/tmp/services.php');
putenv('APP_PACKAGES_CACHE=/tmp/packages.php');
putenv('VIEW_COMPILED_PATH=/tmp/views');
putenv('CACHE_STORE=array');
putenv('SESSION_DRIVER=cookie');
putenv('LOG_CHANNEL=stderr');

// Ensure compiled views directory exists in /tmp
if (!is_dir('/tmp/views')) {
    mkdir('/tmp/views', 0755, true);
}

// 4. Forward requests to the Laravel public/laravel_index.php entry point
require __DIR__ . '/../public/laravel_index.php';
