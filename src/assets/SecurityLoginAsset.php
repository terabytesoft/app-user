<?php

/**
 * SecurityLoginAsset
 *
 * assets form
 **/

namespace app\user\assets;

use yii\web\AssetBundle;

class SecurityLoginAsset extends AssetBundle
{
    public $sourcePath = '@app/user/assets/';

	public $css = [
		'css/security_login.css',
    ];

	public $js = [
    ];

	public $depends = [
		\yii\jquery\YiiAsset::class,
		\yii\bootstrap4\BootstrapAsset::class,
	];
}
