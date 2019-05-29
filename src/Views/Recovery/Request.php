<?php

/**
 * recovery/request
 *
 * Request form
 *
 * View web application user
 **/

use TerabyteSoft\Module\User\Assets\RecoveryRequestAsset;
use Yiisoft\Yii\Bootstrap4\ActiveForm;
use Yiisoft\Yii\Bootstrap4\Html;

/**
 * @var \TerabyteSoft\Module\User\Forms\RecoveryForm $model
 * @var \yii\bootstrap4\ActiveForm $form
 * @var \yii\web\View $this
 **/

$this->title = $this->app->t('ModuleUser', 'Recover your password');

if (!$module->theme) {
    $this->params['breadcrumbs'][] = $this->title;
}

if ($module->floatLabels) {
    \TerabyteSoft\Module\User\Assets\FloatingLabelAsset::register($this);
}

RecoveryRequestAsset::register($this);

if ($module->theme) {
    $this->beginContent($module->themeViewsRequest);
}

?>

<?= Html::beginTag('div', [
   'class' => (!$module->theme) ? 'form-recovery-request' : 'form-recovery-request-adminator'
]) ?>

    <?= Html::tag('h2', '<b>' . Html::encode($this->title) . '</b>', ['class' => 'form-recovery-request-title']) ?>

    <?= Html::beginTag('p', ['class' => 'form-recovery-request-subtitle']) ?>
        <?= $this->app->t(
			'ModuleUser',
			'Please fill out the following fields to' . '<br/>' . 'Recover your password.'
		) ?>
    <?= Html::endTag('p') ?>

    <?= Html::tag('hr', '', ['class' => 'mb-2']) ?>

    <?php $form = ActiveForm::begin([
        'id' => 'form-recovery-request',
		'layout' => 'default',
        'enableClientValidation' => false,
        'enableAjaxValidation' => true,
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
		'options' => ['class' => 'forms-recovery-request'],
		'validateOnType' => false,
        'validateOnChange' => false,
    ]) ?>

        <?= $form->field($model, 'email')->textInput([
			'oninput' => 'this.setCustomValidity("")',
			'oninvalid' => 'this.setCustomValidity("' . $this->app->t('ModuleUser', 'Enter Email Here') . '")',
			'placeholder' => $this->app->t('ModuleUser', 'Email'),
			'required' => (YII_ENV === 'test') ? false : true,
			'tabindex' => '1',
		])->label($this->app->t('ModuleUser', 'Email')) ?>

        <?= Html::submitButton($this->app->t('ModuleUser', 'Request Password'), [
            'class' => 'btn btn-block btn-lg btn-primary mt-3', 'name' => 'request-button', 'tabindex' => '2'
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
