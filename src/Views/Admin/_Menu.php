<?php

/**
 * admin/_Menu
 *
 * View web application user
 **/

use Yiisoft\Yii\Bootstrap4\Nav;

?>

<?php echo Nav::widget([
    'options' => [
		'id' => 'menu-admin',
        'class' => 'mb-1 nav-tabs',
    ],
    'items' => [
        [
            'label' => $this->app->t('ModuleUser', 'Users'),
            'url' => ['/user/admin/index'],
        ],
        [
            'label' => $this->app->t('ModuleUser', 'Roles'),
            'url' => ['/rbac/role/index'],
            'visible' => isset($this->app->extensions['app/yii2-rbac']),
        ],
        [
            'label' => $this->app->t('ModuleUser', 'Permissions'),
            'url' => ['/rbac/permission/index'],
            'visible' => isset($this->app->extensions['app/yii2-rbac']),
        ],
        [
            'label' => $this->app->t('ModuleUser', 'Rules'),
            'url'   => ['/rbac/rule/index'],
            'visible' => isset($this->app->extensions['app/yii2-rbac']),
        ],
        [
            'label' => $this->app->t('ModuleUser', 'Create'),
            'items' => [
                [
                    'label' => $this->app->t('ModuleUser', 'New user'),
                    'url' => ['/user/admin/create'],
                ],
                [
                    'label' => $this->app->t('ModuleUser', 'New role'),
                    'url' => ['/rbac/role/create'],
                    'visible' => isset($this->app->extensions['app/yii2-rbac']),
                ],
                [
                    'label' => $this->app->t('ModuleUser', 'New permission'),
                    'url' => ['/rbac/permission/create'],
                    'visible' => isset($this->app->extensions['app/yii2-rbac']),
                ],
                [
                    'label' => $this->app->t('ModuleUser', 'New rule'),
                    'url'   => ['/rbac/rule/create'],
                    'visible' => isset($this->app->extensions['app/yii2-rbac']),
                ]
            ],
        ],
    ],
]);
