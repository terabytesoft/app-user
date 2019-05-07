<?php

namespace TerabyteSoft\Module\User\Clients;

use Yiisoft\Yii\AuthClient\Clients\Twitter as BaseTwitter;
use Yiisoft\Arrays\ArrayHelper;

/**
 * Twitter
 *
 **/
class Twitter extends BaseTwitter implements ClientInterface
{
    /**
	 * getUsername
	 *
     * @return string
     **/
    public function getUsername()
    {
        return ArrayHelper::getValue($this->getUserAttributes(), 'screen_name');
    }

    /**
	 * getEmail
	 *
     * @return string|null User's email, Twitter does not provide user's email address
     * unless elevated permissions have been granted
     * https://dev.twitter.com/rest/reference/get/account/verify_credentials
     **/
    public function getEmail()
    {
        return ArrayHelper::getValue($this->getUserAttributes(), 'email');
    }
}
