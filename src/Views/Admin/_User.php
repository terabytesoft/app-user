<?php

/**
 * admin/_user
 *
 * User form
 *
 * View web application user
 **/

/**
 * @var \TerabyteSoft\Module\User\Models\UserModel $user
 * @var \Yiisoft\Yii\Bootstrap4\ActiveForm $form
 **/

?>

<?= $form->field($user, 'email')
	->textInput([
		'tabindex' => '1',
	])
	->label($this->app->t('ModuleUser', 'Email'))
?>

<?= $form->field($user, 'username')
	->textInput([
		'tabindex' => '2',
	])
	->label($this->app->t('ModuleUser', 'Username'))
?>

<?php echo $form->field($user, 'password')
	->passwordInput([
		'tabindex' => '3',
	])
	->label($this->app->t('ModuleUser', 'New Password'));
