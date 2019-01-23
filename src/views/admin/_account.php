<?php

/**
 * admin/_account
 *
 * Account Form
 *
 * View web application user
 **/


use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/**
 * @var \app\user\models\UserModel $user
 * @var \yii\web\View $this
 **/

$this->title = $this->app->t('user', 'Account Form');

?>

<?php $this->beginContent('@app/user/views/admin/update.php', ['user' => $user]) ?>

	<?= Html::tag('h2', '<b>' . Html::encode($this->title) . '</b>', ['class' => 'text-center']) ?>

	<?php $form = ActiveForm::begin([
		'id' => 'form-admin-account',
		'enableAjaxValidation' => true,
		'enableClientValidation' => false,
		'layout' => 'default',
		'options' => ['class' => 'form-profile'],
		'validateOnChange' => false,
		'validateOnBlur' => false,
		'validateOnType' => false,
	]) ?>

		<?= $this->render('_user', ['form' => $form, 'user' => $user]) ?>

		<?= Html::submitButton($this->app->t('user', 'Update'), [
			'class' => 'btn btn-block btn-lg btn-primary', 'tabindex' => '4',
		]) ?>

	<?php ActiveForm::end() ?>

<?php $this->endContent();
