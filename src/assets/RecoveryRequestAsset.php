<?php

/**
 * RecoveryRequestAsset
 *
 * Assets Forms
 **/

namespace TerabyteSoft\Module\User\Assets;

use yii\web\AssetBundle;

class RecoveryRequestAsset extends AssetBundle
{
    public $sourcePath = '@TerabyteSoft/Module/User/Assets/';

	public $css = [
		'Css/Recovery_Request.css',
    ];

	public $js = [
    ];

	public $depends = [
		\Yiisoft\Yii\JQuery\YiiAsset::class,
		\Yiisoft\Yii\Bootstrap4\BootstrapAsset::class,
	];
}
