<?php

namespace TerabyteSoft\Module\User\Commands;

use TerabyteSoft\Module\User\Module;
use TerabyteSoft\Module\User\Traits\ModuleTrait;
use Yiisoft\Yii\Console\Controller;
use yii\helpers\Console;

/**
 * Class ConfirmController.
 *
 * Confirms a user
 *
 * @property \TerabyteSoft\Module\User\Module $module
 * @property \yii\web\Application $app
 **/
class ConfirmController extends Controller
{
	use ModuleTrait;

	/**
	 * actionIndex.
	 *
	 * confirms a user by setting confirmed_at field to current time
	 *
	 * @param string $search Email or username
	 **/
	public function actionIndex($search): void
	{
		$user = $this->module->userQuery->findUserByUsernameOrEmail($search);
		if ($user === null) {
			$this->stdout($this->app->t('ModuleUser', 'User is not found') . "\n", Console::FG_RED);
		} else {
			if ($user->confirm()) {
				$this->stdout($this->app->t('ModuleUser', 'User has been confirmed') . "\n", Console::FG_GREEN);
			} else {
				$this->stdout($this->app->t('ModuleUser', 'Error occurred while confirming user') . "\n", Console::FG_RED);
			}
		}
	}
}
