<?php

namespace app\user\assets;

use yii\web\AssetBundle;

/**
 * RequestAsset
 *
 * assets RequestForm
 **/
class RequestAsset extends AssetBundle
{
    public $sourcePath = '@app/user/assets/';

	public $css = [
		'css/request.css',
    ];

	public $js = [
    ];

	public $depends = [
		\yii\jquery\YiiAsset::class,
		\yii\bootstrap4\BootstrapAsset::class,
	];
}
