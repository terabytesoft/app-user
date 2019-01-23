<?php

/**
 * admin/_profile
 *
 * Profile Form
 *
 * View web application user
 **/

use app\user\helpers\TimeZoneHelper;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;

/**
 * @var \app\user\models\ProfileModel $profile
 * @var \app\user\models\UserModel $user
 * @var yii\web\View $this
 **/

$timezoneHelper = new TimeZoneHelper();

$this->title = $this->app->t('user', 'Profile Form');

?>

<?php $this->beginContent('@app/user/views/admin/update.php', ['user' => $user]) ?>

	<?= Html::tag('h2', '<b>' . Html::encode($this->title) . '</b>', ['class' => 'text-center']) ?>

	<?php $form = ActiveForm::begin([
		'id' => 'form-admin-profile',
		'layout' => 'default',
		'enableAjaxValidation' => true,
		'enableClientValidation' => false,
		'options' => ['class' => 'form-profile'],
		'validateOnBlur' => false,
		'validateOnType' => false,
		'validateOnChange' => false,
	]) ?>

		<?= $form->field($profile, 'name')
			->textInput([
				'tabindex' => '1',
			])
			->label($this->app->t('user', 'Name'))
		?>

		<?= $form->field($profile, 'public_email')
			->textInput([
		   		'tabindex' => '2',
			])
			->label($this->app->t('user', 'Email - (Public)'))
		?>

		<?= $form->field($profile, 'website')
			->textInput([
				'tabindex' => '3',
			])
			->label($this->app->t('user', 'Website'))
		?>

		<?= $form->field($profile, 'location')
			->textInput([
				'tabindex' => '4',
			])
			->label($this->app->t('user', 'Location'))
		?>

		<?= $form->field($profile, 'timezone')
			->dropDownList(
				ArrayHelper::map(
					$timezoneHelper->getAll(),
					'timezone',
					'name'
				),
				[
					'tabindex' => '5',
				]
			)
			->label($this->app->t('user', 'Time Zone'))
		?>

		<?= $form->field($profile, 'gravatar_email')
			->textInput([
				'tabindex' => '6',
			])
			->label($this->app->t('user', 'Gravatar Email'))
			->hint(Html::a($this->app->t('user', 'Change your avatar at Gravatar.com'), 'http://gravatar.com'))
		?>

		<?= $form->field($profile, 'bio')->textarea([
				'tabindex' => '7',
			])
			->label($this->app->t('user', 'Bio'))
		?>

		<?= Html::submitButton($this->app->t('user', 'Update'), [
			'class' => 'btn btn-lg btn-primary btn-block', 'tabindex' => '8',
		]) ?>

	<?php ActiveForm::end() ?>

<?php $this->endContent();
