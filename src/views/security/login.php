<?php

use app\user\assets\LoginAsset;
use app\user\forms\LoginForm;
use app\user\widgets\Connect;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/**
 * @var app\user\Module $module
 * @var app\user\forms\LoginForm $model
 * @var yii\web\View $this
 */

$this->title = $this->getApp()->t('user', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;

LoginAsset::register($this);

?>

<?= Html::tag('h1', '<b>' . Html::encode($this->title) . '</b>', ['class' => 'text-center c-grey-900 mb-40']) ?>

<?= Html::beginTag('div', ['class' => 'form-login']) ?>

    <?= Html::beginTag('p', ['class' => 'text-center mb-4']) ?>
        <?= $this->app->t(
			'user',
			'Please fill out the following fields to Sign in.'
		) ?>
    <?= Html::endTag('p') ?>

    <?php $form = ActiveForm::begin([
        'id' => 'form-login',
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
		'options' => ['class' => 'form-login'],
		'validateOnType' => false,
        'validateOnChange' => false,
    ]); ?>

        <?php if ($module->debug) : ?>
            <?= $form->field($model, 'login')->textInput([
			    'autofocus' => true,
			    'oninput' => 'this.setCustomValidity("")',
			    'oninvalid' => 'this.setCustomValidity("' . $this->app->t('user', 'Enter Login Here') . '")',
			    'placeholder' => $this->app->t('user', 'Login'),
			    'required' => (YII_ENV === 'test') ? false : true,
			    'tabindex' => '1',
		    ])->label($this->app->t('user', 'Login')) ?>

        <?php else : ?>

            <?= $form->field($model, 'login')->textInput([
			    'autofocus' => true,
			    'oninput' => 'this.setCustomValidity("")',
			    'oninvalid' => 'this.setCustomValidity("' . $this->app->t('user', 'Enter Login Here') . '")',
			    'placeholder' => $this->app->t('user', 'Login'),
			    'required' => (YII_ENV === 'test') ? false : true,
			    'tabindex' => '1',
		    ])->label($this->app->t('user', 'Login')) ?>

        <?php endif ?>

        <?php if ($module->debug) : ?>
            <?= Html::beginTag('div', ['class' => 'alert alert-warning']) ?>
                <?= $this->getApp()->t('user', 'Password is not necessary because the module is in DEBUG mode.'); ?>
            <?= Html::endTag('div'); ?>

        <?php else : ?>
            <?= $form->field($model, 'password')->passwordInput([
				'oninput' => 'this.setCustomValidity("")',
				'oninvalid' => 'this.setCustomValidity("' . $this->app->t('user', 'Enter Password Here') . '")',
				'placeholder' => $this->app->t('user', 'Password'),
				'required' => (YII_ENV === 'test') ? false : true,
				'tabindex' => '3',
			])->label($this->app->t('user', 'Password')) ?>

        <?php endif ?>

        <?= $form->field($model, 'rememberMe', [
				'options' => ['tabindex' => '3'],
		])->checkbox() ?>

        <?= Html::beginTag('div', ['class' => 'text-center mb-4', 'style' => 'color:#999;margin:1em 0']) ?>

        <?php if ($module->enablePasswordRecovery) : ?>

            <?= $this->app->t(
                'basic',
                'If you forgot your password you can'
            ) . ' ' .
			Html::a(
				$this->app->t('basic', 'reset it here'),
				['/user/recovery/request']
			) ?>

        <?php endif ?>

        <?= Html::endTag('div') ?>

		<?= Html::submitButton($this->app->t('user', 'Sign in'), [
			'class' => 'btn btn-lg btn-primary btn-block', 'name' => 'login-button', 'tabindex' => '4',
        ]); ?>

    <?php ActiveForm::end(); ?>

    <?php if ($module->enableConfirmation) : ?>
            <?= Html::beginTag('p', ['class' => 'text-center']) ?>
                <?= Html::a($this->getApp()->t('user', 'Didn\'t receive confirmation message?'), ['/user/registration/resend']) ?>
            <?= Html::endTag('p') ?>

    <?php endif ?>

    <?php if ($module->enableRegistration) : ?>
        <?= Html::beginTag('p', ['class' => 'text-center']) ?>
            <?= Html::a($this->getApp()->t('user', 'Don\'t have an account? Sign up!'), ['/user/registration/register']) ?>
        <?= Html::endTag('p') ?>
    <?php endif ?>

    <!-- Connect::widget(['baseAuthUrl' => ['/user/security/auth'],]);  -->

<?php echo Html::endTag('div');
