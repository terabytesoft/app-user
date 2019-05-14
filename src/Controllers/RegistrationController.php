<?php

namespace TerabyteSoft\Module\User\Controllers;

use TerabyteSoft\Module\User\Events\ConnectEvent;
use TerabyteSoft\Module\User\Events\FormEvent;
use TerabyteSoft\Module\User\Events\UserEvent;
use TerabyteSoft\Module\User\Module;
use TerabyteSoft\Module\User\Traits\AjaxValidationTrait;
use yii\web\Controller;
use yii\web\filters\AccessControl;
use yii\web\ForbiddenHttpException;

/**
 * Class RegistrationController.
 *
 * Is responsible for all registration process, which includes registration of a new account
 * resending confirmation tokens, email confirmation and registration via social networks
 *
 * @property Module $module
 **/
class RegistrationController extends Controller
{
	use AjaxValidationTrait;

	/**
	 * behaviors.
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
	 * actionRegister.
	 *
	 * displays the registration page
	 * After successful registration if accountConfirmation is enabled shows info message otherwise
	 * redirects to home page
	 *
	 * @throws ForbiddenHttpException
	 *
	 * @return string|object
	 **/
	public function actionRegister()
	{
		if (!$this->module->accountRegistration) {
			throw new ForbiddenHttpException(
				$this->app->t('ModuleUser', 'Account register is disabled')
			);
		}

		$this->trigger(FormEvent::init());

		/** @var \TerabyteSoft\Module\User\Forms\RegistrationForm $model */
		$model = $this->module->registrationForm;

		$this->trigger(FormEvent::beforeRegister());
		$this->performAjaxValidation($model);

		if ($model->load($this->app->request->post()) && $model->validate()) {
			if ($model->register()) {
				$this->trigger(FormEvent::afterRegister());

				$this->app->session->setFlash(
					'info',
					$this->app->t(
						'ModuleUser',
						'Your account has been created and a message with further instructions has been sent to your email.'
					)
				);
			} else {
				$this->app->session->setFlash(
					'warning',
					$this->app->t(
						'ModuleUser',
						'The account could not be created. Contact the administrator.'
					)
				);
			}

			return $this->goHome();
		}

		return $this->render('Register', [
			'model' => $model,
			'module' => $this->module,
		]);
	}

	/**
	 * actionConnect.
	 *
	 * displays page where user can create new account that will be connected to social account
	 *
	 * @param string|\yii\web\Response
	 * @throws NotFoundHttpException
	 *
	 * @return string|\yii\web\Response
	 **/
	public function actionConnect(string $code)
	{
		$account = $this->module->accountQuery->byCode($code)->one();

		if ($account === null || $account->getIsConnected()) {
			throw new NotFoundHttpException();
		}

		$this->trigger(ConnectEvent::init());

		$user = $this->module->userModel;
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
			'model' => $user,
			'account' => $account,
		]);
	}

	/**
	 * actionConfirm.
	 *
	 * confirms user's account. If confirmation was successful logs the user and shows success message. Otherwise
	 * shows error message
	 *
	 * @param int    $id
	 * @param string $code
	 * @throws ForbiddenHttpException
	 *
	 * @return mixed
	 **/
	public function actionConfirm(int $id, string $code)
	{
		$user = $this->module->userQuery->findUserById($id);

		if ($user === null || $this->module->accountConfirmation === false) {
			throw new ForbiddenHttpException(
				$this->app->t('ModuleUser', 'Account confirm is disabled')
			);
		}

		$this->trigger(UserEvent::init());
		$this->trigger(UserEvent::beforeConfirm());

		$token = $this->module->tokenQuery->findTokenByParams(
			$user->id,
			$code,
			$this->module->tokenModel::TYPE_CONFIRMATION
		);

		$this->app->session->set('token', $token);
		$result = false;

		if ($token instanceof $this->module->modelMap['TokenModel'] && !$token->isExpired) {
			$token->delete();
			if ($result = $user->confirm()) {
				$this->app->user->login($user, $this->module->rememberFor);
				$message = $this->app->t('ModuleUser', 'Thank you, registration is now complete.');
			} else {
				$message = $this->app->t('ModuleUser', 'Something went wrong and your account has not been confirmed.');
			}
		} else {
			$message = $this->app->t('ModuleUser', 'The confirmation link is invalid or expired. Please try requesting a new one.');
		}

		$this->app->session->setFlash($result ? 'success' : 'danger', $message);

		$this->trigger(UserEvent::afterConfirm());

		return $this->goHome();
	}

	/**
	 * actionResend.
	 *
	 * displays page where user can request new confirmation token. If resending was successful, displays message
	 *
	 * @throws ForbiddenHttpException
	 *
	 * @return string|object
	 */
	public function actionResend()
	{
		if ($this->module->accountConfirmation === false) {
			throw new ForbiddenHttpException(
				$this->app->t('ModuleUser', 'Account confirm is disabled')
			);
		}

		$this->trigger(FormEvent::init());

		$model = $this->module->resendForm;

		$this->trigger(FormEvent::beforeResend());
		$this->performAjaxValidation($model);

		if ($model->load($this->app->request->post()) && $model->validate()) {
			if ($model->resend()) {
				$this->trigger(FormEvent::afterResend());

				$this->app->session->setFlash(
					'info',
					$this->app->t(
						'ModuleUser',
						'A message has been sent to your email address. It contains a confirmation link that you must click to complete registration.'
					)
				);
			} else {
				$this->app->session->setFlash(
					'warning',
					$this->app->t(
						'ModuleUser',
						'A message has not been sent to your email address. The user has already been confirmed.'
					)
				);
			}

			return $this->goHome();
		}

		return $this->render('Resend', [
			'model' => $model,
			'module' => $this->module,
		]);
	}
}
