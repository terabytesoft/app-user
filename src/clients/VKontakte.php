<?php

namespace app\user\clients;

use app\user\traits\ModuleTrait;
use yii\authclient\clients\VKontakte as BaseVKontakte;

/**
 * VKontakte
 *
 * @property self $app
 */
class VKontakte extends BaseVKontakte implements ClientInterface
{
    use ModuleTrait;

    public $scope = 'email';

	/**
 	 * getEmail
 	 **/
    public function getEmail()
    {
        return $this->getAccessToken()->getParam('email');
    }

	/**
 	 * getUsername
 	 **/
    public function getUsername()
    {
        return isset($this->getUserAttributes()['screen_name'])
            ? $this->getUserAttributes()['screen_name']
            : null;
    }

	/**
 	 * defaultTitle
 	 **/
    protected function defaultTitle()
    {
        return $this->app->t('user', 'VKontakte');
    }
}
