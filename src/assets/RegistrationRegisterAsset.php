<?php

/**
 * RegistrationRegisterAsset
 *
 * assets form
 **/

namespace app\user\assets;

use yii\web\AssetBundle;

class RegistrationRegisterAsset extends AssetBundle
{
    public $sourcePath = '@app/user/assets/';

	public $css = [
		'css/registration_register.css',
    ];

	public $js = [
    ];

	public $depends = [
		\yii\jquery\YiiAsset::class,
		\yii\bootstrap4\BootstrapAsset::class,
	];
}
