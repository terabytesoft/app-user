<?php

namespace app\user\events;

use app\user\models\Profile;
use yii\base\Event;

/**
 * @property Profile $model
 **/
class ProfileEvent extends Event
{
   /**
     * @var Profile
     **/
    private $_profile;

	/**
	 * event is triggered raised after executing init action
	 * triggered with app\user\events\ProfileEvent
	 **/
	const INIT = 'app\user\events\ProfileEvent::INIT';

    /**
     * event is triggered before updating existing user's profile
     * triggered with app\user\events\ProfileEvent
     **/
    const BEFORE_PROFILE_UPDATE = 'app\user\events\ProfileEvent::BEFORE_PROFILE_UPDATE';

    /**
     * event is triggered after updating existing user's profile
     * triggered with app\user\events\ProfileEvent
     **/
    const AFTER_PROFILE_UPDATE = 'app\user\events\ProfileEvent::AFTER_PROFILE_UPDATE';

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

    /**
     * getProfile
     *
     * @return Profile
     **/
    public function getProfile()
    {
        return $this->_profile;
    }

    /**
     * setProfile
     *
     * @param Profile $form
     **/
    public function setProfile(Profile $form)
    {
        $this->_profile = $form;
    }
}
