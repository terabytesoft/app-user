<?php

/**
 * AdminIndexAsset
 *
 * assets form
 **/

namespace app\user\assets;

use yii\web\AssetBundle;

class AdminIndexAsset extends AssetBundle
{
    public $sourcePath = '@app/user/assets/';

	public $css = [
		'css/admin_index.css',
    ];

	public $js = [
    ];

	public $depends = [
        \app\user\assets\FloatingLabelAsset::class,
		\yii\jquery\YiiAsset::class,
		\yii\bootstrap4\BootstrapAsset::class,
	];
}
