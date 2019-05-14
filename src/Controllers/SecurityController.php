<?php

namespace TerabyteSoft\Module\User\Controllers;

use TerabyteSoft\Module\User\Events\AuthEvent;
use TerabyteSoft\Module\User\Events\FormEvent;
use TerabyteSoft\Module\User\Module;
use TerabyteSoft\Module\User\Traits\AjaxValidationTrait;
use Yiisoft\Yii\AuthClient\AuthAction;
use Yiisoft\Yii\AuthClient\ClientInterface;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\filters\AccessControl;
use yii\web\filters\VerbFilter;
use yii\web\Response;

/**
 * Class SecurityController.
 *
 * That manages user authentication process
 *
 * @property Module $module
 **/
class SecurityController extends Controller
{
	use AjaxValidationTrait;

	/**
	 * behaviors.
	 *
	 * @return array behaviors config
	 **/
	public function behaviors()
	{
		return [
			'access' => [
				'__class' => AccessControl::class,
				'rules' => [
					['allow' => true, 'actions' => ['login', 'auth'], 'roles' => ['?']],
					['allow' => true, 'actions' => ['login', 'auth', 'logout'], 'roles' => ['@']],
				],
			],
			'verbs' => [
				'__class' => VerbFilter::class,
				'actions' => [
					'logout' => ['POST'],
				],
			],
		];
	}

	/**
	 * actions.
	 *
	 * @return array actions config
	 **/
	public function actions()
	{
		return [
			'auth' => [
				'__class' => AuthAction::class,
				// if user is not logged in, will try to log him in, otherwise
				// will try to connect social account to user.
				'successCallback' => $this->app->user->isGuest
					? [$this, 'authenticate']
					: [$this, 'connect'],
			],
		];
	}

	/**
	 * actionLogin.
	 *
	 * displays the login page
	 *
	 * @return string|Response
	 **/
	public function actionLogin()
	{
		if (!$this->app->user->isGuest) {
			$this->goHome();
		}

		$model = $this->module->loginForm;

		$this->trigger(FormEvent::init());
		$this->performAjaxValidation($model);
		$this->trigger(FormEvent::beforeLogin());

		if ($model->load($this->app->getRequest()->post()) && $model->login()) {
			$this->trigger(FormEvent::afterLogin());

			return $this->goBack();
		}

		return $this->render('Login', [
			'model' => $model,
			'module' => $this->module,
		]);
	}

	/**
	 * actionLogout.
	 *
	 * logs the user out and then redirects to the homepage
	 *
	 * @return Response
	 **/
	public function actionLogout()
	{
		$this->trigger(FormEvent::init());
		$this->trigger(FormEvent::beforeLogout());
		$this->app->getUser()->logout();
		$this->trigger(FormEvent::afterLogout());

		return $this->goHome();
	}

	/**
	 * authenticate.
	 *
	 * tries to authenticate user via social network. If user has already used
	 * this network's account, he will be logged in. Otherwise, it will try
	 * to create new user account
	 *
	 * @param ClientInterface $client
	 **/
	public function authenticate(ClientInterface $client)
	{
		$account = $this->module->accountQuery->byClient($client)->one();

		if (!$this->module->accountRegistration && ($account === null || $account->user === null)) {
			$this->app->session->setFlash(
				'danger',
				$this->app->t(
					'ModuleUser',
					'Registration on this website is disabled'
				)
			);
			$this->action->successUrl = Url::to(['/user/security/login']);

			return;
		}

		if ($account === null) {
			$accountObj = $this->module->accountModel;
			$account = $accountObj->create($client);
		}

		$this->trigger(AuthEvent::init());
		$this->trigger(AuthEvent::beforeAuthenticate());

		if ($account->user instanceof $this->module->modelMap['UserModel']) {
			if ($account->user->isBlocked) {
				$this->app->session->setFlash(
					'danger',
					$this->app->t(
						'ModuleUser',
						'Your account has been blocked.'
					)
				);
				$this->action->successUrl = Url::to(['/user/security/login']);
			} else {
				$account->user->updateAttributes(['last_login_at' => time()]);
				$this->app->user->login($account->user, $this->module->rememberFor);
				$this->action->successUrl = $this->app->getUser()->getReturnUrl();
			}
		} else {
			$this->action->successUrl = $account->getConnectUrl();
		}
		$this->trigger(AuthEvent::afterAuthenticate());
	}

	/**
	 * connect.
	 *
	 * tries to connect social account to user
	 *
	 * @param ClientInterface $client
	 **/
	public function connect(ClientInterface $client)
	{
		$account = $this->module->accountModel;

		$this->trigger(AuthEvent::init());
		$this->trigger(AuthEvent::beforeConnect());

		$account->connectWithUser($client);

		$this->trigger(AuthEvent::afterConnect());
		$this->action->successUrl = Url::to(['/user/settings/networks']);
	}
}
