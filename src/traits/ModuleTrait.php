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
     * getApp
     *
     * @return \yii\web\Application app
     **/
    public function getApp():  \yii\web\Application
    {
        return Yii::getContainer()->get('app');
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
     * getContainer
     *
     * @return object container
     **/
    public function getContainer(string $param): object
    {
        return (object) Yii::getContainer()->get($param);
    }


	/**
     * getModule
     *
     * @return \app\user\Module module
     **/
    public function getModule(): \app\user\Module
    {
        return Yii::getContainer()->get('app')->getModule('user');
    }
}
