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
        \app\user\assets\FloatingLabelAsset::class,
		\yii\jquery\YiiAsset::class,
		\yii\bootstrap4\BootstrapAsset::class,
	];
}
