<?php

namespace app\user\commands;

use app\user\Module;
use app\user\traits\ModuleTrait;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * DeleteController
 *
 * Deletes a user
 *
 * @property self $app
 * @property Module $module
 **/
class DeleteController extends Controller
{
	use ModuleTrait;

    protected $userQuery;

    /**
	 * __construct
	 *
     * @param string $id
     * @param Module $module
     **/
    public function __construct(string $id, Module $module)
    {
		$this->userQuery = $module->userQuery;

        parent::__construct($id, $module);
    }

    /**
	 * actionIndex
	 *
     * deletes a user
     *
     * @param string $search Email or username
     **/
    public function actionIndex($search): void
    {
        if ($this->confirm($this->app->t('user', 'Are you sure? Deleted user can not be restored'))) {
            $user = $this->userQuery->findUserByUsernameOrEmail($search);
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
