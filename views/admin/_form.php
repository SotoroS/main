<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Stream */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stream-form row d-flex justify-content-start">
    <div class="col-md-8">
    
    <?php $form = ActiveForm::begin(); ?>


        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        
        <?= $form->field($model, 'youtube_url')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'domain')->textInput(['maxlength' => true]) ?>
        
        <?= $form->field($model, 'api_key')->textInput(['maxlength' => true]) ?>
        
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        
        <?php ActiveForm::end(); ?>
        
    </div>
</div>
