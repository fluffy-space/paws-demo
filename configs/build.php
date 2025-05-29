<?php

$superName = 'paws-demo';
$d = DIRECTORY_SEPARATOR;
$localVars = [
    "VAULT_KEY" => "paws-demo_local",
    "__PUBLIC_DIR_PATH__" => __DIR__ . $d . '..' . $d . 'public',
    "__PUBLIC_URL_PATH__" => '',
    "__COMBINE_JS__" => false,
    "__MINIFY_JS__" => false,
    "__DEV_MODE__" => true,
    "HOST_IP" => '127.0.0.1',
    "BASE_DOMAIN" => "paws-demo.wsl.com",
    "BASE_URL" => "https://paws-demo.wsl.com",
    "ORIGINS_BASE_ORIGIN" => "https://paws-demo.wsl.com",
    "ORIGINS_ALLOWED_ARRAY" => [
        "https://paws-demo.wsl.com"
    ],
    "REDIS_DB_INDEX" => 3,
];

$prod = [
    "VAULT_KEY" => "paws-demo_prod",
    "__PUBLIC_DIR_PATH__" => __DIR__ . $d . '..' . $d . 'public',
    "__PUBLIC_URL_PATH__" => '',
    "__COMBINE_JS__" => true,
    "__MINIFY_JS__" => true,
    "__DEV_MODE__" => false,
    "HOST_IP" => '127.0.0.1',
    "BASE_DOMAIN" => "paws-demo.com",
    "BASE_URL" => "https://paws-demo.com",
    "ORIGINS_BASE_ORIGIN" => "https://paws-demo.com",
    "ORIGINS_ALLOWED_ARRAY" => [
        "https://paws-demo.com"
    ],
    "REDIS_DB_INDEX" => 3,    
];

return [
    'name' => $superName,
    'environments' => [
        'local' => [
            'vars' => $localVars,
            'steps' => ['createVaultKeys', 'getVaultKeys', 'buildConfig', 'buildApp']
        ],
        'local-wsl' => [
            'vars' => $localVars,
            'steps' => ['getVaultKeys', 'wslHostIp', 'buildConfig', 'buildApp']
        ],
        'prod' => [
            'vars' => $prod,
            'steps' => ['getVaultKeys', 'buildConfig', 'buildApp']
        ],
    ],
    'actions' => [
        'createVaultKeys' => function (Builder $builder) {
            $vaultDir = $builder->getBaseDir() . '/../vault';
            // System("sudo chmod -R 777 $vaultDir");
            if (!file_exists($vaultDir)) {
                mkdir($vaultDir, 077, true);
            }
            $vaultPath = $vaultDir . '/values.' . $builder->getEnvironment() . '.json';
            if (!file_exists($vaultPath)) {
                file_put_contents($vaultPath, "{}");
            }
        },
        'getVaultKeys' => function (Builder $builder) {
            $vaultPath = $builder->getBaseDir() . '/../vault/values.' . $builder->getEnvironment() . '.json';
            if (!file_exists($vaultPath)) {
                throw new RuntimeException("File '$vaultPath' not found");
            }
            $values = file_get_contents(realpath($vaultPath));
            $array = json_decode($values, true);
            echo '[Build] Read vault values ' . $vaultPath . PHP_EOL;
            $builder->setVariables(array_merge($builder->getVariables(), $array));
        },
        'wslHostIp' => function (Builder $builder) {
            $catResolveOutput = shell_exec('cat /etc/resolv.conf');
            $lines = explode('nameserver', $catResolveOutput);
            $ipLine = explode(PHP_EOL, $lines[1])[0];
            $hostIP = trim($ipLine);
            echo '[Build] Host IP: ' . $hostIP . PHP_EOL;
            $vars = $builder->getVariables();
            $vars['HOST_IP'] = $hostIP;
            $builder->setVariables($vars);
        },
        'buildConfig' => function (Builder $builder) {
            $vars = $builder->getVariables();
            foreach (
                [
                    ['target' => '/configs/app.php', 'template' => '/configs/app.default.php'],
                    //['target' => '/viewi-app/publicConfig.php', 'template' => '/viewi-app/publicConfig.php.template'],
                    //['target' => '/viewi-app/config.php', 'template' => '/viewi-app/config.php.template']
                ] as $configFiles
            ) {
                $target = $builder->getBaseDir() . $configFiles['target'];
                $template = file_get_contents($builder->getBaseDir() . $configFiles['template']);
                foreach ($vars as $key => $value) {
                    if (is_array($value)) {
                        $template = str_replace($key, var_export($value, true), $template);
                    } else {
                        $strValue = is_bool($value) ? ($value ? 'true' : 'false') : $value;
                        $template = str_replace($key, $strValue, $template);
                    }
                }
                if (!file_exists($target) || file_get_contents($target) !== $template) {
                    file_put_contents($target, $template);
                }
            }
        },
        'buildApp' => function (Builder $builder) {
            // build App and Viewi            
            $config = require $builder->getBaseDir() . '/configs/server.php';
            $app = $config['app_factory']();
            $app->build();
        }
    ]
];
