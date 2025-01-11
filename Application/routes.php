<?php

use Viewi\App;

/**
 * @var App $viewiApp
 */

$registerRoutes = function (App $app) {
    // Viewi application here
    include __DIR__ . '/../viewi-app/routes.php';
};

$registerRoutes($viewiApp);
