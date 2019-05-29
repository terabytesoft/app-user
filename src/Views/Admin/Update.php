<?php

/**
 * admin/update
 *
 * Update user
 *
 * View web application user
 **/

use Yiisoft\Yii\Bootstrap4\Html;
use Yiisoft\Yii\Bootstrap4\Nav;

/**
 * @var string $content
 * @var \TerabyteSoft\Module\User\Models\UserModel $user
 * @var \yii\web\View $this
 **/

$this->title = $this->app->t('ModuleUser', 'Update user account');
$this->params['breadcrumbs'][] = ['label' => $this->app->t('ModuleUser', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('_Menu') ?>

<?= Html::beginTag('div', ['class' => 'row']) ?>

	<?= Html::beginTag('div', ['class' => 'col-md-3']) ?>

		<?= Html::beginTag('h5', ['class' => 'text-center']) ?>
			<?= $this->app->t('ModuleUser', 'Menu Settings') ?>
		<?= Html::endTag('h5') ?>

        <?= Nav::widget([
            'options' => [
				'id' => 'menu-admin-update',
				'aria-orientation' => 'vertical',
				'class' => 'nav flex-column nav-pills',
				'role'=> 'tablist',
            ],
            'items' => [
                [
                    'label' => $this->app->t('ModuleUser', 'Account'),
                     'url' => ['/user/admin/update', 'id' => $user->id]
                    ],
                    [
                        'label' => $this->app->t('ModuleUser', 'Profile'),
                        'url' => ['/user/admin/update-profile', 'id' => $user->id]
                    ],
                    [
						'label' => $this->app->t('ModuleUser', 'Information'),
						'url' => ['/user/admin/info', 'id' => $user->id]],
                    [
                     	'label' => $this->app->t('ModuleUser', 'Assignments'),
                        'url' => ['/user/admin/assignments', 'id' => $user->id],
                        'visible' => false,
                    ],
                    [
                        'label' => $this->app->t('ModuleUser', 'Confirm'),
                        'url' => ['/user/admin/confirm', 'id' => $user->id],
                        'visible' => !$user->isConfirmed,
                        'linkOptions' => [
                            'class' => 'btn-outline-success nav-link',
                            'data-method' => 'post',
                            'data-confirm' => $this->app->t('ModuleUser', 'Are you sure you want to confirm this user?'),
                        ],
                    ],
                    [
                        'label' => $this->app->t('ModuleUser', 'Block'),
                        'url' => ['/user/admin/block', 'id' => $user->id],
                        'visible' => !$user->isBlocked,
                        'linkOptions' => [
                            'class' => 'btn-outline-danger nav-link',
                            'data-method' => 'post',
                            'data-confirm' => $this->app->t('ModuleUser', 'Are you sure you want to block this user?'),
                        ],
                    ],
                    [
                        'label' => $this->app->t('ModuleUser', 'Unblock'),
                        'url' => ['/user/admin/block', 'id' => $user->id],
                        'visible' => $user->isBlocked,
                        'linkOptions' => [
                            'class' => 'btn-outline-success snav-link',
                            'data-method' => 'post',
                            'data-confirm' => $this->app->t('ModuleUser', 'Are you sure you want to unblock this user?'),
                        ],
                    ],
                    [
                        'label' => $this->app->t('ModuleUser', 'Delete'),
                        'url' => ['/user/admin/delete', 'id' => $user->id],
                        'linkOptions' => [
                            'class' => 'btn-outline-danger nav-link',
                            'data-method' => 'post',
                            'data-confirm' => $this->app->t('ModuleUser', 'Are you sure you want to delete this user?'),
                        ],
                    ],
                ],
            ]) ?>

	<?= Html::endTag('div') ?>

	<?= Html::beginTag('div', ['class' => 'col-md-9']) ?>
		<?= $content ?>
	<?= Html::endTag('div') ?>

<?php echo Html::endTag('div');
