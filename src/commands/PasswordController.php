<?php

namespace app\user\commands;

use app\user\Module;
use app\user\finder\Finder;
use app\user\traits\ModuleTrait;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * PasswordController
 *
 * Updates user's password
 *
 * @property self $app
 * @property Module $module
 **/
class PasswordController extends Controller
{
	use ModuleTrait;

    protected $finder;

    /**
	 * __construct
	 *
     * @param string $id
     * @param Module $module
     * @param Finder $finder
     **/
    public function __construct($id, $module, Finder $finder)
    {
        $this->finder = $finder;
        parent::__construct($id, $module);
    }

    /**
	 * actionIndex
	 *
     * updates user's password to given
     *
     * @param string $search Email or username
     * @param string $password New password
     **/
    public function actionIndex($search, $password): void
    {
        $user = $this->finder->findUserByUsernameOrEmail($search);
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
