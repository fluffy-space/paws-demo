<?php

namespace Application;

use Fluffy\Domain\App\BaseApp;
use Viewi\App;

class DemoApp extends BaseApp
{
    public function getViewiApp(): App
    {
        return  include __DIR__ . '/../viewi-app/viewi.php';
    }
}
