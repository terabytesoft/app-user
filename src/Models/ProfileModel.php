<?php

namespace TerabyteSoft\Module\User\Models;

use TerabyteSoft\Module\User\Traits\ModuleTrait;
use Yiisoft\ActiveRecord\ActiveRecord;

/**
 * Class ProfileModel.
 *
 * This is the model class for table "profile"
 *
 * Database fields:
 * @property int $user_id
 * @property string  $name
 * @property string  $public_email
 * @property string  $gravatar_email
 * @property string  $gravatar_id
 * @property string  $location
 * @property string  $website
 * @property string  $bio
 * @property string  $timezone
 *
 * Dependencies:
 * @property \TerabyteSoft\Module\User\Module module
 * @property \yii\web\Application app
 **/
class ProfileModel extends ActiveRecord
{
	use ModuleTrait;

	/**
	 * tableName.
	 *
	 **/
	public static function tableName()
	{
		return '{{%profile}}';
	}

	/**
	 * getAvatarUrl.
	 *
	 * returns avatar url or null if avatar is not set
	 *
	 * @param int $size
	 * @return null|string
	 **/
	public function getAvatarUrl($size = 200)
	{
		return '//gravatar.com/avatar/' . $this->gravatar_id . '?s=' . $size;
	}

	/**
	 * getUser.
	 *
	 * @return \Yiisoft\ActiveRecord\ActiveQueryInterface
	 **/
	public function getUser()
	{
		return $this->hasOne($this->module->modelMap['UserModel'], ['id' => 'user_id']);
	}

	/**
	 * rules.
	 *
	 * @return array the validation rules
	 **/
	public function rules(): array
	{
		return [
			'bioString' => ['bio', 'string'],
			'timeZoneValidation' => ['timezone', 'validateTimeZone'],
			'publicEmailPattern' => ['public_email', 'email'],
			'gravatarEmailPattern' => ['gravatar_email', 'email'],
			'websiteUrl' => ['website', 'url'],
			'nameLength' => ['name', 'string', 'max' => 255],
			'publicEmailLength' => ['public_email', 'string', 'max' => 255],
			'gravatarEmailLength' => ['gravatar_email', 'string', 'max' => 255],
			'locationLength' => ['location', 'string', 'max' => 255],
			'websiteLength' => ['website', 'string', 'max' => 255],
		];
	}

	/**
	 * validateTimeZone.
	 *
	 * validates the timezone attribute
	 * Adds an error when the specified time zone doesn't exist
	 *
	 * @param string $attribute the attribute being validated
	 * @param array $params values for the placeholders in the error message
	 **/
	public function validateTimeZone($attribute, $params)
	{
		if (!in_array($this->$attribute, timezone_identifiers_list())) {
			$this->addError($attribute, $this->app->t('ModuleUser', 'Time zone is not valid'));
		}
	}

	/**
	 * getTimeZone.
	 *
	 * get the user's time zone
	 * defaults to the application timezone if not specified by the user
	 *
	 * @return \DateTimeZone
	 **/
	public function getTimeZone()
	{
		try {
			return new \DateTimeZone($this->timezone);
		} catch (\Exception $e) {
			// Default to application time zone if the user hasn't set their time zone
			return new \DateTimeZone($this->app->timeZone);
		}
	}

	/**
	 * setTimeZone.
	 *
	 * set the user's time zone
	 *
	 * @param \DateTimeZone $timezone the timezone to save to the user's profile
	 **/
	public function setTimeZone(\DateTimeZone $timeZone)
	{
		$this->setAttribute('timezone', $timeZone->getName());
	}

	/**
	 * toLocalTime.
	 *
	 * converts DateTime to user's local time
	 *
	 * @param \DateTime $dateTime the datetime to convert
	 *
	 * @return \DateTime
	 **/
	public function toLocalTime(\DateTime $dateTime = null)
	{
		if ($dateTime === null) {
			$dateTime = new \DateTime();
		}

		return $dateTime->setTimezone($this->getTimeZone());
	}

	/**
	 * beforeSave.
	 *
	 * @inheritdoc
	 **/
	public function beforeSave($insert)
	{
		if ($this->isAttributeChanged('gravatar_email')) {
			$this->setAttribute('gravatar_id', md5(strtolower(trim($this->getAttribute('gravatar_email')))));
		}

		return parent::beforeSave($insert);
	}
}
