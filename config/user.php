<?php

return [
    // module user - settings:
    'user.setting.accountAdmins' => ['admin'],
    'user.setting.accountDelete' => false,
    'user.setting.accountConfirmation' => true,
    'user.setting.accountGeneratingPassword' => false,
    'user.setting.accountImpersonateUser' => true,
    'user.setting.accountPasswordRecovery' => true,
    'user.setting.accountRegistration' => true,
    'user.setting.accountUnconfirmedLogin' => true,
    'user.setting.cost' => 10,
    'user.setting.debug' => false,
    'user.setting.emailChangeStrategy' => \TerabyteSoft\Module\User\Module::STRATEGY_DEFAULT,
    'user.setting.floatLabels' => false,
    'user.setting.rememberFor' => 1209600,
    'user.setting.theme' => false,
    'user.setting.theme.layout' => 'Main.php',
    'user.setting.theme.view.security.login' => '',
    'user.setting.theme.view.registration.register' => '',
    'user.setting.theme.view.registration.request' => '',
    'user.setting.theme.view.registration.resend' => '',
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
    'user.formMap.LoginForm' => \TerabyteSoft\Module\User\Forms\LoginForm::class,
    'user.formMap.RecoveryForm' => \TerabyteSoft\Module\User\Forms\RecoveryForm::class,
    'user.formMap.RegistrationForm' => \TerabyteSoft\Module\User\Forms\RegistrationForm::class,
    'user.formMap.ResendForm' => \TerabyteSoft\Module\User\Forms\ResendForm::class,
    'user.formMap.SettingsForm' => \TerabyteSoft\Module\User\Forms\SettingsForm::class,
    // module user - query map models:
    'user.queryMap.AccountQuery' => \TerabyteSoft\Module\User\Querys\AccountQuery::class,
    'user.queryMap.ProfileQuery' => \TerabyteSoft\Module\User\Querys\ProfileQuery::class,
    'user.queryMap.TokenQuery' => \TerabyteSoft\Module\User\Querys\TokenQuery::class,
    'user.queryMap.UserQuery' => \TerabyteSoft\Module\User\Querys\UserQuery::class,
    // module user - map models:
    'user.modelMap.AccountModel' => \TerabyteSoft\Module\User\Models\AccountModel::class,
    'user.modelMap.ProfileModel' => \TerabyteSoft\Module\User\Models\ProfileModel::class,
    'user.modelMap.TokenModel' => \TerabyteSoft\Module\User\Models\TokenModel::class,
    'user.modelMap.UserModel' => \TerabyteSoft\Module\User\Models\UserModel::class,
    // module user - search map models:
    'user.searchMap.UserSearch' => \TerabyteSoft\Module\User\Searchs\UserSearch::class,
];
