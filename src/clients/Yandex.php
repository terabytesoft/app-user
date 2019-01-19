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

	protected $result;

	/**
 	 * getEmail
 	 **/
    public function getEmail()
    {
		$this->result = null;

        $emails = isset($this->getUserAttributes()['emails'])
            ? $this->getUserAttributes()['emails']
            : null;

        if ($emails !== null && isset($emails[0])) {
			$this->resullt = $emails[0];
		}

		return $this->result;
    }

	/**
 	 * getUsername
 	 **/
    public function getUsername()
    {
        return isset($this->getUserAttributes()['login'])
            ? $this->getUserAttributes()['login']
            : null;
    }

	/**
 	 * defaultTitle
 	 **/
    protected function defaultTitle()
    {
        return $this->app->t('user', 'Yandex');
    }
}
