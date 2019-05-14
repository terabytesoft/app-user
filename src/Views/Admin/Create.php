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

$this->title = $this->app->t('ModuleUser', 'Create a user account');
$this->params['breadcrumbs'][] = ['label' => $this->app->t('ModuleUser', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('_Menu') ?>

<?= Html::beginTag('div', ['class' => 'row']) ?>

	<?= Html::beginTag('div', ['class' => 'col-md-3']) ?>

		<?= Html::beginTag('h5', ['class' => 'text-center']) ?>

			<?= $this->app->t('ModuleUser', 'Menu Settings') ?>

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
						'label' => $this->app->t('ModuleUser', 'Account'),
						'url' => ['/user/admin/create']
					],
                    [
						'label' => $this->app->t('ModuleUser', 'Profile'),
						'options' => [
                           	'class' => 'disabled',
                           	'onclick' => 'return false;',
						]
					],
					['label' => $this->app->t('ModuleUser', 'Information'),
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
            <?= $this->app->t('ModuleUser', 'Credentials will be sent to the user by email') ?>.
            <?= $this->app->t('ModuleUser', 'A password will be generated automatically if not provided') ?>.
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

			<?= Html::submitButton($this->app->t('ModuleUser', 'Save'), [
				'class' => 'btn btn-block btn-lg btn-primary', 'tabindex' => '4',
			]) ?>

    	<?php ActiveForm::end() ?>

	<?= Html::endTag('div') ?>

<?php echo Html::endTag('div');
