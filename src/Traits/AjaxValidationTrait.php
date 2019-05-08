<?php

namespace TerabyteSoft\Module\User\Traits;

use yii\base\Model;
use yii\helpers\Yii;
use yii\web\Response;
use Yiisoft\Yii\Bootstrap4\ActiveForm;

trait AjaxValidationTrait
{
    /**
     * Performs ajax validation.
     *
     * @param Model $model
     *
     * @throws \yii\base\ExitException
     */
    protected function performAjaxValidation(Model $model)
    {
        if (Yii::getApp()->request->isAjax && $model->load(Yii::getApp()->request->post())) {
            Yii::getApp()->response->format = Response::FORMAT_JSON;
            Yii::getApp()->response->data   = ActiveForm::validate($model);
            Yii::getApp()->response->send();
            Yii::getApp()->end();
        }
    }
}
