<?php

use Application\DemoApp;
use Application\StartUp;
use Swoole\Constant;

$currentDir = getcwd();
$staticFilesDir = 'files';
return [
    'port' => 8211,
    'static_files' => $currentDir . '/../' . $staticFilesDir,
    'app_factory' => fn() => new DemoApp(new StartUp()),
    'swoole' => [
        Constant::OPTION_WORKER_NUM => 2, //swoole_cpu_num(), //swoole_cpu_num() * 8,
        Constant::OPTION_TASK_WORKER_NUM => 2, // swoole_cpu_num(),
        Constant::OPTION_REACTOR_NUM => 2, // swoole_cpu_num(),
        Constant::OPTION_RELOAD_ASYNC => true,
        Constant::OPTION_MAX_WAIT_TIME => 5,
        Constant::OPTION_ENABLE_STATIC_HANDLER => true,
        Constant::OPTION_DOCUMENT_ROOT => $currentDir . '/public',
        Constant::OPTION_OPEN_HTTP2_PROTOCOL => true,
        Constant::OPTION_LOG_LEVEL => SWOOLE_LOG_ERROR,
        Constant::OPTION_PID_FILE => $currentDir . '/server.pid',
        Constant::OPTION_OPEN_CPU_AFFINITY => true,
        Constant::OPTION_ENABLE_COROUTINE => true,
        Constant::OPTION_TASK_ENABLE_COROUTINE => true,
        Constant::OPTION_HOOK_FLAGS => SWOOLE_HOOK_ALL,
        Constant::OPTION_OPEN_TCP_KEEPALIVE => true,
        Constant::OPTION_TCP_KEEPIDLE => 4,
        Constant::OPTION_TCP_KEEPINTERVAL => 1,
        Constant::OPTION_TCP_KEEPCOUNT => 5
    ]
];
