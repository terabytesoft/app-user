<?php

/**
 * AdminIndexAsset
 *
 * Assets Forms
 **/

namespace Terabytesoft\Module\User\Assets;

use yii\web\AssetBundle;

class AdminIndexAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/Css';

	public $css = [
		'Admin.css',
    ];

	public $js = [
    ];

	public $depends = [
		\Yiisoft\Yii\JQuery\YiiAsset::class,
		\Yiisoft\Yii\Bootstrap4\BootstrapAsset::class,
	];
}
