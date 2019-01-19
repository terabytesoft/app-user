<?php

namespace app\user\clients;

use yii\authclient\clients\Facebook as BaseFacebook;

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
