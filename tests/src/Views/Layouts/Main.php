<?php

/**
 * main
 *
 * Layout web application user
 **/

use TerabyteSoft\Module\User\Tests\Assets\LayoutAdminAsset;
use Yiisoft\Yii\Bootstrap4\Html;
use Yiisoft\Yii\Bootstrap4\Nav;
use Yiisoft\Yii\Bootstrap4\NavBar;
use TerabyteSoft\Widgets\Alert;
use Yiisoft\Yii\JQuery\YiiAsset;

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

				<?= Html::beginTag('wrapper', ['class' => 'd-flex flex-column']) ?>

                    <?php NavBar::begin([
						'brandLabel' => $this->app->t('user', $this->app->name),
						'brandUrl' => $this->app->homeUrl,
						'options' => [
						    'class' => 'navbar  navbar-dark bg-dark navbar-expand-lg',
						],
					]);

                    echo Nav::widget([
					    'options' => ['class' => 'navbar-nav float-right ml-auto'],
					    'items' => $menuItems,
					]);

                    NavBar::end(); ?>

                    <?= Html::beginTag('div', ['class' => 'container flex-fill']) ?>

                        <?= Alert::widget([])?>

						<?= $content ?>

					<?= Html::endTag('div') ?>

					<?= Html::beginTag('footer', ['class' => 'footer']) ?>

						<?= Html::beginTag('div', ['class' => 'container flex-fill']) ?>

							<?= Html::beginTag('p', ['class' => 'float-left text-white']) ?>
								<?= '&copy; ' . $this->app->t('user', 'My Company') . ' ' . date('Y') ?>
							<?= Html::endTag('p') ?>

							<?= Html::beginTag('p', ['class' => 'float-right text-white']) ?>
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

				<?= Html::endTag('wrapper') ?>

			<?= Html::endTag('body') ?>

		<?php $this->endBody() ?>

	<?= Html::endTag('html') ?>

<?php $this->endPage() ?>
