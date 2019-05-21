<?php

return [
    // module user - settings:
    'module.user.setting.accountAdmins' => ['admin'],
    'module.user.setting.accountDelete' => false,
    'module.user.setting.accountConfirmation' => true,
    'module.user.setting.accountGeneratingPassword' => false,
    'module.user.setting.accountImpersonateUser' => true,
    'module.user.setting.accountPasswordRecovery' => true,
    'module.user.setting.accountRegistration' => true,
    'module.user.setting.accountUnconfirmedLogin' => true,
    'module.user.setting.cost' => 10,
    'module.user.setting.debug' => false,
    'module.user.setting.emailChangeStrategy' => \TerabyteSoft\Module\User\Module::STRATEGY_DEFAULT,
    'module.user.setting.floatLabels' => false,
    'module.user.setting.rememberFor' => 1209600,
    'module.user.setting.theme' => false,
    'module.user.setting.theme.layout' => 'Main.php',
    'module.user.setting.theme.view.security.login' => '',
    'module.user.setting.theme.view.registration.register' => '',
    'module.user.setting.theme.view.registration.request' => '',
    'module.user.setting.theme.view.registration.resend' => '',
    'module.user.setting.tokenConfirmWithin' => 86400,
    'module.user.setting.tokenRecoverWithin' => 21600,
    'module.user.setting.urlPrefix' => 'user',
    'module.user.setting.urlRules' => [
        '<id:\d+>'                               => 'profile/show',
        '<action:(login|logout|auth)>'           => 'security/<action>',
        '<action:(register|resend)>'             => 'registration/<action>',
        'confirm/<id:\d+>/<code:[A-Za-z0-9_-]+>' => 'registration/confirm',
        'forgot'                                 => 'recovery/request',
        'recover/<id:\d+>/<code:[A-Za-z0-9_-]+>' => 'recovery/reset',
        'settings/<action:\w+>'                  => 'settings/<action>',
    ],
    // module user - form map models:
    'module.user.formMap.LoginForm' => \TerabyteSoft\Module\User\Forms\LoginForm::class,
    'module.user.formMap.RecoveryForm' => \TerabyteSoft\Module\User\Forms\RecoveryForm::class,
    'module.user.formMap.RegistrationForm' => \TerabyteSoft\Module\User\Forms\RegistrationForm::class,
    'module.user.formMap.ResendForm' => \TerabyteSoft\Module\User\Forms\ResendForm::class,
    'module.user.formMap.SettingsForm' => \TerabyteSoft\Module\User\Forms\SettingsForm::class,
    // module user - query map models:
    'module.user.queryMap.AccountQuery' => \TerabyteSoft\Module\User\Querys\AccountQuery::class,
    'module.user.queryMap.ProfileQuery' => \TerabyteSoft\Module\User\Querys\ProfileQuery::class,
    'module.user.queryMap.TokenQuery' => \TerabyteSoft\Module\User\Querys\TokenQuery::class,
    'module.user.queryMap.UserQuery' => \TerabyteSoft\Module\User\Querys\UserQuery::class,
    // module user - map models:
    'module.user.modelMap.AccountModel' => \TerabyteSoft\Module\User\Models\AccountModel::class,
    'module.user.modelMap.ProfileModel' => \TerabyteSoft\Module\User\Models\ProfileModel::class,
    'module.user.modelMap.TokenModel' => \TerabyteSoft\Module\User\Models\TokenModel::class,
    'module.user.modelMap.UserModel' => \TerabyteSoft\Module\User\Models\UserModel::class,
    // module user - search map models:
    'module.user.searchMap.UserSearch' => \TerabyteSoft\Module\User\Searchs\UserSearch::class,
];
