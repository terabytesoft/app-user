<?php

/**
 * recovery/reset
 *
 * Reset form
 *
 * View web application user
 **/

use app\user\assets\RecoveryResetAsset;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/**
 * @var \app\user\form\RecoveryForm $model
 * @var \yii\web\View $this
 * @var \yii\widgets\ActiveForm $form
 **/

$this->title = $this->app->t('ModuleUser', 'Reset your password');
$this->params['breadcrumbs'][] = $this->title;

if ($module->floatLabels) {
    \app\user\assets\FloatingLabelAsset::register($this);
}

RecoveryResetAsset::register($this);

?>

<?= Html::beginTag('div', ['class' => 'form-recovery-reset']) ?>

    <?= Html::tag('h2', '<b>' . Html::encode($this->title) . '</b>', ['class' => 'form-recovery-reset-title']) ?>

	<?= Html::beginTag('p', ['class' => 'form-recovery-reset-subtitle']) ?>
        <?= $this->app->t(
			'ModuleUser',
			'Please fill out the following fields to' . '<br/>' . 'Reset your password.'
		) ?>
    <?= Html::endTag('p') ?>

    <?= Html::tag('hr', '', ['class' => 'mb-4']) ?>

	<?php $form = ActiveForm::begin([
    	'id' => 'form-recovery-reset',
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
		'options' => ['class' => 'forms-recovery-reset'],
		'validateOnType' => false,
        'validateOnChange' => false,
    ]) ?>

    	<?= $form->field($model, 'password')->passwordInput([
				'oninput' => 'this.setCustomValidity("")',
				'oninvalid' => 'this.setCustomValidity("' . $this->app->t('ModuleUser', 'Enter Password Here') . '")',
				'placeholder' => $this->app->t('ModuleUser', 'Password'),
				'required' => (YII_ENV === 'test') ? false : true,
				'tabindex' => '1',
		])->label($this->app->t('ModuleUser', 'Password')) ?>

    	<?= Html::submitButton($this->app->t('ModuleUser', 'Reset Password'), [
			'class' => 'btn btn-block btn-lg btn-primary mt-3', 'name' => 'reset-button', 'tabindex' => '2'
		]) ?>

	<?php ActiveForm::end() ?>

<?php echo Html::endTag('div');
