<?php

/**
 * LayoutAdminAsset
 *
 * assets form
 **/

namespace app\user\assets;

use yii\web\AssetBundle;

class LayoutAdminAsset extends AssetBundle
{
    public $sourcePath = '@app/user/assets/';

	public $css = [
		'css/layout_main.css',
    ];

	public $js = [
    ];

	public $depends = [
		\yii\jquery\YiiAsset::class,
		\yii\bootstrap4\BootstrapAsset::class,
	];
}
