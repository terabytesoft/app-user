<?php

namespace app\user\clients;

use yii\authclient\clients\Google as BaseGoogle;

/**
 * Google
 *
 **/
class Google extends BaseGoogle implements ClientInterface
{
	/**
 	 * getEmail
 	 **/
    public function getEmail()
    {
        return isset($this->getUserAttributes()['emails'][0]['value'])
            ? $this->getUserAttributes()['emails'][0]['value']
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
