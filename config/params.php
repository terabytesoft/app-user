<?php

return [
    // aplication:
	'app.id' => 'my-project-user',
    'app.name' => 'My Project Basic',
    // db:
    'db.dns' => 'mysql:host=localhost;dbname=app_user;charset=utf8',
    'db.username' => 'root',
    'db.password' => '',
    // debug:
    'debug.allowedIPs' => ['127.0.0.1', '::1', '*'],
    // mailer:
    'mailer.useFileTransport' => true,
    // module user - settings:
    'user.setting.accountAdmins' => ['admin'],
    'user.setting.accountDelete' => false,
    'user.setting.accountConfirmation' => true,
    'user.setting.accountGeneratingPassword' => true,
    'user.setting.accountImpersonateUser' => true,
    'user.setting.accountPasswordRecovery' => false,
    'user.setting.accountRegistration' => false,
    'user.setting.accountUnconfirmedLogin' => false,
    'user.setting.cost' => 10,
    'user.setting.debug' => false,
    'user.setting.emailChangeStrategy' => \app\user\Module::STRATEGY_DEFAULT,
    'user.setting.floatLabels' => false,
    'user.setting.rememberFor' => 1209600,
    'user.setting.tokenConfirmWithin' => 86400,
    'user.setting.tokenRecoverWithin' => 21600,
    'user.setting.urlPrefix' => 'user',
    'user.setting.urlRules' => [
        '<id:\d+>'                               => 'profile/show',
        '<action:(login|logout|auth)>'           => 'security/<action>',
        '<action:(register|resend)>'             => 'registration/<action>',
        'confirm/<id:\d+>/<code:[A-Za-z0-9_-]+>' => 'registration/confirm',
        'forgot'                                 => 'recovery/request',
        'recover/<id:\d+>/<code:[A-Za-z0-9_-]+>' => 'recovery/reset',
        'settings/<action:\w+>'                  => 'settings/<action>',
    ],
    // module user - form map models:
    'user.formMap.LoginForm' => \app\user\forms\LoginForm::class,
    'user.formMap.RecoveryForm' => \app\user\forms\RecoveryForm::class,
    'user.formMap.RegistrationForm' => \app\user\forms\RegistrationForm::class,
    'user.formMap.ResendForm' => \app\user\forms\ResendForm::class,
    'user.formMap.SettingsForm' => \app\user\forms\SettingsForm::class,
    // module user - query map models:
    'user.queryMap.AccountQuery' => \app\user\querys\AccountQuery::class,
    'user.queryMap.ProfileQuery' => \app\user\querys\ProfileQuery::class,
    'user.queryMap.TokenQuery' => \app\user\querys\TokenQuery::class,
    'user.queryMap.UserQuery' => \app\user\querys\UserQuery::class,
    // module user - map models:
    'user.modelMap.AccountModel' => \app\user\models\AccountModel::class,
    'user.modelMap.ProfileModel' => \app\user\models\ProfileModel::class,
    'user.modelMap.TokenModel' => \app\user\models\TokenModel::class,
    'user.modelMap.UserModel' => \app\user\models\UserModel::class,
    // module user - search map models:
    'user.searchMap.UserSearch' => \app\user\searchs\UserSearch::class,
    // translator:
    'i18n.locale' => 'en',
    'i18n.encoding' => 'UTF-8',
    'translator.basePath' => '@app/user/messages',
    'translator.sourceLanguage' => 'en',
];
