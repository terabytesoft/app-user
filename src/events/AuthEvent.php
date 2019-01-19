<?php

namespace app\user\events;

use app\user\models\Account;
use yii\authclient\ClientInterface;
use yii\base\Event;

/**
 * @property Account         $account
 * @property ClientInterface $client
 **/
class AuthEvent extends Event
{
	/**
	 * event is triggered raised after executing init action
	 * triggered with app\user\events\AuthEvent
	 **/
    const INIT = 'app\user\events\AuthEvent::INIT';

    /**
     * event is triggered before authenticating user via social network
     * triggered with app\user\events\AuthEvent
     **/
    const BEFORE_AUTHENTICATE = 'app\user\events\AuthEvent::BEFORE_AUTHENTICATE';

    /**
     * event is triggered after authenticating user via social network
     * triggered with app\user\events\AuthEvent
     **/
    const AFTER_AUTHENTICATE = 'app\user\events\AuthEvent::AFTER_AUTHENTICATE';

    /**
     * event is triggered before connecting social network account to user
     * triggered with app\user\events\AuthEvent
     **/
    const BEFORE_CONNECT = 'app\user\events\AuthEvent::BEFORE_CONNECT';

    /**
     * event is triggered before connecting social network account to user
     * triggered with app\user\events\AuthEvent.
     **/
    const AFTER_CONNECT = 'app\user\events\AuthEvent::AFTER_CONNECT';

    /**
     * @var ClientInterface
     **/
    private $_client;

    /**
     * @var Account
     **/
    private $_account;

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

    /**
     * getAccount
     *
     * @return Account
     **/
    public function getAccount()
    {
        return $this->_account;
    }

    /**
     * setAccount
     *
     * @param Account $account
     */
    public function setAccount(Account $account)
    {
        $this->_account = $account;
    }

    /**
     * getClient
     *
     * @return ClientInterface
     */
    public function getClient()
    {
        return $this->_client;
    }

    /**
     * setClient
     *
     * @param ClientInterface $client
     */
    public function setClient(ClientInterface $client)
    {
        $this->_client = $client;
    }
}
