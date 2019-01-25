<?php

return [
    'app' => [
        'modules' => [
            'user' => [
                '__class' => app\user\Module::class,
                'basePath' => dirname(__DIR__) . '/src',
				'controllerNamespace' => 'app\user\controllers',
                'formMap' => [
                    'LoginForm'        => app\user\forms\LoginForm::class,
                    'RecoveryForm'     => app\user\forms\RecoveryForm::class,
                    'RegistrationForm' => app\user\forms\RegistrationForm::class,
                    'ResendForm'       => app\user\forms\ResendForm::class,
                    'SettingsForm'     => app\user\forms\SettingsForm::class,
				],
                'queryMap' => [
					'AccountQuery' => app\user\querys\AccountQuery::class,
					'ProfileQuery' => app\user\querys\ProfileQuery::class,
					'TokenQuery'   => app\user\querys\TokenQuery::class,
					'UserQuery'    => app\user\querys\UserQuery::class,
				],
				'modelMap' => [
                    'AccountModel' => app\user\models\AccountModel::class,
                    'ProfileModel' => app\user\models\ProfileModel::class,
                    'TokenModel'   => app\user\models\TokenModel::class,
                    'UserModel'    => app\user\models\UserModel::class,
				],
				'searchMap' => [
                    'UserSearch'   => app\user\searchs\UserSearch::class,
				],
				'enableAccountDelete' => true,
				'enableConfirmation' => true,
				'enableFlashMessages' => true,
				'enableRegistration' => true,
                'enableUnconfirmedLogin' => true,
                'confirmWithin' => 21600,
                'cost' => 12,
				'admins' => ['admin'],
            ],
        ],
	],
	'authClientCollection' => [
		'__class' => yii\authclient\Collection::class,
		'clients' => [],
	],
    'cache' => [
        '__class' => yii\cache\Cache::class,
        'handler' => [
            '__class' => yii\cache\FileCache::class,
            'keyPrefix' => 'app-user',
        ],
    ],
    'logger' => [
        '__construct()' => [
            'targets' => [
                [
                    '__class' => yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'mailer' => [
        '__class' => yii\swiftmailer\Mailer::class,
        'useFileTransport' => $params['mailer.useFileTransport'],
	],
    'translator' => [
        'translations' => [
            'user' => [
                '__class' => yii\i18n\PhpMessageSource::class,
                'sourceLanguage' => $params['translator.sourceLanguage'],
                'basePath' => $params['translator.basePath'],
            ],
        ],
	],
];
