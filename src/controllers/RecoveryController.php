<?php

namespace app\user\controllers;

use app\user\Module;
use app\user\events\FormEvent;
use app\user\events\ResetPasswordEvent;
use app\user\traits\AjaxValidationTrait;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\filters\AccessControl;

/**
 * RecoveryController
 *
 * Manages password recovery process
 *
 * @property Module $module
 **/
class RecoveryController extends Controller
{
    use AjaxValidationTrait;

	protected $tokenModel;
	protected $tokenQuery;
	protected $recoveryForm;

    /**
	 * __construct
	 *
     * @param string $id
     * @param Module $module
     **/
    public function __construct(string $id, Module $module)
    {
		$this->tokenModel = $module->tokenModel;
		$this->tokenQuery = $module->tokenQuery;
		$this->recoveryForm = new $module->formMap['RecoveryForm'];

		parent::__construct($id, $module);
    }

	/**
     * behaviors
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
	 * actionRequest
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

        $model = $this->recoveryForm;
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
						'user',
						'An email has been sent with instructions for resetting your password'
					)
				);
			} else {
				$this->app->session->setFlash(
					'warning',
					$this->app->t(
						'user',
						'A message has not been sent to your email address. Contact the administrator.'
                    )
                );
			}

    		return $this->goHome();
        }

        return $this->render('request', [
            'model' => $model,
            'module' => $this->module,
        ]);
    }

    /**
	 * actionReset
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

        $token = $this->tokenQuery->findToken([
            'user_id' => $id,
            'code' => $code,
            'type' => $this->tokenModel::TYPE_RECOVERY
        ])->one();

        if (empty($token) || ! $token instanceof \app\user\models\TokenModel) {
            throw new NotFoundHttpException();
        }

        $this->trigger(ResetPasswordEvent::init());
        $this->trigger(ResetPasswordEvent::beforeTokenValidate());

        if ($token === null || $token->isExpired || $token->user === null) {
            $this->trigger(ResetPasswordEvent::afterTokenValidate());

            $this->app->session->setFlash(
                'danger',
                $this->app->t(
                    'user',
                    'Recovery link is invalid or expired. Please try requesting a new one.'
                )
            );
        }

		$model = $this->recoveryForm;
		$model->scenario = $model::SCENARIO_RESET;

        $this->performAjaxValidation($model);
        $this->trigger(ResetPasswordEvent::beforeReset());

        if ($model->load($this->app->getRequest()->post()) && $model->validate()) {
			if ($token->user->resetPassword($model->password)) {
				$this->trigger(ResetPasswordEvent::afterReset());
				$this->app->session->setFlash(
					'success',
					$this->app->t(
						'user',
						'Your password has been changed successfully.'
					)
				);
				$token->delete();
			} else {
				$this->app->session->setFlash(
					'danger',
					$this->app->t(
						'user',
						'An error occurred and your password has not been changed. Please try again later.'
					)
				);
			}

			return $this->goHome();
        }

        return $this->render('reset', [
            'model' => $model,
            'module' => $this->module,
        ]);
    }
}
