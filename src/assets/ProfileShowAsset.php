<?php

/**
 * ProfileShowAsset
 *
 * assets form
 **/

namespace app\user\assets;

use yii\web\AssetBundle;

class ProfileShowAsset extends AssetBundle
{
    public $sourcePath = '@app/user/assets/';

	public $css = [
		'css/profile_show.css',
    ];

	public $js = [
    ];

	public $depends = [
        \assets\fontawesome\dev\css\NpmSolidAsset::class,
		\yii\bootstrap4\BootstrapAsset::class,
    ];

    public $publishOptions = [
        'only' => [
            'css/*',
        ],
    ];
}
