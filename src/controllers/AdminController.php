<?php

namespace app\user\controllers;

use app\user\Module;
use app\user\events\FormEvent;
use app\user\events\ProfileEvent;
use app\user\events\UserEvent;
use app\user\finder\Finder;
use app\user\filters\AccessRule;
use app\user\models\Profile;
use app\user\models\UserModel;
use app\user\models\UserSearch;
use app\user\helpers\Password;
use yii\helpers\Yii;
use yii\base\Model;
use yii\base\Module as Module2;
use yii\exceptions\ExitException;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\filters\AccessControl;
use yii\web\filters\VerbFilter;

/**
 * AdminController
 *
 * Allows you to administrate users
 *
 * @property Module $module
 **/
class AdminController extends Controller
{
    /**
     * name of the session key in which the original user id is saved
     * when using the impersonate user function
     * used inside actionSwitch()
     **/
    const ORIGINAL_USER_SESSION_KEY = 'original_user';

    protected $finder;

    /**
	 * __construct
	 *
     * @param string $id
     * @param Module $module
     * @param Finder $finder
     **/
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
            'verbs' => [
                '__class' => VerbFilter::class,
                'actions' => [
                    'delete'          => ['post'],
                    'confirm'         => ['post'],
                    'resend-password' => ['post'],
                    'block'           => ['post'],
                    'switch'          => ['post'],
                ],
            ],
            'access' => [
                '__class' => AccessControl::class,
                'ruleConfig' => [
                    '__class' => AccessRule::class,
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['switch'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
	 * actionIndex
	 *
     * lists all User models
     *
     * @return string|object
     **/
    public function actionIndex()
    {
        Url::remember('', 'actions-redirect');

        $searchModel = new UserSearch();

        $dataProvider = $searchModel->search($this->app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }

    /**
	 * actionCreate
	 *
     * creates a new User model
     * if creation is successful, the browser will be redirected to the 'index' page
     *
     * @return string|object
     **/
    public function actionCreate()
    {
		$user = new UserModel();
		$user->scenario = 'create';

        $this->trigger(UserEvent::init());
        $this->performAjaxValidation($user);
		$this->trigger(UserEvent::beforeCreate());

        if ($user->load($this->app->request->post()) && $user->create()) {
            $this->app->session->setFlash(
				'success',
				$this->app->t('user', 'User has been created')
			);
            $this->trigger(UserEvent::afterCreate());
            return $this->redirect(['update', 'id' => $user->id]);
        }

        return $this->render('create', [
            'user' => $user,
        ]);
    }

    /**
	 * actionUpdate
	 *
     * updates an existing User model
     *
     * @param int $id
     *
     * @return string|object
     **/
    public function actionUpdate(int $id)
    {
        Url::remember('', 'actions-redirect');

        $user = $this->findModel($id);
        $user->scenario = 'update';

        $this->trigger(UserEvent::init());
        $this->performAjaxValidation($user);
		$this->trigger(UserEvent::beforeUpdate());

        if ($user->load($this->app->request->post()) && $user->save()) {
            $this->app->session->setFlash(
				'success',
				$this->app->t('user', 'Account details have been updated')
			);
			$this->trigger(UserEvent::afterUpdate());

            return $this->refresh();
        }

        return $this->render('_account', [
            'user' => $user,
        ]);
    }

    /**
     * actionUpdateProfile
	 *
	 * updates an existing profile
     *
     * @param int $id
     *
     * @return string|object
     **/
    public function actionUpdateProfile(int $id)
    {
        Url::remember('', 'actions-redirect');

        $user = $this->findModel($id);
        $profile = $user->profile;

        if ($profile == null) {
            $profile = new Profile();
            $profile->link('user', $user);
        }

        $this->trigger(ProfileEvent::init());
        $this->performAjaxValidation($profile);
        $this->trigger(ProfileEvent::beforeProfileUpdate());

        if ($profile->load($this->app->request->post()) && $profile->save()) {
            $this->app->session->setFlash(
                'success',
                $this->app->t('user', 'Profile details have been updated')
            );
			$this->trigger(ProfileEvent::afterProfileUpdate());

            return $this->refresh();
        }

        return $this->render('_profile', [
            'user'    => $user,
            'profile' => $profile,
        ]);
    }

    /**
	 * actionInfo
	 *
     * shows information about user
     *
     * @param int $id
     *
     * @return string
     **/
    public function actionInfo(int $id): string
    {
        Url::remember('', 'actions-redirect');

        $user = $this->findModel($id);

        return $this->render('_info', [
            'user' => $user,
        ]);
    }

    /**
	 * actionSwitch
	 *
     * switches to the given user for the rest of the session
     * when no id is given, we switch back to the original admin user
     * that started the impersonation.
     *
     * @param int $id
     *
     * @return string|object
     **/
    public function actionSwitch($id = null)
    {
        if (!$this->module->enableImpersonateUser) {
            throw new ForbiddenHttpException(
                $this->app->t(
					'user',
					'Impersonate user is disabled in the application configuration'
				)
            );
        }

        if (!$id && $this->app->session->has(self::ORIGINAL_USER_SESSION_KEY)) {
            $user = $this->findModel($this->app->session->get(self::ORIGINAL_USER_SESSION_KEY));
            $this->app->session->remove(self::ORIGINAL_USER_SESSION_KEY);
        } else {
            if (!$this->app->user->identity->isAdmin) {
                throw new ForbiddenHttpException;
            }
            $user = $this->findModel($id);
            $this->app->session->set(self::ORIGINAL_USER_SESSION_KEY, $this->app->user->id);
        }

        $this->trigger(UserEvent::init());
        $this->trigger(UserEvent::beforeImpersonate());
        $this->app->user->switchIdentity($user, 3600);
        $this->trigger(UserEvent::afterImpersonate());

        return $this->goHome();
    }

    /**
	 * actionAssignments
	 *
     * if "app/yii2-rbac" extension is installed, this page displays form
     * where user can assign multiple auth items to user.
     *
     * @param int $id
     *
     * @return string
     * @throws NotFoundHttpException
     **/
    public function actionAssignments(int $id): string
    {
        if (!isset($this->app->extensions['app/yii2-rbac'])) {
            throw new NotFoundHttpException();
        }

        Url::remember('', 'actions-redirect');

        $user = $this->findModel($id);

        return $this->render('_assignments', [
            'user' => $user,
        ]);
    }

    /**
	 * actionConfirm
	 *
     * confirms the User
     *
     * @param int $id
     *
     * @return Response
     **/
    public function actionConfirm(int $id)
    {
        $model = $this->findModel($id);

        $this->trigger(UserEvent::init());
        $this->trigger(UserEvent::beforeConfirm());

        $model->confirm();

        $this->trigger(UserEvent::afterConfirm());
        $this->app->session->setFlash(
			'success',
			$this->app->t('user', 'User has been confirmed')
		);

        return $this->redirect(Url::previous('actions-redirect'));
    }

    /**
	 * actionDelete
	 *
     * deletes an existing user model
     * if deletion is successful, the browser will be redirected to the 'index' page
     *
     * @param int $id
     *
     * @return Response
     **/
    public function actionDelete(int $id)
    {
        if ($id == $this->app->user->getId()) {
            $this->app->session->setFlash(
                'danger',
                $this->app->t('user', 'You can not remove your own account')
            );
        } else {
            $model = $this->findModel($id);

            $this->trigger(UserEvent::init());
            $this->trigger(UserEvent::beforeDelete());

            $model->delete();

            $this->trigger(UserEvent::afterDelete());
            $this->app->session->setFlash(
                'success',
                $this->app->t('user', 'User has been deleted')
            );
        }

        return $this->redirect(['index']);
    }

    /**
	 * actionBlock
	 *
     * blocks the user
     *
     * @param int $id
     *
     * @return Response
     **/
    public function actionBlock(int $id)
    {
        if ($id == $this->app->user->getId()) {
            $this->app->session->setFlash(
                'danger',
                $this->app->t('user', 'You can not block your own account')
            );
        } else {
            $user  = $this->findModel($id);

            $this->trigger(UserEvent::init());
            if ($user->getIsBlocked()) {
                $this->trigger(UserEvent::beforeUnblock());

                $user->unblock();

                $this->trigger(UserEvent::afterUnblock());
                $this->app->session->setFlash(
                    'success',
                    $this->app->t('user', 'User has been unblocked')
                );
            } else {
                $this->trigger(UserEvent::beforeBlock());

                $user->block();

                $this->trigger(UserEvent::afterBlock());
                $this->app->session->setFlash(
                    'success',
                    $this->app->t('user', 'User has been blocked')
                );
            }
        }

        return $this->redirect(Url::previous('actions-redirect'));
    }

    /**
	 * actionResendPassword
	 *
     * generates a new password and sends it to the user
     *
	 * @param int $id
     * @return Response
     **/
    public function actionResendPassword(int $id)
    {
        $user = $this->findModel($id);
        if ($user->isAdmin) {
            throw new ForbiddenHttpException(
                $this->app->t('user', 'Password generation is not possible for admin users')
            );
        }

        if ($user->resendPassword()) {
            $this->app->session->setFlash(
                'success',
                $this->app->t('user', 'New Password has been generated and sent to user')
            );
        } else {
            $this->app->session->setFlash(
                'danger',
                $this->app->t('user', 'Error while trying to generate new password')
            );
        }

        return $this->redirect(Url::previous('actions-redirect'));
    }

    /**
	 * findModel
	 *
     * finds the user model based on its primary key value
     * If the model is not found, a 404 HTTP exception will be thrown
     *
     * @param int $id
     *
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     **/
    protected function findModel(int $id)
    {
        $user = $this->finder->findUserById($id);
        if ($user === null) {
            throw new NotFoundHttpException('The requested page does not exist');
        }

        return $user;
    }

    /**
	 * performAjaxValidation
	 *
     * performs ajax validation
     *
     * @param array|Model $model
     *
     * @throws ExitException
     **/
    protected function performAjaxValidation(Model $model)
    {
        if ($this->app->request->isAjax && !$this->app->request->isPjax) {
            if ($model->load($this->app->request->post())) {
                $this->app->response->format = Response::FORMAT_JSON;
                $this->app->response->data = json_encode(ActiveForm::validate($model));
                $this->app->end();
            }
        }
    }
}
