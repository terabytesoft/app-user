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
    public $sourcePath = __DIR__ . '/Css';

	public $css = [
		'Register.css',
    ];

	public $js = [
    ];

	public $depends = [
		\Yiisoft\Yii\JQuery\YiiAsset::class,
		\Yiisoft\Yii\Bootstrap4\BootstrapAsset::class,
	];
}
