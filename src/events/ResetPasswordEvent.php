<?php

namespace TerabyteSoft\Module\User\Events;

use yii\base\Event;

/**
 * ResetPasswordEvent
 *
 **/
class ResetPasswordEvent extends Event
{
	/**
	 * event is triggered raised after executing init action
	 * triggered with TerabyteSoft\Module\User\Events\ResetPasswordEvent
	 **/
	const INIT = 'TerabyteSoft\Module\User\Events\ResetPasswordEvent::INIT';

    /**
     * event is triggered before validating recovery token
     * triggered with TerabyteSoft\Module\User\Events\ResetPasswordEvent. May not have $form property set
     **/
    const BEFORE_TOKEN_VALIDATE = 'TerabyteSoft\Module\User\Events\ResetPasswordEvent::BEFORE_TOKEN_VALIDATE';

    /**
     * event is triggered after validating recovery token
     * triggered with TerabyteSoft\Module\User\Events\ResetPasswordEvent. May not have $form property set
     **/
    const AFTER_TOKEN_VALIDATE = 'TerabyteSoft\Module\User\Events\ResetPasswordEvent::AFTER_TOKEN_VALIDATE';

    /**
     * event is triggered before resetting password
     * triggered with TerabyteSoft\Module\User\Events\ResetPasswordEvent
     **/
    const BEFORE_RESET = 'TerabyteSoft\Module\User\Events\ResetPasswordEvent::BEFORE_RESET';

    /**
     * event is triggered after resetting password
     * triggered with TerabyteSoft\Module\User\Events\ResetPasswordEvent
     **/
    const AFTER_RESET = 'TerabyteSoft\Module\User\Events\ResetPasswordEvent::AFTER_RESET';

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
	 * beforeTokenValidate
     *
	 * @return self created event
	 **/
	public static function beforeTokenValidate(): self
	{
		return new static(static::BEFORE_TOKEN_VALIDATE);
    }

    /**
	 * afterTokenValidate
     *
	 * @return self created event
	 **/
	public static function afterTokenValidate(): self
	{
		return new static(static::AFTER_TOKEN_VALIDATE);
    }

    /**
	 * beforeReset
     *
	 * @return self created event
	 **/
	public static function beforeReset(): self
	{
		return new static(static::BEFORE_RESET);
    }

    /**
	 * afterReset
     *
	 * @return self created event
	 **/
	public static function afterReset(): self
	{
		return new static(static::AFTER_RESET);
	}
}
