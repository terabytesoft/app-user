<?php

/**
 * admin/_profile
 *
 * Profile Form
 *
 * View web application user
 **/

use TerabyteSoft\Module\User\Helpers\TimeZoneHelper;
use Yiisoft\Yii\Bootstrap4\ActiveForm;
use Yiisoft\Yii\Bootstrap4\Html;
use Yiisoft\Arrays\ArrayHelper;

/**
 * @var \TerabyteSoft\Module\User\Models\ProfileModel $profile
 * @var \TerabyteSoft\Module\User\Models\UserModel $user
 * @var yii\web\View $this
 **/

$timezoneHelper = new TimeZoneHelper();

$this->title = $this->app->t('ModuleUser', 'Profile Form');

?>

<?php $this->beginContent('@TerabyteSoft/Module/User/Views/Admin/Update.php', ['user' => $user]) ?>

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
			->label($this->app->t('ModuleUser', 'Name'))
		?>

		<?= $form->field($profile, 'public_email')
			->textInput([
		   		'tabindex' => '2',
			])
			->label($this->app->t('ModuleUser', 'Email - (Public)'))
		?>

		<?= $form->field($profile, 'website')
			->textInput([
				'tabindex' => '3',
			])
			->label($this->app->t('ModuleUser', 'Website'))
		?>

		<?= $form->field($profile, 'location')
			->textInput([
				'tabindex' => '4',
			])
			->label($this->app->t('ModuleUser', 'Location'))
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
			->label($this->app->t('ModuleUser', 'Time Zone'))
		?>

		<?= $form->field($profile, 'gravatar_email')
			->textInput([
				'tabindex' => '6',
			])
			->label($this->app->t('ModuleUser', 'Gravatar Email'))
			->hint(Html::a($this->app->t('ModuleUser', 'Change your avatar at Gravatar.com'), 'http://gravatar.com'))
		?>

		<?= $form->field($profile, 'bio')->textarea([
				'tabindex' => '7',
			])
			->label($this->app->t('ModuleUser', 'Bio'))
		?>

		<?= Html::submitButton($this->app->t('ModuleUser', 'Update'), [
			'class' => 'btn btn-lg btn-primary btn-block', 'tabindex' => '8',
		]) ?>

	<?php ActiveForm::end() ?>

<?php $this->endContent();
