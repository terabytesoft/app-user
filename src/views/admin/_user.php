<?php

/**
 * admin/_user
 *
 * User form
 *
 * View web application user
 **/

/**
 * @var \app\user\models\UserModel $user
 * @var \yii\widgets\ActiveForm $form
 **/

?>

<?= $form->field($user, 'email')
	->textInput([
		'tabindex' => '1',
	])
	->label($this->app->t('user', 'Email'))
?>

<?= $form->field($user, 'username')
	->textInput([
		'tabindex' => '2',
	])
	->label($this->app->t('user', 'Username'))
?>

<?php echo $form->field($user, 'password')
	->passwordInput([
		'tabindex' => '3',
	])
	->label($this->app->t('user', 'New Password'));
