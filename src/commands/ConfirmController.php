<?php

namespace app\user\commands;

use app\user\Module;
use app\user\traits\ModuleTrait;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * ConfirmController
 *
 * Confirms a user
 *
 * Dependencies:
 * @property \app\user\Module module
 * @property \yii\activerecord\ActiveQuery userQuery
 * @property \yii\web\Application app
 **/
class ConfirmController extends Controller
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
     * confirms a user by setting confirmed_at field to current time
     *
     * @param string $search Email or username
     **/
    public function actionIndex($search): void
    {
        $user = $this->userQuery->findUserByUsernameOrEmail($search);
        if ($user === null) {
            $this->stdout($this->app->t('user', 'User is not found') . "\n", Console::FG_RED);
        } else {
            if ($user->confirm()) {
                $this->stdout($this->app->t('user', 'User has been confirmed') . "\n", Console::FG_GREEN);
            } else {
                $this->stdout($this->app->t('user', 'Error occurred while confirming user') . "\n", Console::FG_RED);
            }
        }
    }
}
