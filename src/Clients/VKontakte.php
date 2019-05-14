<?php

namespace TerabyteSoft\Module\User\Clients;

use TerabyteSoft\Module\User\Traits\ModuleTrait;
use Yiisoft\Yii\AuthClient\Clients\VKontakte as BaseVKontakte;

/**
 * VKontakte
 *
 * Dependencies:
 * @property \TerabyteSoft\Module\User\Module module
 * @property \yii\web\Application app
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
        return $this->app->t('ModuleUser', 'VKontakte');
    }
}
