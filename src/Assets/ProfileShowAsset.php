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
    public $sourcePath = '@TerabyteSoft/Module/User/Assets/';

	public $css = [
		'Css/Profile_Show.css',
    ];

	public $js = [
    ];

	public $depends = [
        \TerabyteSoft\Assets\Fontawesome\Dev\Css\NpmSolidAsset::class,
		\Yiisoft\Yii\Bootstrap4\BootstrapAsset::class,
    ];

    public $publishOptions = [
        'only' => [
            'css/*',
        ],
    ];
}
