<?php

namespace TerabyteSoft\Module\User\Events;

use yii\base\Event;

/**
 * ResetPasswordEvent
 *
 **/
class UserEvent extends Event
{
	/**
	 * event is triggered raised after executing init action
	 * triggered with TerabyteSoft\Module\User\Events\UserEvent
	 **/
	const INIT = 'TerabyteSoft\Module\User\Events\UserEvent::INIT';

    /**
     * event is triggered before confirming user
     * triggered with TerabyteSoft\Module\User\Events\UserEvent
     **/
    const BEFORE_CONFIRM = 'TerabyteSoft\Module\User\Events\UserEvent::BEFORE_CONFIRM';

    /**
     * event is triggered before confirming user
     * triggered with TerabyteSoft\Module\User\Events\UserEvent
     **/
    const AFTER_CONFIRM = 'TerabyteSoft\Module\User\Events\UserEvent::AFTER_CONFIRM';

    /**
     * event is triggered before creating new user
     * triggered with TerabyteSoft\Module\User\Events\UserEvent
     **/
    const BEFORE_CREATE = 'TerabyteSoft\Module\User\Events\UserEvent::BEFORE_CREATE';

    /**
     * event is triggered after creating new user
     * triggered with TerabyteSoft\Module\User\Events\UserEvent
     **/
    const AFTER_CREATE = 'TerabyteSoft\Module\User\Events\UserEvent::AFTER_CREATE';

    /**
     * event is triggered before updating existing user
     * triggered with TerabyteSoft\Module\User\Events\UserEvent
     **/
    const BEFORE_UPDATE = 'TerabyteSoft\Module\User\Events\UserEvent::BEFORE_UPDATE';

    /**
     * event is triggered after updating existing user
     * triggered with TerabyteSoft\Module\User\Events\UserEvent
     **/
    const AFTER_UPDATE = 'TerabyteSoft\Module\User\Events\UserEvent::AFTER_UPDATE';

    /**
     * event is triggered before impersonating as another user
     * triggered with TerabyteSoft\Module\User\Events\UserEvent
     **/
    const BEFORE_IMPERSONATE = 'TerabyteSoft\Module\User\Events\UserEvent::BEFORE_IMPERSONATE';

    /**
     * event is triggered after impersonating as another user
     * triggered with TerabyteSoft\Module\User\Events\UserEvent
     **/
    const AFTER_IMPERSONATE = 'TerabyteSoft\Module\User\Events\UserEvent::AFTER_IMPERSONATE';

    /**
     * event is triggered before deleting existing user
     * triggered with TerabyteSoft\Module\User\Events\UserEvent
     **/
    const BEFORE_DELETE = 'TerabyteSoft\Module\User\Events\UserEvent::BEFORE_DELETE';

    /**
     * event is triggered after deleting existing user
     * triggered with TerabyteSoft\Module\User\Events\UserEvent
     **/
    const AFTER_DELETE = 'TerabyteSoft\Module\User\Events\UserEvent::AFTER_DELETE';

    /**
     * event is triggered before blocking existing user
     * triggered with TerabyteSoft\Module\User\Events\UserEvent
     **/
    const BEFORE_BLOCK = 'TerabyteSoft\Module\User\Events\UserEvent::BEFORE_BLOCK';

    /**
     * event is triggered after blocking existing user
     * triggered with TerabyteSoft\Module\User\Events\UserEvent
     **/
    const AFTER_BLOCK = 'TerabyteSoft\Module\User\Events\UserEvent::AFTER_BLOCK';

    /**
     * event is triggered before unblocking existing user
     * triggered with TerabyteSoft\Module\User\Events\UserEvent
     **/
    const BEFORE_UNBLOCK = 'TerabyteSoft\Module\User\Events\UserEvent::BEFORE_UNBLOCK';

    /**
     * event is triggered after unblocking existing user
     * triggered with TerabyteSoft\Module\User\Events\UserEvent
     **/
    const AFTER_UNBLOCK = 'TerabyteSoft\Module\User\Events\UserEvent::AFTER_UNBLOCK';

    /**
     * event is triggered before updating user's profile
     * triggered with TerabyteSoft\Module\User\Events\UserEvent
     **/
    const BEFORE_PROFILE_UPDATE = 'TerabyteSoft\Module\User\Events\UserEvent::BEFORE_PROFILE_UPDATE';

    /**
     * event is triggered after updating user's profile
     * triggered with TerabyteSoft\Module\User\Events\UserEvent
     **/
    const AFTER_PROFILE_UPDATE = 'TerabyteSoft\Module\User\Events\UserEvent::AFTER_PROFILE_UPDATE';

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
	 * beforeConfirm
     *
	 * @return self created event
	 **/
	public static function beforeConfirm(): self
	{
		return new static(static::BEFORE_CONFIRM);
    }

	/**
	 * afterConfirm
     *
	 * @return self created event
	 **/
	public static function afterConfirm(): self
	{
		return new static(static::AFTER_CONFIRM);
    }

	/**
	 * beforeCreate
     *
	 * @return self created event
	 **/
	public static function beforeCreate(): self
	{
		return new static(static::BEFORE_CREATE);
    }

	/**
	 * afterCreate
     *
	 * @return self created event
	 **/
	public static function afterCreate(): self
	{
		return new static(static::AFTER_CREATE);
	}

	/**
	 * beforeUpdate
     *
	 * @return self created event
	 **/
	public static function beforeUpdate(): self
	{
		return new static(static::BEFORE_UPDATE);
    }

	/**
	 * afterUpdate
     *
	 * @return self created event
	 **/
	public static function afterUpdate(): self
	{
		return new static(static::AFTER_UPDATE);
	}

	/**
	 * beforeImpersonate
     *
	 * @return self created event
	 **/
	public static function beforeImpersonate(): self
	{
		return new static(static::BEFORE_IMPERSONATE);
    }

	/**
	 * afterImpersonate
     *
	 * @return self created event
	 **/
	public static function afterImpersonate(): self
	{
        return new static(static::AFTER_IMPERSONATE);
    }

	/**
	 * beforeDelete
     *
	 * @return self created event
	 **/
	public static function beforeDelete(): self
	{
        return new static(static::BEFORE_DELETE);
    }

	/**
	 * afterDelete
     *
	 * @return self created event
	 **/
	public static function afterDelete(): self
	{
        return new static(static::AFTER_DELETE);
    }

	/**
	 * beforeBlock
     *
	 * @return self created event
	 **/
	public static function beforeBlock(): self
	{
        return new static(static::BEFORE_BLOCK);
    }

    /**
	 * afterBlock
     *
	 * @return self created event
	 **/
	public static function afterBlock(): self
	{
        return new static(static::AFTER_BLOCK);
    }

	/**
	 * beforeUnblock
     *
	 * @return self created event
	 **/
	public static function beforeUnblock(): self
	{
        return new static(static::BEFORE_UNBLOCK);
    }

	/**
	 * afterUnblock
     *
	 * @return self created event
	 **/
	public static function afterUnblock(): self
	{
        return new static(static::AFTER_UNBLOCK);
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
