<?php

namespace TerabyteSoft\Module\User\Controllers;

use TerabyteSoft\Module\User\Events\FormEvent;
use TerabyteSoft\Module\User\Events\ResetPasswordEvent;
use TerabyteSoft\Module\User\Module;
use TerabyteSoft\Module\User\Traits\AjaxValidationTrait;
use yii\web\Controller;
use yii\web\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * Class RecoveryController.
 *
 * Manages password recovery process
 *
 * @property Module $module
 **/
class RecoveryController extends Controller
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
					['allow' => true, 'actions' => ['request', 'reset'], 'roles' => ['?']],
				],
			],
		];
	}

	/**
	 * actionRequest.
	 *
	 * shows page where user can request password recovery
	 *
	 * @throws \yii\web\NotFoundHttpException
	 *
	 * @return string|object
	 **/
	public function actionRequest()
	{
		if (!$this->module->accountPasswordRecovery) {
			throw new NotFoundHttpException();
		}

		$model = $this->module->recoveryForm;
		$model->scenario = $model::SCENARIO_REQUEST;

		$this->trigger(FormEvent::init());
		$this->performAjaxValidation($model);
		$this->trigger(FormEvent::beforeRequest());

		if ($model->load($this->app->request->post()) && $model->validate()) {
			if ($model->sendRecoveryMessage()) {
				$this->trigger(FormEvent::afterRequest());

				$this->app->session->setFlash(
					'info',
					$this->app->t(
						'ModuleUser',
						'An email has been sent with instructions for resetting your password'
					)
				);
			} else {
				$this->app->session->setFlash(
					'warning',
					$this->app->t(
						'ModuleUser',
						'A message has not been sent to your email address. Contact the administrator.'
					)
				);
			}

			return $this->goHome();
		}

		return $this->render('Request', [
			'model' => $model,
			'module' => $this->module,
		]);
	}

	/**
	 * actionReset.
	 *
	 * displays page where user can reset password
	 *
	 * @param int $id
	 * @param string $code
	 * @throws \yii\web\NotFoundHttpException
	 *
	 * @return string|object
	 **/
	public function actionReset(int $id, string $code)
	{
		if (!$this->module->accountPasswordRecovery) {
			throw new NotFoundHttpException();
		}

		$token = $this->module->tokenQuery->findToken([
			'user_id' => $id,
			'code' => $code,
			'type' => $this->module->tokenModel::TYPE_RECOVERY,
		])->one();

		if (empty($token) || !$token instanceof \app\user\models\TokenModel) {
			throw new NotFoundHttpException();
		}

		$this->trigger(ResetPasswordEvent::init());
		$this->trigger(ResetPasswordEvent::beforeTokenValidate());

		if ($token === null || $token->isExpired || $token->user === null) {
			$this->trigger(ResetPasswordEvent::afterTokenValidate());

			$this->app->session->setFlash(
				'danger',
				$this->app->t(
					'ModuleUser',
					'Recovery link is invalid or expired. Please try requesting a new one.'
				)
			);
		}

		$model = $this->module->recoveryForm;
		$model->scenario = $model::SCENARIO_RESET;

		$this->performAjaxValidation($model);
		$this->trigger(ResetPasswordEvent::beforeReset());

		if ($model->load($this->app->getRequest()->post()) && $model->validate()) {
			if ($token->user->resetPassword($model->password)) {
				$this->trigger(ResetPasswordEvent::afterReset());
				$this->app->session->setFlash(
					'success',
					$this->app->t(
						'ModuleUser',
						'Your password has been changed successfully.'
					)
				);
				$token->delete();
			} else {
				$this->app->session->setFlash(
					'danger',
					$this->app->t(
						'ModuleUser',
						'An error occurred and your password has not been changed. Please try again later.'
					)
				);
			}

			return $this->goHome();
		}

		return $this->render('Reset', [
			'model' => $model,
			'module' => $this->module,
		]);
	}
}
