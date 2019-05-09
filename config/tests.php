<?php

use yii\di\Reference;

return [
    'app' => [
        'basePath' => dirname(__DIR__) . '/tests/src',
        'controllerNamespace' => '\TerabyteSoft\Module\User\Tests\Controllers',
        'layout' => 'Main.php',
    ],
	'authClientCollection' => [
		'__class' => Yiisoft\Yii\AuthClient\Collection::class,
		'setClients()' => [
			'github' => [
				'__class'      => Yiisoft\Yii\AuthClient\Clients\Github::class,
				'clientId'     => 'CLIENT_ID',
				'clientSecret' => 'CLIENT_SECRET',
			],
		],
	],
    'aliases' => array_merge($aliases, [
        '__class'   => yii\base\Aliases::class,
        '@root'     => YII_ROOT,
        '@vendor'   => '@root/vendor',
        '@public'   => '@root/tests/public',
        '@runtime'  => '@public/runtime',
        '@web'      => '/',
    ]),
    'assetManager' => [
        '__class'   => yii\web\AssetManager::class,
        'basePath'  => '@public/assets',
        'baseUrl'   => '@web/assets',
    ],
    'theme' => [
        'pathMap' => [
            '@app/views/layouts' => '@TerabyteSoft/Module/User/Tests/Views/Layouts',
            '@app/views/site' => '@TerabyteSoft/Module/User/Tests/Views/Site',
        ],
    ],
];
