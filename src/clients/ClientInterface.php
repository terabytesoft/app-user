<?php

namespace app\user\clients;

use yii\authclient\ClientInterface as BaseInterface;

/**
 * ClientInterface
 *
 * Enhances default yii client interface by adding methods that can be used to
 * get user's email and username
 *
 * @property Module $module
 * @property-read string $email
 * @property-read string $username
 **/
interface ClientInterface extends BaseInterface
{
	/**
 	 * getEmail
 	 **/
    public function getEmail();

	/**
 	 * getUsername
 	 **/
    public function getUsername();
}
