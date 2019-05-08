<?php

namespace TerabyteSoft\Module\User\Filters;

use yii\web\NotFoundHttpException;
use yii\base\ActionFilter;

/**
 * BackendFilter is used to allow access only to admin and security controller in frontend when using Yii2-user with
 * Yii2 advanced template.
 */
class BackendFilter extends ActionFilter
{
    /**
     * @var array
     */
    public $controllers = ['profile', 'recovery', 'registration', 'settings'];

    /**
     * @param \yii\base\Action $action
     *
     * @return bool
     * @throws \yii\web\NotFoundHttpException
     */
    public function beforeAction($action)
    {
        if (in_array($action->controller->id, $this->controllers)) {
            throw new NotFoundHttpException('Not found');
        }

        return true;
    }
}
