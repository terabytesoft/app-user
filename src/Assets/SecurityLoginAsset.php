<?php

/**
 * SecurityLoginAsset
 *
 * Assets Forms
 **/

namespace TerabyteSoft\Module\User\Assets;

use yii\web\AssetBundle;

class SecurityLoginAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/Css';

	public $css = [
		'Login.css',
    ];

	public $js = [
    ];

	public $depends = [
		\Yiisoft\Yii\JQuery\YiiAsset::class,
		\Yiisoft\Yii\Bootstrap4\BootstrapAsset::class,
	];
}
