<?php

use app\user\assets\RegistrationAsset;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\user\models\User $model
 * @var app\user\Module $module
 */

$this->title = $this->getApp()->t('user', 'Sign up');
$this->params['breadcrumbs'][] = $this->title;

RegistrationAsset::register($this);

?>

<?= Html::tag('h1', '<b>' . Html::encode($this->title) . '</b>', ['class' => 'text-center c-grey-900 mb-40']) ?>

<?= Html::beginTag('div', ['class' => 'form-registration']) ?>

    <?= Html::beginTag('p', ['class' => 'text-center mb-4']) ?>
        <?= $this->app->t(
			'user',
			'Please fill out the following fields to Sign up.'
		) ?>
    <?= Html::endTag('p') ?>

    <?php $form = ActiveForm::begin([
        'id' => 'form-registration',
		'layout' => 'default',
		'fieldConfig' => [
			'template' => '{input}{label}{hint}{error}',
			'horizontalCssClasses' => [
				'label' => '',
				'offset' => '',
				'wrapper' => '',
				'error' => 'text-center',
                'hint' => '',
                'field' => 'form-label-group',
			],
			'options' => ['class' => 'form-label-group'],
		],
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
		'options' => ['class' => 'form-registration'],
		'validateOnType' => false,
        'validateOnChange' => false,
    ]); ?>

        <?= $form->field($model, 'email')->textInput([
			'oninput' => 'this.setCustomValidity("")',
			'oninvalid' => 'this.setCustomValidity("' . $this->app->t('user', 'Enter Email Here') . '")',
			'placeholder' => $this->app->t('user', 'Email'),
			'required' => (YII_ENV === 'test') ? false : true,
			'tabindex' => '1',
		])->label($this->app->t('user', 'Email')) ?>

        <?= $form->field($model, 'username')->textInput([
			'autofocus' => true,
			'oninput' => 'this.setCustomValidity("")',
			'oninvalid' => 'this.setCustomValidity("' . $this->app->t('user', 'Enter Username Here') . '")',
			'placeholder' => $this->app->t('user', 'Username'),
			'required' => (YII_ENV === 'test') ? false : true,
			'tabindex' => '2',
		])->label($this->app->t('user', 'Username')) ?>

        <?php if ($module->enableGeneratingPassword === false) : ?>
            <?= $form->field($model, 'password')->passwordInput([
				'oninput' => 'this.setCustomValidity("")',
				'oninvalid' => 'this.setCustomValidity("' . $this->app->t('user', 'Enter Password Here') . '")',
				'placeholder' => $this->app->t('user', 'Password'),
				'required' => (YII_ENV === 'test') ? false : true,
				'tabindex' => '3',
			])->label($this->app->t('user', 'Password')) ?>
        <?php endif ?>

        <?= Html::submitButton($this->getApp()->t('user', 'Sign up'), [
            'class' => 'btn btn-lg btn-primary btn-block', 'name' => 'signup-button', 'tabindex' => '4'
        ]) ?>

    <?php ActiveForm::end(); ?>

    <p class="text-center">
        <?= Html::a($this->getApp()->t('user', 'Already registered? Sign in!'), ['/user/security/login']) ?>
    </p>

<?php echo Html::endTag('div');
