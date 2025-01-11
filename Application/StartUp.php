<?php

namespace Application;

use DotDi\DependencyInjection\IServiceProvider;
use DotDi\DependencyInjection\ServiceProviderHelper;
use Fluffy\Domain\App\BaseApp;
use Fluffy\Domain\App\BaseStartUp;
use Fluffy\Domain\App\RequestDelegate;
use Fluffy\Domain\Configuration\Config;
use Fluffy\Domain\Message\HttpRequest;
use Fluffy\Domain\Message\HttpResponse;
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

        // $app->use(function (RequestDelegate $next, SessionContext $sessionContext) {
        //     // uncomment in order to track request activities
        //     // TODO: protect from flood
        //     // $sessionContext->SaveSession();
        //     $next();
        // });


        // prepare crontab tasks
        include_once __DIR__ . '/crontab.php';

        // prepare routes and Viewi
        $viewiApp = $this->viewiApp;
        include_once __DIR__ . '/routes.php';

        // prepare socket hubs
        include_once __DIR__ . '/hubs.php';

        parent::configure($app);
    }
}
