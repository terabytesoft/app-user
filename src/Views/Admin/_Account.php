<?php

/**
 * Admin/_Account
 *
 * _Account Form
 *
 * View web application user
 **/

use Yiisoft\Yii\Bootstrap4\ActiveForm;
use Yiisoft\Yii\Bootstrap4\Html;

/**
 * @var \TerabyteSoft\Module\User\Models\UserModel $user
 * @var \yii\web\View $this
 **/

$this->title = $this->app->t('user', 'Account Form');

?>

<?php $this->beginContent('@TerabyteSoft/Module/User/Views/Admin/Update.php', ['user' => $user]) ?>

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

		<?= $this->render('_User', ['form' => $form, 'user' => $user]) ?>

		<?= Html::submitButton($this->app->t('user', 'Update'), [
			'class' => 'btn btn-block btn-lg btn-primary', 'tabindex' => '4',
		]) ?>

	<?php ActiveForm::end() ?>

<?php $this->endContent();
