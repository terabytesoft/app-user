<?php

/**
 * registration/register
 *
 * Register form
 *
 * View web application user
 **/

use TerabyteSoft\Module\User\Assets\RegistrationRegisterAsset;
use TerabyteSoft\Module\User\widgets\Connect;
use Yiisoft\Yii\Bootstrap4\ActiveForm;
use Yiisoft\Yii\Bootstrap4\Html;

/**
 * @var \TerabyteSoft\Module\User\Module $module
 * @var \TerabyteSoft\Module\User\Models\UserModel $model
 * @var \yii\web\View $this
 **/

$this->title = $this->app->t('ModuleUser', 'Sign up');

if (!$module->theme) {
    $this->params['breadcrumbs'][] = $this->title;
}

if ($module->floatLabels) {
    \TerabyteSoft\Module\User\Assets\FloatingLabelAsset::register($this);
}

RegistrationRegisterAsset::register($this);

if ($module->theme) {
    $this->beginContent($module->themeViewsRegister);
}

?>

<?= Html::beginTag('div', [
    'class' => (!$module->theme) ? 'form-registration-register' : 'form-registration-register-adminator'
]) ?>

    <?= Html::tag('h2', '<b>' . Html::encode($this->title) . '</b>', ['class' => 'form-registration-register-title']) ?>

    <?= Html::beginTag('p', ['class' => 'form-registration-register-subtitle']) ?>
        <?= $this->app->t(
			'ModuleUser',
			'Please fill out the following fields to Sign up.'
		) ?>
    <?= Html::endTag('p') ?>

    <?= Html::tag('hr', '', ['class' => 'mb-2']) ?>

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
				'oninvalid' => 'this.setCustomValidity("' . $this->app->t('ModuleUser', 'Enter Email Here') . '")',
				'placeholder' => $this->app->t('ModuleUser', 'Email'),
				'required' => (YII_ENV === 'test') ? false : true,
				'tabindex' => '1',
			])->label($this->app->t('ModuleUser', 'Email'))
		?>

		<?= $form->field($model, 'username')
			->textInput([
				'oninput' => 'this.setCustomValidity("")',
				'oninvalid' => 'this.setCustomValidity("' . $this->app->t('ModuleUser', 'Enter Username Here') . '")',
				'placeholder' => $this->app->t('ModuleUser', 'Username'),
				'required' => (YII_ENV === 'test') ? false : true,
				'tabindex' => '2',
			])->label($this->app->t('ModuleUser', 'Username'))
		?>

        <?php if ($module->accountGeneratingPassword === false) : ?>
			<?= $form->field($model, 'password')
				->passwordInput([
					'oninput' => 'this.setCustomValidity("")',
					'oninvalid' => 'this.setCustomValidity("' . $this->app->t('ModuleUser', 'Enter Password Here') . '")',
					'placeholder' => $this->app->t('ModuleUser', 'Password'),
					'required' => (YII_ENV === 'test') ? false : true,
					'tabindex' => '3',
				])->label($this->app->t('ModuleUser', 'Password'))
		?>
        <?php endif ?>

        <?= Html::submitButton($this->app->t('ModuleUser', 'Sign up'), [
            'class' => 'btn-block btn btn-lg btn-primary mt-3', 'name' => 'register-button', 'tabindex' => '4'
        ]) ?>

    <?php ActiveForm::end() ?>

    <?= Html::tag('hr', '', ['class' => 'mb-2']) ?>

    <?= Html::beginTag('p', ['class' => 'mt-3 text-center']) ?>
        <?= Html::a($this->app->t('ModuleUser', 'Already registered? Sign in!'), ['/user/security/login']) ?>
    <?= Html::endTag('p') ?>

    <?php if ($module->theme) : ?>
        <?= Html::beginTag('p', ['class' => 'text-center']) ?>
            <?= Html::a(
                Html::tag(
                    'span',
                    Html::tag(
                        'i',
                        ' ',
                        ['class' => 'c-blue-500 ti-home']
                    ),
                    ['class' => 'icon-holder']
                ) .
                $this->app->t(
                    'ModuleUser',
                    'Go to Home'
                ),
                ['/']
            ) ?>
        <?= Html::endTag('p') ?>
    <?php endif ?>

<?php echo Html::endTag('div');

if ($module->theme) {
    $this->endContent();
}
