<?php

/**
 * profile/show
 *
 * Profile info
 *
 * View web application user
 **/

use TerabyteSoft\Assets\Fontawesome\Dev\Css\NpmAllAsset;
use TerabyteSoft\Module\User\Assets\ProfileShowAsset;
use yii\bootstrap4\Html;

/**
 * @property \app\user\models\UserModel $user
 * @var \app\user\models\ProfileModel $profile
 * @var \yii\web\View $this
 **/

$this->title = $this->app->t('ModuleUser', 'Profile Details');
$this->params['breadcrumbs'][] = empty($profile->name) ? $profile->user->username : $profile->name;

NpmAllAsset::register($this);
ProfileShowAsset::register($this);

?>

<?= Html::beginTag('div', ['class' => 'form-profile-show']) ?>

        <?= Html::tag('h2', '<b>' . Html::encode($this->title) . '</b>', ['class' => 'form-profile-show-title']) ?>

        <?= Html::beginTag('p', ['class' => 'form-profile-show-subtitle']) ?>
            <?= $this->app->t(
			    'ModuleUser',
			    'Show the details of the User.'
		    ) ?>
        <?= Html::endTag('p') ?>

        <?= Html::tag('hr', '', ['class' => 'mb-2']) ?>

        <?= Html::beginTag('div', ['class' => 'form-profile-show-body']) ?>

            <?= Html::img($profile->getAvatarUrl(230), [
                'class' => 'form-profile-show-img img-responsive img-circle',
                'title' => $profile->name,
                ]) ?>

            <?= Html::tag('p', $this->app->t('ModuleUser', 'Gravatar image'), ['class' => 'text-muted text-center mt-2']); ?>

        <?= Html::endTag('div') ?>

        <?= Html::beginTag('div', ['class' => 'form-profile-show-content']) ?>

            <?= Html::beginTag('div', ['class' => 'form-profile-show-fields-title']) ?>
    	        <?= Html::encode(
			        empty($profile->name) ?
			        $this->app->t('ModuleUser', 'Username:') :
                    $this->app->t('ModuleUser', 'Name:')
                )?>
            <?= Html::endTag('div') ?>

            <?= Html::beginTag('div', ['class' => 'alert alert-info flex-fill p-2', 'role' => 'alert']) ?>
                <?= Html::encode(empty($profile->name) ? $profile->user->username : $profile->name) ?>
            <?= Html::endTag('div') ?>

            <?= Html::beginTag('div', ['class' => 'form-profile-show-fields-title']) ?>
                <?= Html::encode($this->app->t('ModuleUser', 'Email - (Public):')) ?>
            <?= Html::endTag('div') ?>

		    <?= Html::beginTag('div', ['class' => 'alert alert-info flex-fill p-2', 'role' => 'alert']) ?>
			    <?= Html::tag('i', '', ['class' => 'fas fa-envelope']) ?>
			    <?= Html::a(
				    Html::encode(empty($profile->public_email) ? '(not set)' : 'mailto:' . $profile->public_email),
				    Html::encode(empty($profile->public_email) ? 'javascript:;' : 'mailto:' . $profile->public_email)
			    ) ?>
		    <?= Html::endTag('div') ?>

            <?= Html::beginTag('div', ['class' => 'form-profile-show-fields-title']) ?>
                <?= Html::encode($this->app->t('ModuleUser', 'Website:')) ?>
            <?= Html::endTag('div') ?>

		    <?= Html::beginTag('div', ['class' => 'alert alert-info flex-fill p-2', 'role' => 'alert']) ?>
                <?= Html::tag('i', '', ['class' => 'fas fa-globe']) ?>
			    <?= Html::a(
				    Html::encode(empty($profile->website) ? '(not set)' : $profile->website),
				    Html::encode(empty($profile->website) ? 'javascript:;' : $profile->website)
			    ) ?>
		    <?= Html::endTag('div') ?>

            <?= Html::beginTag('div', ['class' => 'form-profile-show-fields-title']) ?>
                <?= Html::encode($this->app->t('ModuleUser', 'Location:')) ?>
            <?= Html::endTag('div') ?>

		    <?= Html::beginTag('div', ['class' => 'alert alert-info flex-fill p-2', 'role' => 'alert']) ?>
			    <?= Html::tag('i', '', ['class' => 'fas fa-map-marked']) ?>
			    <?= Html::encode(empty($profile->location) ? '(not set)' : $profile->location) ?>
		    <?= Html::endTag('div') ?>

            <?= Html::beginTag('div', ['class' => 'form-profile-show-fields-title']) ?>
                <?= Html::encode($this->app->t('ModuleUser', 'Time Zone:')) ?>
            <?= Html::endTag('div') ?>

		    <?= Html::beginTag('div', ['class' => 'alert alert-info flex-fill p-2', 'role' => 'alert']) ?>
			    <?= Html::tag('i', '', ['class' => 'fas fa-user-clock']) ?>
			    <?= Html::encode(empty($profile->timezone) ? '(not set)' : $profile->timezone) ?>
            <?= Html::endTag('div') ?>

            <?= Html::beginTag('div', ['class' => 'form-profile-show-fields-title']) ?>
                <?= Html::encode($this->app->t('ModuleUser', 'Gravatar Email:')) ?>
            <?= Html::endTag('div') ?>

		    <?= Html::beginTag('div', ['class' => 'alert alert-info flex-fill p-2', 'role' => 'alert']) ?>
		        <?= Html::tag('i', '', ['class' => 'fas fa-image']) ?>
		        <?= Html::encode(empty($profile->gravatar_email) ? '(not set)' : $profile->gravatar_email) ?>
		    <?= Html::endTag('div') ?>

            <?= Html::beginTag('div', ['class' => 'form-profile-show-fields-title']) ?>
                <?= Html::encode($this->app->t('ModuleUser', 'Bio:')) ?>
            <?= Html::endTag('div') ?>

            <?= Html::beginTag('div', ['class' => 'alert alert-info flex-fill p-2', 'role' => 'alert']) ?>
			    <?= Html::tag('i', '', ['class' => 'fas fa-atlas']) ?>
			    <?= Html::encode(empty($profile->bio) ? '(not set)' : $profile->bio) ?>
		    <?= Html::endTag('div') ?>

            <?= Html::beginTag('div', ['class' => 'form-profile-show-fields-title']) ?>
                <?= Html::encode($this->app->t('ModuleUser', 'Register:')) ?>
            <?= Html::endTag('div') ?>

		    <?= Html::beginTag('div', ['class' => 'alert alert-info flex-fill p-2', 'role' => 'alert']) ?>
			    <?= Html::tag('i', '', ['class' => 'fas fa-registered']) ?>
			    <?= Html::encode(empty($profile->user->created_at) ?
				    '(not set)' :
				    $this->app->t('ModuleUser', 'Joined on {0, date}', [$profile->user->created_at]))
			    ?>
            <?= Html::endTag('div') ?>

        <?= Html::endTag('div') ?>

<?php echo Html::endTag('div');
