<?php

/**
 * registration/connect
 *
 * Connect form
 *
 * View web application user
 **/

use app\user\assets\RegistrationConnectAsset;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/**
 * @var \app\user\models\AccountModel $account
 * @var \app\user\models\UserModel $model
 * @var \yii\bootstrap4\ActiveForm $form
 * @var \yii\web\View $this
 */

$this->title = $this->getApp()->t('user', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;

if ($module->floatLabels) {
    \app\user\assets\FloatingLabelAsset::register($this);
}

RegistrationConnectAsset::register($this);

?>

<?= Html::beginTag('div', ['class' => 'form-registration-connect']) ?>

    <?= Html::tag('h2', '<b>' . Html::encode($this->title) . '</b>', ['class' => 'form-registration-connect-title']) ?>

    <?= Html::beginTag('p', ['class' => 'form-registration-connect-subtitle']) ?>
		<?= $this->getApp()->t(
            'user',
            'In order to finish your registration, we need you to enter following fields'
        ) ?>
    <?= Html::endTag('p') ?>

    <?= Html::tag('hr', '', ['class' => 'mb-4']) ?>

    <?php $form = ActiveForm::begin([
		'id' => 'form-registration-connect',
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
		'options' => ['class' => 'forms-registration-connect'],
		'validateOnType' => false,
        'validateOnChange' => false,
    ]) ?>

		<?= $form->field($model, 'email')
			->textInput([
				'oninput' => 'this.setCustomValidity("")',
				'oninvalid' => 'this.setCustomValidity("' . $this->app->t('user', 'Enter Email Here') . '")',
				'placeholder' => $this->app->t('user', 'Email'),
				'required' => (YII_ENV === 'test') ? false : true,
				'tabindex' => '1',
			])->label($this->app->t('user', 'Email'))
		?>

		<?= $form->field($model, 'username')
			->textInput([
				'autofocus' => true,
				'oninput' => 'this.setCustomValidity("")',
				'oninvalid' => 'this.setCustomValidity("' . $this->app->t('user', 'Enter Username Here') . '")',
				'placeholder' => $this->app->t('user', 'Username'),
				'required' => (YII_ENV === 'test') ? false : true,
				'tabindex' => '2',
			])->label($this->app->t('user', 'Username'))
		?>

		<?= Html::submitButton($this->getApp()->t('user', 'Continue'), [
            'class' => 'btn btn-block btn-lg btn-primary mt-3', 'name' => 'connect-button', 'tabindex' => '3'
        ]) ?>


    <?php ActiveForm::end() ?>

    <?= Html::tag('hr', ['class' => 'mb-4']) ?>

	<?= Html::beginTag('p', ['class' => 'text-center']) ?>
        <?= Html::a(
            $this->getApp()->t(
                'user',
                'If you already registered, sign in and connect this account on settings page'
            ),
            ['/user/settings/networks']
        ) ?>
	<?= Html::endTag('p') ?>

<?php echo Html::endTag('div');
