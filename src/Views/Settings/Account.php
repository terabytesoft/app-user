<?php

/**
 * Account
 **/

use Yiisoft\Yii\Bootstrap4\ActiveForm;
use Yiisoft\Yii\Bootstrap4\Html;

/**
 * @var \TerabyteSoft\Module\User\Form\SettingsForm $model
 * @var \Yiisoft\Yii\Bootstrap4\ActiveForm $form
 * @var \yii\web\View $this
 **/

$this->title = $this->app->t('ModuleUser', 'Account Form');
$this->params['breadcrumbs'][] = $this->title;

?>

<?= Html::beginTag('div', ['class' => 'row']) ?>

	<?= Html::beginTag('div', ['class' => 'col-md-3']) ?>
        <?= $this->render('_Menu') ?>
	<?= Html::endTag('div') ?>

	<?= Html::beginTag('div', ['class' => 'col-md-9']) ?>

		<?= Html::tag('h2', '<b>' . Html::encode($this->title) . '</b>', ['class' => 'text-center']) ?>

        <?php $form = ActiveForm::begin([
            'id' => 'form-settings-account',
			'layout' => 'default',
        	'enableAjaxValidation' => true,
        	'enableClientValidation' => false,
			'options' => ['class' => 'form-settings-account'],
			'validateOnBlur' => false,
			'validateOnType' => false,
        	'validateOnChange' => false,
        ]) ?>


			<?= $form->field($model, 'email')
				->textInput([
					'tabindex' => '1',
				])
				->label($this->app->t('ModuleUser', 'Email'))
			?>

        	<?= $form->field($model, 'username')
				->textInput([
					'tabindex' => '2',
				])
				->label($this->app->t('ModuleUser', 'Username'))
			?>

			<?= $form->field($model, 'new_password')
				->passwordInput([
					'tabindex' => '3',
				])
				->label($this->app->t('ModuleUser', 'New Password'))
			?>

        	<?= $form->field($model, 'current_password')
				->passwordInput([
					'tabindex' => '4',
				])
				->label($this->app->t('ModuleUser', 'Current Password'))
			?>

			<?= Html::submitButton($this->app->t('ModuleUser', 'Save'), [
				'class' => 'btn btn-block btn-lg btn-primary', 'name' => 'account-button', 'tabindex' => '5',
	    	]); ?>

		<?php ActiveForm::end() ?>

	<?= Html::endTag('div') ?>

<?php echo Html::endTag('div');
