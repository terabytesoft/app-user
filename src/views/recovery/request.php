<?php

/**
 * recovery/request
 *
 * Request form
 *
 * View web application user
 **/

use app\user\assets\RecoveryRequestAsset;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/**
 * @var \app\user\forms\RecoveryForm $model
 * @var \yii\bootstrap4\ActiveForm $form
 * @var \yii\web\View $this
 **/

$this->title = $this->app->t('user', 'Recover your password');
$this->params['breadcrumbs'][] = $this->title;

RecoveryRequestAsset::register($this);

?>

<?= Html::tag('h2', '<b>' . Html::encode($this->title) . '</b>', ['class' => 'text-center']) ?>

<?= Html::beginTag('div', ['class' => 'form-recovery-request']) ?>

    <?= Html::beginTag('p', ['class' => 'text-center mb-4']) ?>
        <?= $this->app->t(
			'user',
			'Please fill out the following fields to' . '<br/>' . 'Recover your password.'
		) ?>
    <?= Html::endTag('p') ?>

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
			'template' => '{input}{label}{hint}{error}',
		],
		'options' => ['class' => 'form-request'],
		'validateOnType' => false,
        'validateOnChange' => false,
    ]) ?>

        <?= $form->field($model, 'email')->textInput([
			'oninput' => 'this.setCustomValidity("")',
			'oninvalid' => 'this.setCustomValidity("' . $this->app->t('user', 'Enter Email Here') . '")',
			'placeholder' => $this->app->t('user', 'Email'),
			'required' => (YII_ENV === 'test') ? false : true,
			'tabindex' => '1',
		])->label($this->app->t('user', 'Email')) ?>

        <?= Html::submitButton($this->app->t('user', 'Request Password'), [
            'class' => 'btn btn-block btn-lg btn-primary', 'name' => 'request-button', 'tabindex' => '2'
        ]) ?>

    <?php ActiveForm::end() ?>

<?php echo Html::endTag('div');
