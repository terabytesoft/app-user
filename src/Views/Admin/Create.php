<?php

/**
 * admin/create
 *
 * Create user
 *
 * View web application user
 **/

use Yiisoft\Yii\Bootstrap4\ActiveForm;
use Yiisoft\Yii\Bootstrap4\Html;
use Yiisoft\Yii\Bootstrap4\Nav;

/**
 * @var \TerabyteSoft\Module\User\Models\UserModel $user
 * @var \yii\web\View $this
 **/

$this->title = $this->app->t('user', 'Create a user account');
$this->params['breadcrumbs'][] = ['label' => $this->app->t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('_Menu') ?>

<?= Html::beginTag('div', ['class' => 'row']) ?>

	<?= Html::beginTag('div', ['class' => 'col-md-3']) ?>

		<?= Html::beginTag('h5', ['class' => 'text-center']) ?>

			<?= $this->app->t('user', 'Menu Settings') ?>

		<?= Html::endTag('h5') ?>

            <?= Nav::widget([
                'options' => [
					'id' => 'menu-admin-create',
					'aria-orientation' => 'vertical',
					'class' => 'flex-column nav nav-pills',
					'role'=> 'tablist',
                ],
                'items' => [
                    [
						'label' => $this->app->t('user', 'Account'),
						'url' => ['/user/admin/create']
					],
                    [
						'label' => $this->app->t('user', 'Profile'),
						'options' => [
                           	'class' => 'disabled',
                           	'onclick' => 'return false;',
						]
					],
					['label' => $this->app->t('user', 'Information'),
						'options' => [
                           	'class' => 'disabled',
                           	'onclick' => 'return false;',
						]
					],
                ],
            ]) ?>

	<?= Html::endTag('div') ?>

	<?= Html::beginTag('div', ['class' => 'col-md-9']) ?>

		<?= Html::beginTag('div', ['class' => 'alert alert-info', 'role' => 'alert']) ?>
            <?= $this->app->t('user', 'Credentials will be sent to the user by email') ?>.
            <?= $this->app->t('user', 'A password will be generated automatically if not provided') ?>.
		<?= Html::endTag('div') ?>

        <?php $form = ActiveForm::begin([
			'id' => 'form-admin-create',
			'enableAjaxValidation' => true,
			'enableClientValidation' => false,
			'layout' => 'default',
			'options' => ['class' => 'form-profile'],
			'validateOnChange' => false,
			'validateOnBlur' => false,
			'validateOnType' => false,
		]) ?>

        	<?= $this->render('_User', ['form' => $form, 'user' => $user]) ?>

			<?= Html::submitButton($this->app->t('user', 'Save'), [
				'class' => 'btn btn-block btn-lg btn-primary', 'tabindex' => '4',
			]) ?>

    	<?php ActiveForm::end() ?>

	<?= Html::endTag('div') ?>

<?php echo Html::endTag('div');
