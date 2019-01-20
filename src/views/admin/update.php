<?php

use yii\bootstrap4\Nav;

/**
 * @var \yii\web\View $this
 * @var \app\user\models\User $user
 * @var string $content
 */

$this->title = $this->app->t('user', 'Update user account');
$this->params['breadcrumbs'][] = ['label' => $this->app->t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_menu') ?>

<div class="row">
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <?= Nav::widget([
                    'options' => [
                        'class' => 'nav-pills nav-stacked',
                    ],
                    'items' => [
                        [
                            'label' => $this->app->t('user', 'Account details'),
                            'url' => ['/user/admin/update', 'id' => $user->id]
                        ],
                        [
                            'label' => $this->app->t('user', 'Profile details'),
                            'url' => ['/user/admin/update-profile', 'id' => $user->id]
                        ],
                        ['label' => $this->app->t('user', 'Information'), 'url' => ['/user/admin/info', 'id' => $user->id]],
                        [
                            'label' => $this->app->t('user', 'Assignments'),
                            'url' => ['/user/admin/assignments', 'id' => $user->id],
                            'visible' => false,
                        ],
                        '<hr>',
                        [
                            'label' => $this->app->t('user', 'Confirm'),
                            'url' => ['/user/admin/confirm', 'id' => $user->id],
                            'visible' => !$user->isConfirmed,
                            'linkOptions' => [
                                'class' => 'text-success',
                                'data-method' => 'post',
                                'data-confirm' => $this->app->t('user', 'Are you sure you want to confirm this user?'),
                            ],
                        ],
                        [
                            'label' => $this->app->t('user', 'Block'),
                            'url' => ['/user/admin/block', 'id' => $user->id],
                            'visible' => !$user->isBlocked,
                            'linkOptions' => [
                                'class' => 'text-danger',
                                'data-method' => 'post',
                                'data-confirm' => $this->app->t('user', 'Are you sure you want to block this user?'),
                            ],
                        ],
                        [
                            'label' => $this->app->t('user', 'Unblock'),
                            'url' => ['/user/admin/block', 'id' => $user->id],
                            'visible' => $user->isBlocked,
                            'linkOptions' => [
                                'class' => 'text-success',
                                'data-method' => 'post',
                                'data-confirm' => $this->app->t('user', 'Are you sure you want to unblock this user?'),
                            ],
                        ],
                        [
                            'label' => $this->app->t('user', 'Delete'),
                            'url' => ['/user/admin/delete', 'id' => $user->id],
                            'linkOptions' => [
                                'class' => 'text-danger',
                                'data-method' => 'post',
                                'data-confirm' => $this->app->t('user', 'Are you sure you want to delete this user?'),
                            ],
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-body">
                <?= $content ?>
            </div>
        </div>
    </div>
</div>
