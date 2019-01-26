<?php

/**
 * index
 *
 * View web application user
 **/

use app\user\tests\assets\LayoutAdminAsset;
use yii\bootstrap4\Html;

LayoutAdminAsset::register($this);

$this->title = $this->app->t('user', 'Index');

?>

	<?= Html::tag('h1', $this->app->t('user', 'Congratulations'), ['class' => 'text-center']) ?>

	<?= Html::beginTag('p', ['class' => 'text-center']) ?>
		<?= $this->app->t('user', 'Flexible user registration and authentication module for Yii3') ?>
	<?= Html::endTag('p') ?>
