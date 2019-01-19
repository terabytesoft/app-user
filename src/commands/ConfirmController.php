<?php

namespace app\user\commands;

use app\user\Module;
use app\user\finder\Finder;
use app\user\traits\ModuleTrait;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * ConfirmController
 *
 * Confirms a user
 *
 * @property self $app
 * @property Module $module
 **/
class ConfirmController extends Controller
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
     * confirms a user by setting confirmed_at field to current time
     *
     * @param string $search Email or username
     **/
    public function actionIndex($search): void
    {
        $user = $this->finder->findUserByUsernameOrEmail($search);
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
