<?php

namespace app\user\controllers;

use app\user\Module;
use app\user\finder\Finder;
use app\user\events\ConnectEvent;
use app\user\events\FormEvent;
use app\user\events\ResetPasswordEvent;
use app\user\events\UserEvent;
use app\user\forms\RegistrationForm;
use app\user\forms\ResendForm;
use app\user\models\TokenModel;
use app\user\models\UserModel;
use app\user\traits\AjaxValidationTrait;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\filters\AccessControl;

/**
 * RegistrationController
 *
 * Is responsible for all registration process, which includes registration of a new account
 * resending confirmation tokens, email confirmation and registration via social networks
 *
 * @property Module $module
 */
class RegistrationController extends Controller
{
    use AjaxValidationTrait;

    protected $finder;

    /**
	 * __construct
	 *
     * @param string $id
     * @param Module $module
     * @param Finder $finder
     */
    public function __construct(string $id, Module $module, Finder $finder)
    {
        $this->finder = $finder;
        parent::__construct($id, $module);
    }

	/**
     * behaviors
     *
	 * @return array behaviors config
	 **/
    public function behaviors(): array
    {
        return [
            'access' => [
                '__class' => AccessControl::class,
                'rules' => [
                    ['allow' => true, 'actions' => ['register', 'connect'], 'roles' => ['?']],
                    ['allow' => true, 'actions' => ['confirm', 'resend'], 'roles' => ['?', '@']],
                ],
            ],
        ];
    }

    /**
	 * actionRegister
	 *
     * displays the registration page
     * After successful registration if enableConfirmation is enabled shows info message otherwise
     * redirects to home page
     *
     * @return string|object
     * @throws \yii\web\HttpException
     */
    public function actionRegister()
    {
        if (!$this->module->enableRegistration) {
            throw new NotFoundHttpException();
        }

        $this->trigger(FormEvent::init());

        /** @var RegistrationForm $model */
        $model = new RegistrationForm();

        $this->trigger(FormEvent::beforeRegister());
        $this->performAjaxValidation($model);

        if ($model->load($this->app->request->post()) && $model->validate()) {
            if ($model->register()) {
                $this->trigger(FormEvent::afterRegister());

                $this->app->session->setFlash(
                    'info',
                    $this->app->t(
                        'user',
                        'Your account has been created and a message with further instructions has been sent to your email'
                    )
                );
            } else {
				$this->app->session->setFlash(
					'warning',
					$this->app->t(
						'user',
						'The account could not be created. Contact the administrator.'
                    )
                );
			}

            return $this->goHome();
        }

        return $this->render('register', [
            'model'  => $model,
            'module' => $this->module,
        ]);
    }

    /**
	 * actionConnect
	 *
     * displays page where user can create new account that will be connected to social account
     *
     * @param string|\yii\web\Response
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionConnect(string $code)
    {
        $account = $this->finder->findAccount()->byCode($code)->one();

        if ($account === null || $account->getIsConnected()) {
            throw new NotFoundHttpException();
        }

        $this->trigger(ConnectEvent::init());

		$user = new UserModel();
		$user->scenario = 'connect';
		$user->username = $account->username;
		$user->email = $account->email;

        $this->trigger(ConnectEvent::beforeConnect());

        if ($user->load($this->app->request->post()) && $user->create()) {
            $account->connect($user);
            $this->trigger(ConnectEvent::afterConnect());
            $this->app->user->login($user, $this->module->rememberFor);
            return $this->goBack();
        }

        return $this->render('connect', [
            'model'   => $user,
            'account' => $account,
        ]);
    }

    /**
	 * actionConfirm
	 *
     * confirms user's account. If confirmation was successful logs the user and shows success message. Otherwise
     * shows error message
     *
     * @param int    $id
     * @param string $code
     *
     * @return mixed
     * @throws \yii\web\HttpException
     */
    public function actionConfirm(int $id, string $code)
    {
        $user = $this->finder->findUserById($id);

        if ($user === null || $this->module->enableConfirmation === false) {
            throw new NotFoundHttpException();
        }

        $this->trigger(UserEvent::init());
        $this->trigger(UserEvent::beforeConfirm());

        $token = $this->finder->findTokenByParams($user->id, $code, TokenModel::TYPE_CONFIRMATION);

		$this->app->session->set('token', $token);
		$result = false;

        if ($token instanceof TokenModel && !$token->isExpired) {
			$token->delete();
            if ($result = $user->confirm()) {
				$this->app->user->login($user, $this->module->rememberFor);
                $message = $this->app->t('user', 'Thank you, registration is now complete.');
            } else {
                $message = $this->app->t('user', 'Something went wrong and your account has not been confirmed.');
			}
        } else {
            $message = $this->app->t('user', 'The confirmation link is invalid or expired. Please try requesting a new one.');
        }

        $this->app->session->setFlash($result ? 'success' : 'danger', $message);

        $this->trigger(UserEvent::afterConfirm());

        return $this->goHome();
    }

    /**
	 * actionResend
	 *
     * displays page where user can request new confirmation token. If resending was successful, displays message
     *
     * @return string|object
     * @throws \yii\web\HttpException
     */
    public function actionResend()
    {
        if ($this->module->enableConfirmation === false) {
            throw new NotFoundHttpException();
        }

        $this->trigger(FormEvent::init());

        $model = new ResendForm();

        $this->trigger(FormEvent::beforeResend());
        $this->performAjaxValidation($model);

		if ($model->load($this->app->request->post()) && $model->validate()) {
			if ($model->resend()) {
				$this->trigger(FormEvent::afterResend());

				$this->app->session->setFlash(
					'info',
					$this->app->t(
						'user',
						'A message has been sent to your email address. It contains a confirmation link that you must click to complete registration.'
					)
				);
            } else {
				$this->app->session->setFlash(
					'warning',
					$this->app->t(
						'user',
						'A message has not been sent to your email address. The user has already been confirmed.'
                    )
                );
			}

			return $this->goHome();
        }

        return $this->render('resend', [
            'model' => $model,
        ]);
    }
}
