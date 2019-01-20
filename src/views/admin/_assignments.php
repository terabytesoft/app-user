<?php

use app\rbac\widgets\Assignments;

/**
 * @var yii\web\View $this
 * @var app\user\models\User $user
 */
?>

<?php $this->beginContent('@app/user/views/admin/update.php', ['user' => $user]) ?>

<?= yii\bootstrap4\Alert::widget([
    'options' => [
        'class' => 'alert-info alert-dismissible',
    ],
    'body' => $this->getApp()->t('user', 'You can assign multiple roles or permissions to user by using the form below'),
]) ?>

<?= Assignments::widget(['userId' => $user->id]) ?>

<?php $this->endContent();
