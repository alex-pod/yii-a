<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
    'container' => [
        'singletons' => [
            \backend\services\interfaces\ChargeServiceInterface::class => \backend\services\ChargeService::class,
            \backend\services\interfaces\TransactionServiceInterface::class =>
                \backend\services\TransactionService::class,
            \backend\services\interfaces\ReporterInterface::class => \backend\services\ReporterService::class,
        ],
    ],
];
