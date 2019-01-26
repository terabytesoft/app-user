<?php

/**
 * RecoveryResetAsset
 *
 * assets form
 **/

namespace app\user\assets;

use yii\web\AssetBundle;

class RecoveryResetAsset extends AssetBundle
{
    public $sourcePath = '@app/user/assets/';

	public $css = [
		'css/recovery_reset.css',
	];

	public $js = [
    ];

	public $depends = [
		\yii\jquery\YiiAsset::class,
		\yii\bootstrap4\BootstrapAsset::class,
	];
}
