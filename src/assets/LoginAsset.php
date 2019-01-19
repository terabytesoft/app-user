<?php

namespace app\user\assets;

use yii\web\AssetBundle;

/**
 * LoginAsset
 *
 * assets LoginForm
 **/
class LoginAsset extends AssetBundle
{
    public $sourcePath = '@app/user/assets/';

	public $css = [
		'css/login.css',
    ];

	public $js = [
    ];

	public $depends = [
		\yii\jquery\YiiAsset::class,
		\yii\bootstrap4\BootstrapAsset::class,
	];
}
