<?php

namespace TerabyteSoft\Module\User\Commands;

use TerabyteSoft\Module\User\Module;
use TerabyteSoft\Module\User\Traits\ModuleTrait;
use Yiisoft\Yii\Console\Controller;
use yii\helpers\Console;

/**
 * Class DeleteController.
 *
 * Deletes a user
 *
 * @property \TerabyteSoft\Module\User\Module module
 * @property \yii\web\Application app
 **/
class DeleteController extends Controller
{
	use ModuleTrait;

	/**
	 * actionIndex.
	 *
	 * deletes a user
	 *
	 * @param string $search Email or username
	 **/
	public function actionIndex($search): void
	{
		if ($this->confirm($this->app->t('user', 'Are you sure? Deleted user can not be restored'))) {
			$user = $this->module->userQuery->findUserByUsernameOrEmail($search);
			if ($user === null) {
				$this->stdout($this->app->t('user', 'User is not found') . "\n", Console::FG_RED);
			} else {
				if ($user->delete() !== false) {
					$this->stdout($this->app->t('user', 'User has been deleted') . "\n", Console::FG_GREEN);
				} else {
					$this->stdout($this->app->t('user', 'Error occurred while deleting user') . "\n", Console::FG_RED);
				}
			}
		}
	}
}
