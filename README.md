# Fluffy Paws demo application

## Commands

### Set up DB tables and oathers

`php fluffy migrate`

### Set up Nginx on WSL

`sudo php fluffy nginx paws-demo.wsl.com`

### Run server

`php fluffy server`

### Reload server

`php fluffy reload`

### Watch mode - runs server and rebuilds application on file changes

`php fluffy watch`

### Build - builds the app

`php fluffy build [environment]`

For example:

`php fluffy build dev`

`php fluffy build prod`

`php fluffy build local`

### Install (create all tables)

`php fluffy install`

### Run migrations

`php fluffy migrate`

### Create Entity model

`php fluffy model create EntityName [Namespace]`

Example:

`php fluffy model create UserTokenEntity Auth`

### Generate Entity model repository, migration, service; register migration, repository, service

`php fluffy model build UserTokenEntity Auth`

### Front-end (Deprecated)

  cd any-front
  npm install
  npm run dev

  Prod
  npm run build

### Cron Tab

`Application\crontab.php`

```php
CronTab::schedule([TestTask::class, 'execute'], '*/5 * * * * *');
```

### Hubs (Web sockets)

`Application\hubs.php`

```php
Hubs::mapHub('collect', [CollectHub::class, 'collect']);
```

```php
<?php

namespace Application\Hubs;

use Application\Models\CollectModel;

class CollectHub
{
    public function collect(CollectModel $message, $data, string $name)
    {
        print_r(['CollectHub::collect', $message->date, $data, $name]);
    }
}
```

```js
websocket.send(JSON.stringify({ 
  route: 'collect',
  data: { 
    name: 'Viewi',
    date: 123
  }
}));
```
