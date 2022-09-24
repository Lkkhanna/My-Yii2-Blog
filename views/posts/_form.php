<?php

use app\models\Categories;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Posts $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="posts-form fw-bolder">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>
    
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <br>

    <?= $form->field($model, 'category_id')->dropDownList(
        ArrayHelper::map(Categories::find()->all(), 'id', 'title'),
        ['prompt' => 'Select Category'], 
        ['options'=>[$model->category_id=>['Selected'=>true]]],
    ) ?>

    <br>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <br>

    <?= $form->field($model, 'body')->textarea(['rows' => 5]) ?>

    <br>

    <?= $form->field($model, 'image')->fileInput(
        ['value' => $model->image],
    ) ?>

    <br>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
