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
     * @return Module
     */
    public function getModule()
    {
        return Yii::getContainer()->get('app')->modules['user'];
    }

    /**
     * @return string
     */
    public static function getDb()
    {
        return Yii::getContainer()->get('db');
    }

    /**
     * @return self
     */
    public function getApp(): self
    {
        return Yii::getContainer()->get('app');
    }
}
