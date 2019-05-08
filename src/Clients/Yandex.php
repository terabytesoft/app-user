<?php

namespace TerabyteSoft\Module\User\Clients;

use TerabyteSoft\Module\User\Traits\ModuleTrait;
use Yiisoft\Yii\AuthClient\Clients\Yandex as BaseYandex;

/**
 * Yandex
 *
 * Dependencies:
 * @property \TerabyteSoft\Module\User\Module module
 * @property \yii\web\Application app
 **/
class Yandex extends BaseYandex implements ClientInterface
{
	use ModuleTrait;

	/**
     * getEmail
     *
     * @return
 	 **/
    public function getEmail(bool $result = null)
    {
        $emails = isset($this->getUserAttributes()['emails'])
            ? $this->getUserAttributes()['emails']
            : null;

        if ($emails !== null && isset($emails[0])) {
			$result = $emails[0];
		}

		return $result;
    }

	/**
 	 * getUsername
     *
     * @return string|null
     **/
    public function getUsername()
    {
        return isset($this->getUserAttributes()['login'])
            ? $this->getUserAttributes()['login']
            : null;
    }

	/**
     * defaultTitle
     *
     * @return string
 	 **/
    protected function defaultTitle(): string
    {
        return $this->app->t('user', 'Yandex');
    }
}
