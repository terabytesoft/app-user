<?php

/**
 * registration/resend
 *
 * Resend form
 *
 * View web application user
 **/

use app\user\assets\RegistrationResendAsset;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/**
 * @var \app\user\forms\ResendForm $model
 * @var \yii\web\View $this
 */

$this->title = $this->app->t('user', 'Request new confirmation message');
$this->params['breadcrumbs'][] = $this->title;

if ($module->floatLabels) {
    \app\user\assets\FloatingLabelAsset::register($this);
}

RegistrationResendAsset::register($this);

?>

<?= Html::beginTag('div', ['class' => 'form-registration-resend']) ?>

    <?= Html::tag('h2', '<b>' . Html::encode($this->title) . '</b>', ['class' => 'form-registration-resend-title']) ?>

    <?= Html::beginTag('p', ['class' => 'form-registration-resend-subtitle']) ?>
        <?= $this->app->t(
			'user',
			'Please fill out the following fields to Resend.'
		) ?>
    <?= Html::endTag('p') ?>

    <?= Html::tag('hr', '', ['class' => 'mb-4']) ?>

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
	        'oninvalid' => 'this.setCustomValidity("' . $this->app->t('user', 'Enter Email Here') . '")',
            'placeholder' => $this->app->t('user', 'Email'),
		    'required' => (YII_ENV === 'test') ? false : true,
		    'tabindex' => '1',
            ])->label($this->app->t('user', 'Email'));
        ?>

        <?= Html::submitButton($this->app->t('user', 'Continue'), [
            'class' => 'btn btn-block btn-lg btn-primary mt-3', 'name' => 'resend-button', 'tabindex' => '2'
        ]) ?>

	<?php ActiveForm::end(); ?>

<?php echo Html::endTag('div');
