<?php

return [
    'assetManager' => [
        'appendTimestamp' => true,
    ],
    'request' => [
        'enableCookieValidation' => false,
        // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
        'cookieValidationKey' => '',
	],
    'urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName' => false,
    ],
	'user' => [
        'identityClass' => app\user\models\UserModel::class,
	],
];
