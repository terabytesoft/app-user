<?php

namespace app\user\events;

use app\user\forms\RecoveryForm;
use app\user\models\Token;
use yii\base\Event;

/**
 * @property Token        $token
 * @property RecoveryForm $form
 **/
class ResetPasswordEvent extends Event
{
	/**
	 * event is triggered raised after executing init action
	 * triggered with app\user\events\ResetPasswordEvent
	 **/
	const INIT = 'app\user\events\ResetPasswordEvent::INIT';

    /**
     * event is triggered before validating recovery token
     * triggered with app\user\events\ResetPasswordEvent. May not have $form property set
     **/
    const BEFORE_TOKEN_VALIDATE = 'app\user\events\ResetPasswordEvent::BEFORE_TOKEN_VALIDATE';

    /**
     * event is triggered after validating recovery token
     * triggered with app\user\events\ResetPasswordEvent. May not have $form property set
     **/
    const AFTER_TOKEN_VALIDATE = 'app\user\events\ResetPasswordEvent::AFTER_TOKEN_VALIDATE';

    /**
     * event is triggered before resetting password
     * triggered with app\user\events\ResetPasswordEvent
     **/
    const BEFORE_RESET = 'app\user\events\ResetPasswordEvent::BEFORE_RESET';

    /**
     * event is triggered after resetting password
     * triggered with app\user\events\ResetPasswordEvent
     **/
    const AFTER_RESET = 'app\user\events\ResetPasswordEvent::AFTER_RESET';

    /**
     * @var RecoveryForm
     **/
    private $_form;

    /**
     * @var Token
     **/
    private $_token;

    /**
     * getToken
     *
     * @return Token
     **/
    public function getToken()
    {
        return $this->_token;
    }

    /**
     * setToken
     *
     * @param Token $token
     **/
    public function setToken(Token $token = null)
    {
        $this->_token = $token;
    }

    /**
     * RecoveryForm
     *
     * @return RecoveryForm
     **/
    public function getForm()
    {
        return $this->_form;
    }

    /**
     * RecoveryForm
     *
     * @param RecoveryForm $form
     **/
    public function setForm(RecoveryForm $form = null)
    {
        $this->_form = $form;
    }

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
