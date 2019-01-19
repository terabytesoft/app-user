<?php

namespace app\user\events;

use app\user\models\User;
use app\user\models\Account;
use yii\base\Event;

/**
 * @property User    $model
 * @property Account $account
 **/
class ConnectEvent extends Event
{
	/**
	 * event is triggered raised after executing init action
	 * triggered with app\user\events\ConnectEvent
	 **/
	const INIT = 'app\user\events\ConnectEvent::INIT';

    /**
     * event is triggered before connecting user to social account
     * triggered with app\user\events\ConnectEvent
     **/
    const BEFORE_CONNECT = 'app\user\events\ConnectEvent::BEFORE_CONNECT';
    /**
     * event is triggered after connecting user to social account
     * triggered with app\user\events\ConnectEvent
     */
    const AFTER_CONNECT = 'app\user\events\ConnectEvent::AFTER_CONNECT';

    /**
     * event is triggered before disconnecting social account from user
     * triggered with app\user\events\ConnectEvent
     */
    const BEFORE_DISCONNECT = 'app\user\events\ConnectEvent::BEFORE_DISCONNECT';

    /**
     * event is triggered after disconnecting social account from user
     * triggered with app\user\events\ConnectEvent
     */
    const AFTER_DISCONNECT = 'app\user\events\ConnectEvent::AFTER_DISCONNECT';

	/**
	 * init
     *
	 * @return self created event
	 */
	public static function init(): self
	{
		return new static(static::INIT);
	}

	/**
     * beforeConnect
	 *
	 * @return self created event
	 */
	public static function beforeConnect(): self
	{
		return new static(static::BEFORE_CONNECT);
	}

	/**
	 * afterConnect
     *
	 * @return self created event
	 */
	public static function afterConnect(): self
	{
		return new static(static::AFTER_CONNECT);
	}

	/**
	 * beforeDisconnect
     *
	 * @return self created event
	 */
	public static function beforeDisconnect(): self
	{
		return new static(static::BEFORE_DISCONNECT);
	}

	/**
	 * afterDisconnect
     *
	 * @return self created event
	 */
	public static function afterDisconnect(): self
	{
		return new static(static::AFTER_DISCONNECT);
	}

    /**
     * @var User
     */
    private $_user;

    /**
     * @var Account
     */
    private $_account;

    /**
     * getAccount
     *
     * @return Account
     */
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
     * getUser
     *
     * @return User
     */
    public function getUser()
    {
        return $this->_user;
    }

    /**
     * @param User $form
     */
    public function setUser(User $user)
    {
        $this->_user = $user;
    }
}
