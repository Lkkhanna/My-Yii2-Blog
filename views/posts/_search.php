<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

const STATUSES = ['' => 'Select', 0 => 'Draft', 1 => 'Published', 2 => 'In Review'];

/** @var yii\web\View $this */
/** @var app\models\PostsSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="posts-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'status')->dropDownList(STATUSES) ?>

    <br>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <!-- <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?> -->
        <?= Html::a('Reset', ['/'], ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
