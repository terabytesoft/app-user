<?php

namespace app\user\widgets;

use app\user\traits\ModuleTrait;
use yii\bootstrap4\Menu;
use yii\widgets\Widget;

/**
 * UserMenu.
 *
 * User menu widget.
 *
 * @property self $app
 **/
class UserMenu extends Widget
{
	use ModuleTrait;

	/** @array \app\user\forms\RegistrationForm */
	public $items;

	public function init(): void
	{
		parent::init();

		$networksVisible = count($this->app->authClientCollection->clients) > 0;

		$this->items = [
				['label' => $this->app->t('user', 'Profile'), 'url' => ['/user/settings/profile']],
				['label' => $this->app->t('user', 'Account'), 'url' => ['/user/settings/account']],
				[
					'label' => $this->app->t('user', 'Networks'),
					'url' => ['/user/settings/networks'],
					'visible' => $networksVisible,
				],
			];
	}

	/**
	 * @inheritdoc
	 **/
	public function run()
	{
		return Menu::widget([
			'options' => [
				'class' => 'nav nav-pills nav-stacked',
			],
			'items' => $this->items,
		]);
	}
}
