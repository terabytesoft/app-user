<?php

namespace app\user\assets;

use yii\web\AssetBundle;

/**
 * UserAsset
 *
 * assets UserForm
 **/
class UserAsset extends AssetBundle
{
    public $sourcePath = '@app/user/assets/';

	public $css = [
		'css/register.css',
    ];

	public $js = [
    ];

	public $depends = [
		\yii\jquery\YiiAsset::class,
		\yii\bootstrap4\BootstrapAsset::class,
	];
}
