<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Likescomentario */

$this->title = 'Update Likescomentario: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Likescomentarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="likescomentario-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
