<?php

use Nette\Neon\Neon;

$configFile = __DIR__ . '/config/config.neon';

if (!file_exists($configFile)) {
    echo "Configure your config.neon by instruction in readme.md file";
}

$dbConfig = Neon::decodeFile($configFile)['database'];

preg_match('/host=([^;]+);/', $dbConfig['dsn'], $hostMatch);
preg_match('/dbname=([^;]+);/', $dbConfig['dsn'], $nameMatch);

$config = [
    'host' => $hostMatch[1] ?? null,
    'name' => $nameMatch[1] ?? null,
    'user' => $dbConfig['user'] ?? null,
    'pass' => $dbConfig['password'] ?? null,
];

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'development' => [
            'adapter' => 'mysql',
            'host' => $config['host'],
            'name' => $config['name'],
            'user' => $config['user'],
            'pass' => $config['pass'],
            'port' => '3306',
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];
