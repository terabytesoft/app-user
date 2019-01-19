<?php

use yii\bootstrap4\Nav;

?>

<?= Nav::widget([
    'options' => [
        'class' => 'nav-tabs',
        'style' => 'margin-bottom: 15px',
    ],
    'items' => [
        [
            'label' => $this->getApp()->t('user', 'Users'),
            'url' => ['/user/admin/index'],
        ],
        [
            'label' => $this->getApp()->t('user', 'Roles'),
            'url' => ['/rbac/role/index'],
            'visible' => isset($this->getApp()->extensions['app/yii2-rbac']),
        ],
        [
            'label' => $this->getApp()->t('user', 'Permissions'),
            'url' => ['/rbac/permission/index'],
            'visible' => isset($this->getApp()->extensions['app/yii2-rbac']),
        ],
        [
            'label' => $this->getApp()->t('user', 'Rules'),
            'url'   => ['/rbac/rule/index'],
            'visible' => isset($this->getApp()->extensions['app/yii2-rbac']),
        ],
        [
            'label' => $this->getApp()->t('user', 'Create'),
            'items' => [
                [
                    'label' => $this->getApp()->t('user', 'New user'),
                    'url' => ['/user/admin/create'],
                ],
                [
                    'label' => $this->getApp()->t('user', 'New role'),
                    'url' => ['/rbac/role/create'],
                    'visible' => isset($this->getApp()->extensions['app/yii2-rbac']),
                ],
                [
                    'label' => $this->getApp()->t('user', 'New permission'),
                    'url' => ['/rbac/permission/create'],
                    'visible' => isset($this->getApp()->extensions['app/yii2-rbac']),
                ],
                [
                    'label' => $this->getApp()->t('user', 'New rule'),
                    'url'   => ['/rbac/rule/create'],
                    'visible' => isset($this->getApp()->extensions['app/yii2-rbac']),
                ]
            ],
        ],
    ],
]) ?>
