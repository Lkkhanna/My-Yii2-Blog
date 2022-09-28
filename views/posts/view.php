<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Posts $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="posts-view">

    <?php if (!Yii::$app->user->isGuest): ?>
        <p>
            <?= Html::a('Update', ['update', 'slug' => $model->slug], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'slug' => $model->slug], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    <?php endif; ?>
    <div>
    <hr>
        <h1><?php echo Html::encode($model->title) ?></h1>
        <p class="text-muted">
            <small>
                Created: <?php echo Yii::$app->formatter->asRelativeTime($model->created_at) ?><br>
                By: <?php echo $model->createdBy->username ?? '' ?>
            </small>
        </p>
        <hr>
        <div>
            <u><h4> Description </h4></u>
            <?php echo Html::encode($model->body); ?>
        </div>
        <hr>
        <div>
            <u><h4> Post Image(s) </h4></u>
            <?php foreach($images as $val) {?>
            <?= Html::img('@web/uploads/'. $val->image, ['alt'=>'Image not available', 'class'=>'thing']);?>
            <?php } ?>
        </div>
        
    </div>

</div>
