<?php

namespace app\user\widgets;

use app\user\forms\LoginForm;
use yii\base\Widget;

/**
 * Login
 *
 * Login for widget
 **/
class Login extends Widget
{
    /**
     * @var bool
     **/
    public $validate = true;

    /**
     * @inheritdoc
     **/
    public function run()
    {
        return $this->render('login', [
            'model' => new LoginForm(),
        ]);
    }
}
