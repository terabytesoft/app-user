<?php

/**
 * LayoutAdminAsset
 *
 * assets form
 **/

namespace TerabyteSoft\Module\User\Tests\Assets;

use yii\web\AssetBundle;

class LayoutAdminAsset extends AssetBundle
{
    public $sourcePath = '@TerabyteSoft/Module/User/Tests/Assets/';

	public $css = [
		'Css/Main.css',
    ];

	public $depends = [
        \Yiisoft\Yii\JQuery\YiiAsset::class,
        \Yiisoft\Yii\Bootstrap4\BootstrapAsset::class,
    ];

    public $publishOptions = [
        'only' => [
            'Css/*',
        ],
    ];
}
