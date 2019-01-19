<?php

use app\user\assets\ResetAsset;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var app\user\models\RecoveryForm $model
 */

$this->title = $this->getApp()->t('user', 'Reset your password');
$this->params['breadcrumbs'][] = $this->title;

ResetAsset::register($this);

?>

<?= Html::tag('h1', '<b>' . Html::encode($this->title) . '</b>', ['class' => 'text-center c-grey-900 mb-40']) ?>

<?= Html::beginTag('div', ['class' => 'form-reset']) ?>

	<?= Html::beginTag('p', ['class' => 'text-center mb-4']) ?>
        <?= $this->app->t(
			'user',
			'Please fill out the following fields to' . '<br/>' . 'Reset your password.'
		) ?>
    <?= Html::endTag('p') ?>

	<?php $form = ActiveForm::begin([
    	'id' => 'form-reset',
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
		'options' => ['class' => 'form-reset'],
		'validateOnType' => false,
        'validateOnChange' => false,
    ]); ?>

    	<?= $form->field($model, 'password')->passwordInput([
				'oninput' => 'this.setCustomValidity("")',
				'oninvalid' => 'this.setCustomValidity("' . $this->app->t('user', 'Enter Password Here') . '")',
				'placeholder' => $this->app->t('user', 'Password'),
				'required' => (YII_ENV === 'test') ? false : true,
				'tabindex' => '1',
		])->label($this->app->t('user', 'Password')) ?>

    	<?= Html::submitButton($this->getApp()->t('user', 'Finish'), [
			'class' => 'btn btn-lg btn-primary btn-block', 'name' => 'signup-button', 'tabindex' => '2'
		]) ?>

	<?php ActiveForm::end(); ?>

<?php echo Html::endTag('div');
