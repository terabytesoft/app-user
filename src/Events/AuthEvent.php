<?php

namespace TerabyteSoft\Module\User\Events;

use yii\base\Event;

/**
 * AuthEvent
 *
 **/
class AuthEvent extends Event
{
	/**
	 * event is triggered raised after executing init action
	 * triggered with TerabyteSoft\Module\User\Events\AuthEvent
	 **/
    const INIT = 'TerabyteSoft\Module\User\Events\AuthEvent::INIT';

    /**
     * event is triggered before authenticating user via social network
     * triggered with TerabyteSoft\Module\User\Events\AuthEvent
     **/
    const BEFORE_AUTHENTICATE = 'TerabyteSoft\Module\User\Events\AuthEvent::BEFORE_AUTHENTICATE';

    /**
     * event is triggered after authenticating user via social network
     * triggered with TerabyteSoft\Module\User\Events\AuthEvent
     **/
    const AFTER_AUTHENTICATE = 'TerabyteSoft\Module\User\Events\AuthEvent::AFTER_AUTHENTICATE';

    /**
     * event is triggered before connecting social network account to user
     * triggered with TerabyteSoft\Module\User\Events\AuthEvent
     **/
    const BEFORE_CONNECT = 'TerabyteSoft\Module\User\Events\AuthEvent::BEFORE_CONNECT';

    /**
     * event is triggered before connecting social network account to user
     * triggered with TerabyteSoft\Module\User\Events\AuthEvent.
     **/
    const AFTER_CONNECT = 'TerabyteSoft\Module\User\Events\AuthEvent::AFTER_CONNECT';

	/**
	 * init
     *
	 * @return self created event
	 **/
	public static function init(): self
	{
		return new static(static::INIT);
	}

	/**
	 * beforeAuthenticate
     *
	 * @return self created event
	 **/
	public static function beforeAuthenticate(): self
	{
		return new static(static::BEFORE_AUTHENTICATE);
    }

    /**
	 * afterAuthenticate
     *
	 * @return self created event
	 **/
	public static function afterAuthenticate(): self
	{
		return new static(static::AFTER_AUTHENTICATE);
    }

	/**
	 * beforeConnect
     *
	 * @return self created event
	 **/
	public static function beforeConnect(): self
	{
		return new static(static::BEFORE_CONNECT);
    }

	/**
	 * afterConnect
     *
	 * @return self created event
	 **/
	public static function afterConnect(): self
	{
		return new static(static::AFTER_CONNECT);
	}
}
