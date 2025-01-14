<?php

namespace Application;

use DotDi\DependencyInjection\IServiceProvider;
use Fluffy\Domain\App\BaseApp;
use Fluffy\Domain\App\BaseStartUp;
use Fluffy\Domain\App\RequestDelegate;
use Fluffy\Domain\Message\HttpResponse;
use Fluffy\Middleware\RoutingMiddleware;
use Throwable;

/** @namespaces **/
// !Do not delete the line above!

class StartUp extends BaseStartUp
{
    public function __construct()
    {
        parent::__construct(__DIR__);
    }

    function configureServices(IServiceProvider $serviceProvider): void
    {
        parent::configureServices($serviceProvider);
        /** @insert **/
        // !Do not delete the line above!

        // Socket hubs


        // Tasks

        // Controllers
        // ServiceProviderHelper::discover($serviceProvider, [ControllersMark::folder()]);

        // Viewi
        // Route::setAdapter(new SwooleViewiAdapter($serviceProvider));
    }

    function configureMigrations(IServiceProvider $serviceProvider): void
    {
        parent::configureMigrations($serviceProvider);
        // override migration context
        // ServiceProviderHelper::discover($serviceProvider, [MigrationsMark::folder()]);
    }

    function configureInstallDependencies(IServiceProvider $serviceProvider): void
    {
        parent::configureInstallDependencies($serviceProvider);
        // ServiceProviderHelper::discover($serviceProvider, [MigrationsMark::folder()]);
    }

    function configure(BaseApp $app)
    {
        $app->use(function (RequestDelegate $next, HttpResponse $response) {
            try {
                $start = hrtime(true);
                $next();
                $end = (hrtime(true) - $start) / 1000000;
                $response->headers['Server-Timing'] = "app;dur=$end";
            } catch (Throwable $t) {
                echo '[Server] Request error.' . PHP_EOL;
                echo $t->__toString() . PHP_EOL;
                $response->status = 500;
                $end = (hrtime(true) - $start) / 1000000;
                $response->headers['Server-Timing'] = "app;dur=$end";
                $response->headers['Content-Type'] = "text/html; charset=utf-8";
                $response->body = 'Server error.';
                //   '<pre>' . $t->__toString() . ' </pre>';
                // .'<pre>' . print_r($t, true) . ' </pre>';
            }
        });

        // routes handler
        $app->use(RoutingMiddleware::class);

        // prepare crontab tasks
        include_once __DIR__ . '/crontab.php';

        // prepare routes and Viewi        
        $serviceProvider = $app->getProvider();
        $viewiApp = $serviceProvider->get(\Viewi\App::class);
        include_once __DIR__ . '/routes.php';

        // prepare socket hubs
        include_once __DIR__ . '/hubs.php';

        parent::configure($app);
    }
}
