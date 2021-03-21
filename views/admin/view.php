<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Stream */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Streams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="stream-view p-5">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row align-items-center pb-2">
        <div class="col-8">
            <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
        <div class="col-4 text-right">
            <?= Html::a('Все проекты', ['index'], ['class' => 'btn btn btn-primary']) ?>
            <?= Html::a('Мой стрим', ['self-stream', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'youtube_url:url',
            'domain',
            'api_key',
        ],
    ]) ?>
    <br>
    <h3>Товары для стрима</h3> 
    <br>

    <div class="table-responsive">
        <table class="table align-items-center table-flush">
            <thead class="thead-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" class="sort" data-sort="name">Изображение</th>
                    <th scope="col" class="sort" data-sort="name">Наименование</th>
                    <th scope="col" class="sort" data-sort="budget">Ссылка на товар</th>
                </tr>
            </thead>
            <tbody class="list">
                <?php foreach($models as $key => $model):?>
                <tr>
                    <td>
                        <?=$key+1?>
                    </td>
                    <td>
                        <div class="avatar rounded-circle" style="background-position: center; background-size: cover; background-repeat: no-repeat; background-image: url('<?=$model->image?>');"></div>
                    </td>
                    <!-- Наименование -->
                    <td scope="row">
                        <div class="media align-items-center">
                            <div class="media-body">
                                <span class="name mb-0 text-sm"><?=$model->name?> </span>
                            </div>
                        </div>
                    </td>
                    <!-- Ссылка на товар -->
                    <td class="budget">
                        <a href="<?=$model->url?>" target="_blank"><button type="button" class="btn btn-info">Перейти</button></a>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>

</div>
