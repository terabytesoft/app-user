<?php

namespace TerabyteSoft\Module\User\Clients;

use Yiisoft\Yii\AuthClient\Clients\LinkedIn as BaseLinkedIn;

/**
 * LinkedIn
 *
 **/
class LinkedIn extends BaseLinkedIn implements ClientInterface
{
	/**
 	 * getEmail
 	 **/
    public function getEmail()
    {
        return isset($this->getUserAttributes()['email-address'])
            ? $this->getUserAttributes()['email-address']
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
