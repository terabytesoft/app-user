<?php

/**
 * RegistrationResendAsset
 *
 * assets form
 **/

namespace app\user\assets;

use yii\web\AssetBundle;

class RegistrationResendAsset extends AssetBundle
{
    public $sourcePath = '@app/user/assets/';

	public $css = [
		'css/registration_resend.css',
    ];

	public $js = [
    ];

	public $depends = [
        \app\user\assets\FloatingLabelAsset::class,
		\yii\jquery\YiiAsset::class,
		\yii\bootstrap4\BootstrapAsset::class,
	];
}
