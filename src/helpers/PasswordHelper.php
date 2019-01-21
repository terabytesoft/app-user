<?php

namespace app\user\helpers;

use app\user\traits\ModuleTrait;
use yii\base\Security;

/**
 * PasswordHelper
 *
 * Dependencies:
 * @property \app\user\Module module
 **/
class PasswordHelper
{
    use ModuleTrait;

    /**
     * @var Security
     **/
    protected $security;

    /**
	 * __construct
	 *
     **/
    public function __construct()
    {
        $this->security = new Security();
    }

    /**
     * hash
     *
     * wrapper for yii security helper method
     *
     * @param $password
     *
     * @return string
     **/
    public function hash($password)
    {
        return $this->security->generatePasswordHash($password, $this->module->cost);
    }

    /**
     * validate
     *
     * wrapper for yii security helper method
     *
     * @param $password
     * @param $hash
     *
     * @return bool
     */
    public function validate($password, $hash)
    {
        return $this->security->validatePassword($password, $hash);
    }

    /**
     * generate
     *
     * generates user-friendly random password containing at least one lower case letter, one uppercase letter and one
     * digit. The remaining characters in the password are chosen at random from those three sets
     *
     * @see https://gist.github.com/tylerhall/521810
     *
     * @param $length
     *
     * @return string
     */
    public function generate($length)
    {
        $sets = [
            'abcdefghjkmnpqrstuvwxyz',
            'ABCDEFGHJKMNPQRSTUVWXYZ',
            '23456789',
        ];
        $all = '';
        $password = '';
        foreach ($sets as $set) {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }

        $all = str_split($all);
        for ($i = 0; $i < $length - count($sets); $i++) {
            $password .= $all[array_rand($all)];
        }

        $password = str_shuffle($password);

        return $password;
    }
}
