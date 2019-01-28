<?php

/**
 * registration/register
 *
 * Register form
 *
 * View web application user
 **/

use app\user\assets\RegistrationRegisterAsset;
use app\user\widgets\Connect;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/**
 * @var \app\user\Module $module
 * @var \app\user\models\UserModel $model
 * @var \yii\web\View $this
 **/

$this->title = $this->getApp()->t('user', 'Sign up');
$this->params['breadcrumbs'][] = $this->title;

if ($module->floatLabels) {
    \app\user\assets\FloatingLabelAsset::register($this);
}

RegistrationRegisterAsset::register($this);

?>

<?= Html::beginTag('div', ['class' => 'form-registration-register']) ?>

    <?= Html::tag('h2', '<b>' . Html::encode($this->title) . '</b>', ['class' => 'form-registration-register-title']) ?>

    <?= Html::beginTag('p', ['class' => 'form-registration-register-subtitle']) ?>
        <?= $this->app->t(
			'user',
			'Please fill out the following fields to Sign up.'
		) ?>
    <?= Html::endTag('p') ?>

    <?= Html::tag('hr', '', ['class' => 'mb-4']) ?>

    <?php $form = ActiveForm::begin([
        'id' => 'form-registration-register',
		'layout' => 'default',
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
		'fieldConfig' => [
			'horizontalCssClasses' => [
				'label' => '',
				'offset' => '',
				'wrapper' => '',
				'error' => 'text-center',
                'hint' => '',
                'field' => 'form-label-group',
			],
			'options' => ['class' => 'form-label-group'],
            'template' => ($module->floatLabels) ?
                '{input}{label}{hint}{error}' :
                '<div>{label}{input}{hint}{error}</div>',
		],
		'options' => ['class' => 'forms-registration-register'],
		'validateOnType' => false,
        'validateOnChange' => false,
    ]) ?>

		<?= $form->field($model, 'email')
			->textInput([
				'autofocus' => true,
				'oninput' => 'this.setCustomValidity("")',
				'oninvalid' => 'this.setCustomValidity("' . $this->app->t('user', 'Enter Email Here') . '")',
				'placeholder' => $this->app->t('user', 'Email'),
				'required' => (YII_ENV === 'test') ? false : true,
				'tabindex' => '1',
			])->label($this->app->t('user', 'Email'))
		?>

		<?= $form->field($model, 'username')
			->textInput([
				'oninput' => 'this.setCustomValidity("")',
				'oninvalid' => 'this.setCustomValidity("' . $this->app->t('user', 'Enter Username Here') . '")',
				'placeholder' => $this->app->t('user', 'Username'),
				'required' => (YII_ENV === 'test') ? false : true,
				'tabindex' => '2',
			])->label($this->app->t('user', 'Username'))
		?>

        <?php if ($module->enableGeneratingPassword === false) : ?>
			<?= $form->field($model, 'password')
				->passwordInput([
					'oninput' => 'this.setCustomValidity("")',
					'oninvalid' => 'this.setCustomValidity("' . $this->app->t('user', 'Enter Password Here') . '")',
					'placeholder' => $this->app->t('user', 'Password'),
					'required' => (YII_ENV === 'test') ? false : true,
					'tabindex' => '3',
				])->label($this->app->t('user', 'Password'))
		?>
        <?php endif ?>

        <?= Html::submitButton($this->getApp()->t('user', 'Sign up'), [
            'class' => 'btn-block btn btn-lg btn-primary mt-3', 'name' => 'register-button', 'tabindex' => '4'
        ]) ?>

    <?php ActiveForm::end() ?>

    <?= Html::tag('hr', ['class' => 'mb-4']) ?>

    <?= Html::beginTag('p', ['class' => 'mt-3 text-center']) ?>
        <?= Html::a($this->getApp()->t('user', 'Already registered? Sign in!'), ['/user/security/login']) ?>
	<?= Html::endTag('p') ?>

<?php echo Html::endTag('div');
