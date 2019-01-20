<?php

namespace app\user\clients;

use app\user\traits\ModuleTrait;
use yii\authclient\clients\Yandex as BaseYandex;

/**
 * Yandex
 *
 * @property self $app
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
