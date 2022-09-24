<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Posts $model */

$this->title = 'Create Post';
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-create">

    <h1><?=Html::encode($this->title)?></h1>

    <hr class="bg-danger border-4 border-top border-danger">

    <?=$this->render('_form', [
    'model' => $model,
])?>

</div>
