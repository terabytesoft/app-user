<?php

use yii\di\Reference;

return [
    'app' => [
        'basePath' => dirname(__DIR__) . '/tests/src',
        'controllerNamespace' => 'app\user\tests\controllers',
    ],
	'authClientCollection' => [
		'__class' => yii\authclient\Collection::class,
		'clients' => [
			'facebook' => [
				'__class'      => app\user\clients\Facebook::class,
				'clientId'     => 'CLIENT_ID',
				'clientSecret' => 'CLIENT_SECRET',
			],
			'github' => [
				'__class'      => app\user\clients\GitHub::class,
				'clientId'     => 'CLIENT_ID',
				'clientSecret' => 'CLIENT_SECRET',
			],
			'google' => [
				'__class'      => app\user\clients\Google::class,
				'clientId'     => 'CLIENT_ID',
				'clientSecret' => 'CLIENT_SECRET',
			],
			'linkedin' => [
				'__class'        => app\user\clients\LinkedIn::class,
				'clientId'     => 'CLIENT_ID',
				'clientSecret' => 'CLIENT_SECRET'
			],
			'twitter' => [
				'__class'        => app\user\clients\Twitter::class,
				'consumerKey'    => 'CONSUMER_KEY',
				'consumerSecret' => 'CONSUMER_SECRET',
			],
			'vkontakte' => [
				'__class'        => app\user\clients\VKontakte::class,
				'clientId'     => 'CLIENT_ID',
				'clientSecret' => 'CLIENT_SECRET',
			],
			'yandex' => [
				'__class'        => app\user\clients\Yandex::class,
				'clientId'     => 'CLIENT_ID',
				'clientSecret' => 'CLIENT_SECRET'
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
];
