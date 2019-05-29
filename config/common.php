<?php

return [
    'app' => [
        'modules' => [
            'user' => [
                '__class' => \TerabyteSoft\Module\User\Module::class,
                'basePath' => dirname(__DIR__) . '/src',
                'controllerNamespace' => '\TerabyteSoft\Module\User\Controllers',
                'accountAdmins' => $params['module.user.setting.accountAdmins'],
                'accountDelete' => $params['module.user.setting.accountDelete'],
                'accountConfirmation' => $params['module.user.setting.accountConfirmation'],
                'accountGeneratingPassword' => $params['module.user.setting.accountGeneratingPassword'],
                'accountImpersonateUser'  => $params['module.user.setting.accountImpersonateUser'],
                'accountPasswordRecovery' => $params['module.user.setting.accountPasswordRecovery'],
                'accountRegistration' => $params['module.user.setting.accountRegistration'],
                'accountUnconfirmedLogin' => $params['module.user.setting.accountUnconfirmedLogin'],
                'cost' => $params['module.user.setting.cost'],
                'debug' => $params['module.user.setting.debug'],
                'emailChangeStrategy' => $params['module.user.setting.emailChangeStrategy'],
                'floatLabels' => $params['module.user.setting.floatLabels'],
                'formMap' => [
                    'LoginForm'        => $params['module.user.formMap.LoginForm'],
                    'RecoveryForm'     => $params['module.user.formMap.RecoveryForm'],
                    'RegistrationForm' => $params['module.user.formMap.RegistrationForm'],
                    'ResendForm'       => $params['module.user.formMap.ResendForm'],
                    'SettingsForm'     => $params['module.user.formMap.SettingsForm'],
				],
                'queryMap' => [
					'AccountQuery' => $params['module.user.queryMap.AccountQuery'],
					'ProfileQuery' => $params['module.user.queryMap.ProfileQuery'],
					'TokenQuery'   => $params['module.user.queryMap.TokenQuery'],
					'UserQuery'    => $params['module.user.queryMap.UserQuery'],
				],
				'modelMap' => [
                    'AccountModel' => $params['module.user.modelMap.AccountModel'],
                    'ProfileModel' => $params['module.user.modelMap.ProfileModel'],
                    'TokenModel'   => $params['module.user.modelMap.TokenModel'],
                    'UserModel'    => $params['module.user.modelMap.UserModel'],
				],
				'searchMap' => [
                    'UserSearch'   => $params['module.user.searchMap.UserSearch'],
                ],
                'rememberFor' => $params['module.user.setting.rememberFor'],
                'theme' => $params['module.user.setting.theme'],
                'themeViewsLogin' => $params['module.user.setting.theme.view.security.login'],
                'themeViewsRegister' => $params['module.user.setting.theme.view.registration.register'],
                'themeViewsRequest' => $params['module.user.setting.theme.view.registration.request'],
                'themeViewsResend' => $params['module.user.setting.theme.view.registration.resend'],
                'tokenConfirmWithin' => $params['module.user.setting.tokenConfirmWithin'],
                'tokenRecoverWithin' => $params['module.user.setting.tokenRecoverWithin'],
                'urlPrefix' => $params['module.user.setting.urlPrefix'],
                'urlRules' => $params['module.user.setting.urlRules'],
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
    'mailer' => [
        '__class' => \Yiisoft\Yii\SwiftMailer\Mailer::class,
        'useFileTransport' => $params['mailer.useFileTransport'],
	],
    'translator' => [
        'translations' => [
            'ModuleUser' => [
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
