<?php

use yii\bootstrap4\Nav;

/**
 * @var \yii\web\View $this
 * @var \app\user\models\User $user
 * @var string $content
 */

$this->title = $this-getApp()->t('user', 'Update user account');
$this->params['breadcrumbs'][] = ['label' => $this-getApp()->t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => $this-getApp()->getModule('user')]) ?>

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
                            'label' => $this-getApp()->t('user', 'Account details'),
                            'url' => ['/user/admin/update', 'id' => $user->id]
                        ],
                        [
                            'label' => $this-getApp()->t('user', 'Profile details'),
                            'url' => ['/user/admin/update-profile', 'id' => $user->id]
                        ],
                        ['label' => $this-getApp()->t('user', 'Information'), 'url' => ['/user/admin/info', 'id' => $user->id]],
                        [
                            'label' => $this-getApp()->t('user', 'Assignments'),
                            'url' => ['/user/admin/assignments', 'id' => $user->id],
                            'visible' => isset($this-getApp()->extensions['app/yii2-rbac']),
                        ],
                        '<hr>',
                        [
                            'label' => $this-getApp()->t('user', 'Confirm'),
                            'url' => ['/user/admin/confirm', 'id' => $user->id],
                            'visible' => !$user->isConfirmed,
                            'linkOptions' => [
                                'class' => 'text-success',
                                'data-method' => 'post',
                                'data-confirm' => $this-getApp()->t('user', 'Are you sure you want to confirm this user?'),
                            ],
                        ],
                        [
                            'label' => $this-getApp()->t('user', 'Block'),
                            'url' => ['/user/admin/block', 'id' => $user->id],
                            'visible' => !$user->isBlocked,
                            'linkOptions' => [
                                'class' => 'text-danger',
                                'data-method' => 'post',
                                'data-confirm' => $this-getApp()->t('user', 'Are you sure you want to block this user?'),
                            ],
                        ],
                        [
                            'label' => $this-getApp()->t('user', 'Unblock'),
                            'url' => ['/user/admin/block', 'id' => $user->id],
                            'visible' => $user->isBlocked,
                            'linkOptions' => [
                                'class' => 'text-success',
                                'data-method' => 'post',
                                'data-confirm' => $this-getApp()->t('user', 'Are you sure you want to unblock this user?'),
                            ],
                        ],
                        [
                            'label' => $this-getApp()->t('user', 'Delete'),
                            'url' => ['/user/admin/delete', 'id' => $user->id],
                            'linkOptions' => [
                                'class' => 'text-danger',
                                'data-method' => 'post',
                                'data-confirm' => $this-getApp()->t('user', 'Are you sure you want to delete this user?'),
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
