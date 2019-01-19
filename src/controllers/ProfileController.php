<?php

namespace app\user\controllers;

use app\user\Module;
use app\user\finder\Finder;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\filters\AccessControl;

/**
 * ProfileController
 *
 * Shows users profiles
 *
 * @property Module $module
 **/
class ProfileController extends Controller
{
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
            'access' => [
                '__class' => AccessControl::class,
                'rules' => [
                    ['allow' => true, 'actions' => ['index'], 'roles' => ['@']],
                    ['allow' => true, 'actions' => ['show'], 'roles' => ['?', '@']],
                ],
            ],
        ];
    }

    /**
	 * actionIndex
	 *
     * redirects to current user's profile
     *
     * @return
     **/
    public function actionIndex()
    {
        return $this->redirect(['show', 'id' => $this->getApp()->user->getId()]);
    }

    /**
	 * actionShow
	 *
     * shows user's profile
     *
     * @param int $id
     *
     * @return string|object
     * @throws \yii\web\NotFoundHttpException
     **/
    public function actionShow(int $id)
    {
        $profile = $this->finder->findProfileById($id);

        if ($profile === null) {
            throw new NotFoundHttpException();
        }

        return $this->render('show', [
            'profile' => $profile,
        ]);
    }
}
