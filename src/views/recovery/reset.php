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

$this->title = $this->getApp()->t('user', 'Reset your password');
$this->params['breadcrumbs'][] = $this->title;

if ($module->floatLabels) {
    \app\user\assets\FloatingLabelAsset::register($this);
}

RecoveryResetAsset::register($this);

?>

<?= Html::tag('h2', '<b>' . Html::encode($this->title) . '</b>', ['class' => 'text-center']) ?>

<?= Html::beginTag('div', ['class' => 'form-recovery-reset']) ?>

	<?= Html::beginTag('p', ['class' => 'text-center mb-4']) ?>
        <?= $this->app->t(
			'user',
			'Please fill out the following fields to' . '<br/>' . 'Reset your password.'
		) ?>
    <?= Html::endTag('p') ?>

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
		'options' => ['class' => 'form-reset'],
		'validateOnType' => false,
        'validateOnChange' => false,
    ]) ?>

    	<?= $form->field($model, 'password')->passwordInput([
				'oninput' => 'this.setCustomValidity("")',
				'oninvalid' => 'this.setCustomValidity("' . $this->app->t('user', 'Enter Password Here') . '")',
				'placeholder' => $this->app->t('user', 'Password'),
				'required' => (YII_ENV === 'test') ? false : true,
				'tabindex' => '1',
		])->label($this->app->t('user', 'Password')) ?>

    	<?= Html::submitButton($this->getApp()->t('user', 'Reset Password'), [
			'class' => 'btn btn-block btn-lg btn-primary mt-3', 'name' => 'reset-button', 'tabindex' => '2'
		]) ?>

	<?php ActiveForm::end() ?>

<?php echo Html::endTag('div');
