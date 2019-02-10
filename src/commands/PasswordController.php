<?php

namespace app\user\commands;

use app\user\Module;
use app\user\traits\ModuleTrait;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Class PasswordController.
 *
 * Updates user's password
 *
 * @property \app\user\Module module
 * @property \yii\web\Application app
 **/
class PasswordController extends Controller
{
	use ModuleTrait;

	/**
	 * actionIndex.
	 *
	 * updates user's password to given
	 *
	 * @param string $search Email or username
	 * @param string $password New password
	 **/
	public function actionIndex($search, $password): void
	{
		$user = $this->module->userQuery->findUserByUsernameOrEmail($search);
		if ($user === null) {
			$this->stdout($this->app->t('user', 'User is not found') . "\n", Console::FG_RED);
		} else {
			if ($user->resetPassword($password)) {
				$this->stdout($this->app->t('user', 'Password has been changed') . "\n", Console::FG_GREEN);
			} else {
				$this->stdout($this->app->t('user', 'Error occurred while changing password') . "\n", Console::FG_RED);
			}
		}
	}
}
