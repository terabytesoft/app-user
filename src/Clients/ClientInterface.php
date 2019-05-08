<?php

namespace TerabyteSoft\Module\User\Clients;

use Yiisoft\Yii\AuthClient\ClientInterface as BaseInterface;

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
