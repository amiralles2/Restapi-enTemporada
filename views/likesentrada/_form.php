<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Likesentrada */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="likesentrada-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_usuario')->textInput() ?>

    <?= $form->field($model, 'id_entrada')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
