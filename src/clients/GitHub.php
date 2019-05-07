<?php

namespace TerabyteSoft\Module\User\Clients;

use Yiisoft\Yii\AuthClient\Clients\GitHub as BaseGitHub;

/**
 * GitHub
 *
 **/
class GitHub extends BaseGitHub implements ClientInterface
{
	/**
 	 * getEmail
 	 **/
    public function getEmail()
    {
        return isset($this->getUserAttributes()['email'])
            ? $this->getUserAttributes()['email']
            : null;
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
}
