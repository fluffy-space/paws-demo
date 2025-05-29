<?php

return [
    'before' => function ($dir) {
        if (file_exists('/proc/sys/fs/binfmt_misc/WSLInterop')) {
            // we are in wsl
            System('sudo service nginx start');
            System('sudo service postgresql start');
        }
        $command = "php fluffy build local";
        System($command);
        $pid = @file_get_contents($dir . '/server.pid');
        if ($pid) {
            $command = "kill -9 $pid";
            echo $command . PHP_EOL;
            echo shell_exec($command);
        }
    },
    'onStart' => function ($dir) {
        $command = "php fluffy server";
        System($command);
    },
    'onChange' => function ($dir) {
        $command = "php fluffy build local";
        System($command);
        // reload server
        $pid = @file_get_contents($dir . '/server.pid');
        if ($pid) {
            $restartAll = "kill -USR1 $pid";
            $restartTasks = "kill -USR2 $pid";
            $sendShutDown = "kill -15 $pid";
            $kill = "kill -9 $pid";

            $command = "kill -USR1 $pid";
            echo $command . PHP_EOL;
            echo shell_exec($command);
        }
    },
    'ignore' => [
        '.*/.git/',
        '/viewi-app/build/*',
        '/viewi-app/js/app/*',
        '/viewi-app/js/viewi/*',
        '/viewi-app/js/exports/*',
        '/viewi-app/js/dist/*',
        '/public/viewi-build/*',
        '/public/viewi-ui/*',
        '/public/viewi-viewi/*',
        '/public/viewi-*',
        '/@folder/*',
        '.*/server.pid'
    ]
];
