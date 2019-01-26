<?php

/**
 * FloatingLabelAsset
 *
 * assets form
 **/

namespace app\user\assets;

use yii\web\AssetBundle;

class FloatingLabelAsset extends AssetBundle
{
    public $sourcePath = '@app/user/assets/';

	public $css = [
		'css/floating_labels.css',
    ];

	public $js = [
    ];

	public $depends = [
		\yii\jquery\YiiAsset::class,
		\yii\bootstrap4\BootstrapAsset::class,
	];
}
