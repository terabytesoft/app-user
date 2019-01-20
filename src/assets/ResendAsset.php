<?php

namespace app\user\assets;

use yii\web\AssetBundle;

/**
 * ResendAsset
 *
 * assets ResendForm
 **/
class ResendAsset extends AssetBundle
{
    public $sourcePath = '@app/user/assets/';

	public $css = [
		'css/resend.css',
    ];

	public $js = [
    ];

	public $depends = [
		\yii\jquery\YiiAsset::class,
		\yii\bootstrap4\BootstrapAsset::class,
	];
}