<?php

/**
 * LayoutAdminAsset
 *
 * assets form
 **/

namespace app\user\tests\assets;

use yii\web\AssetBundle;

class LayoutAdminAsset extends AssetBundle
{
    public $sourcePath = '@app/user/tests/assets/';

	public $css = [
		'css/cover.css',
    ];

	public $depends = [
		\yii\jquery\YiiAsset::class,
		\yii\bootstrap4\BootstrapAsset::class,
	];
}
