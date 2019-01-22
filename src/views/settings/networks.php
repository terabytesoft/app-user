<?php

use app\user\widgets\Connect;
use yii\bootstrap4\Html;

/**
 * @var $this yii\web\View
 * @var $form yii\bootstrap4\ActiveForm
 */

$this->title = $this->app->t('user', 'Social Accounts Form');
$this->params['breadcrumbs'][] = $this->title;

?>

<?= Html::beginTag('div', ['class' => 'row']) ?>
	<?= Html::beginTag('div', ['class' => 'col-md-3']) ?>
        <?= $this->render('_menu') ?>
	<?= Html::endTag('div') ?>
	<?= Html::beginTag('div', ['class' => 'col-md-9']) ?>
		<?= Html::tag('h2', '<b>' . Html::encode($this->title) . '</b>', ['class' => 'text-center']) ?>
        <div class="alert alert-info align-middle">
            <?= $this->app->t('user', 'You can connect multiple accounts to be able to log in using them') ?>
        </div>

        <?php $auth = Connect::begin([
            'baseAuthUrl' => ['/user/security/auth'],
            'accounts' => $user->accounts,
            'autoRender' => false,
            'popupMode' => false,
        ]) ?>

			<?php foreach ($auth->getClients() as $client) : ?>

				<?= Html::beginTag('div', ['class' => 'align-items-center border border-success bd-highlight d-flex flex-row justify-content-between mb-3']) ?>
					<?= Html::beginTag('div', ['class' => 'bd-highlight p-2']) ?>
                        <?= Html::tag('span', '', ['class' => 'auth-icon ' . $client->getName()]) ?>
					<?= Html::endTag('div') ?>

					<?= Html::beginTag('div', ['class' => 'bd-highlight flex-fill p-2']) ?>
                       	<strong><?= $client->getTitle() ?></strong>
					<?= Html::endTag('div') ?>

					<?= Html::beginTag('div', ['class' => 'bd-highlight p-3 w-25']) ?>
                        <?= $auth->isConnected($client) ?
                           	Html::a($this->app->t('user', 'Disconnect'), $auth->createClientUrl($client), [
                               		'class' => 'btn btn-danger btn-block',
                                	'data-method' => 'POST',
                                ]) :
                                Html::a($this->app->t('user', 'Connect'), $auth->createClientUrl($client), [
                                	'class' => 'btn btn-success btn-block',
								])
						?>
					<?= Html::endTag('div') ?>
				<?= Html::endTag('div') ?>

			<?php endforeach; ?>

        <?php Connect::end() ?>

	<?= Html::endTag('div') ?>
<?php echo Html::endTag('div');
