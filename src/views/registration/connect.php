<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\User $model
 * @var dektrium\user\models\Account $account
 */

$this->title = $this->getApp()->t('user', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <div class="alert alert-info">
                    <p>
                        <?= $this->getApp()->t(
                            'user',
                            'In order to finish your registration, we need you to enter following fields'
                        ) ?>:
                    </p>
                </div>
                <?php $form = ActiveForm::begin([
                    'id' => 'connect-account-form',
                ]); ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'username') ?>

                <?= Html::submitButton($this->getApp()->t('user', 'Continue'), ['class' => 'btn btn-success btn-block']) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <p class="text-center">
            <?= Html::a(
                $this->getApp()->t(
                    'user',
                    'If you already registered, sign in and connect this account on settings page'
                ),
                ['/user/settings/networks']
            ) ?>.
        </p>
    </div>
</div>
