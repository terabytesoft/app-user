<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var string $action
 * @var \app\user\models\LoginForm $model
 * @var \yii\bootstrap4\ActiveForm $form
 * @var \yii\web\View $this
 */

?>

<?php if ($this->app->user->isGuest) : ?>
    <?php $form = ActiveForm::begin([
        'id'                     => 'login-widget-form',
        'action'                 => Url::to(['/user/security/login']),
        'enableAjaxValidation'   => true,
        'enableClientValidation' => false,
        'validateOnBlur'         => false,
        'validateOnType'         => false,
        'validateOnChange'       => false,
    ]) ?>

    <?= $form->field($model, 'login')->textInput(['placeholder' => 'Login']) ?>

    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password']) ?>

    <?= $form->field($model, 'rememberMe')->checkbox() ?>

    <?= Html::submitButton($this->app->t('ModuleUser', 'Sign in'), ['class' => 'btn btn-primary btn-block']) ?>

    <?php ActiveForm::end(); ?>
<?php else : ?>
    <?= Html::a($this->app->t('ModuleUser', 'Logout'), ['/user/security/logout'], [
        'class'       => 'btn btn-danger btn-block',
        'data-method' => 'post'
    ]) ?>
<?php endif;
