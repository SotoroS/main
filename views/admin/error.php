<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

// $this->title = $name;
?>
<div class="admin-error p-5">
    <?= Html::a('Все проекты', ['index'], ['class' => 'btn btn btn-primary']) ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger p-4">
        <?= nl2br(Html::encode($message)) ?>
    </div>



</div>
