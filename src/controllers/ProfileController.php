<?php

namespace TerabyteSoft\Module\User\Controllers;

use TerabyteSoft\Module\User\Module;
use yii\web\Controller;
use yii\web\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * Class ProfileController.
 *
 * Shows users profiles
 *
 * @property Module $module
 **/
class ProfileController extends Controller
{
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
					['allow' => true, 'actions' => ['index'], 'roles' => ['@']],
					['allow' => true, 'actions' => ['show'], 'roles' => ['?', '@']],
				],
			],
		];
	}

	/**
	 * actionIndex.
	 *
	 * redirects to current user's profile
	 *
	 * @return
	 **/
	public function actionIndex()
	{
		return $this->redirect(['show', 'id' => $this->app->user->getId()]);
	}

	/**
	 * actionShow.
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
		$profile = $this->module->profileQuery->findProfileById($id);

		if ($profile === null) {
			throw new NotFoundHttpException();
		}

		return $this->render('show', [
			'profile' => $profile,
		]);
	}
}
