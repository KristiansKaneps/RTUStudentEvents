<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'autoload.php';

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';

try {
    require_once CORE_DIR . 'DI' . DIRECTORY_SEPARATOR . 'dependency_injection.php';

    // Automatically load helper functions.
    $helperFiles = scandir(CORE_DIR . 'Helper', SCANDIR_SORT_ASCENDING);
    foreach ($helperFiles as $file) {
        if (is_dir($file)) continue;
        include_once(CORE_DIR . 'Helper' . DIRECTORY_SEPARATOR . $file);
    }

    // Register all application's routes.
    require_once ROOT_DIR . 'routes' . DIRECTORY_SEPARATOR . 'web.php';

    // Dispatch the current request.
    Router\Router::dispatch();
} catch (\Error | \Exception $e) {
    if (config('ENVIRONMENT') !== 'development' && config('ENVIRONMENT') !== 'local') {
        http_response_code(500);
        include_once PUBLIC_DIR . DIRECTORY_SEPARATOR . 'error' . DIRECTORY_SEPARATOR . 'unknown.html';
    } else {
        echo $e->getMessage() . PHP_EOL;
    }
}