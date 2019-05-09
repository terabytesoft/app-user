<?php

/**
 * Admin/_Assignments
 *
 * _Assignments Form
 *
 * View web application user
 **/

use TerabyteSoft\Module\User\Rbac\Widgets\Assignments;

/**
 * @var \yii\web\View $this
 * @var \TerabyteSoft\Module\User\Models\User $user
 */
?>

<?php $this->beginContent('@TerabyteSoft/Module/User/Views/Admin/Update.php', ['user' => $user]) ?>

<?= Yiisoft\Yii\Bootstrap4\Alert::widget([
    'options' => [
        'class' => 'alert-info alert-dismissible',
    ],
    'body' => $this->app()->t(
		'user',
		'You can assign multiple roles or permissions to user by using the form below'
	),
]) ?>

<?= Assignments::widget(['userId' => $user->id]) ?>

<?php $this->endContent();
