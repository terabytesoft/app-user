<?php

/**
 * registration/resend
 *
 * Resend form
 *
 * View web application user
 **/

use TerabyteSoft\Module\User\Assets\RegistrationResendAsset;
use Yiisoft\Yii\Bootstrap4\ActiveForm;
use Yiisoft\Yii\Bootstrap4\Html;

/**
 * @var \TerabyteSoft\Module\User\forms\ResendForm $model
 * @var \yii\web\View $this
 */

$this->title = $this->app->t('ModuleUser', 'Request new confirmation message');

if (!$module->theme) {
    $this->params['breadcrumbs'][] = $this->title;
}

if ($module->floatLabels) {
    \TerabyteSoft\Module\User\Assets\FloatingLabelAsset::register($this);
}

RegistrationResendAsset::register($this);

if ($module->theme) {
    $this->beginContent($module->themeViewsResend);
}

?>

<?= Html::beginTag('div', [
    'class' => (!$module->theme) ? 'form-registration-resend' : 'form-registration-resend-adminator'
]) ?>

    <?= Html::tag('h2', '<b>' . Html::encode($this->title) . '</b>', ['class' => 'form-registration-resend-title']) ?>

    <?= Html::beginTag('p', ['class' => 'form-registration-resend-subtitle']) ?>
        <?= $this->app->t(
			'ModuleUser',
			'Please fill out the following fields to Resend.'
		) ?>
    <?= Html::endTag('p') ?>

    <?= Html::tag('hr', '', ['class' => 'mb-2']) ?>

    <?php $form = ActiveForm::begin([
        'id' => 'form-registration-resend',
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
        'options' => ['class' => 'forms-registration-resend'],
        'validateOnType' => false,
        'validateOnChange' => false,
    ]) ?>

        <?= $form->field($model, 'email')->textInput([
	        'oninput' => 'this.setCustomValidity("")',
	        'oninvalid' => 'this.setCustomValidity("' . $this->app->t('ModuleUser', 'Enter Email Here') . '")',
            'placeholder' => $this->app->t('ModuleUser', 'Email'),
		    'required' => (YII_ENV === 'test') ? false : true,
		    'tabindex' => '1',
            ])->label($this->app->t('ModuleUser', 'Email'));
        ?>

        <?= Html::submitButton($this->app->t('ModuleUser', 'Continue'), [
            'class' => 'btn btn-block btn-lg btn-primary mt-3', 'name' => 'resend-button', 'tabindex' => '2'
        ]) ?>

	<?php ActiveForm::end(); ?>

    <?= Html::tag('hr', '', ['class' => 'mb-2']) ?>

    <?php if ($module->accountRegistration) : ?>
        <?= Html::beginTag('p', ['class' => 'text-center']) ?>
            <?= Html::a($this->app->t('ModuleUser', 'Don\'t have an account? Sign up!'), ['/user/registration/register']) ?>
        <?= Html::endTag('p') ?>
    <?php endif ?>

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
