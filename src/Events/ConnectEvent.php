<?php

namespace TerabyteSoft\Module\User\Events;

use yii\base\Event;

/**
 * ConnectEvent
 *
 **/
class ConnectEvent extends Event
{
	/**
	 * event is triggered raised after executing init action
	 * triggered with TerabyteSoft\Module\User\Events\ConnectEvent
	 **/
	const INIT = 'TerabyteSoft\Module\User\Events\ConnectEvent::INIT';

    /**
     * event is triggered before connecting user to social account
     * triggered with TerabyteSoft\Module\User\Events\ConnectEvent
     **/
    const BEFORE_CONNECT = 'TerabyteSoft\Module\User\Events\ConnectEvent::BEFORE_CONNECT';
    /**
     * event is triggered after connecting user to social account
     * triggered with TerabyteSoft\Module\User\Events\ConnectEvent
     */
    const AFTER_CONNECT = 'TerabyteSoft\Module\User\Events\ConnectEvent::AFTER_CONNECT';

    /**
     * event is triggered before disconnecting social account from user
     * triggered with TerabyteSoft\Module\User\Events\ConnectEvent
     */
    const BEFORE_DISCONNECT = 'TerabyteSoft\Module\User\Events\ConnectEvent::BEFORE_DISCONNECT';

    /**
     * event is triggered after disconnecting social account from user
     * triggered with TerabyteSoft\Module\User\Events\ConnectEvent
     */
    const AFTER_DISCONNECT = 'TerabyteSoft\Module\User\Events\ConnectEvent::AFTER_DISCONNECT';

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

	/**
	 * beforeDisconnect
     *
	 * @return self created event
	 **/
	public static function beforeDisconnect(): self
	{
		return new static(static::BEFORE_DISCONNECT);
	}

	/**
	 * afterDisconnect
     *
	 * @return self created event
	 **/
	public static function afterDisconnect(): self
	{
		return new static(static::AFTER_DISCONNECT);
	}
}
