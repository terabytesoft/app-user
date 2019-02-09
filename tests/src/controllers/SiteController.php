<?php

namespace app\user\tests\controllers;

use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\filters\AccessControl;
use yii\web\filters\VerbFilter;

/**
 * SiteController
 *
 * Layout web application user test
 **/
class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                '__class' => ErrorAction::class,
            ],
        ];
    }

    /**
     * actionIndex
     *
	 * @return array actions config
	 **/
    public function actionIndex()
    {
        return $this->render('index');
    }
}
