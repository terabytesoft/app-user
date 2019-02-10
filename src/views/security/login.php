<?php

/**
 * security/login
 *
 * Login form
 *
 * View web application user
 **/

use app\user\assets\SecurityLoginAsset;
use app\user\widgets\Connect;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/**
 * @var \app\user\Module $module
 * @var \app\user\forms\LoginForm $model
 * @var \yii\web\View $this
 **/

$this->title = $this->app->t('user', 'Login');
$this->params['breadcrumbs'][] = $this->title;

if ($module->floatLabels) {
    \app\user\assets\FloatingLabelAsset::register($this);
}

SecurityLoginAsset::register($this);

?>

<?= Html::beginTag('div', ['class' => 'form-security-login']) ?>

    <?= Html::tag('h2', '<b>' . Html::encode($this->title) . '</b>', ['class' => 'form-security-login-title']) ?>

    <?= Html::beginTag('p', ['class' => 'form-security-login-subtitle']) ?>
        <?= $this->app->t(
			'user',
			'Please fill out the following fields to Login.'
		) ?>
    <?= Html::endTag('p') ?>

    <?= Html::tag('hr', '', ['class' => 'mb-4']) ?>

	<?php if (!$module->debug) : ?>

    	<?php $form = ActiveForm::begin([
        	'id' => 'form-security-login',
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
			] ,
			'options' => ['class' => 'forms-security-login'],
			'validateOnBlur' => false,
			'validateOnType' => false,
        	'validateOnChange' => false,
    	]) ?>

			<?= $form->field($model, 'login')
				->textInput([
			    	'autofocus' => true,
			    	'oninput' => 'this.setCustomValidity("")',
			    	'oninvalid' => 'this.setCustomValidity("' . $this->app->t('user', 'Enter Login Here') . '")',
			    	'placeholder' => $this->app->t('user', 'Login'),
			    	'required' => (YII_ENV === 'test') ? false : true,
			    	'tabindex' => '1',
				])
				->label($this->app->t('user', 'Login'))
			?>

			<?= $form->field($model, 'password')
				->passwordInput([
					'oninput' => 'this.setCustomValidity("")',
					'oninvalid' => 'this.setCustomValidity("' . $this->app->t('user', 'Enter Password Here') . '")',
					'placeholder' => $this->app->t('user', 'Password'),
					'required' => (YII_ENV === 'test') ? false : true,
					'tabindex' => '2',
				])
				->label($this->app->t('user', 'Password'))
			?>

			<?= $form->field($model, 'rememberMe')
				->checkbox([
					'options' => ['tabindex' => '3'],
				])
			?>

    <?php else : ?>

		<?php $form = ActiveForm::begin([
        	'id' => 'form-login',
        	'enableAjaxValidation' => true,
        	'enableClientValidation' => false,
			'options' => ['class' => 'form-login'],
			'validateOnBlur' => false,
			'validateOnType' => false,
        	'validateOnChange' => false,
    	]) ?>

			<?= $form->field($model, 'login')
				->dropDownList(
					$model->loginList(),
					[
						'autofocus' => 'autofocus',
						'class' => 'form-control',
						'placeholder' => '',
						'tabindex' => '1',
					]
				)
				->label('')
			?>

			<?= Html::beginTag('div', ['class' => 'alert alert-warning']) ?>
                <?= $this->app->t('user', 'Password is not necessary because the module is in DEBUG mode.'); ?>
            <?= Html::endTag('div'); ?>

	<?php endif ?>

        <?= Html::beginTag('div', ['class' => 'text-center mb-4', 'style' => 'color:#999;margin:1em 0']) ?>

        <?php if ($module->accountPasswordRecovery) : ?>

            <?= $this->app->t(
                'user',
                'If you forgot your password you can'
            ) . ' ' .
			Html::a(
				$this->app->t('user', 'reset it here'),
				['/user/recovery/request']
			) ?>

        <?php endif ?>

        <?= Html::endTag('div') ?>

		<?= Html::submitButton($this->app->t('user', 'Login'), [
			'class' => 'btn btn-block btn-lg btn-primary mt-3', 'name' => 'login-button', 'tabindex' => '4',
        ]); ?>

    <?php ActiveForm::end() ?>

    <?= Html::tag('hr', '', ['class' => 'mb-4']) ?>

    <?php if ($module->accountConfirmation) : ?>
            <?= Html::beginTag('p', ['class' => 'text-center']) ?>
                <?= Html::a($this->app->t('user', 'Didn\'t receive confirmation message?'), ['/user/registration/resend']) ?>
            <?= Html::endTag('p') ?>

    <?php endif ?>

    <?php if ($module->accountRegistration) : ?>
        <?= Html::beginTag('p', ['class' => 'text-center']) ?>
            <?= Html::a($this->app->t('user', 'Don\'t have an account? Sign up!'), ['/user/registration/register']) ?>
        <?= Html::endTag('p') ?>
    <?php endif ?>

	<?php $auth = Connect::begin([
		'baseAuthUrl' => ['/user/security/auth'],
        'popupMode' => false,
    ]) ?>

        <?php if ($auth->getClients()) : ?>

            <?= Html::beginTag(
                'div',
                [
                    'class' => 'align-items-center d-flex flex-row justify-content-around mb-3'
                ]
            ) ?>

                <?php foreach ($auth->getClients() as $client) : ?>
                    <?= Html::beginTag('div', ['class' => 'p-2']) ?>
                        <?= Html::a('', $auth->createClientUrl($client), [
                            'class' => 'auth-icon ' . $client->getName() . ' btn btn-block',
                        ]) ?>
                    <?= Html::endTag('div') ?>
                <?php endforeach; ?>

            <?= Html::endTag('div') ?>

        <?php endif ?>

    <?php Connect::end() ?>

<?php echo Html::endTag('div');
