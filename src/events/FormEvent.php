<?php

namespace app\user\events;

use yii\base\Event;
use yii\base\Model;

/**
 * @property Model $model
 */

class FormEvent extends Event
{
	/**
	 * event is triggered raised after executing init action
	 * triggered with app\user\events\FormEvent
	 */
	const INIT = 'app\user\events\FomEvent::INIT';

	/**
	 * event is triggered after creating RegistrationForm class
	 * triggered with app\user\events\FormEvent
	 */
	const BEFORE_REGISTER = 'app\user\events\FomEvent::BEFORE_REGISTER';

	/**
	 * event is triggered after successful registration Form class
	 * triggered with app\user\events\FormEvent
	 */
	const AFTER_REGISTER = 'app\user\events\FomEvent::AFTER_REGISTER';

    /**
     * event is triggered after creating ResendForm class
     * triggered with app\user\events\FormEvent
     */
    const BEFORE_RESEND = 'app\user\events\FomEvent::BEFORE_RESEND';

    /**
     * event is triggered after successful resending of confirmation email
     * triggered with app\user\events\FormEvent
     */
    const AFTER_RESEND = 'app\user\events\FomEvent::AFTER_RESEND';

    /**
     * event is triggered before logging user in
     * triggered with app\user\events\FormEvent
     */
    const BEFORE_LOGIN = 'app\user\events\FomEvent::BEFORE_LOGIN';

    /**
     * event is triggered after logging user in
     * triggered with app\user\events\FormEvent
     */
    const AFTER_LOGIN = 'app\user\events\FomEvent::AFTER_LOGIN';

    /**
     * event is triggered before logging user out
     * triggered with app\user\events\UserEvent
     */
    const BEFORE_LOGOUT = 'app\user\events\FomEvent::BEFORE_LOGOUT';

    /**
     * event is triggered after logging user out
     * triggered with app\user\events\UserEvent
     */
    const AFTER_LOGOUT = 'app\user\events\FomEvent::AFTER_LOGOUT';

    /**
     * event is triggered before requesting password reset
     * triggered with app\user\events\FormEvent
     */
    const BEFORE_REQUEST = 'app\user\events\FomEvent::BEFORE_REQUEST';

    /**
     * event is triggered after requesting password reset
     * triggered with app\user\events\FormEvent
     */
    const AFTER_REQUEST = 'app\user\events\FomEvent::AFTER_REQUEST';

    /**
     * event is triggered before updating user's account settings
     * triggered with app\user\events\FormEvent
     */
    const BEFORE_ACCOUNT_UPDATE = 'app\user\events\FomEvent::BEFORE_ACCOUNT_UPDATE';

    /**
     * event is triggered after updating user's account settings
     * triggered with app\user\events\FormEvent
     */
    const AFTER_ACCOUNT_UPDATE = 'app\user\events\FomEvent::AFTER_ACCOUNT_UPDATE';


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
	 * beforeRegister
     *
	 * @return self created event
	 */
	public static function beforeRegister(): self
	{
		return new static(static::BEFORE_REGISTER);
	}

	/**
	 * afterRegister
     *
	 * @return self created event
	 */
	public static function afterRegister(): self
	{
		return new static(static::AFTER_REGISTER);
    }

    /**
	 * beforeResend
     *
	 * @return self created event
	 */
	public static function beforeResend(): self
	{
		return new static(static::BEFORE_RESEND);
    }

    /**
	 * afterResend
     *
	 * @return self created event
	 */
	public static function afterResend(): self
	{
		return new static(static::AFTER_RESEND);
    }

    /**
	 * beforeLogin
     *
	 * @return self created event
	 */
	public static function beforeLogin(): self
	{
		return new static(static::BEFORE_LOGIN);
    }

    /**
	 * afterLogin
     *
	 * @return self created event
	 */
	public static function afterLogin(): self
	{
		return new static(static::AFTER_LOGIN);
    }

    /**
	 * beforeLogout
     *
	 * @return self created event
	 */
	public static function beforeLogout(): self
	{
		return new static(static::BEFORE_LOGOUT);
    }

    /**
	 * afterLogout
     *
	 * @return self created event
	 */
	public static function afterLogout(): self
	{
		return new static(static::AFTER_LOGOUT);
    }

    /**
	 * beforeRequest
     *
	 * @return self created event
	 */
	public static function beforeRequest(): self
	{
		return new static(static::BEFORE_REQUEST);
    }

    /**
	 * afterRequest
     *
	 * @return self created event
	 */
	public static function afterRequest(): self
	{
		return new static(static::AFTER_REQUEST);
    }

    /**
	 * beforeAccountUpdate
     *
	 * @return self created event
	 */
	public static function beforeAccountUpdate(): self
	{
		return new static(static::BEFORE_ACCOUNT_UPDATE);
    }

    /**
	 * afterAccountUpdate
     *
	 * @return self created event
	 */
	public static function afterAccountUpdate(): self
	{
		return new static(static::AFTER_ACCOUNT_UPDATE);
    }
}
