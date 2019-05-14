<?php

/**
 * ProfileShowAsset
 *
 * Assets Forms
 **/

namespace TerabyteSoft\Module\User\Assets;

use yii\web\AssetBundle;

class ProfileShowAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/Css';

	public $css = [
		'Profile.css',
    ];

	public $js = [
    ];

	public $depends = [
        \TerabyteSoft\Assets\Fontawesome\Dev\Css\NpmSolidAsset::class,
		\Yiisoft\Yii\Bootstrap4\BootstrapAsset::class,
    ];
}
