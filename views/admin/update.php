<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Stream */

$this->title = 'Редактировать стрим: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Streams', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="stream-update p-4">


    <div class="row align-items-center">
        <div class="col-8">
            <!-- <h3 class="mb-0">Edit profile </h3> -->
            <h1 class="mb-0"><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-4 text-right">
            <!-- <a href="#!" class="btn btn-sm btn-primary">Settings</a> -->
            <?= Html::a('Все проекты', ['index'], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <hr>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
