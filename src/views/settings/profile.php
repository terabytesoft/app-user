<?php

use app\user\helpers\TimeZoneHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var TimeZoneHelper $timezoneHelper
 * @var app\user\models\Profile $model
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 */

$timezoneHelper = new TimeZoneHelper();

$this->title = $this->app->t('user', 'Profile Form');
$this->params['breadcrumbs'][] = $this->title;

?>

<?= Html::beginTag('div', ['class' => 'row']) ?>
	<?= Html::beginTag('div', ['class' => 'col-md-3']) ?>
        <?= $this->render('_menu') ?>
	<?= Html::endTag('div') ?>
	<?= Html::beginTag('div', ['class' => 'col-md-9']) ?>
		<?= Html::tag('h2', '<b>' . Html::encode($this->title) . '</b>', ['class' => 'text-center']) ?>

        <?php $form = ActiveForm::begin([
            'id' => 'profile-form',
			'layout' => 'default',
        	'enableAjaxValidation' => true,
        	'enableClientValidation' => false,
			'options' => ['class' => 'form-profile'],
			'validateOnBlur' => false,
			'validateOnType' => false,
        	'validateOnChange' => false,
        ]); ?>

			<?= $form->field($model, 'name')
				->textInput([
			    	'tabindex' => '1',
				])
				->label($this->app->t('user', 'Name'))
			?>

			<?= $form->field($model, 'public_email')
				->textInput([
			    	'tabindex' => '2',
				])
				->label($this->app->t('user', 'Email - (Public)'))
			?>

			<?= $form->field($model, 'website')
				->textInput([
			    	'tabindex' => '3',
				])
				->label($this->app->t('user', 'Website'))
			?>

			<?= $form->field($model, 'location')
				->textInput([
			    	'tabindex' => '4',
				])
				->label($this->app->t('user', 'Location'))
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
				->label($this->app->t('user', 'Time Zone'))
			?>

			<?= $form->field($model, 'gravatar_email')
				->textInput([
			    	'tabindex' => '6',
				])
				->label($this->app->t('user', 'Gravatar Email'))
				->hint(Html::a($this->app->t('user', 'Change your avatar at Gravatar.com'), 'http://gravatar.com'))
			?>

            <?= $form->field($model, 'bio')->textarea([
			    	'tabindex' => '7',
				])
				->label($this->app->t('user', 'Bio'))
			?>

			<?= Html::submitButton($this->app->t('user', 'Save'), [
				'class' => 'btn btn-lg btn-primary btn-block', 'name' => 'profile-save-button', 'tabindex' => '8',
	        ]); ?>

        <?php ActiveForm::end(); ?>

	<?= Html::endTag('div') ?>
<?php echo Html::endTag('div');
