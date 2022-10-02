<?php

use app\models\Categories;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

const STATUSES = ['' => 'Select', 0 => 'Draft', 1 => 'Published', 2 => 'In Review'];

/** @var yii\web\View $this */
/** @var app\models\Posts $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="posts-form fw-bolder">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>
    
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'categories')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Categories::find()->all(), 'id', 'title'),
        'language' => 'en',
        'options' => ['options' => $categories ?? ['0'], 'placeholder' => 'Select Categories', 'multiple' => true],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'status')->dropDownList(STATUSES) ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 5]) ?>

    <?= $form->field($model, 'image[]')->fileInput([
        'multiple' => true,
        'accept' => 'image/*'
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>