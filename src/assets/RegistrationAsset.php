<?php

namespace app\user\assets;

use yii\web\AssetBundle;

/**
 * RegistrationAsset
 *
 * assets RegistrationForm
 **/
class RegistrationAsset extends AssetBundle
{
    public $sourcePath = '@app/user/assets/';

	public $css = [
		'css/register.css',
    ];

	public $js = [
    ];

	public $depends = [
		\yii\jquery\YiiAsset::class,
		\yii\bootstrap4\BootstrapAsset::class,
	];
}
