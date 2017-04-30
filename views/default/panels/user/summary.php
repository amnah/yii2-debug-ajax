<?php

/* @var $this \yii\web\View */
/* @var $panel yii\debug\panels\UserPanel */

if (Yii::$app->user->isGuest) {
    $title = "Guest";
} elseif ($panel->userSwitch->isMainUser()) {
    $title = "Main user";
} else {
    $title = "Switched user";
}
if (!empty(Yii::$app->user->identity->email)) {
    $title .= " - " . Yii::$app->user->identity->email;
}
?>
<div class="yii-debug-toolbar__block" title="<?= $title ?>">
    <a href="<?= $panel->getUrl() ?>">
        <?php if (Yii::$app->user->isGuest): ?>
            <span class="yii-debug-toolbar__label">Guest</span>
        <?php else: ?>
            <?php if ($panel->userSwitch->isMainUser()): ?>
                User <span class="yii-debug-toolbar__label yii-debug-toolbar__label_info"><?= Yii::$app->user->id ?></span>
            <?php else: ?>
                User <span class="yii-debug-toolbar__label yii-debug-toolbar__label_warning"><?= Yii::$app->user->id ?></span>
            <?php endif; ?>
            <?php if ($panel->canSwitchUser()): ?>
                <span class="yii-debug-toolbar__switch-icon yii-debug-toolbar__userswitch" id="yii-debug-toolbar__switch-users">
            </span>
            <?php endif; ?>
        <?php endif; ?>
    </a>
</div>
