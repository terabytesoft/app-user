<?php

/**
 * profile/show
 *
 * Profile info
 *
 * View web application user
 **/

use app\user\assets\ProfileShowAsset;
use yii\bootstrap4\Html;

/**
 * @property \app\user\models\UserModel $user
 * @var \app\user\models\ProfileModel $profile
 * @var \yii\web\View $this
 **/

$this->title = $this->app->t('user', 'Profile Details');
$this->params['breadcrumbs'][] = empty($profile->name) ? $profile->user->username : $profile->name;

ProfileShowAsset::register($this);

?>

<?= Html::beginTag('div', ['class' => 'form-profile-show']) ?>

        <?= Html::tag('h2', '<b>' . Html::encode($this->title) . '</b>', ['class' => 'form-profile-show-title']) ?>

        <?= Html::beginTag('p', ['class' => 'form-profile-show-subtitle']) ?>
            <?= $this->app->t(
			    'user',
			    'Show the details of the User.'
		    ) ?>
        <?= Html::endTag('p') ?>

        <?= Html::tag('hr', ['class' => 'mb-4']) ?>

        <?= Html::beginTag('div', ['class' => 'form-profile-show-body']) ?>

            <?= Html::img($profile->getAvatarUrl(230), [
                'class' => 'form-profile-show-img img-responsive img-circle',
                'title' => $profile->name,
                ]) ?>

            <?= Html::tag('p', $this->app->t('user', 'Gravatar image'), ['class' => 'text-muted text-center mt-2']); ?>

        <?= Html::endTag('div') ?>

        <?= Html::beginTag('div', ['class' => 'form-profile-show-content']) ?>

            <?= Html::beginTag('div', ['class' => 'form-profile-show-fields-title']) ?>
    	        <?= Html::encode(
			        empty($profile->name) ?
			        $this->app->t('user', 'Username:') :
                    $this->app->t('user', 'Name:')
                )?>
            <?= Html::endTag('div') ?>

            <?= Html::beginTag('div', ['class' => 'alert alert-info flex-fill p-2', 'role' => 'alert']) ?>
                <?= Html::encode(empty($profile->name) ? $profile->user->username : $profile->name) ?>
            <?= Html::endTag('div') ?>

            <?= Html::beginTag('div', ['class' => 'form-profile-show-fields-title']) ?>
                <?= Html::encode($this->app->t('user', 'Email - (Public):')) ?>
            <?= Html::endTag('div') ?>

		    <?= Html::beginTag('div', ['class' => 'alert alert-info flex-fill p-2', 'role' => 'alert']) ?>
			    <?= Html::tag('i', '', ['class' => 'fas fa-envelope']) ?>
			    <?= Html::a(
				    Html::encode(empty($profile->public_email) ? '(not set)' : 'mailto:' . $profile->public_email),
				    Html::encode(empty($profile->public_email) ? 'javascript:;' : 'mailto:' . $profile->public_email)
			    ) ?>
		    <?= Html::endTag('div') ?>

            <?= Html::beginTag('div', ['class' => 'form-profile-show-fields-title']) ?>
                <?= Html::encode($this->app->t('user', 'Website:')) ?>
            <?= Html::endTag('div') ?>

		    <?= Html::beginTag('div', ['class' => 'alert alert-info flex-fill p-2', 'role' => 'alert']) ?>
                <?= Html::tag('i', '', ['class' => 'fas fa-globe']) ?>
			    <?= Html::a(
				    Html::encode(empty($profile->website) ? '(not set)' : $profile->website),
				    Html::encode(empty($profile->website) ? 'javascript:;' : $profile->website)
			    ) ?>
		    <?= Html::endTag('div') ?>

            <?= Html::beginTag('div', ['class' => 'form-profile-show-fields-title']) ?>
                <?= Html::encode($this->app->t('user', 'Location:')) ?>
            <?= Html::endTag('div') ?>

		    <?= Html::beginTag('div', ['class' => 'alert alert-info flex-fill p-2', 'role' => 'alert']) ?>
			    <?= Html::tag('i', '', ['class' => 'fas fa-map-marked']) ?>
			    <?= Html::encode(empty($profile->location) ? '(not set)' : $profile->location) ?>
		    <?= Html::endTag('div') ?>

            <?= Html::beginTag('div', ['class' => 'form-profile-show-fields-title']) ?>
                <?= Html::encode($this->app->t('user', 'Time Zone:')) ?>
            <?= Html::endTag('div') ?>

		    <?= Html::beginTag('div', ['class' => 'alert alert-info flex-fill p-2', 'role' => 'alert']) ?>
			    <?= Html::tag('i', '', ['class' => 'fas fa-user-clock']) ?>
			    <?= Html::encode(empty($profile->timezone) ? '(not set)' : $profile->timezone) ?>
            <?= Html::endTag('div') ?>

            <?= Html::beginTag('div', ['class' => 'form-profile-show-fields-title']) ?>
                <?= Html::encode($this->app->t('user', 'Gravatar Email:')) ?>
            <?= Html::endTag('div') ?>

		    <?= Html::beginTag('div', ['class' => 'alert alert-info flex-fill p-2', 'role' => 'alert']) ?>
		        <?= Html::tag('i', '', ['class' => 'fas fa-image']) ?>
		        <?= Html::encode(empty($profile->gravatar_email) ? '(not set)' : $profile->gravatar_email) ?>
		    <?= Html::endTag('div') ?>

            <?= Html::beginTag('div', ['class' => 'form-profile-show-fields-title']) ?>
                <?= Html::encode($this->app->t('user', 'Bio:')) ?>
            <?= Html::endTag('div') ?>

            <?= Html::beginTag('div', ['class' => 'alert alert-info flex-fill p-2', 'role' => 'alert']) ?>
			    <?= Html::tag('i', '', ['class' => 'fas fa-atlas']) ?>
			    <?= Html::encode(empty($profile->bio) ? '(not set)' : $profile->bio) ?>
		    <?= Html::endTag('div') ?>

            <?= Html::beginTag('div', ['class' => 'form-profile-show-fields-title']) ?>
                <?= Html::encode($this->app->t('user', 'Register:')) ?>
            <?= Html::endTag('div') ?>

		    <?= Html::beginTag('div', ['class' => 'alert alert-info flex-fill p-2', 'role' => 'alert']) ?>
			    <?= Html::tag('i', '', ['class' => 'fas fa-registered']) ?>
			    <?= Html::encode(empty($profile->user->created_at) ?
				    '(not set)' :
				    $this->app->t('user', 'Joined on {0, date}', [$profile->user->created_at]))
			    ?>
            <?= Html::endTag('div') ?>

        <?= Html::endTag('div') ?>

<?php echo Html::endTag('div');
