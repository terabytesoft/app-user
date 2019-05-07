<?php

/**
 * RegistrationRegisterAsset
 *
 * Assets Forms
 **/

namespace TerabyteSoft\Module\User\Assets;

use yii\web\AssetBundle;

class RegistrationRegisterAsset extends AssetBundle
{
    public $sourcePath = '@TerabyteSoft/Module/User/Assets/';

	public $css = [
		'Css/Registration_Register.css',
    ];

	public $js = [
    ];

	public $depends = [
		\Yiisoft\Yii\JQuery\YiiAsset::class,
		\Yiisoft\Yii\Bootstrap4\BootstrapAsset::class,
	];
}
