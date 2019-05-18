<?php

/**
 * settings/profile
 *
 * Profile form
 *
 * View web application user
 **/

use TerabyteSoft\Module\User\Helpers\TimeZoneHelper;
use Yiisoft\Yii\Bootstrap4\ActiveForm;
use Yiisoft\Yii\Bootstrap4\Html;
use Yiisoft\Arrays\ArrayHelper;

/**
 * @var TimeZoneHelper $timezoneHelper
 * @var \TerabyteSoft\Module\User\Models\ProfileModel $model
 * @var \Yiisoft\Yii\Bootstrap4\ActiveForm $form
 * @var \yii\web\View $this
 **/

$timezoneHelper = new TimeZoneHelper();

$this->title = $this->app->t('ModuleUser', 'Profile Form');
$this->params['breadcrumbs'][] = $this->title;

?>

<?= Html::beginTag('div', ['class' => 'row']) ?>

	<?= Html::beginTag('div', ['class' => 'col-md-3']) ?>
        <?= $this->render('_Menu') ?>
	<?= Html::endTag('div') ?>

	<?= Html::beginTag('div', ['class' => 'col-md-9']) ?>

		<?= Html::tag('h2', '<b>' . Html::encode($this->title) . '</b>', ['class' => 'text-center']) ?>

        <?php $form = ActiveForm::begin([
            'id' => 'form-settings-profile',
			'layout' => 'default',
        	'enableAjaxValidation' => true,
        	'enableClientValidation' => false,
			'options' => ['class' => 'form-settings-profile'],
			'validateOnBlur' => false,
			'validateOnType' => false,
        	'validateOnChange' => false,
        ]) ?>

			<?= $form->field($model, 'name')
				->textInput([
			    	'tabindex' => '1',
				])
				->label($this->app->t('ModuleUser', 'Name'))
			?>

			<?= $form->field($model, 'public_email')
				->textInput([
			    	'tabindex' => '2',
				])
				->label($this->app->t('ModuleUser', 'Email - (Public)'))
			?>

			<?= $form->field($model, 'website')
				->textInput([
			    	'tabindex' => '3',
				])
				->label($this->app->t('ModuleUser', 'Website'))
			?>

			<?= $form->field($model, 'location')
				->textInput([
			    	'tabindex' => '4',
				])
				->label($this->app->t('ModuleUser', 'Location'))
			?>

			<?= $form->field($model, 'timezone')
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

			<?= $form->field($model, 'gravatar_email')
				->textInput([
			    	'tabindex' => '6',
				])
				->label($this->app->t('ModuleUser', 'Gravatar Email'))
				->hint(Html::a($this->app->t('ModuleUser', 'Change your avatar at Gravatar.com'), 'http://gravatar.com'))
			?>

            <?= $form->field($model, 'bio')->textarea([
			    	'tabindex' => '7',
				])
				->label($this->app->t('ModuleUser', 'Bio'))
			?>

			<?= Html::submitButton($this->app->t('ModuleUser', 'Save'), [
				'class' => 'btn btn-block btn-lg btn-primary', 'name' => 'profile-button', 'tabindex' => '8',
	        ]); ?>

        <?php ActiveForm::end() ?>

	<?= Html::endTag('div') ?>

<?php echo Html::endTag('div');
