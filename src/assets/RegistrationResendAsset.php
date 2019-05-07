<?php

/**
 * RegistrationResendAsset
 *
 * Assets Forms
 **/

namespace TerabyteSoft\Module\User\Assets;

use yii\web\AssetBundle;

class RegistrationResendAsset extends AssetBundle
{
    public $sourcePath = '@TerabyteSoft/Module/User/Assets/';

	public $css = [
		'Css/Registration_Resend.css',
    ];

	public $js = [
    ];

	public $depends = [
		\Yiisoft\Yii\JQuery\YiiAsset::class,
		\Yiisoft\Yii\Bootstrap4\BootstrapAsset::class,
	];
}
