<?php

/**
 * RecoveryResetAsset
 *
 * Assets Forms
 **/

namespace TerabyteSoft\Module\User\Assets;

use yii\web\AssetBundle;

class RecoveryResetAsset extends AssetBundle
{
    public $sourcePath = '@Terabytesoft/Module/User/Assets/';

	public $css = [
		'Css/Recovery_Reset.css',
	];

	public $js = [
    ];

	public $depends = [
		\Yiisoft\Yii\JQuery\YiiAsset::class,
		\Yiisoft\Yii\Bootstrap4\BootstrapAsset::class,
	];
}
