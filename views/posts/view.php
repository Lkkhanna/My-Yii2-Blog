<?php

use app\models\Posts;
use app\models\SubReplies;
use yii\base\View;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Url as HelpersUrl;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Posts $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="posts-view">
    <?php if (!Yii::$app->user->isGuest) : ?>
        <p>
            <?= Html::a('Update', ['update', 'slug' => $model->slug], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'slug' => $model->slug], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
            <?= Html::button('Add Comment', ['class' => 'btn btn-success', 'id' => 'modalButton', 'value' => count($comments)]) ?>
        </p>
    <?php endif; ?>
    <div class='container'>
        <?php $this->registerJs('$(".alert").animate({opacity: 1.0}, 2000).fadeOut("slow");'); ?>
        <h1><?php echo Html::encode($model->title) ?></h1>
        <p class="text-muted">
            <small>
                Created : <?php echo Yii::$app->formatter->asRelativeTime($model->created_at) ?><br>
                By : <?php echo $model->createdBy->username ?? '' ?>
            </small>
        </p>
        <hr>
        <div>
            <u>
                <h4> Description : </h4>
            </u>
            <?php echo Html::encode($model->body); ?>
        </div>
        <hr>
        <div>
            <u>
                <h4> Post Image's : </h4>
            </u>
            <?php foreach ($images as $val) { ?>
                <?= Html::img('@web/uploads/' . $val->image, ['alt' => 'Image not available', 'class' => 'thing']); ?>
            <?php } ?>
        </div>
        <hr>
        <div>
            <u>
                <h4> Comment's : </h4>
            </u>
            <br>
            <?php foreach ($comments as $key => $data) { ?>
                <div class='container'>
                    <?= $key + 1 . ") " . Html::encode($data->comment); ?>
                    <div class="text-center">
                    <?= Html::button('Add Reply', ['class' => 'btn btn-info btn-sm', 'id' => 'replyModalButton' . $key + 1, 'value' => $data->id]) ?>
                    </div>
                    <?php $replies = Posts::getCommentReplies($data->id); ?>
                    <?php if (!empty($replies)) { ?>
                        <u>
                            <h5> Replies : </h5>
                        </u>
                        <?php foreach ($replies as $key => $reply) { ?>
                            <div class='form-control'>
                                <?= '# ' . Html::encode($reply->reply); ?>
                                <div class="text-center">
                                    <?= Html::button('Add Sub Reply', ['class' => 'btn btn-secondary btn-sm repliesCount', 'id' => 'subReplyModalButton' . $reply->id, 'value' => $reply->id]) ?>
                                </div>
                                <?php $sub_replies = Posts::getSubReplies($reply->id); ?>
                                <?php if (!empty($sub_replies)) { ?>
                                    <u>
                                        <h6> Sub Replies : </h6>
                                    </u>
                                    <?php foreach ($sub_replies as $key => $reply) { ?>
                                        <?= '- ' . Html::encode($reply->reply_message); ?><br>
                                    <?php } ?>
                                    <br>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <br>
                    <?php } ?>
                </div>
                <br>
                <hr>
            <?php } ?>
        </div>
    </div>

    <!-- Comments Modal -->
    <?php $form = ActiveForm::begin(['action' => HelpersUrl::toRoute(['comments', 'slug' => $model->slug])]); ?>
    <?php
        Modal::begin([
            'title' => 'Add Comment',
            'class' => 'btn btn-primary',
            'id' => 'modal',
            'size' => 'modal-lg'
        ]);
        echo "<div id='modalContent'></div>";
        echo $form->field($model, 'comment')->textInput(['maxlength' => true, 'value' => '']);
        echo '<br>';
        echo Html::submitButton('Save', ['class' => 'btn btn-success']);
        Modal::end();
    ?>
    <?php ActiveForm::end(); ?>

    <!-- Reply Modal -->
    <?php $form = ActiveForm::begin(['action' => HelpersUrl::toRoute(['reply', 'slug' => $model->slug])]); ?>
    <?php
        Modal::begin([
            'title' => 'Add Reply',
            'class' => 'btn btn-primary',
            'id' => 'replyModal',
            'size' => 'modal-lg'
        ]);
        echo "<div id='replyModalContent'></div>";
        echo $form->field($model, 'reply')->textInput(['maxlength' => true, 'value' => '']);
        echo $form->field($model, 'comment_id')->hiddenInput(['id' => 'comment_id' ,'value' => 0])->label(false);
        echo '<br>';
        echo Html::submitButton('Save', ['class' => 'btn btn-success']);
        Modal::end();
    ?>
    <?php ActiveForm::end(); ?>

    <!-- Sub Reply Modal -->
    <?php $form = ActiveForm::begin(['action' => HelpersUrl::toRoute(['sub-reply', 'slug' => $model->slug])]); ?>
    <?php
        Modal::begin([
            'title' => 'Add Sub Reply',
            'class' => 'btn btn-primary',
            'id' => 'subReplyModal',
            'size' => 'modal-lg'
        ]);
        echo "<div id='subReplyModalContent'></div>";
        echo $form->field($model, 'sub_reply')->textInput(['maxlength' => true, 'value' => '']);
        echo $form->field($model, 'reply_id')->hiddenInput(['id' => 'reply_id' ,'value' => 0])->label(false);
        echo '<br>';
        echo Html::submitButton('Save', ['class' => 'btn btn-success']);
        Modal::end();
    ?>
    <?php ActiveForm::end(); ?>
    
</div>