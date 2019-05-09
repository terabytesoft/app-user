<?php

return [
    'app' => [
        'modules' => [
            'user' => [
                '__class' => \TerabyteSoft\Module\User\Module::class,
                'basePath' => dirname(__DIR__) . '/src',
                'controllerNamespace' => '\TerabyteSoft\Module\User\Controllers',
                'accountAdmins' => $params['user.setting.accountAdmins'],
                'accountDelete' => $params['user.setting.accountDelete'],
                'accountConfirmation' => $params['user.setting.accountConfirmation'],
                'accountGeneratingPassword' => $params['user.setting.accountGeneratingPassword'],
                'accountImpersonateUser'  => $params['user.setting.accountImpersonateUser'],
                'accountPasswordRecovery' => $params['user.setting.accountPasswordRecovery'],
                'accountRegistration' => $params['user.setting.accountRegistration'],
                'accountUnconfirmedLogin' => $params['user.setting.accountUnconfirmedLogin'],
                'cost' => $params['user.setting.cost'],
                'debug' => $params['user.setting.debug'],
                'emailChangeStrategy' => $params['user.setting.emailChangeStrategy'],
                'floatLabels' => $params['user.setting.floatLabels'],
                'formMap' => [
                    'LoginForm'        => $params['user.formMap.LoginForm'],
                    'RecoveryForm'     => $params['user.formMap.RecoveryForm'],
                    'RegistrationForm' => $params['user.formMap.RegistrationForm'],
                    'ResendForm'       => $params['user.formMap.ResendForm'],
                    'SettingsForm'     => $params['user.formMap.SettingsForm'],
				],
                'queryMap' => [
					'AccountQuery' => $params['user.queryMap.AccountQuery'],
					'ProfileQuery' => $params['user.queryMap.ProfileQuery'],
					'TokenQuery'   => $params['user.queryMap.TokenQuery'],
					'UserQuery'    => $params['user.queryMap.UserQuery'],
				],
				'modelMap' => [
                    'AccountModel' => $params['user.modelMap.AccountModel'],
                    'ProfileModel' => $params['user.modelMap.ProfileModel'],
                    'TokenModel'   => $params['user.modelMap.TokenModel'],
                    'UserModel'    => $params['user.modelMap.UserModel'],
				],
				'searchMap' => [
                    'UserSearch'   => $params['user.searchMap.UserSearch'],
                ],
                'rememberFor' => $params['user.setting.rememberFor'],
                'tokenConfirmWithin' => $params['user.setting.tokenConfirmWithin'],
                'tokenRecoverWithin' => $params['user.setting.tokenRecoverWithin'],
                'urlPrefix' => $params['user.setting.urlPrefix'],
                'urlRules' => $params['user.setting.urlRules'],
            ],
        ],
    ],
    'db' => [
        '__class'   => \Yiisoft\Db\Connection::class,
        'dsn'       => $params['db.dns'],
        'username'  => $params['db.username'],
        'password'  =>  $params['db.password'],
    ],
    'cache' => [
        '__class' => \Yiisoft\Cache\Cache::class,
        'handler' => [
            '__class' => \Yiisoft\Cache\FileCache::class,
            'keyPrefix' => 'app-user',
        ],
    ],
    'logger' => function () {
        return new \Yiisoft\Log\Logger([
            new \Yiisoft\Log\FileTarget('/tmp/log.txt')
        ]);
    },
    'mailer' => [
        '__class' => \Yiisoft\Yii\SwiftMailer\Mailer::class,
        'useFileTransport' => $params['mailer.useFileTransport'],
	],
    'translator' => [
        'translations' => [
            'user' => [
                '__class' => \yii\i18n\PhpMessageSource::class,
                'sourceLanguage' => $params['translator.sourceLanguage'],
                'basePath' => $params['translator.basePath'],
            ],
        ],
    ],
    'theme' => [
    	'pathMap' => [
            '@TerabyteSoft/Module/User/views/admin' => '@TerabyteSoft/Module/User/Views/Admin',
            '@TerabyteSoft/Module/User/views/mail' => '@TerabyteSoft/Module/User/Views/Mail',
        	'@TerabyteSoft/Module/User/views/mail/layouts' => '@TerabyteSoft/Module/User/Views/Mail/Layouts',
        	'@TerabyteSoft/Module/User/views/mail/text' => '@TerabyteSoft/Module/User/Views/Mail/Text',
            '@TerabyteSoft/Module/User/views/profile' => '@TerabyteSoft/Module/User/Views/Profile',
            '@TerabyteSoft/Module/User/views/recovery' => '@TerabyteSoft/Module/User/Views/Recovery',
        	'@TerabyteSoft/Module/User/views/registration' => '@TerabyteSoft/Module/User/Views/Registration',
            '@TerabyteSoft/Module/User/views/security' => '@TerabyteSoft/Module/User/Views/Security',
            '@TerabyteSoft/Module/User/views/settings' => '@TerabyteSoft/Module/User/Views/Settings',
        ],
    ],
];
