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
     * @return object Module
     */
    public function getModule()
    {
        return (object) Yii::getContainer()->get('app')->modules['user'];
    }

    /**
     * @return string
     */
    public static function getDb()
    {
        return Yii::getContainer()->get('db');
    }

    /**
     * @return yii\web\Application App
     */
    public function getApp()
    {
        return Yii::getContainer()->get('app');
	}
}
