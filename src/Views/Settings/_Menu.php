<?php

/**
 * _Menu
 **/

use Yiisoft\Yii\Bootstrap4\Html;
use Yiisoft\Yii\Bootstrap4\Nav;

/**
 * @var \TerabyteSoft\Module\User\Models\UserModel $user
 **/

$user = $this->app->user->identity;

$menuSettings = [
	[
		'label' => $this->app->t('ModuleUser', 'Profile'),
		'url' => ['/user/settings/profile'],
		'linkOptions' => ['class' => 'nav-link'],
	],
	[
		'label' => $this->app->t('ModuleUser', 'Account'),
		'url' => ['/user/settings/account'],
		'linkOptions' => ['class' => 'nav-link'],
	],
	[
		'label' => $this->app->t('ModuleUser', 'Social Accounts'),
		'url' => ['/user/settings/networks'],
		'linkOptions' => ['class' => 'nav-link'],
	],
];

if ($this->app->controller->action->id === 'account') {
	$menuSettings[] = [
		'label' => $this->app->t('ModuleUser', 'Delete account'),
		'url' => ['delete'],
		'linkOptions' => [
			'class' => 'btn-outline-danger nav-link',
			'data-method' => 'post',
			'data-confirm' => $this->app->t('ModuleUser', 'Are you sure? There is no going back'),
		],
		'visible' => ($this->app->modules['user']->accountDelete),
	];
}

?>

<?= Html::beginTag('h5', ['class' => 'text-center']) ?>
	<?= $this->app->t('ModuleUser', 'Menu Settings') ?>
<?= Html::endTag('h5') ?>

<?php echo Nav::widget([
	'items' => $menuSettings,
	'options' => [
		'aria-orientation' => 'vertical',
		'class' => 'nav flex-column nav-pills',
		'id' => 'v-pills-tab',
		'role'=> 'tablist',
	],
]);
