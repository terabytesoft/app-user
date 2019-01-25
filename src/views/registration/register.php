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

RegistrationRegisterAsset::register($this);

?>

<?= Html::tag('h2', '<b>' . Html::encode($this->title) . '</b>', ['class' => 'text-center']) ?>

<?= Html::beginTag('div', ['class' => 'form-registration-register']) ?>

    <?= Html::beginTag('p', ['class' => 'text-center mb-4']) ?>
        <?= $this->app->t(
			'user',
			'Please fill out the following fields to Sign up.'
		) ?>
    <?= Html::endTag('p') ?>

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
			'template' => '{input}{label}{hint}{error}',
		],
		'options' => ['class' => 'form-registration'],
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
            'class' => 'btn-block btn btn-lg btn-primary', 'name' => 'register-button', 'tabindex' => '4'
        ]) ?>

    <?php ActiveForm::end() ?>

    <?= Html::beginTag('p', ['class' => 'text-center']) ?>
        <?= Html::a($this->getApp()->t('user', 'Already registered? Sign in!'), ['/user/security/login']) ?>
	<?= Html::endTag('p') ?>

<?php echo Html::endTag('div');
