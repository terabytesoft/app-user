<?php

namespace app\user\traits;

use yii\helpers\Yii;

/**
 * ModuleTrait
 *
 **/
trait ModuleTrait
{
    /**
     * getModule
     *
     * @return \app\user\Module module
     **/
    public function getModule(): \app\user\Module
    {
        return Yii::getContainer()->get('app')->modules['user'];
    }

    /**
     * getDb
     *
     * @return object db
     **/
    public static function getDb(): object
    {
        return (object) Yii::getContainer()->get('db');
    }

    /**
     * getApp
     *
     * @return \yii\web\Application app
     **/
    public function getApp():  \yii\web\Application
    {
        return Yii::getContainer()->get('app');
	}
}
