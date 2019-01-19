<?php

namespace app\user\assets;

use yii\web\AssetBundle;

/**
 * ResetAsset
 *
 * assets ResetForm
 **/
class ResetAsset extends AssetBundle
{
    public $sourcePath = '@app/user/assets/';

	public $css = [
		'css/reset.css',
    ];

	public $js = [
    ];

	public $depends = [
		\yii\jquery\YiiAsset::class,
		\yii\bootstrap4\BootstrapAsset::class,
	];
}
