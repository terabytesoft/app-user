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
    public $sourcePath = '@TerabyteSoft/Module/User/Assets/';

	public $css = [
		'Css/Admin_Index.css',
    ];

	public $js = [
    ];

	public $depends = [
		\Yiisoft\Yii\JQuery\YiiAsset::class,
		\Yiisoft\Yii\Bootstrap4\BootstrapAsset::class,
	];
}
