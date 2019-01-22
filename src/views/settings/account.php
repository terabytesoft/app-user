<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var app\user\models\SettingsForm $model
 */

$this->title = $this->getApp()->t('user', 'Account settings');
$this->params['breadcrumbs'][] = $this->title;

?>

<?= Html::beginTag('div', ['class' => 'row']) ?>
	<?= Html::beginTag('div', ['class' => 'col-md-3']) ?>
        <?= $this->render('_menu') ?>
	<?= Html::endTag('div') ?>
	<?= Html::beginTag('div', ['class' => 'col-md-9']) ?>
		<?= Html::tag('h2', '<b>' . Html::encode($this->title) . '</b>', ['class' => 'text-center']) ?>

        <?php $form = ActiveForm::begin([
            'id' => 'account-form',
			'layout' => 'default',
        	'enableAjaxValidation' => true,
        	'enableClientValidation' => false,
			'options' => ['class' => 'form-profile'],
			'validateOnBlur' => false,
			'validateOnType' => false,
        	'validateOnChange' => false,
        ]); ?>


			<?= $form->field($model, 'email')
				->textInput([
					'tabindex' => '1',
				])
				->label($this->app->t('user', 'Email'))
			?>

        	<?= $form->field($model, 'username')
				->textInput([
					'tabindex' => '2',
				])
				->label($this->app->t('user', 'Username'))
			?>

			<?= $form->field($model, 'new_password')
				->passwordInput([
					'tabindex' => '3',
				])
				->label($this->app->t('user', 'New Password'))
			?>

        	<?= $form->field($model, 'current_password')
				->passwordInput([
					'tabindex' => '4',
				])
				->label($this->app->t('user', 'Current Password'))
			?>

			<?= Html::submitButton($this->app->t('user', 'Save'), [
				'class' => 'btn btn-lg btn-primary btn-block', 'name' => 'account-save-button', 'tabindex' => '5',
	    	]); ?>

		<?php ActiveForm::end(); ?>

	<?= Html::endTag('div') ?>
<?php echo Html::endTag('div');
