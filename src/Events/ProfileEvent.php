<?php

namespace TerabyteSoft\Module\User\Events;

use yii\base\Event;

/**
 * ProfileEvent
 *
 **/
class ProfileEvent extends Event
{
	/**
	 * event is triggered raised after executing init action
	 * triggered with TerabyteSoft\Module\User\Events\ProfileEvent
	 **/
	const INIT = 'TerabyteSoft\Module\User\Events\ProfileEvent::INIT';

    /**
     * event is triggered before updating existing user's profile
     * triggered with TerabyteSoft\Module\User\Events\ProfileEvent
     **/
    const BEFORE_PROFILE_UPDATE = 'TerabyteSoft\Module\User\Events\ProfileEvent::BEFORE_PROFILE_UPDATE';

    /**
     * event is triggered after updating existing user's profile
     * triggered with TerabyteSoft\Module\User\Events\ProfileEvent
     **/
    const AFTER_PROFILE_UPDATE = 'TerabyteSoft\Module\User\Events\ProfileEvent::AFTER_PROFILE_UPDATE';

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
	 * beforeProfileUpdate
     *
	 * @return self created event
	 **/
	public static function beforeProfileUpdate(): self
	{
		return new static(static::BEFORE_PROFILE_UPDATE);
    }

    /**
	 * afterProfileUpdate
     *
	 * @return self created event
	 **/
	public static function afterProfileUpdate(): self
	{
		return new static(static::AFTER_PROFILE_UPDATE);
    }
}
