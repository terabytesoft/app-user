<?php

namespace app\user\traits;

use app\user\Module;
use yii\helpers\Yii;

/**
 * Trait ModuleTrait
 *
 * @property-read Module $module
 */
trait ModuleTrait
{
    /**
     * getModule
     *
     * @return object module
     */
    public function getModule()
    {
        return (object) Yii::getContainer()->get('app')->modules['user'];
    }

    /**
     * getDb
     *
     * @return string
     */
    public static function getDb()
    {
        return Yii::getContainer()->get('db');
    }

    /**
     * getApp
     *
     * @return \yii\web\Application app
     */
    public function getApp()
    {
        return Yii::getContainer()->get('app');
	}
}
