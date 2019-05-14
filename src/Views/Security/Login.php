<?php

/**
 * security/login
 *
 * Login form
 *
 * View web application user
 **/

use TerabyteSoft\Module\User\Assets\SecurityLoginAsset;
use TerabyteSoft\Module\User\widgets\Connect;
use Yiisoft\Yii\Bootstrap4\ActiveForm;
use Yiisoft\Yii\Bootstrap4\Html;

/**
 * @var \TerabyteSoft\Module\User\Module $module
 * @var \TerabyteSoft\Module\User\forms\LoginForm $model
 * @var \yii\web\View $this
 **/

$this->title = $this->app->t('ModuleUser', 'Login');
if (!$module->theme) {
    $this->params['breadcrumbs'][] = $this->title;
}

if ($module->floatLabels) {
    \TerabyteSoft\Module\User\Assets\FloatingLabelAsset::register($this);
}

SecurityLoginAsset::register($this);

if ($module->theme) {
    $this->beginContent($module->themeViewsRegister);
}

?>

<?= Html::beginTag('div', [
        'class' => (!$module->theme) ? 'form-security-login' : 'form-security-login-adminator'
    ])
?>

    <?= Html::tag('h2', '<b>' . Html::encode($this->title) . '</b>', ['class' => 'form-security-login-title']) ?>

    <?= Html::beginTag('p', ['class' => 'form-security-login-subtitle']) ?>
        <?= $this->app->t(
            'ModuleUser',
            'Please fill out the following fields to Login.'
        ) ?>
    <?= Html::endTag('p') ?>

    <?= Html::tag('hr', '', ['class' => 'mb-2']) ?>

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
                    'oninvalid' => 'this.setCustomValidity("' . $this->app->t('ModuleUser', 'Enter Login Here') . '")',
                    'placeholder' => $this->app->t('ModuleUser', 'Login'),
                    'required' => (YII_ENV === 'test') ? false : true,
                    'tabindex' => '1',
                ])
                ->label($this->app->t('ModuleUser', 'Login'))
            ?>

            <?= $form->field($model, 'password')
                ->passwordInput([
                    'oninput' => 'this.setCustomValidity("")',
                    'oninvalid' => 'this.setCustomValidity("' . $this->app->t('ModuleUser', 'Enter Password Here') . '")',
                    'placeholder' => $this->app->t('ModuleUser', 'Password'),
                    'required' => (YII_ENV === 'test') ? false : true,
                    'tabindex' => '2',
                ])
                ->label($this->app->t('ModuleUser', 'Password'))
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
                <?= $this->app->t('ModuleUser', 'Password is not necessary because the module is in DEBUG mode.'); ?>
            <?= Html::endTag('div'); ?>

    <?php endif ?>

        <?= Html::beginTag('div', ['class' => 'form-security-recovery-password']) ?>

        <?php if ($module->accountPasswordRecovery) : ?>

            <?= $this->app->t(
                'ModuleUser',
                'If you forgot your password you can'
            ) . ' ' .
            Html::a(
                $this->app->t('ModuleUser', 'reset it here'),
                ['/user/recovery/request']
            ) ?>

        <?php endif ?>

        <?= Html::endTag('div') ?>

        <?= Html::submitButton($this->app->t('ModuleUser', 'Login'), [
            'class' => 'btn btn-block btn-lg btn-primary mt-3', 'name' => 'login-button', 'tabindex' => '4',
        ]); ?>

    <?php ActiveForm::end() ?>

    <?= Html::tag('hr', '', ['class' => 'mb-2']) ?>

    <?php if ($module->accountConfirmation) : ?>
            <?= Html::beginTag('p', ['class' => 'text-center']) ?>
                <?= Html::a($this->app->t('ModuleUser', 'Didn\'t receive confirmation message?'), ['/user/registration/resend']) ?>
            <?= Html::endTag('p') ?>

    <?php endif ?>

    <?php if ($module->accountRegistration) : ?>
        <?= Html::beginTag('p', ['class' => 'text-center']) ?>
            <?= Html::a($this->app->t('ModuleUser', 'Don\'t have an account? Sign up!'), ['/user/registration/register']) ?>
        <?= Html::endTag('p') ?>
    <?php endif ?>

    <?php if ($module->theme) : ?>
        <?= Html::beginTag('p', ['class' => 'text-center']) ?>
            <?= Html::a($this->app->t('ModuleUser', 'Go to Home'), ['/']) ?>
        <?= Html::endTag('p') ?>
    <?php endif ?>

<?php echo Html::endTag('div');

if ($module->theme) {
    $this->endContent();
}
