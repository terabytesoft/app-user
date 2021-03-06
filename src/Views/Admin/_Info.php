<?php

/**
 * admin/_info
 *
 * Info user
 *
 * View web application user
 **/

use Yiisoft\Yii\Bootstrap4\Html;

/**
 * @var \app\user\models\UserModel $user
 * @var \yii\web\View $this
 **/

$this->title = $this->app->t('ModuleUser', 'Information Details');

?>

<?php $this->beginContent('@TerabyteSoft/Module/User/Views/Admin/Update.php', ['user' => $user]) ?>

	<?= Html::beginTag(
		'div',
		[
			'id' => 'form-admin-info',
			'class' => 'd-flex flex-column justify-content-around mb-3',
		]
	) ?>

		<?= Html::tag('h2', '<b>' . Html::encode($this->title) . '</b>', ['class' => 'text-center']) ?>

		<?= Html::beginTag('div', ['class' => 'flex-fill p-2']) ?>
        	<strong><?= $this->app->t('ModuleUser', 'Registration time') ?>:</strong>
			<?= Html::beginTag('div', ['class' => 'alert alert-info', 'role' => 'alert']) ?>
        		<?= $this->app->t('ModuleUser', '{0, date, MMMM dd, YYYY HH:mm}', [$user->created_at]) ?>
			<?= Html::endTag('div') ?>
		<?= Html::endTag('div') ?>

    	<?php if ($user->registration_ip !== null) : ?>

			<?= Html::beginTag('div', ['class' => 'flex-fill p-2']) ?>
            	<strong><?= $this->app->t('ModuleUser', 'Registration IP') ?>:</strong>
				<?= Html::beginTag('div', ['class' => 'alert alert-info', 'role' => 'alert']) ?>
            		<?= $user->registration_ip ?>
				<?= Html::endTag('div') ?>
       		<?= Html::endTag('div') ?>

    	<?php endif ?>

		<?= Html::beginTag('div', ['class' => 'flex-fill p-2']) ?>
        	<strong><?= $this->app->t('ModuleUser', 'Confirmation status') ?>:</strong>
        	<?php if ($user->isConfirmed) : ?>
				<?= Html::beginTag('div', ['class' => 'alert alert-success', 'role' => 'alert']) ?>
                	<?= $this->app->t('ModuleUser', 'Confirmed at {0, date, MMMM dd, YYYY HH:mm}', [$user->confirmed_at]) ?>
				<?= Html::endTag('div') ?>
        	<?php else : ?>
				<?= Html::beginTag('div', ['class' => 'alert alert-danger', 'role' => 'alert']) ?>
            		<?= $this->app->t('ModuleUser', 'Unconfirmed') ?>
				<?= Html::endTag('div') ?>
        	<?php endif ?>
		<?= Html::endTag('div') ?>

		<?= Html::beginTag('div', ['class' => 'flex-fill p-2']) ?>
        	<strong><?= $this->app->t('ModuleUser', 'Block status') ?>:</strong>
        	<?php if ($user->isBlocked) : ?>
				<?= Html::beginTag('div', ['class' => 'alert alert-danger', 'role' => 'alert']) ?>
                	<?= $this->app->t('ModuleUser', 'Blocked at {0, date, MMMM dd, YYYY HH:mm}', [$user->blocked_at]) ?>
				<?= Html::endTag('div') ?>
        	<?php else : ?>
				<?= Html::beginTag('div', ['class' => 'alert alert-success', 'role' => 'alert']) ?>
					<?= $this->app->t('ModuleUser', 'Not blocked') ?>
				<?= Html::endTag('div') ?>
        	<?php endif ?>
		<?= Html::endTag('div') ?>

	<?= Html::endTag('div') ?>

<?php $this->endContent();
