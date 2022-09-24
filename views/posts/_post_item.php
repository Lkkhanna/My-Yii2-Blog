<?php

/** @var $model \app\models\Article */
?>

<div>
    <a href="<?php echo \yii\helpers\Url::to(['view', 'slug' => $model->slug]) ?>">
        <h3><?php echo \yii\helpers\Html::encode($model->title) ?></h3>
    </a>
    <div>
        <?php echo \yii\helpers\StringHelper::truncateWords(\yii\helpers\Html::encode($model->body), 40) ?>
    </div>
    <p class="text-muted">
        <small>
            Created: <?php echo Yii::$app->formatter->asRelativeTime($model->created_at) ?><br>
            By: <?php echo $model->createdBy->username ?? '' ?>
        </small>
    </p>
    <hr>
</div>