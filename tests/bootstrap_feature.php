<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

if (file_exists(dirname(__DIR__) . '/config/bootstrap.php')) {
    require dirname(__DIR__) . '/config/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__) . '/.env');
}

// Recreate database structure based on the production table
passthru(sprintf(
    'APP_ENV=%s php "%s/../bin/console" --env=test doctrine:database:drop --force',
    $_ENV['APP_ENV'] ?? 'test',
    __DIR__
));

passthru(sprintf(
    'APP_ENV=%s php "%s/../bin/console" --env=test doctrine:database:create',
    $_ENV['APP_ENV'] ?? 'test',
    __DIR__
));

passthru(sprintf(
    'APP_ENV=%s php "%s/../bin/console" --env=test doctrine:schema:create',
    $_ENV['APP_ENV'] ?? 'test',
    __DIR__
));

// Load data fixtures
passthru(sprintf(
    'APP_ENV=%s php "%s/../bin/console" --env=test doctrine:fixtures:load --group=test --no-interaction',
    $_ENV['APP_ENV'] ?? 'test',
    __DIR__
));
