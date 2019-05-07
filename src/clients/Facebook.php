<?php

namespace TerabyteSoft\Module\User\Clients;

use Yiisoft\Yii\AuthClient\Clients\Facebook as BaseFacebook;

/**
 * Facebook
 *
 **/
class Facebook extends BaseFacebook implements ClientInterface
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
        return;
    }
}
