<?php

namespace app\user\controllers;

use app\user\Module;
use app\user\events\ConnectEvent;
use app\user\events\FormEvent;
use app\user\events\ProfileEvent;
use app\user\events\UserEvent;
use app\user\finder\Finder;
use app\user\forms\SettingsForm;
use app\user\models\Profile;
use app\user\models\User;
use app\user\traits\AjaxValidationTrait;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\filters\AccessControl;
use yii\web\filters\VerbFilter;

/**
 * SettingsController
 *
 * SettingsController manages updating user settings (e.g. profile, email and password)
 *
 * @property Module $module
 **/
class SettingsController extends Controller
{
    use AjaxValidationTrait;

    public $defaultAction = 'profile';

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
    public function behaviors()
    {
        return [
            'verbs' => [
                '__class' => VerbFilter::class,
                'actions' => [
                    'disconnect' => ['post'],
                    'delete'     => ['post'],
                ],
            ],
            'access' => [
                '__class' => AccessControl::class,
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['profile', 'account', 'networks', 'disconnect', 'delete'],
                        'roles'   => ['@'],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['confirm'],
                        'roles'   => ['?', '@'],
                    ],
                ],
            ],
        ];
    }

    /**
	 * actionProfile
	 *
     * shows profile settings form
     *
     * @return string|\yii\web\Response
     */
    public function actionProfile()
    {
        $model = $this->finder->findProfileById($this->app->user->identity->getId());

        if ($model == null) {
            $model = new Profile();
            $model->link('user', $this->app->user->identity);
        }

        $this->trigger(ProfileEvent::init());
        $this->performAjaxValidation($model);
        $this->trigger(ProfileEvent::beforeProfileUpdate());

        if ($model->load($this->app->request->post()) && $model->save()) {
            $this->app->getSession()->setFlash(
                'success',
                $this->app->t(
                    'user',
                    'Your profile has been updated'
                )
            );
            $this->trigger(ProfileEvent::afterProfileUpdate());

            return $this->refresh();
        }

        return $this->render('profile', [
            'model' => $model,
        ]);
    }

    /**
	 * actionAccount
	 *
     * displays page where user can update account settings (username, email or password)
     *
     * @return string|\yii\web\Response
     */
    public function actionAccount()
    {
        $model = new SettingsForm();

        $this->trigger(FormEvent::init());
        $this->performAjaxValidation($model);
        $this->trigger(FormEvent::beforeAccountUpdate());

        if ($model->load($this->app->request->post()) && $model->save()) {
            $this->app->session->setFlash(
                'success',
                $this->app->t(
                    'user',
                    'Your account details have been updated'
                )
            );
            $this->trigger(FormEvent::afterAccountUpdate());

            return $this->refresh();
        }

        return $this->render('account', [
            'model' => $model,
        ]);
    }

    /**
	 * actionConfirm
	 *
     * attempts changing user's email address
     *
     * @param int    $id
     * @param string $code
     *
     * @return string|\yii\web\Response
     * @throws \yii\web\HttpException
     */
    public function actionConfirm(int $id, string $code)
    {
        $user = $this->finder->findUserById($id);

        if ($user === null || $this->module->emailChangeStrategy == Module::STRATEGY_INSECURE) {
            throw new NotFoundHttpException();
        }

        $this->trigger(UserEvent::init());
        $this->trigger(UserEvent::beforeConfirm());

        $user->attemptEmailChange($code);

        $this->trigger(UserEvent::afterConfirm());

        return $this->redirect(['account']);
    }

    /**
	 * actionNetworks
	 *
     * displays list of connected network accounts
     *
     * @return string
     **/
    public function actionNetworks(): string
    {
        return $this->render('networks', [
            'user' => $this->app->user->identity,
        ]);
    }

    /**
	 * actionDisconnect
	 *
     * disconnects a network account from user
     *
     * @param int $id
     *
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     * @throws \yii\web\ForbiddenHttpException
     **/
    public function actionDisconnect(int $id)
    {
        $account = $this->finder->findAccount()->byId($id)->one();

        if ($account === null) {
            throw new NotFoundHttpException();
        }
        if ($account->user_id != $this->app->user->id) {
            throw new ForbiddenHttpException();
        }

        $this->trigger(ConnectEvent::init());
        $this->trigger(ConnectEvent::beforeDisconnect());

        $account->delete();

        $this->trigger(ConnectEvent::afterDisconnect());

        return $this->redirect(['networks']);
    }

    /**
	 * actionDelete
	 *
     * completely deletes user's account
     *
     * @return \yii\web\Response
     * @throws \Exception
     **/
    public function actionDelete()
    {
        if (!$this->module->enableAccountDelete) {
            throw new NotFoundHttpException($this->app->t('user', 'Not found'));
        }

        $user  = $this->app->user->identity;

        $this->trigger(UserEvent::init());
        $this->app->user->logout();
        $this->trigger(UserEvent::beforeDelete());

        $user->delete();

        $this->trigger(UserEvent::afterDelete());
        $this->app->session->setFlash(
            'info',
            $this->app->t(
                'user',
                'Your account has been completely deleted'
            )
        );

        return $this->goHome();
    }
}
