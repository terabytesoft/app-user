<?php

/**
 * main
 *
 * Layout web application user
 **/

use app\user\tests\assets\LayoutAdminAsset;
use app\widgets\Alert;
use yii\jquery\YiiAsset;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

LayoutAdminAsset::register($this);

if ($this->app->user->isGuest) {
    $menuItems[] = [
	    'label' => $this->app->t('user', 'Sign up'),
	    'url' => ['/user/registration/register'],
    ];
    $menuItems[] = [
	    'label' => $this->app->t('user', 'Login'),
	    'url' => ['/user/security/login']
    ];
} else {
    $menuItems[] = [
        'label' =>  $this->app->t('user', 'Logout'),
        'url' => ['/user/security/logout'],
        'linkOptions' => ['data-method' => 'POST'],
    ];
}

?>

<?php $this->beginPage() ?>

	<!DOCTYPE html>
	<?= Html::beginTag('html', ['lang' => $this->app->language]) ?>

	    <?= Html::beginTag('head') ?>
		    <?= Html::tag('meta', '', ['charset' => $this->app->encoding]) ?>
		    <?= Html::tag('meta', '', ['http-equiv' => 'X-UA-Compatible', 'content' => 'IE=edge']) ?>
		    <?= Html::tag('meta', '', ['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1']) ?>
		    <?= Html::csrfMetaTags() ?>
		    <?= Html::tag('title', Html::encode($this->title)) ?>
            <?php $this->head() ?>
        <?= Html::endTag('head') ?>

		<?php $this->beginBody() ?>

		    <?= Html::beginTag('body') ?>

                <?= Html::beginTag('div', ['class' => 'cover d-flex w-100 h-100 p-3 mx-auto flex-column']) ?>

                    <?= Html::beginTag('header', ['class' => 'masthead mb-auto']) ?>

                        <?php NavBar::begin([
				            'brandLabel' => $this->app->t('user', $this->app->name),
				            'brandUrl' => $this->app->homeUrl,
			    	        'options' => [
			                    'class' => 'navbar  navbar-dark navbar-expand-lg',
					        ],
                        ]);

                        echo Nav::widget([
			                'options' => ['class' => 'navbar-nav float-right ml-auto'],
			                'items' => $menuItems,
                        ]);

                        NavBar::end(); ?>

                    <?= Html::endTag('header') ?>

                    <?= Html::beginTag('main', ['class' => 'inner cover', 'role' => 'main']) ?>
                            <?= Alert::widget() ?>
				            <?= $content ?>
                    <?= Html::endTag('main') ?>

                    <?= Html::beginTag('footer', ['class' => 'mastfoot mt-auto']) ?>
                        <?= Html::beginTag('div', ['class' => '']) ?>
                            <?= Html::beginTag('p', ['class' => 'float-left']) ?>
                                <?= '&copy; ' . $this->app->t('user', 'My Company') . ' ' . date('Y') ?>
                            <?= Html::endTag('p') ?>
                            <?= Html::beginTag('p', ['class' => 'float-right']) ?>
                                <?= $this->app->t('user', 'Powered by') ?>
                                <?= Html::a(
                                    $this->app->t(
                                        'user',
                                        'Yii Framework'
                                    ),
                                    'http://www.yiiframework.com/',
                                    ['rel' => 'external']
                                ) ?>
                            <?= Html::endTag('p') ?>
                        <?= Html::endTag('div') ?>
                    <?= Html::endTag('footer') ?>

                <?= Html::endTag('div') ?>

            <?= Html::endTag('body') ?>

        <?php $this->endBody() ?>

	<?= Html::endTag('html') ?>

<?php $this->endPage() ?>
