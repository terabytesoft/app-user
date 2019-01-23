<?php

/**
 * admin/_menu
 *
 * View web application user
 **/

use yii\bootstrap4\Nav;

?>

<?php echo Nav::widget([
    'options' => [
		'id' => 'menu-admin',
        'class' => 'mb-1 nav-tabs',
    ],
    'items' => [
        [
            'label' => $this->app->t('user', 'Users'),
            'url' => ['/user/admin/index'],
        ],
        [
            'label' => $this->app->t('user', 'Roles'),
            'url' => ['/rbac/role/index'],
            'visible' => isset($this->app->extensions['app/yii2-rbac']),
        ],
        [
            'label' => $this->app->t('user', 'Permissions'),
            'url' => ['/rbac/permission/index'],
            'visible' => isset($this->app->extensions['app/yii2-rbac']),
        ],
        [
            'label' => $this->app->t('user', 'Rules'),
            'url'   => ['/rbac/rule/index'],
            'visible' => isset($this->app->extensions['app/yii2-rbac']),
        ],
        [
            'label' => $this->app->t('user', 'Create'),
            'items' => [
                [
                    'label' => $this->app->t('user', 'New user'),
                    'url' => ['/user/admin/create'],
                ],
                [
                    'label' => $this->app->t('user', 'New role'),
                    'url' => ['/rbac/role/create'],
                    'visible' => isset($this->app->extensions['app/yii2-rbac']),
                ],
                [
                    'label' => $this->app->t('user', 'New permission'),
                    'url' => ['/rbac/permission/create'],
                    'visible' => isset($this->app->extensions['app/yii2-rbac']),
                ],
                [
                    'label' => $this->app->t('user', 'New rule'),
                    'url'   => ['/rbac/rule/create'],
                    'visible' => isset($this->app->extensions['app/yii2-rbac']),
                ]
            ],
        ],
    ],
]);
