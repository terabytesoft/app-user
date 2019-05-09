<?php

namespace TerabyteSoft\Module\User\Commands;

use TerabyteSoft\Module\User\Module;
use TerabyteSoft\Module\User\Traits\ModuleTrait;
use Yiisoft\Yii\Console\Controller;
use yii\helpers\Console;

/**
 * Class CreateController.
 *
 * Creates new user account
 *
 * @property \TerabyteSoft\Module\User\Module module
 * @property \yii\web\Application app
 **/
class CreateController extends Controller
{
	use ModuleTrait;

	/**
	 * actionIndex.
	 *
	 * this command creates new user account. If password is not set, this command will generate new 8-char password
	 * after saving user to database, this command uses mailer component to send credentials (username and password) to
	 * user via email
	 *
	 * @param string      $email    Email address
	 * @param string      $username Username
	 * @param null|string $password Password (if null it will be generated automatically)
	 **/
	public function actionIndex($email, $username, $password = null): void
	{
		$user = $this->module->userModel;
		$user->scenario = 'create';
		$user->email = $email;
		$user->username = $username;
		$user->password = $password;

		if ($user->create()) {
			$this->stdout($this->app->t('user', 'User has been created') . "!\n", Console::FG_GREEN);
		} else {
			$this->stdout($this->app->t('user', 'Please fix following errors:') . "\n", Console::FG_RED);
			foreach ($user->errors as $errors) {
				foreach ($errors as $error) {
					$this->stdout(' - ' . $error . "\n", Console::FG_RED);
				}
			}
		}
	}
}
